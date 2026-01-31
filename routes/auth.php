<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleLoginController;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

// Redirect login ke Google OAuth langsung
Route::get('/login', function() {
    return redirect()->route('google.login');
})->name('login');

// Jika ada yang akses register, redirect ke Google juga
Route::get('/register', function() {
    return redirect()->route('google.login');
})->name('register');

// Google OAuth Routes
Route::get('/auth/google', [GoogleLoginController::class, 'redirectToGoogle'])
    ->name('google.login');
    
Route::get('/auth/google/callback', [GoogleLoginController::class, 'handleGoogleCallback'])
    ->name('google.callback');

// Logout
Route::post('/logout', function() {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');