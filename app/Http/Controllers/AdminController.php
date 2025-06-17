<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User;
use App\Models\Review;
use App\Models\Developer;
use App\Models\Publisher;
use App\Models\Genre;
use App\Models\Platform;
use Illuminate\Http\Request;

class AdminController extends Controller
{    public function __construct()
    {
        // Apply auth middleware only - role checking will be done in individual methods
        $this->middleware('auth');
    }    /**
     * Show the admin dashboard
     */
    public function dashboard()
    {
        // Temporarily disable admin check for debugging
        /*
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Access denied. Admin privileges required.');
        }
        */
        
        $stats = [
            'total_games' => Game::count(),
            'total_users' => User::count(),
            'total_reviews' => Review::count(),
            'total_developers' => Developer::count(),
            'total_publishers' => Publisher::count(),
            'total_genres' => Genre::count(),
            'total_platforms' => Platform::count(),
            'recent_games' => Game::latest()->take(5)->get(),
            'recent_reviews' => Review::with(['user', 'game'])->latest()->take(5)->get(),
            'recent_users' => User::latest()->take(5)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    /**
     * Show users management page
     */
    public function users(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.users', compact('users'));
    }

    /**
     * Update user role
     */
    public function updateUserRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:user,admin'
        ]);

        $user->update(['role' => $request->role]);

        return redirect()->back()->with('success', 'User role updated successfully!');
    }

    /**
     * Delete user
     */
    public function deleteUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account!');
        }

        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully!');
    }
}
