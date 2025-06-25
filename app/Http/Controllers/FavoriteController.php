<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\UserFavorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class FavoriteController extends Controller
{
    /**
     * Display user's favorites
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $type = $request->get('type', 'favorite'); // 'favorite' or 'wishlist'
        
        $favorites = $user->userFavorites()
            ->with(['game.publisher', 'game.developers', 'game.genres', 'game.platforms'])
            ->where('type', $type)
            ->orderBy('created_at', 'desc')
            ->get();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $favorites,
                'type' => $type,
                'count' => $favorites->count()
            ]);
        }

        return view('favorites.index', compact('favorites', 'type'));
    }

    /**
     * Add game to favorites/wishlist
     */
    public function store(Request $request)
    {
        $request->validate([
            'game_id' => 'required|exists:games,id',
            'type' => ['required', Rule::in(['favorite', 'wishlist'])],
            'notes' => 'nullable|string|max:500'
        ]);

        $user = Auth::user();
        
        // Check if already exists
        $existing = $user->userFavorites()
            ->where('game_id', $request->game_id)
            ->where('type', $request->type)
            ->first();

        if ($existing) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Game is already in your ' . $request->type . ' list'
                ], 409);
            }
            
            return back()->with('error', 'Game is already in your ' . $request->type . ' list');
        }

        // Create favorite
        $favorite = $user->addToFavorites(
            $request->game_id,
            $request->type,
            $request->notes
        );

        $game = Game::find($request->game_id);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => "'{$game->title}' added to {$request->type} list",
                'data' => $favorite->load('game')
            ], 201);
        }

        return back()->with('success', "'{$game->title}' added to {$request->type} list");
    }

    /**
     * Remove game from favorites/wishlist
     */
    public function destroy(Request $request, $gameId)
    {
        $type = $request->get('type', 'favorite');
        $user = Auth::user();

        $favorite = $user->userFavorites()
            ->where('game_id', $gameId)
            ->where('type', $type)
            ->first();

        if (!$favorite) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Game not found in your ' . $type . ' list'
                ], 404);
            }
            
            return back()->with('error', 'Game not found in your ' . $type . ' list');
        }

        $game = $favorite->game;
        $favorite->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => "'{$game->title}' removed from {$type} list"
            ]);
        }

        return back()->with('success', "'{$game->title}' removed from {$type} list");
    }

    /**
     * Update favorite notes
     */
    public function update(Request $request, $favoriteId)
    {
        $request->validate([
            'notes' => 'nullable|string|max:500'
        ]);

        $user = Auth::user();
        
        $favorite = $user->userFavorites()->find($favoriteId);
        
        if (!$favorite) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Favorite not found'
                ], 404);
            }
            
            return back()->with('error', 'Favorite not found');
        }

        $favorite->update(['notes' => $request->notes]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Notes updated successfully',
                'data' => $favorite->load('game')
            ]);
        }

        return back()->with('success', 'Notes updated successfully');
    }

    /**
     * Get favorites statistics
     */
    public function stats()
    {
        $user = Auth::user();
        
        $stats = [
            'total_favorites' => $user->userFavorites()->favorites()->count(),
            'total_wishlist' => $user->userFavorites()->wishlist()->count(),
            'total_combined' => $user->userFavorites()->count(),
            'recent_additions' => $user->userFavorites()
                ->with('game')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get(),
            'favorite_genres' => $user->userFavorites()
                ->with('game.genres')
                ->get()
                ->flatMap(function($favorite) {
                    return $favorite->game->genres;
                })
                ->groupBy('name')
                ->map(function($group) {
                    return $group->count();
                })
                ->sortDesc()
                ->take(5)
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Check if game is in user's favorites/wishlist
     */
    public function check($gameId, Request $request)
    {
        $user = Auth::user();
        $type = $request->get('type', 'favorite');
        
        $isFavorited = $user->hasFavorited($gameId, $type);
        
        return response()->json([
            'success' => true,
            'is_favorited' => $isFavorited,
            'type' => $type
        ]);
    }
}
