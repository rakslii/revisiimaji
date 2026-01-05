<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\PromoCodeController as AdminPromoCodeController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {
    // Login routes
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');
    
    // Protected admin routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/customers', [AdminController::class, 'customers'])->name('customers');
        Route::get('/customers/{id}', [AdminController::class, 'customerDetail'])->name('customers.show');
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
        Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
        
        // Orders
        Route::get('/orders', [AdminOrderController::class, 'orders'])->name('orders');
        Route::get('/orders/{id}', [AdminOrderController::class, 'orderDetail'])->name('orders.show');
        Route::put('/orders/{id}/status', [AdminOrderController::class, 'updateOrderStatus'])->name('orders.update-status');
        Route::post('/orders/{id}/confirm-payment', [AdminOrderController::class, 'confirmPayment'])->name('orders.confirm-payment');
        
        // Products
        Route::get('/products', [AdminProductController::class, 'products'])->name('products');
        Route::post('/products', [AdminProductController::class, 'storeProduct'])->name('products.store');
        Route::put('/products/{id}', [AdminProductController::class, 'updateProduct'])->name('products.update');
        Route::delete('/products/{id}', [AdminProductController::class, 'deleteProduct'])->name('products.delete');
        
        // Promo Codes
        Route::get('/promo-codes', [AdminPromoCodeController::class, 'promoCodes'])->name('promo-codes');
        Route::post('/promo-codes', [AdminPromoCodeController::class, 'storePromoCode'])->name('promo-codes.store');
        Route::put('/promo-codes/{id}', [AdminPromoCodeController::class, 'updatePromoCode'])->name('promo-codes.update');
        Route::delete('/promo-codes/{id}', [AdminPromoCodeController::class, 'deletePromoCode'])->name('promo-codes.delete');
    });
});