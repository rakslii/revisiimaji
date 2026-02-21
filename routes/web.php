<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController as FrontProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController as FrontOrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\GoogleLoginController;
use App\Http\Controllers\MidtransController;

// Import models untuk About Us dan Consultation
use App\Models\AboutUsSection;
use App\Models\TeamMember;
use App\Models\Achievement;
use App\Models\CoreValue;
use App\Models\ConsultationGeneral;
use App\Models\ConsultationProduct;
use App\Models\ConsultationCustomProduct;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// ===== ABOUT US ROUTE =====
Route::get('/about-us', function () {
    try {
        // Ambil semua data untuk halaman about us dari database
        $sections = AboutUsSection::active()->ordered()->get();
        
        // Kelompokkan section berdasarkan type
        $heroSection = $sections->where('section_type', 'hero')->first();
        $storySection = $sections->where('section_type', 'story')->first();
        $missionSection = $sections->where('section_type', 'mission')->first();
        $valuesSection = $sections->where('section_type', 'values')->first();
        $teamSection = $sections->where('section_type', 'team')->first();
        $statsSection = $sections->where('section_type', 'stats')->first();
        $technologySection = $sections->where('section_type', 'technology')->first();
        $ctaSection = $sections->where('section_type', 'cta')->first();
        
        // Ambil data dari tabel lain
        $teamMembers = TeamMember::active()->ordered()->get();
        $achievements = Achievement::active()->ordered()->get();
        $coreValues = CoreValue::active()->ordered()->get();
        
        // PERBAIKAN: Gunakan view 'pages.about' yang sudah ada
        return view('pages.about', compact(
            'heroSection',
            'storySection',
            'missionSection',
            'valuesSection',
            'teamSection',
            'statsSection',
            'technologySection',
            'ctaSection',
            'teamMembers',
            'achievements',
            'coreValues'
        ));
    } catch (\Exception $e) {
        // Jika terjadi error, tampilkan halaman about us dengan data default
        \Log::error('Error loading about us page: ' . $e->getMessage());
        
        // Data default jika database error
        $sections = collect();
        $teamMembers = collect();
        $achievements = collect();
        $coreValues = collect();
        
        // PERBAIKAN: Gunakan view 'pages.about' yang sudah ada
        return view('pages.about', compact(
            'sections',
            'teamMembers',
            'achievements',
            'coreValues'
        ));
    }
})->name('about-us');
// =======================
// WHATSAPP CONSULTATION ROUTES
// =======================

// General WhatsApp (Navbar, Home, CTA)
Route::get('/whatsapp-chat', function () {
    try {
        $consultation = ConsultationGeneral::where('is_active', true)->first();
        
        if ($consultation) {
            return redirect()->away($consultation->getWhatsAppUrl());
        }
    } catch (\Exception $e) {
        \Log::error('WhatsApp General Error: ' . $e->getMessage());
    }
    
    // Fallback jika tidak ada data atau error
    $number = env('WHATSAPP_NUMBER', '6281234567890');
    $message = env('WHATSAPP_MESSAGE', 'Halo Cipta Imaji, saya ingin konsultasi');
    return redirect()->away("https://wa.me/{$number}?text=" . urlencode($message));
})->name('whatsapp.chat');

// Product WhatsApp (per produk)
Route::get('/product/{id}/whatsapp', function ($id) {
    try {
        $product = App\Models\Product::findOrFail($id);
        $consultation = ConsultationProduct::where('is_active', true)->first();
        
        if ($consultation) {
            return redirect()->away($consultation->getWhatsAppUrl($product));
        }
    } catch (\Exception $e) {
        \Log::error('WhatsApp Product Error: ' . $e->getMessage());
    }
    
    // Fallback
    $number = env('WHATSAPP_NUMBER', '6281234567890');
    $message = "Halo, saya tertarik dengan produk ini. Bisa info lebih lanjut?";
    return redirect()->away("https://wa.me/{$number}?text=" . urlencode($message));
})->name('product.whatsapp');

// Custom Product WhatsApp
Route::get('/custom-product/{slug}/whatsapp', function ($slug) {
    try {
        $consultation = ConsultationCustomProduct::where('is_active', true)->first();
        
        if ($consultation) {
            // Ubah slug menjadi nama produk yang bagus (contoh: "kaos-custom" -> "Kaos Custom")
            $productName = str_replace('-', ' ', $slug);
            $productName = ucwords($productName);
            
            return redirect()->away($consultation->getWhatsAppUrl($productName));
        }
    } catch (\Exception $e) {
        \Log::error('WhatsApp Custom Error: ' . $e->getMessage());
    }
    
    // Fallback
    $number = env('WHATSAPP_NUMBER', '6281234567890');
    $message = "Halo, saya ingin konsultasi tentang produk custom.";
    return redirect()->away("https://wa.me/{$number}?text=" . urlencode($message));
})->name('custom.whatsapp');

// OPTIONAL: Route WhatsApp dengan parameter tipe (versi ringkas)
Route::get('/wa/{type?}/{param?}', function ($type = 'general', $param = null) {
    try {
        if ($type == 'product' && $param) {
            $product = App\Models\Product::find($param);
            $consultation = ConsultationProduct::where('is_active', true)->first();
            
            if ($consultation && $product) {
                return redirect()->away($consultation->getWhatsAppUrl($product));
            }
        }
        elseif ($type == 'custom' && $param) {
            $consultation = ConsultationCustomProduct::where('is_active', true)->first();
            $productName = str_replace('-', ' ', $param);
            $productName = ucwords($productName);
            
            if ($consultation) {
                return redirect()->away($consultation->getWhatsAppUrl($productName));
            }
        }
        else {
            $consultation = ConsultationGeneral::where('is_active', true)->first();
            
            if ($consultation) {
                return redirect()->away($consultation->getWhatsAppUrl());
            }
        }
    } catch (\Exception $e) {
        \Log::error('WhatsApp Route Error: ' . $e->getMessage());
    }
    
    // Fallback
    $number = env('WHATSAPP_NUMBER', '6281234567890');
    $message = env('WHATSAPP_MESSAGE', 'Halo Cipta Imaji, saya ingin konsultasi');
    return redirect()->away("https://wa.me/{$number}?text=" . urlencode($message));
})->name('wa');

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
Route::get('/categories', [FrontProductController::class, 'categories'])->name('products.index');


// Route untuk Live Search
Route::post('/products/live-search', [FrontProductController::class, 'liveSearch'])->name('products.live-search');

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
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
    Route::post('/{item}', [CartController::class, 'update'])->name('update');
    Route::delete('/{item}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/', [CartController::class, 'clear'])->name('clear');
    
    // ✅ TAMBAHKAN INI
    Route::get('/count', [CartController::class, 'getCartCount'])->name('count');
    
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
});

// Checkout process
Route::post('/checkout/process', [CartController::class, 'processCheckout'])
    ->name('checkout.process');


// =======================
// ORDERS (LOGIN)
// =======================
Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [FrontOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [FrontOrderController::class, 'showOrder'])->name('orders.show');
    Route::get('/orders/{id}/payment', [FrontOrderController::class, 'payment'])->name('orders.payment');
    Route::post('/orders/{id}/check-payment-status', [FrontOrderController::class, 'checkPaymentStatus'])->name('orders.checkPaymentStatus');
});


// =======================
// MIDTRANS NOTIFICATION
// =======================
Route::post('/midtrans/notification', [MidtransController::class, 'notification'])
    ->name('midtrans.notification');


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