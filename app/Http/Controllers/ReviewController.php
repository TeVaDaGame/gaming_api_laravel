<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Game;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Review::with('game', 'user')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'game_id' => 'required|exists:games,id',
            'user_id' => 'required|exists:users,id',
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string',
        ]);

        $review = Review::create($request->all());
        return response()->json(['message' => 'Review created', 'review' => $review], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        return response()->json($review->load('game', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
    {
        $request->validate([
            'rating' => 'integer|between:1,5',
            'comment' => 'string',
        ]);

        $review->update($request->all());
        return response()->json(['message' => 'Review updated', 'review' => $review]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        $review->delete();
        return response()->json(['message' => 'Review deleted']);
    }

    // Web methods for review pages
    public function reviewsIndex(Request $request)
    {
        $query = Review::with(['game', 'user'])
            ->orderBy('created_at', 'desc');
            
        // Apply filters
        if ($request->filled('game')) {
            $query->where('game_id', $request->game);
        }
        
        if ($request->filled('rating')) {
            $query->where('rating', '>=', $request->rating);
        }
        
        if ($request->filled('recommended')) {
            $query->where('is_recommended', $request->recommended);
        }
            
        $reviews = $query->paginate(12);
            
        $games = Game::where('is_active', true)
            ->orderBy('title')
            ->get();
            
        return view('reviews.index', compact('reviews', 'games'));
    }

    public function create(Request $request)
    {
        $gameId = $request->get('game_id');
        $game = null;
        
        if ($gameId) {
            $game = Game::findOrFail($gameId);
        }
        
        $games = Game::where('is_active', true)
            ->orderBy('title')
            ->get();
            
        return view('reviews.create', compact('games', 'game'));
    }

    public function storeWeb(Request $request)
    {
        $request->validate([
            'game_id' => 'required|exists:games,id',
            'rating' => 'required|integer|between:1,5',
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:10',
            'is_recommended' => 'boolean',
        ]);

        // Check if user already reviewed this game
        $existingReview = Review::where('user_id', auth()->id())
            ->where('game_id', $request->game_id)
            ->first();

        if ($existingReview) {
            return redirect()->back()
                ->with('error', 'You have already reviewed this game. You can edit your existing review instead.');
        }

        Review::create([
            'user_id' => auth()->id(),
            'game_id' => $request->game_id,
            'rating' => $request->rating,
            'title' => $request->title,
            'content' => $request->content,
            'is_recommended' => $request->has('is_recommended'),
        ]);

        return redirect()->route('reviews.index')
            ->with('success', 'Review created successfully!');
    }

    public function edit(Review $review)
    {
        // Check if user owns this review
        if ($review->user_id !== auth()->id()) {
            return redirect()->route('reviews.index')
                ->with('error', 'You can only edit your own reviews.');
        }

        $games = Game::where('is_active', true)
            ->orderBy('title')
            ->get();

        return view('reviews.edit', compact('review', 'games'));
    }

    public function updateWeb(Request $request, Review $review)
    {
        // Check if user owns this review
        if ($review->user_id !== auth()->id()) {
            return redirect()->route('reviews.index')
                ->with('error', 'You can only edit your own reviews.');
        }

        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:10',
            'is_recommended' => 'boolean',
        ]);

        $review->update([
            'rating' => $request->rating,
            'title' => $request->title,
            'content' => $request->content,
            'is_recommended' => $request->has('is_recommended'),
        ]);

        return redirect()->route('reviews.index')
            ->with('success', 'Review updated successfully!');
    }

    public function destroyWeb(Review $review)
    {
        // Check if user owns this review or is admin
        if ($review->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            return redirect()->route('reviews.index')
                ->with('error', 'You can only delete your own reviews.');
        }

        $review->delete();

        return redirect()->route('reviews.index')
            ->with('success', 'Review deleted successfully!');
    }
}
