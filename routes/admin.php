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
    // Login routes (TANPA middleware)
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');
    
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Customers - RESTful routes (Pindah ke CustomerController)
    Route::get('/customers', [AdminCustomerController::class, 'customers'])->name('customers');
    Route::get('/customers/create', [AdminCustomerController::class, 'create'])->name('customers.create');
    Route::post('/customers', [AdminCustomerController::class, 'store'])->name('customers.store');
    Route::get('/customers/{id}', [AdminCustomerController::class, 'customerDetail'])->name('customers.show');
    Route::get('/customers/{id}/edit', [AdminCustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/customers/{id}', [AdminCustomerController::class, 'update'])->name('customers.update');
    Route::delete('/customers/{id}', [AdminCustomerController::class, 'destroy'])->name('customers.destroy');
    Route::put('/customers/{id}/status', [AdminCustomerController::class, 'updateStatus'])->name('customers.update-status');

    // Settings (Tetap di AdminController)
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');

     // Orders - RESTful routes dengan method yang benar
    Route::get('/orders', [AdminOrderController::class, 'orders'])->name('orders');
    Route::get('/orders/create', [AdminOrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [AdminOrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{id}', [AdminOrderController::class, 'orderDetail'])->name('orders.show');
    Route::get('/orders/{id}/edit', [AdminOrderController::class, 'edit'])->name('orders.edit');
    Route::put('/orders/{id}', [AdminOrderController::class, 'update'])->name('orders.update');
    Route::delete('/orders/{id}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');
    
    // Order Status Routes - Gunakan POST untuk semua agar konsisten
    Route::post('/orders/{id}/update-status', [AdminOrderController::class, 'updateOrderStatus'])->name('orders.update-status');
    Route::post('/orders/{id}/confirm-payment', [AdminOrderController::class, 'confirmPayment'])->name('orders.confirm-payment');
    Route::post('/orders/{id}/mark-processing', [AdminOrderController::class, 'markAsProcessing'])->name('orders.mark-processing');
    Route::post('/orders/{id}/mark-completed', [AdminOrderController::class, 'markAsCompleted'])->name('orders.mark-completed');
    
    // Products - RESTful routes
    Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [AdminProductController::class, 'create'])->name('products.create');
    Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}', [AdminProductController::class, 'show'])->name('products.show');
    Route::get('/products/{id}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [AdminProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [AdminProductController::class, 'destroy'])->name('products.destroy');

    // Promo Codes
    Route::get('/promo-codes', [AdminPromoCodeController::class, 'promoCodes'])->name('promo-codes');
    Route::post('/promo-codes', [AdminPromoCodeController::class, 'storePromoCode'])->name('promo-codes.store');
    Route::put('/promo-codes/{id}', [AdminPromoCodeController::class, 'updatePromoCode'])->name('promo-codes.update');
    Route::delete('/promo-codes/{id}', [AdminPromoCodeController::class, 'deletePromoCode'])->name('promo-codes.delete');
});