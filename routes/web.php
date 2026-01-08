<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController as FrontProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController as FrontOrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\GoogleLoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| WEB ROUTES
|--------------------------------------------------------------------------
*/

// =======================
// LOGIN (CUSTOM POST)
// =======================
Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->route('admin.dashboard');
    }

    return back()->withErrors([
        'email' => 'Email atau password salah',
    ]);
})->name('login.post');


// =======================
// PUBLIC
// =======================
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/products', [FrontProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [FrontProductController::class, 'show'])->name('products.show');
Route::get('/categories', [FrontProductController::class, 'categories'])->name('products.categories');

Route::get('/whatsapp', function () {
    $number = env('WHATSAPP_NUMBER', '6281234567890');
    $message = env('WHATSAPP_MESSAGE', 'Halo Cipta Imaji, saya ingin konsultasi');
    return redirect()->away("https://wa.me/{$number}?text={$message}");
})->name('whatsapp.chat');

Route::get('/track-order', function () {
    return view('pages.orders.track');
})->name('orders.track');


// =======================
// GOOGLE LOGIN
// =======================
Route::get('/auth/google', [GoogleLoginController::class, 'redirectToGoogle'])
    ->name('google.login');

Route::get('/auth/google/callback', [GoogleLoginController::class, 'handleGoogleCallback'])
    ->name('google.callback');


// =======================
// CART ROUTES
// =======================
Route::prefix('cart')->name('cart.')->group(function () {
    // View cart
    Route::get('/', [CartController::class, 'index'])->name('index');
    
    // Cart operations
    Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
    Route::post('/{item}', [CartController::class, 'update'])->name('update');
    Route::delete('/{item}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/', [CartController::class, 'clear'])->name('clear');
    Route::get('/count', [CartController::class, 'getCartCount'])->name('count');
    
    // Checkout routes
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::post('/process', [CartController::class, 'processCheckout'])->name('process');
});


// =======================
// ORDERS (LOGIN)
// =======================
Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [FrontOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [FrontOrderController::class, 'showOrder'])->name('orders.show');
});


// =======================
// PROFILE
// =======================
Route::middleware(['auth'])->prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('index');
    Route::put('/', [ProfileController::class, 'update'])->name('update');

    Route::post('/locations', [ProfileController::class, 'storeLocation'])->name('locations.store');
    Route::put('/locations/{location}', [ProfileController::class, 'updateLocation'])->name('locations.update');
    Route::get('/locations/{location}/edit', [ProfileController::class, 'editLocation'])->name('locations.edit');
    Route::post('/locations/{location}/set-primary', [ProfileController::class, 'setPrimaryLocation'])->name('locations.setPrimary');
    Route::delete('/locations/{location}', [ProfileController::class, 'deleteLocation'])->name('locations.delete');
});


// =======================
// LOGOUT
// =======================
Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');


// =======================
// ADMIN & AUTH
// =======================
require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';


// =======================
// FALLBACK (PALING BAWAH)
// =======================
Route::get('/{any}', [HomeController::class, 'index'])
    ->where('any', '.*');