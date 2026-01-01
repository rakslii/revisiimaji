<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProductController as FrontProductController;
use App\Http\Controllers\PromoCodeController as FrontPromoCodeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\LocationController as FrontLocationController;
use App\Http\Controllers\OrderController as FrontOrderController;

/*
|--------------------------------------------------------------------------
| API Routes (for Vue Frontend)
|--------------------------------------------------------------------------
*/

// Public API Routes
Route::prefix('api')->group(function () {
    // Auth check (public)
    Route::get('/auth/check', [AuthController::class, 'check']);

    // Products
    Route::get('/products', [FrontProductController::class, 'index']);
    Route::get('/products/{id}', [FrontProductController::class, 'show']);
    Route::get('/categories', [FrontProductController::class, 'categories']);

    // Promo code check
    Route::post('/promo/check', [FrontPromoCodeController::class, 'check']);

    // Payment callback (Midtrans webhook)
    Route::post('/payment/callback', [PaymentController::class, 'handleCallback']);
});

// Protected API Routes (require authentication)
Route::prefix('api')->middleware(['auth:sanctum'])->group(function () {
    // Auth
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    // Locations
    Route::get('/locations', [FrontLocationController::class, 'index']);
    Route::post('/locations', [FrontLocationController::class, 'store']);
    Route::put('/locations/{id}', [FrontLocationController::class, 'update']);
    Route::delete('/locations/{id}', [FrontLocationController::class, 'destroy']);
    Route::post('/locations/{id}/set-primary', [FrontLocationController::class, 'setPrimary']);

    // Orders
    Route::get('/orders', [FrontOrderController::class, 'userOrders']);
    Route::get('/orders/{id}', [FrontOrderController::class, 'show']);
    Route::post('/orders', [FrontOrderController::class, 'store']);

    // Promo codes (user)
    Route::get('/promo-codes/available', [FrontPromoCodeController::class, 'available']);
});
