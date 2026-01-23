<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\PromoCodeController as AdminPromoCodeController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;

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

    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // ============ CUSTOMERS ============
    Route::prefix('customers')->name('customers.')->group(function () {
        Route::get('/', [AdminCustomerController::class, 'index'])->name('index');
        Route::get('/create', [AdminCustomerController::class, 'create'])->name('create');
        Route::post('/', [AdminCustomerController::class, 'store'])->name('store');
        Route::get('/{id}', [AdminCustomerController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [AdminCustomerController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AdminCustomerController::class, 'update'])->name('update');
        Route::delete('/{id}', [AdminCustomerController::class, 'destroy'])->name('destroy');
        Route::put('/{id}/status', [AdminCustomerController::class, 'updateStatus'])->name('status.update');
    });

    // Settings
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');

    // ============ ORDERS ============
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [AdminOrderController::class, 'index'])->name('index');
        Route::get('/create', [AdminOrderController::class, 'create'])->name('create');
        Route::post('/', [AdminOrderController::class, 'store'])->name('store');
        Route::get('/{id}', [AdminOrderController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [AdminOrderController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AdminOrderController::class, 'update'])->name('update');
        Route::delete('/{id}', [AdminOrderController::class, 'destroy'])->name('destroy');

        // Order Status Routes
        Route::post('/{id}/update-status', [AdminOrderController::class, 'updateOrderStatus'])->name('update-status');
        Route::post('/{id}/confirm-payment', [AdminOrderController::class, 'confirmPayment'])->name('confirm-payment');
        Route::post('/{id}/mark-processing', [AdminOrderController::class, 'markAsProcessing'])->name('mark-processing');
        Route::post('/{id}/mark-completed', [AdminOrderController::class, 'markAsCompleted'])->name('mark-completed');
    });

// ============ PRODUCTS ============
Route::prefix('products')->name('products.')->group(function () {
    Route::get('/', [AdminProductController::class, 'index'])->name('index');
    Route::get('/create', [AdminProductController::class, 'create'])->name('create');
    Route::post('/', [AdminProductController::class, 'store'])->name('store');
    Route::get('/{id}', [AdminProductController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [AdminProductController::class, 'edit'])->name('edit');
    Route::put('/{id}', [AdminProductController::class, 'update'])->name('update');
    Route::delete('/{id}', [AdminProductController::class, 'destroy'])->name('destroy');

    // API routes untuk image handling (ditambahkan)
    Route::post('/{id}/upload-image', [AdminProductController::class, 'uploadImage'])->name('upload-image');
    Route::delete('/{id}/delete-image', [AdminProductController::class, 'deleteImage'])->name('delete-image');
});

    // ============ PROMO CODES ============
    Route::prefix('promo-codes')->name('promo-codes.')->group(function () {
        Route::get('/', [AdminPromoCodeController::class, 'index'])->name('index');
        Route::post('/', [AdminPromoCodeController::class, 'store'])->name('store');
        Route::put('/{id}', [AdminPromoCodeController::class, 'update'])->name('update');
        Route::delete('/{id}', [AdminPromoCodeController::class, 'destroy'])->name('destroy');
    });
});
