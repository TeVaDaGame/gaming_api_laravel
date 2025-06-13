<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\DeveloperController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\PlatformController;
use App\Http\Controllers\ReviewController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public API Authentication endpoints
Route::post('/login', [AuthController::class, 'apiLogin']);
Route::post('/register', [AuthController::class, 'apiRegister']);

// Public API endpoints (no authentication required)
Route::get('/games', [GameController::class, 'index']);
Route::get('/developers', [DeveloperController::class, 'index']);
Route::get('/publishers', [PublisherController::class, 'index']);
Route::get('/genres', [GenreController::class, 'index']);
Route::get('/platforms', [PlatformController::class, 'index']);
Route::get('/reviews', [ReviewController::class, 'index']);

// Temporary: Make POST reviews public for testing
Route::post('/reviews', [ReviewController::class, 'store']);

// Test endpoint
Route::get('/test', function () {
    return response()->json([
        'message' => 'API is working!',
        'timestamp' => now(),
        'version' => '1.0.0'
    ]);
});

// Protected API Routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    // User info
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    // Games routes (protected)
    Route::prefix('games')->group(function () {
        Route::post('/', [GameController::class, 'store']);
        Route::get('/search', [GameController::class, 'search']);
        Route::get('/popular', [GameController::class, 'popular']);
        Route::get('/latest', [GameController::class, 'latest']);
        Route::get('/{game}', [GameController::class, 'show']);
        Route::put('/{game}', [GameController::class, 'update']);
        Route::delete('/{game}', [GameController::class, 'destroy']);
        Route::get('/{game}/developers', [GameController::class, 'developers']);
        Route::get('/{game}/reviews', [GameController::class, 'reviews']);
        Route::post('/{game}/rate', [GameController::class, 'rate']);
    });

    // Developers routes (protected)
    Route::prefix('developers')->group(function () {
        Route::post('/', [DeveloperController::class, 'store']);
        Route::get('/search', [DeveloperController::class, 'search']);
        Route::get('/{developer}', [DeveloperController::class, 'show']);
        Route::put('/{developer}', [DeveloperController::class, 'update']);
        Route::delete('/{developer}', [DeveloperController::class, 'destroy']);
        Route::get('/{developer}/games', [DeveloperController::class, 'games']);
    });

    // Publishers routes (protected)
    Route::prefix('publishers')->group(function () {
        Route::post('/', [PublisherController::class, 'store']);
        Route::get('/search', [PublisherController::class, 'search']);
        Route::get('/{publisher}', [PublisherController::class, 'show']);
        Route::put('/{publisher}', [PublisherController::class, 'update']);
        Route::delete('/{publisher}', [PublisherController::class, 'destroy']);
        Route::get('/{publisher}/games', [PublisherController::class, 'games']);
    });

    // Genres routes (protected)
    Route::prefix('genres')->group(function () {
        Route::post('/', [GenreController::class, 'store']);
        Route::get('/{genre}', [GenreController::class, 'show']);
        Route::put('/{genre}', [GenreController::class, 'update']);
        Route::delete('/{genre}', [GenreController::class, 'destroy']);
        Route::get('/{genre}/games', [GenreController::class, 'games']);
    });

    // Platforms routes (protected)
    Route::prefix('platforms')->group(function () {
        Route::post('/', [PlatformController::class, 'store']);
        Route::get('/{platform}', [PlatformController::class, 'show']);
        Route::put('/{platform}', [PlatformController::class, 'update']);
        Route::delete('/{platform}', [PlatformController::class, 'destroy']);
        Route::get('/{platform}/games', [PlatformController::class, 'games']);
    });    // Reviews routes (protected)
    Route::prefix('reviews')->group(function () {
        Route::get('/{review}', [ReviewController::class, 'show']);
        Route::put('/{review}', [ReviewController::class, 'update']);
        Route::delete('/{review}', [ReviewController::class, 'destroy']);
    });
});
