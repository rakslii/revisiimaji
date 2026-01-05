<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleLoginController;
use App\Http\Controllers\Auth\AuthController;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

// Login/Register Pages
Route::get('/login', function() {
    return view('auth.login');
})->name('login');

Route::get('/register', function() {
    return view('auth.register');
})->name('register');

// Google OAuth Routes
Route::get('/auth/google', [GoogleLoginController::class, 'redirectToGoogle'])
    ->name('google.login');
Route::get('/auth/google/callback', [GoogleLoginController::class, 'handleGoogleCallback'])
    ->name('google.callback');

// Web Logout - PERHATIKAN INI
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// ATAU jika AuthController tidak ada method logout, ganti dengan:
// Route::post('/logout', function() {
//     auth()->logout();
//     return redirect('/');
// })->name('logout');
