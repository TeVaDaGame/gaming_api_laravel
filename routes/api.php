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
    
    // Games routes (read-only for all users)
    Route::prefix('games')->group(function () {
        Route::get('/search', [GameController::class, 'search']);
        Route::get('/popular', [GameController::class, 'popular']);
        Route::get('/latest', [GameController::class, 'latest']);
        Route::get('/{game}', [GameController::class, 'show']);
        Route::get('/{game}/developers', [GameController::class, 'developers']);
        Route::get('/{game}/reviews', [GameController::class, 'reviews']);
        Route::post('/{game}/rate', [GameController::class, 'rate']);
    });

    // Admin-only game management routes
    Route::middleware('admin')->prefix('games')->group(function () {
        Route::post('/', [GameController::class, 'store']);
        Route::put('/{game}', [GameController::class, 'update']);
        Route::delete('/{game}', [GameController::class, 'destroy']);
    });

    // Admin-only developers routes
    Route::middleware('admin')->prefix('developers')->group(function () {
        Route::post('/', [DeveloperController::class, 'store']);
        Route::put('/{developer}', [DeveloperController::class, 'update']);
        Route::delete('/{developer}', [DeveloperController::class, 'destroy']);
    });    // Developers routes (read-only for all users)
    Route::prefix('developers')->group(function () {
        Route::get('/search', [DeveloperController::class, 'search']);
        Route::get('/{developer}', [DeveloperController::class, 'show']);
        Route::get('/{developer}/games', [DeveloperController::class, 'games']);
    });

    // Admin-only publishers routes
    Route::middleware('admin')->prefix('publishers')->group(function () {
        Route::post('/', [PublisherController::class, 'store']);
        Route::put('/{publisher}', [PublisherController::class, 'update']);
        Route::delete('/{publisher}', [PublisherController::class, 'destroy']);
    });

    // Publishers routes (read-only for all users)
    Route::prefix('publishers')->group(function () {
        Route::get('/search', [PublisherController::class, 'search']);
        Route::get('/{publisher}', [PublisherController::class, 'show']);
        Route::get('/{publisher}/games', [PublisherController::class, 'games']);
    });

    // Admin-only genres routes
    Route::middleware('admin')->prefix('genres')->group(function () {
        Route::post('/', [GenreController::class, 'store']);
        Route::put('/{genre}', [GenreController::class, 'update']);
        Route::delete('/{genre}', [GenreController::class, 'destroy']);
    });

    // Genres routes (read-only for all users)
    Route::prefix('genres')->group(function () {
        Route::get('/{genre}', [GenreController::class, 'show']);
        Route::get('/{genre}/games', [GenreController::class, 'games']);
    });

    // Admin-only platforms routes
    Route::middleware('admin')->prefix('platforms')->group(function () {
        Route::post('/', [PlatformController::class, 'store']);
        Route::put('/{platform}', [PlatformController::class, 'update']);
        Route::delete('/{platform}', [PlatformController::class, 'destroy']);
    });

    // Platforms routes (read-only for all users)
    Route::prefix('platforms')->group(function () {
        Route::get('/{platform}', [PlatformController::class, 'show']);
        Route::get('/{platform}/games', [PlatformController::class, 'games']);
    });// Reviews routes (protected)
    Route::prefix('reviews')->group(function () {
        Route::get('/{review}', [ReviewController::class, 'show']);
        Route::put('/{review}', [ReviewController::class, 'update']);
        Route::delete('/{review}', [ReviewController::class, 'destroy']);
    });

    // Favorites routes (protected)
    Route::prefix('favorites')->group(function () {
        Route::get('/', [App\Http\Controllers\FavoriteController::class, 'index']);
        Route::post('/', [App\Http\Controllers\FavoriteController::class, 'store']);
        Route::delete('/{game}', [App\Http\Controllers\FavoriteController::class, 'destroy']);
        Route::put('/{favorite}', [App\Http\Controllers\FavoriteController::class, 'update']);
        Route::get('/stats', [App\Http\Controllers\FavoriteController::class, 'stats']);
        Route::get('/check/{game}', [App\Http\Controllers\FavoriteController::class, 'check']);
    });
});
