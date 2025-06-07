<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Publisher::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'country' => 'required|string',
        ]);

        $publisher = Publisher::create($request->all());
        return response()->json(['message' => 'Publisher created', 'publisher' => $publisher], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Publisher $publisher)
    {
        return response()->json($publisher);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Publisher $publisher)
    {
        $request->validate([
            'name' => 'string',
            'country' => 'string',
        ]);

        $publisher->update($request->all());
        return response()->json(['message' => 'Publisher updated', 'publisher' => $publisher]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Publisher $publisher)
    {
        $publisher->delete();
        return response()->json(['message' => 'Publisher deleted']);
    }

    /**
     * Display a listing of the games for a specific publisher.
     */
    public function games(Publisher $publisher)
    {
        return response()->json($publisher->games);
    }

    /**
     * Search for publishers by name.
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        $publishers = Publisher::where('name', 'like', "%{$query}%")->get();
        return response()->json($publishers);
    }
}
