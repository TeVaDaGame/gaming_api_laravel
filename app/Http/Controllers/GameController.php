<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Publisher;
use App\Models\Developer;
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
            'release_date' => 'required|date',
            'publisher_id' => 'required|exists:publishers,id',
            'rating' => 'required|numeric|between:0,10',
            'price' => 'required|numeric|min:0',
            'is_active' => 'boolean',
            'developer_ids' => 'required|array|exists:developers,id'
        ]);

        $game = Game::create($request->only([
            'title', 'slug', 'description', 'release_date',
            'publisher_id', 'rating', 'price', 'is_active'
        ]));
        
        if ($request->has('developer_ids')) {
            $game->developers()->attach($request->developer_ids);
        }

        return response()->json(['message' => 'Game created', 'game' => $game], 201);
    }

    public function show(Game $game)
    {
        return response()->json($game->load('publisher', 'developers'));
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
}

