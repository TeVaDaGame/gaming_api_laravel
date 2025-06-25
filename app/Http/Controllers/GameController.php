<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Publisher;
use App\Models\Developer;
use App\Models\Genre;
use App\Models\Platform;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index() {
        return response()->json(Game::with('publisher', 'developers')->get());
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string',
            'slug' => 'required|string|unique:games',
            'description' => 'required|string',
            'image_url' => 'nullable|url|max:500',
            'cover_image' => 'nullable|url|max:500',
            'release_date' => 'required|date',
            'publisher_id' => 'required|exists:publishers,id',
            'rating' => 'required|numeric|between:0,10',
            'price' => 'required|numeric|min:0',
            'is_active' => 'boolean',
            'developer_ids' => 'required|array|exists:developers,id'
        ]);

        $game = Game::create($request->only([
            'title', 'slug', 'description', 'image_url', 'cover_image', 'release_date',
            'publisher_id', 'rating', 'price', 'is_active'
        ]));
        
        if ($request->has('developer_ids')) {
            $game->developers()->attach($request->developer_ids);
        }

        return response()->json(['message' => 'Game created', 'game' => $game], 201);
    }

    public function show(Game $game)
    {
        // Load all relationships for comprehensive game information
        $game->load([
            'genres',
            'platforms', 
            'developers',
            'publisher',
            'reviews' => function($query) {
                $query->with('user')->latest();
            }
        ]);

        // Calculate average rating
        $averageRating = $game->reviews()->avg('rating');
        $totalReviews = $game->reviews()->count();
        
        // Get user's review if they're logged in
        $userReview = null;
        if (auth()->check()) {
            $userReview = $game->reviews()->where('user_id', auth()->id())->first();
        }

        // Get similar games (same genres)
        $similarGames = Game::whereHas('genres', function($query) use ($game) {
            $query->whereIn('genre_id', $game->genres->pluck('id'));
        })
        ->where('id', '!=', $game->id)
        ->with(['genres', 'platforms'])
        ->limit(6)
        ->get();

        return view('games.show', compact(
            'game', 
            'averageRating', 
            'totalReviews', 
            'userReview', 
            'similarGames'
        ));
    }

    public function update(Request $request, Game $game)
    {
        $request->validate([
            'title' => 'string',
            'genre' => 'string',
            'rating' => 'numeric',
            'class' => 'string',
            'publisher_id' => 'exists:publishers,id',
            'developer_ids' => 'array'
        ]);

        $game->update($request->only('title', 'genre', 'rating', 'class', 'publisher_id'));
        if ($request->has('developer_ids')) {
            $game->developers()->sync($request->developer_ids);
        }

        return response()->json(['message' => 'Game updated', 'game' => $game]);
    }

    public function destroy(Game $game)
    {
        $game->delete();
        return response()->json(['message' => 'Game deleted']);
    }

    public function developers(Game $game)
    {
        return response()->json($game->developers);
    }

    public function reviews(Game $game)
    {
        return response()->json($game->reviews);
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        $games = Game::where('title', 'like', "%{$query}%")->get();
        return response()->json($games);
    }

    public function popular()
    {
        return response()->json(Game::orderBy('rating', 'desc')->take(10)->get());
    }

    public function latest()
    {
        return response()->json(Game::latest()->take(10)->get());
    }

    public function rate(Request $request, Game $game)
    {
        $request->validate([
            'rating' => 'required|numeric|between:1,5'
        ]);

        $game->rating = ($game->rating + $request->rating) / 2;
        $game->save();

        return response()->json(['message' => 'Game rated', 'game' => $game]);
    }

    // Web methods for game management interface
    public function manage(Request $request)
    {
        $query = Game::with(['publisher', 'developers', 'genres', 'platforms']);
        
        // Apply search filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }
        
        if ($request->filled('publisher')) {
            $query->where('publisher_id', $request->publisher);
        }
        
        if ($request->filled('genre')) {
            $query->whereHas('genres', function($q) use ($request) {
                $q->where('genres.id', $request->genre);
            });
        }
        
        if ($request->filled('status')) {
            $status = $request->status === 'active' ? 1 : 0;
            $query->where('is_active', $status);
        }
        
        // Order by title and get all games without pagination
        $games = $query->orderBy('title', 'asc')->get();
        
        // Get filter options
        $publishers = Publisher::orderBy('name')->get();
        $genres = Genre::orderBy('name')->get();
        
        return view('games.manage', compact('games', 'publishers', 'genres'));
    }

    public function create()
    {
        $publishers = Publisher::all();
        $developers = Developer::all();
        $genres = Genre::all();
        $platforms = Platform::all();
        
        return view('games.create', compact('publishers', 'developers', 'genres', 'platforms'));
    }

    public function storeWeb(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:games|max:255',
            'description' => 'required|string',
            'image_url' => 'nullable|url|max:500',
            'cover_image' => 'nullable|url|max:500',
            'release_date' => 'required|date',
            'publisher_id' => 'required|exists:publishers,id',
            'rating' => 'required|numeric|between:0,10',
            'price' => 'required|numeric|min:0',
            'is_active' => 'boolean',
            'developer_ids' => 'required|array',
            'developer_ids.*' => 'exists:developers,id',
            'genre_ids' => 'array',
            'genre_ids.*' => 'exists:genres,id',
            'platform_ids' => 'array',
            'platform_ids.*' => 'exists:platforms,id'
        ]);

        $game = Game::create($request->only([
            'title', 'slug', 'description', 'image_url', 'cover_image', 'release_date',
            'publisher_id', 'rating', 'price', 'is_active'
        ]));

        if ($request->has('developer_ids')) {
            $game->developers()->attach($request->developer_ids);
        }

        if ($request->has('genre_ids')) {
            $game->genres()->attach($request->genre_ids);
        }

        if ($request->has('platform_ids')) {
            $game->platforms()->attach($request->platform_ids);
        }

        return redirect()->route('games.manage')->with('success', 'Game created successfully!');
    }

    public function edit(Game $game)
    {
        $publishers = Publisher::all();
        $developers = Developer::all();
        $genres = Genre::all();
        $platforms = Platform::all();
        
        $game->load(['publisher', 'developers', 'genres', 'platforms']);
        
        return view('games.edit', compact('game', 'publishers', 'developers', 'genres', 'platforms'));
    }

    public function updateWeb(Request $request, Game $game)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:games,slug,' . $game->id,
            'description' => 'required|string',
            'image_url' => 'nullable|url|max:500',
            'cover_image' => 'nullable|url|max:500',
            'release_date' => 'required|date',
            'publisher_id' => 'required|exists:publishers,id',
            'rating' => 'required|numeric|between:0,10',
            'price' => 'required|numeric|min:0',
            'is_active' => 'boolean',
            'developer_ids' => 'required|array',
            'developer_ids.*' => 'exists:developers,id',
            'genre_ids' => 'array',
            'genre_ids.*' => 'exists:genres,id',
            'platform_ids' => 'array',
            'platform_ids.*' => 'exists:platforms,id'
        ]);

        $game->update($request->only([
            'title', 'slug', 'description', 'image_url', 'cover_image', 'release_date',
            'publisher_id', 'rating', 'price', 'is_active'
        ]));

        if ($request->has('developer_ids')) {
            $game->developers()->sync($request->developer_ids);
        }

        if ($request->has('genre_ids')) {
            $game->genres()->sync($request->genre_ids);
        }

        if ($request->has('platform_ids')) {
            $game->platforms()->sync($request->platform_ids);
        }

        return redirect()->route('games.manage')->with('success', 'Game updated successfully!');
    }

    public function destroyWeb(Game $game)
    {
        $game->delete();
        return redirect()->route('games.manage')->with('success', 'Game deleted successfully!');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'selected_games' => 'required|array|min:1',
            'selected_games.*' => 'exists:games,id'
        ]);

        $count = Game::whereIn('id', $request->selected_games)->count();
        Game::whereIn('id', $request->selected_games)->delete();

        return redirect()->route('games.manage')->with('success', "{$count} games deleted successfully!");
    }

    // Method for dashboard statistics
    public function getStats()
    {
        return [
            'total_games' => Game::count(),
            'total_developers' => Developer::count(),
            'total_reviews' => \App\Models\Review::count(),
            'total_publishers' => Publisher::count(),
        ];
    }

    public function searchPage(Request $request)
    {
        $query = $request->get('q');
        $genre = $request->get('genre');
        $publisher = $request->get('publisher');
        $ratingSort = $request->get('rating_sort');
        $maxPrice = $request->get('max_price');
        
        $games = Game::with(['publisher', 'developers', 'genres', 'platforms']);
        
        // Apply search filters
        if ($query) {
            $games->where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            });
        }
        
        if ($genre) {
            $games->whereHas('genres', function($q) use ($genre) {
                $q->where('genres.id', $genre);
            });
        }
        
        if ($publisher) {
            $games->where('publisher_id', $publisher);
        }
        
        if ($maxPrice) {
            $games->where('price', '<=', $maxPrice);
        }
        
        // Only get active games for search
        $games->where('is_active', true);
        
        // Apply rating sort
        if ($ratingSort) {
            if ($ratingSort === 'high_to_low') {
                $games->orderBy('rating', 'desc');
            } elseif ($ratingSort === 'low_to_high') {
                $games->orderBy('rating', 'asc');
            }
        } else {
            // Default order - by title
            $games->orderBy('title', 'asc');
        }
        
        // Get all results without pagination
        $results = $games->get();
        
        // Get filter options
        $genres = Genre::orderBy('name')->get();
        $publishers = Publisher::orderBy('name')->get();
        
        return view('games.search', compact('results', 'genres', 'publishers', 'query', 'genre', 'publisher', 'ratingSort', 'maxPrice'));
    }
}

