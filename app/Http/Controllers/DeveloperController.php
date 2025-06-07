<?php

namespace App\Http\Controllers;

use App\Models\Developer;
use Illuminate\Http\Request;

class DeveloperController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index()
    {
        return response()->json(Developer::all());
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

        $developer = Developer::create($request->all());
        return response()->json(['message' => 'Developer created', 'developer' => $developer], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Developer $developer)
    {
        return response()->json($developer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Developer $developer)
    {
        $request->validate([
            'name' => 'string',
            'country' => 'string',
        ]);

        $developer->update($request->all());
        return response()->json(['message' => 'Developer updated', 'developer' => $developer]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Developer $developer)
    {
        $developer->delete();
        return response()->json(['message' => 'Developer deleted']);
    }

    /**
     * Display a listing of the resource's games.
     */
    public function games(Developer $developer)
    {
        return response()->json($developer->games);
    }

    /**
     * Search for developers by name.
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        $developers = Developer::where('name', 'like', "%{$query}%")->get();
        return response()->json($developers);
    }
}
