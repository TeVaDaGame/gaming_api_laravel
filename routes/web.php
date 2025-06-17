<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

// Welcome route
Route::get('/', function () {
    return view('index');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Test route to check if admin middleware works
Route::get('/admin-test', function () {
    return 'Admin middleware is working!';
})->middleware(['auth', 'admin']);

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [AuthController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::get('/settings', [AuthController::class, 'settings'])->name('settings');
    Route::put('/settings', [AuthController::class, 'updateSettings'])->name('settings.update');
    
    // Review routes (all authenticated users)
    Route::get('/reviews', [App\Http\Controllers\ReviewController::class, 'reviewsIndex'])->name('reviews.index');
    Route::get('/reviews/create', [App\Http\Controllers\ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/reviews', [App\Http\Controllers\ReviewController::class, 'storeWeb'])->name('reviews.store');
    Route::get('/reviews/{review}/edit', [App\Http\Controllers\ReviewController::class, 'edit'])->name('reviews.edit');
    Route::put('/reviews/{review}', [App\Http\Controllers\ReviewController::class, 'updateWeb'])->name('reviews.update');
    Route::delete('/reviews/{review}', [App\Http\Controllers\ReviewController::class, 'destroyWeb'])->name('reviews.destroy');
    
    // Admin only routes
    Route::middleware('admin')->group(function () {
        // Admin dashboard
        Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
        
        // User management
        Route::get('/admin/users', [App\Http\Controllers\AdminController::class, 'users'])->name('admin.users');
        Route::put('/admin/users/{user}/role', [App\Http\Controllers\AdminController::class, 'updateUserRole'])->name('admin.users.update-role');
        Route::delete('/admin/users/{user}', [App\Http\Controllers\AdminController::class, 'deleteUser'])->name('admin.users.delete');
        
        // Game management
        Route::get('/games/manage', [App\Http\Controllers\GameController::class, 'manage'])->name('games.manage');
        Route::get('/games/create', [App\Http\Controllers\GameController::class, 'create'])->name('games.create');
        Route::post('/games', [App\Http\Controllers\GameController::class, 'storeWeb'])->name('games.store');
        Route::get('/games/{game}/edit', [App\Http\Controllers\GameController::class, 'edit'])->name('games.edit');
        Route::put('/games/{game}', [App\Http\Controllers\GameController::class, 'updateWeb'])->name('games.update');
        Route::delete('/games/{game}', [App\Http\Controllers\GameController::class, 'destroyWeb'])->name('games.destroy');
        Route::delete('/games/bulk-delete', [App\Http\Controllers\GameController::class, 'bulkDelete'])->name('games.bulk-delete');
    });
    
    // All authenticated users can search
    Route::get('/games/search', [App\Http\Controllers\GameController::class, 'searchPage'])->name('games.search');
    Route::get('/games/{game}', [App\Http\Controllers\GameController::class, 'show'])->name('games.show');
});

// API Documentation route
Route::get('/docs', function () {
    return view('api.documentation');
});