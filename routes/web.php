<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\ShortUrlController;

// Auth routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Test route
Route::get('/debug-test', fn() => 'Debug OK');

// Authenticated routes
Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/invite', [InviteController::class, 'create'])->name('invite');
    Route::post('/invite', [InviteController::class, 'store'])->name('invite.store');
    Route::post('/generate', [ShortUrlController::class, 'store'])->name('short.store');
});

// Public short link redirect
Route::get('/{shortCode}', [ShortUrlController::class, 'resolve'])->name('short.resolve');
