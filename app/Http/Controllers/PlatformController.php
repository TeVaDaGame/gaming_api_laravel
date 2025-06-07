<?php

namespace App\Http\Controllers;

use App\Models\Platform;
use Illuminate\Http\Request;

class PlatformController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Platform::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'manufacturer' => 'required|string',
        ]);

        $platform = Platform::create($request->all());
        return response()->json(['message' => 'Platform created', 'platform' => $platform], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Platform $platform)
    {
        return response()->json($platform);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Platform $platform)
    {
        $request->validate([
            'name' => 'string',
            'manufacturer' => 'string',
        ]);

        $platform->update($request->all());
        return response()->json(['message' => 'Platform updated', 'platform' => $platform]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Platform $platform)
    {
        $platform->delete();
        return response()->json(['message' => 'Platform deleted']);
    }

    /**
     * Display the games of the specified platform.
     */
    public function games(Platform $platform)
    {
        return response()->json($platform->games);
    }
}
