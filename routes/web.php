<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController as FrontProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;

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

// ... kode sebelumnya ...

// Logout route
Route::post('/logout', function() {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Admin Routes
Route::get('/admin/dashboard', function () {
    return view('pages.admin.dashboard');
});



require __DIR__.'/auth.php';

// Fallback for Vue SPA
Route::get('/{any}', [HomeController::class, 'index'])->where('any', '.*');


