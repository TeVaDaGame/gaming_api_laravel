<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\DeveloperController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\PlatformController;
use App\Http\Controllers\ReviewController;

// Welcome route
Route::get('/', function () {
    return view('welcome');
});

// API Routes Group
Route::prefix('api')->middleware('api')->group(function () {
    // Games routes
    Route::prefix('games')->group(function () {
        Route::get('/', [GameController::class, 'index']);
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

    // Developers routes
    Route::prefix('developers')->group(function () {
        Route::get('/', [DeveloperController::class, 'index']);
        Route::post('/', [DeveloperController::class, 'store']);
        Route::get('/search', [DeveloperController::class, 'search']);
        Route::get('/{developer}', [DeveloperController::class, 'show']);
        Route::put('/{developer}', [DeveloperController::class, 'update']);
        Route::delete('/{developer}', [DeveloperController::class, 'destroy']);
        Route::get('/{developer}/games', [DeveloperController::class, 'games']);
    });

    // Publishers routes
    Route::prefix('publishers')->group(function () {
        Route::get('/', [PublisherController::class, 'index']);
        Route::post('/', [PublisherController::class, 'store']);
        Route::get('/search', [PublisherController::class, 'search']);
        Route::get('/{publisher}', [PublisherController::class, 'show']);
        Route::put('/{publisher}', [PublisherController::class, 'update']);
        Route::delete('/{publisher}', [PublisherController::class, 'destroy']);
        Route::get('/{publisher}/games', [PublisherController::class, 'games']);
    });

    // Genres routes
    Route::prefix('genres')->group(function () {
        Route::get('/', [GenreController::class, 'index']);
        Route::post('/', [GenreController::class, 'store']);
        Route::get('/{genre}', [GenreController::class, 'show']);
        Route::put('/{genre}', [GenreController::class, 'update']);
        Route::delete('/{genre}', [GenreController::class, 'destroy']);
        Route::get('/{genre}/games', [GenreController::class, 'games']);
    });

    // Platforms routes
    Route::prefix('platforms')->group(function () {
        Route::get('/', [PlatformController::class, 'index']);
        Route::post('/', [PlatformController::class, 'store']);
        Route::get('/{platform}', [PlatformController::class, 'show']);
        Route::put('/{platform}', [PlatformController::class, 'update']);
        Route::delete('/{platform}', [PlatformController::class, 'destroy']);
        Route::get('/{platform}/games', [PlatformController::class, 'games']);
    });

    // Reviews routes
    Route::prefix('reviews')->group(function () {
        Route::get('/', [ReviewController::class, 'index']);
        Route::post('/', [ReviewController::class, 'store']);
        Route::get('/{review}', [ReviewController::class, 'show']);
        Route::put('/{review}', [ReviewController::class, 'update']);
        Route::delete('/{review}', [ReviewController::class, 'destroy']);
    });
});

// API Documentation route
Route::get('/docs', function () {
    return view('api.documentation');
});