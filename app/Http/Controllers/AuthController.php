<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Default role for new registrations
        ]);

        Auth::login($user);

        return redirect('/dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function dashboard()
    {
        $gameController = new \App\Http\Controllers\GameController();
        $stats = $gameController->getStats();
        
        return view('dashboard', compact('stats'));
    }

    public function profile()
    {
        $user = auth()->user();
        $users = collect();
        
        // Only admins can see all users
        if ($user->isAdmin()) {
            $users = User::all();
        }
        
        return view('profile', compact('user', 'users'));
    }

    public function editProfile()
    {
        $user = auth()->user();
        $users = collect();
        
        // Only admins can see all users
        if ($user->isAdmin()) {
            $users = User::all();
        }
        
        return view('profile.edit', compact('user', 'users'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'current_password' => 'required|string',
            'new_password' => 'nullable|string|min:8|confirmed',
        ];
        
        // Only admins can change roles and update other users
        if ($user->isAdmin()) {
            $rules['role'] = 'sometimes|in:admin,user';
            $rules['user_id'] = 'sometimes|exists:users,id';
        }
        
        $request->validate($rules);
        
        // Verify current password
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()
                ->withErrors(['current_password' => 'The current password is incorrect.'])
                ->withInput();
        }
        
        // Determine which user to update
        $targetUser = $user;
        if ($user->isAdmin() && $request->has('user_id')) {
            $targetUser = User::findOrFail($request->user_id);
        }
        
        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
        ];
        
        // Update password if provided
        if ($request->filled('new_password')) {
            $updateData['password'] = Hash::make($request->new_password);
        }
        
        // Only admins can update roles
        if ($user->isAdmin() && $request->has('role')) {
            $updateData['role'] = $request->role;
        }
        
        $targetUser->update($updateData);
        
        $message = $targetUser->id === $user->id ? 'Profile updated successfully!' : 'User updated successfully!';
        
        // Add password change message if password was updated
        if ($request->filled('new_password') && $targetUser->id === $user->id) {
            $message = 'Profile and password updated successfully!';
        }
        
        // Redirect to appropriate page
        if ($targetUser->id === $user->id) {
            return redirect()->route('profile')->with('success', $message);
        } else {
            return redirect()->route('profile')->with('success', $message);
        }
    }

    // API Authentication methods
    public function apiLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function apiRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Default role for API registrations
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    public function settings()
    {
        $user = auth()->user();
        $genres = \App\Models\Genre::all();
        $platforms = \App\Models\Platform::all();
        
        return view('settings', compact('user', 'genres', 'platforms'));
    }

    public function updateSettings(Request $request)
    {
        $user = auth()->user();
        
        $request->validate([
            'theme' => 'in:light,dark',
            'items_per_page' => 'integer|min:6|max:50',
            'date_format' => 'in:M d Y,d/m/Y,Y-m-d',
            'time_zone' => 'string|max:50',
            'email_notifications' => 'boolean',
            'review_notifications' => 'boolean',
            'newsletter_subscription' => 'boolean',
            'game_recommendations' => 'boolean',
            'favorite_genres' => 'array',
            'favorite_genres.*' => 'exists:genres,id',
            'preferred_platforms' => 'array',
            'preferred_platforms.*' => 'exists:platforms,id',
            'rating_display' => 'in:stars,numbers,both',
            'mature_content_filter' => 'boolean',
            'show_only_available' => 'boolean',
            'profile_visibility' => 'in:public,private',
            'review_privacy' => 'in:public,private',
            'activity_tracking' => 'boolean',
        ]);

        $settings = [
            'theme' => $request->input('theme', 'light'),
            'items_per_page' => (int) $request->input('items_per_page', 12),
            'date_format' => $request->input('date_format', 'M d, Y'),
            'time_zone' => $request->input('time_zone', 'UTC'),
            'email_notifications' => $request->boolean('email_notifications'),
            'review_notifications' => $request->boolean('review_notifications'),
            'newsletter_subscription' => $request->boolean('newsletter_subscription'),
            'game_recommendations' => $request->boolean('game_recommendations'),
            'favorite_genres' => $request->input('favorite_genres', []),
            'preferred_platforms' => $request->input('preferred_platforms', []),
            'rating_display' => $request->input('rating_display', 'stars'),
            'mature_content_filter' => $request->boolean('mature_content_filter'),
            'show_only_available' => $request->boolean('show_only_available'),
            'profile_visibility' => $request->input('profile_visibility', 'public'),
            'review_privacy' => $request->input('review_privacy', 'public'),
            'activity_tracking' => $request->boolean('activity_tracking'),
        ];

        $user->updateSettings($settings);

        return redirect()->route('settings')->with('success', 'Settings updated successfully!');
    }
}
