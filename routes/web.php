<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
});

// API Documentation route
Route::get('/docs', function () {
    return view('api.documentation');
});