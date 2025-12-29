<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleLoginController;
use App\Http\Controllers\Auth\AuthController;

// Frontend Controllers
use App\Http\Controllers\ProductController as FrontProductController;
use App\Http\Controllers\OrderController as FrontOrderController;
use App\Http\Controllers\LocationController as FrontLocationController;
use App\Http\Controllers\PromoCodeController as FrontPromoCodeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;

// API Controllers
use App\Http\Controllers\API\LocationController as ApiLocationController;
use App\Http\Controllers\API\PaymentCallbackController;
use App\Http\Controllers\API\WhatsAppController;

// Admin Controllers
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\OrderManagementController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ProductManagementController;
use App\Http\Controllers\Admin\PromoCodeController as AdminPromoCodeController;
use App\Http\Controllers\Admin\PromoCodeManagementController;
use App\Http\Controllers\Admin\SettingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Homepage - Tampilkan halaman home
Route::get('/', [HomeController::class, 'index'])->name('home');

// PUBLIC PAGES - Tambahkan route untuk public access
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

// Login/Register Routes
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

// Profile Routes
Route::middleware(['auth'])->prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [\App\Http\Controllers\ProfileController::class, 'index'])->name('index');
    Route::put('/', [\App\Http\Controllers\ProfileController::class, 'update'])->name('update');
    Route::post('/locations', [\App\Http\Controllers\ProfileController::class, 'storeLocation'])->name('locations.store');
    Route::delete('/locations/{location}', [\App\Http\Controllers\ProfileController::class, 'deleteLocation'])->name('locations.delete');
});

// Profile Routes
Route::middleware(['auth'])->prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('index');
    Route::get('/profile/locations/{location}/edit', [ProfileController::class, 'editLocation'])->name('profile.locations.edit');
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

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {
    // Admin Login Page
    Route::get('/login', function () {
        return view('admin.login');
    })->name('login');

    // Admin Dashboard & Routes (protected)
    Route::middleware(['auth:sanctum', 'admin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Order Management
        Route::get('/orders', [AdminOrderController::class, 'orders'])->name('orders');
        Route::get('/orders/{id}', [AdminOrderController::class, 'orderDetail'])->name('orders.show');
        Route::put('/orders/{id}/status', [AdminOrderController::class, 'updateOrderStatus'])->name('orders.update-status');
        Route::post('/orders/{id}/confirm-payment', [AdminOrderController::class, 'confirmPayment'])->name('orders.confirm-payment');

        // Product Management
        Route::get('/products', [AdminProductController::class, 'products'])->name('products');
        Route::post('/products', [AdminProductController::class, 'storeProduct'])->name('products.store');
        Route::put('/products/{id}', [AdminProductController::class, 'updateProduct'])->name('products.update');
        Route::delete('/products/{id}', [AdminProductController::class, 'deleteProduct'])->name('products.delete');

        // Promo Code Management
        Route::get('/promo-codes', [AdminPromoCodeController::class, 'promoCodes'])->name('promo-codes');
        Route::post('/promo-codes', [AdminPromoCodeController::class, 'storePromoCode'])->name('promo-codes.store');
        Route::put('/promo-codes/{id}', [AdminPromoCodeController::class, 'updatePromoCode'])->name('promo-codes.update');
        Route::delete('/promo-codes/{id}', [AdminPromoCodeController::class, 'deletePromoCode'])->name('promo-codes.delete');

        // Customer Management
        Route::get('/customers', [AdminController::class, 'customers'])->name('customers');
        Route::get('/customers/{id}', [AdminController::class, 'customerDetail'])->name('customers.show');

        // Settings
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
        Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
    });
});

// Fallback for Vue SPA - tampilkan halaman home juga
Route::get('/{any}', [HomeController::class, 'index'])->where('any', '.*');
/*
|--------------------------------------------------------------------------
| API Routes (for Vue Frontend)
|--------------------------------------------------------------------------
*/// Tambahkan route orders.index untuk web
Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [\App\Http\Controllers\OrderController::class, 'showOrder'])->name('orders.show');
});

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
// Cart Routes
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
    Route::post('/{item}', [CartController::class, 'update'])->name('update');
    Route::delete('/{item}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/', [CartController::class, 'clear'])->name('clear');
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::get('/count', [CartController::class, 'getCartCount'])->name('count');
});
/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {
    // Admin Login Page
    Route::get('/login', function () {
        return view('admin.login');
    })->name('login');

    // Admin Dashboard & Routes (protected)
    Route::middleware(['auth:sanctum', 'admin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Order Management
        Route::get('/orders', [AdminOrderController::class, 'orders'])->name('orders');
        Route::get('/orders/{id}', [AdminOrderController::class, 'orderDetail'])->name('orders.show');
        Route::put('/orders/{id}/status', [AdminOrderController::class, 'updateOrderStatus'])->name('orders.update-status');
        Route::post('/orders/{id}/confirm-payment', [AdminOrderController::class, 'confirmPayment'])->name('orders.confirm-payment');

        // Product Management
        Route::get('/products', [AdminProductController::class, 'products'])->name('products');
        Route::post('/products', [AdminProductController::class, 'storeProduct'])->name('products.store');
        Route::put('/products/{id}', [AdminProductController::class, 'updateProduct'])->name('products.update');
        Route::delete('/products/{id}', [AdminProductController::class, 'deleteProduct'])->name('products.delete');

        // Promo Code Management
        Route::get('/promo-codes', [AdminPromoCodeController::class, 'promoCodes'])->name('promo-codes');
        Route::post('/promo-codes', [AdminPromoCodeController::class, 'storePromoCode'])->name('promo-codes.store');
        Route::put('/promo-codes/{id}', [AdminPromoCodeController::class, 'updatePromoCode'])->name('promo-codes.update');
        Route::delete('/promo-codes/{id}', [AdminPromoCodeController::class, 'deletePromoCode'])->name('promo-codes.delete');

        // Customer Management
        Route::get('/customers', [AdminController::class, 'customers'])->name('customers');
        Route::get('/customers/{id}', [AdminController::class, 'customerDetail'])->name('customers.show');

        // Settings
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
        Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
    });
});

// Fallback for Vue SPA - tampilkan halaman home juga
Route::get('/{any}', [HomeController::class, 'index'])->where('any', '.*');
