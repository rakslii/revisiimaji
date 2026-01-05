<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleLoginController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController as FrontProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\PromoCodeController as AdminPromoCodeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// PUBLIC PAGES
Route::get('/products', [FrontProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [FrontProductController::class, 'show'])->name('products.show');
Route::get('/categories', [FrontProductController::class, 'categories'])->name('products.categories');

// WhatsApp Route
Route::get('/whatsapp', function() {
    $number = env('WHATSAPP_NUMBER', '6281234567890');
    $message = env('WHATSAPP_MESSAGE', 'Halo Cipta Imaji, saya ingin konsultasi');
    return redirect()->away("https://wa.me/{$number}?text={$message}");
})->name('whatsapp.chat');

// Cart Route
Route::get('/cart', function() {
    return view('pages.cart.index');
})->name('cart.index');

// Track Order Route
Route::get('/track-order', function() {
    return view('pages.orders.track');
})->name('orders.track');

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

// Web Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Cart Routes
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
    Route::post('/{item}', [CartController::class, 'update'])->name('update');
    Route::delete('/{item}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/', [CartController::class, 'clear'])->name('clear');
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::get('/count', [CartController::class, 'getCartCount'])->name('count');
});

// Orders Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'showOrder'])->name('orders.show');
});

// Profile Routes
Route::middleware(['auth'])->prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('index');
    Route::put('/', [ProfileController::class, 'update'])->name('update');

    // Location Routes
    Route::post('/locations', [ProfileController::class, 'storeLocation'])->name('locations.store');
    Route::put('/locations/{location}', [ProfileController::class, 'updateLocation'])->name('locations.update');
    Route::get('/locations/{location}/edit', [ProfileController::class, 'editLocation'])->name('locations.edit');
    Route::post('/locations/{location}/set-primary', [ProfileController::class, 'setPrimaryLocation'])->name('locations.setPrimary');
    Route::delete('/locations/{location}', [ProfileController::class, 'deleteLocation'])->name('locations.delete');
});

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
 
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/customers', [AdminController::class, 'customers'])->name('customers');
        Route::get('/customers/{id}', [AdminController::class, 'customerDetail'])->name('customers.show');
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
        Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
        
        // Orders
        Route::get('/orders', [OrderController::class, 'orders'])->name('orders');
        Route::get('/orders/{id}', [OrderController::class, 'orderDetail'])->name('orders.show');
        Route::put('/orders/{id}/status', [OrderController::class, 'updateOrderStatus'])->name('orders.update-status');
        Route::post('/orders/{id}/confirm-payment', [OrderController::class, 'confirmPayment'])->name('orders.confirm-payment');
        
        // Products
        Route::get('/products', [ProductController::class, 'products'])->name('products');
        Route::post('/products', [ProductController::class, 'storeProduct'])->name('products.store');
        Route::put('/products/{id}', [ProductController::class, 'updateProduct'])->name('products.update');
        Route::delete('/products/{id}', [ProductController::class, 'deleteProduct'])->name('products.delete');
        
        // Promo Codes
        Route::get('/promo-codes', [PromoCodeController::class, 'promoCodes'])->name('promo-codes');
        Route::post('/promo-codes', [PromoCodeController::class, 'storePromoCode'])->name('promo-codes.store');
        Route::put('/promo-codes/{id}', [PromoCodeController::class, 'updatePromoCode'])->name('promo-codes.update');
        Route::delete('/promo-codes/{id}', [PromoCodeController::class, 'deletePromoCode'])->name('promo-codes.delete');
    });
// Fallback for Vue SPA
Route::get('/{any}', [HomeController::class, 'index'])->where('any', '.*');