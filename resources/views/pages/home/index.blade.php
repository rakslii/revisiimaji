@extends('layouts.app')

@section('title', 'Cipta Imaji - Digital Printing Terpercaya')

@section('content')
<!-- Hero Section dengan gambar background -->
<section class="relative bg-gradient-to-r from-blue-700 to-blue-900 text-white overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 bg-black opacity-10"></div>
    <div class="absolute top-0 right-0 w-64 h-64 bg-blue-500 rounded-full -mt-32 -mr-32 opacity-20"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-purple-500 rounded-full -mb-48 -ml-48 opacity-20"></div>
    
    <div class="container mx-auto px-4 py-16 md:py-24 relative z-10">
        <div class="max-w-3xl">
            <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
                Cetak Karya, <span class="text-yellow-300">Wujudkan Imajinasi</span>
            </h1>
            <p class="text-xl md:text-2xl mb-8 opacity-90">
                Layanan digital printing lengkap untuk kebutuhan bisnis, acara, dan personal dengan kualitas premium.
            </p>
            
            <!-- Search Bar (inspirasi Shopee) -->
            <div class="bg-white rounded-lg p-1 shadow-xl mb-8 max-w-2xl">
                <div class="flex">
                    <input type="text" 
                           placeholder="Cari produk printing yang Anda butuhkan..."
                           class="flex-grow px-6 py-4 text-gray-800 rounded-l-lg focus:outline-none text-lg">
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-r-lg font-semibold transition duration-300">
                        <i class="fas fa-search mr-2"></i>Cari
                    </button>
                </div>
            </div>
            
            <div class="flex flex-col md:flex-row gap-4">
                <a href="{{ route('products.index') }}" 
                   class="bg-yellow-400 text-blue-900 px-8 py-4 rounded-lg font-bold hover:bg-yellow-300 transition duration-300 shadow-lg hover:shadow-xl flex items-center justify-center text-lg">
                    <i class="fas fa-shopping-bag mr-3"></i> Belanja Sekarang
                </a>
                <a href="{{ route('whatsapp.chat') }}" target="_blank" 
                   class="bg-green-500 text-white px-8 py-4 rounded-lg font-bold hover:bg-green-600 transition duration-300 shadow-lg hover:shadow-xl flex items-center justify-center text-lg">
                    <i class="fab fa-whatsapp mr-3"></i> Konsultasi Gratis
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Promo Banner (inspirasi Shopee) -->
<section class="bg-gradient-to-r from-red-500 to-pink-500 text-white py-6">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-center space-x-4">
            <i class="fas fa-gift text-2xl"></i>
            <span class="text-lg font-semibold">🎁 PROMO SPESIAL: Dapatkan Diskon 20% untuk Order Pertama!</span>
            <a href="{{ route('products.index') }}" class="bg-white text-red-500 px-4 py-1 rounded-full font-bold hover:bg-gray-100 ml-4">
                Klaim Sekarang
            </a>
        </div>
    </div>
</section>

<!-- Features Grid -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-4">Mengapa Memilih <span class="text-blue-600">Cipta Imaji</span>?</h2>
        <p class="text-gray-600 text-center mb-12 max-w-2xl mx-auto">Kami memberikan pengalaman terbaik dalam layanan digital printing</p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Feature 1 -->
            <div class="bg-gradient-to-br from-blue-50 to-white p-6 rounded-xl shadow-md hover:shadow-lg transition duration-300 border border-blue-100">
                <div class="w-14 h-14 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center mb-5">
                    <i class="fas fa-shipping-fast text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-3">Gratis Ongkir</h3>
                <p class="text-gray-600">Gratis ongkir untuk order minimal Rp 500.000 di area Jabodetabek</p>
            </div>
            
            <!-- Feature 2 -->
            <div class="bg-gradient-to-br from-green-50 to-white p-6 rounded-xl shadow-md hover:shadow-lg transition duration-300 border border-green-100">
                <div class="w-14 h-14 bg-gradient-to-r from-green-500 to-green-600 rounded-full flex items-center justify-center mb-5">
                    <i class="fas fa-shield-alt text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-3">Garansi 100%</h3>
                <p class="text-gray-600">Uang kembali 100% jika produk tidak sesuai dengan pesanan</p>
            </div>
            
            <!-- Feature 3 -->
            <div class="bg-gradient-to-br from-purple-50 to-white p-6 rounded-xl shadow-md hover:shadow-lg transition duration-300 border border-purple-100">
                <div class="w-14 h-14 bg-gradient-to-r from-purple-500 to-purple-600 rounded-full flex items-center justify-center mb-5">
                    <i class="fas fa-headset text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-3">Support 24/7</h3>
                <p class="text-gray-600">Tim customer service siap membantu 24 jam via WhatsApp</p>
            </div>
            
            <!-- Feature 4 -->
            <div class="bg-gradient-to-br from-orange-50 to-white p-6 rounded-xl shadow-md hover:shadow-lg transition duration-300 border border-orange-100">
                <div class="w-14 h-14 bg-gradient-to-r from-orange-500 to-orange-600 rounded-full flex items-center justify-center mb-5">
                    <i class="fas fa-qrcode text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-3">Pembayaran Lengkap</h3>
                <p class="text-gray-600">Bayar dengan QRIS, Transfer Bank, E-Wallet & COD (Jabodetabek)</p>
            </div>
        </div>
    </div>
</section>

<!-- Product Categories dengan gambar -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-10">
            <div>
                <h2 class="text-3xl font-bold">Kategori <span class="text-blue-600">Produk</span></h2>
                <p class="text-gray-600 mt-2">Temukan produk printing sesuai kebutuhan Anda</p>
            </div>
            <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold flex items-center">
                Lihat Semua <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Category 1 -->
            <a href="{{ route('products.index') }}?category=instan" 
               class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition duration-300">
                <div class="h-64 bg-gradient-to-r from-blue-500 to-blue-700 relative">
                    <div class="absolute inset-0 bg-black opacity-20"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <i class="fas fa-print text-white text-8xl opacity-30"></i>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                        <h3 class="text-2xl font-bold mb-2">Produk Instan</h3>
                        <p class="opacity-90">Siap cetak dalam 24 jam</p>
                        <div class="mt-3 flex items-center">
                            <span class="bg-white text-blue-600 px-3 py-1 rounded-full text-sm font-bold">
                                Mulai Rp 25.000
                            </span>
                            <span class="ml-auto group-hover:translate-x-2 transition-transform">
                                <i class="fas fa-arrow-right"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </a>
            
            <!-- Category 2 -->
            <a href="{{ route('products.index') }}?category=non-instan" 
               class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition duration-300">
                <div class="h-64 bg-gradient-to-r from-purple-500 to-purple-700 relative">
                    <div class="absolute inset-0 bg-black opacity-20"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <i class="fas fa-paint-brush text-white text-8xl opacity-30"></i>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                        <h3 class="text-2xl font-bold mb-2">Produk Custom</h3>
                        <p class="opacity-90">Desain sesuai kebutuhan Anda</p>
                        <div class="mt-3 flex items-center">
                            <span class="bg-white text-purple-600 px-3 py-1 rounded-full text-sm font-bold">
                                Konsultasi Gratis
                            </span>
                            <span class="ml-auto group-hover:translate-x-2 transition-transform">
                                <i class="fas fa-arrow-right"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </a>
            
            <!-- Category 3 -->
            <a href="{{ route('whatsapp.chat') }}" target="_blank"
               class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition duration-300">
                <div class="h-64 bg-gradient-to-r from-green-500 to-green-700 relative">
                    <div class="absolute inset-0 bg-black opacity-20"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <i class="fas fa-gem text-white text-8xl opacity-30"></i>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                        <h3 class="text-2xl font-bold mb-2">Premium Package</h3>
                        <p class="opacity-90">Kebutuhan branding & perusahaan</p>
                        <div class="mt-3 flex items-center">
                            <span class="bg-white text-green-600 px-3 py-1 rounded-full text-sm font-bold">
                                Spesial Diskon
                            </span>
                            <span class="ml-auto group-hover:translate-x-2 transition-transform">
                                <i class="fas fa-arrow-right"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</section>

<!-- Best Selling Products -->
@if($products->isNotEmpty())
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-10">
            <div>
                <h2 class="text-3xl font-bold">Produk <span class="text-blue-600">Terlaris</span></h2>
                <p class="text-gray-600 mt-2">Produk paling banyak dibeli oleh pelanggan kami</p>
            </div>
            <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold flex items-center">
                Lihat Semua <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($products->take(4) as $product)
            <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition duration-300 border border-gray-100 overflow-hidden group">
                <!-- Product Image Placeholder -->
                <div class="h-48 bg-gradient-to-r from-blue-100 to-blue-50 flex items-center justify-center relative overflow-hidden">
                    <i class="fas fa-print text-blue-300 text-6xl"></i>
                    <!-- Sale Badge -->
                    @if($loop->first)
                    <div class="absolute top-3 left-3 bg-red-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                        TERLARIS
                    </div>
                    @endif
                </div>
                
                <div class="p-4">
                    <h3 class="font-bold text-lg mb-2 group-hover:text-blue-600 transition">{{ $product->name }}</h3>
                    <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ Str::limit($product->description, 60) }}</p>
                    
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="font-bold text-blue-600 text-lg">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            @if($product->old_price)
                            <span class="text-gray-400 text-sm line-through ml-2">Rp {{ number_format($product->old_price, 0, ',', '.') }}</span>
                            @endif
                        </div>
                        <a href="{{ route('products.show', $product->id) }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white w-10 h-10 rounded-full flex items-center justify-center">
                            <i class="fas fa-shopping-cart"></i>
                        </a>
                    </div>
                    
                    <!-- Rating -->
                    <div class="flex items-center mt-3">
                        <div class="flex text-yellow-400">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= 4)
                                    <i class="fas fa-star"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                        </div>
                        <span class="text-gray-500 text-sm ml-2">({{ rand(10, 99) }})</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- How It Works -->
<section class="py-16 bg-gradient-to-b from-gray-50 to-white">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-4">Cara <span class="text-blue-600">Pemesanan</span></h2>
        <p class="text-gray-600 text-center mb-12 max-w-2xl mx-auto">Hanya 4 langkah mudah untuk mendapatkan produk printing Anda</p>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Step 1 -->
            <div class="text-center relative">
                <div class="w-20 h-20 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 relative z-10 shadow-lg">
                    <span class="text-white text-2xl font-bold">1</span>
                </div>
                <div class="absolute top-10 left-1/2 w-full h-1 bg-blue-200 transform translate-x-1/2 md:block hidden"></div>
                <h3 class="text-xl font-bold mb-3">Pilih Produk</h3>
                <p class="text-gray-600">Cari produk yang Anda butuhkan di katalog kami</p>
            </div>
            
            <!-- Step 2 -->
            <div class="text-center relative">
                <div class="w-20 h-20 bg-gradient-to-r from-purple-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-6 relative z-10 shadow-lg">
                    <span class="text-white text-2xl font-bold">2</span>
                </div>
                <div class="absolute top-10 left-1/2 w-full h-1 bg-purple-200 transform translate-x-1/2 md:block hidden"></div>
                <h3 class="text-xl font-bold mb-3">Custom Desain</h3>
                <p class="text-gray-600">Upload desain atau konsultasi dengan tim kami</p>
            </div>
            
            <!-- Step 3 -->
            <div class="text-center relative">
                <div class="w-20 h-20 bg-gradient-to-r from-green-500 to-green-600 rounded-full flex items-center justify-center mx-auto mb-6 relative z-10 shadow-lg">
                    <span class="text-white text-2xl font-bold">3</span>
                </div>
                <div class="absolute top-10 left-1/2 w-full h-1 bg-green-200 transform translate-x-1/2 md:block hidden"></div>
                <h3 class="text-xl font-bold mb-3">Pembayaran</h3>
                <p class="text-gray-600">Bayar dengan metode pembayaran yang tersedia</p>
            </div>
            
            <!-- Step 4 -->
            <div class="text-center">
                <div class="w-20 h-20 bg-gradient-to-r from-orange-500 to-orange-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                    <span class="text-white text-2xl font-bold">4</span>
                </div>
                <h3 class="text-xl font-bold mb-3">Produk Dikirim</h3>
                <p class="text-gray-600">Produk dikirim dan Anda bisa lacak pesanan</p>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-4">Apa Kata <span class="text-blue-600">Pelanggan</span> Kami?</h2>
        <p class="text-gray-600 text-center mb-12 max-w-2xl mx-auto">Ribuan pelanggan telah mempercayai kebutuhan printing mereka kepada kami</p>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Testimonial 1 -->
            <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white font-bold mr-4">
                        AS
                    </div>
                    <div>
                        <h4 class="font-bold">Ahmad Surya</h4>
                        <p class="text-gray-500 text-sm">Pemilik UMKM</p>
                    </div>
                </div>
                <div class="flex text-yellow-400 mb-3">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="text-gray-700 italic">"Kualitas cetakan brosur untuk usaha saya sangat bagus. Proses cepat dan harganya terjangkau. Recommended banget!"</p>
            </div>
            
            <!-- Testimonial 2 -->
            <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-gradient-to-r from-purple-400 to-purple-600 rounded-full flex items-center justify-center text-white font-bold mr-4">
                        RW
                    </div>
                    <div>
                        <h4 class="font-bold">Rina Wijaya</h4>
                        <p class="text-gray-500 text-sm">Event Organizer</p>
                    </div>
                </div>
                <div class="flex text-yellow-400 mb-3">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="text-gray-700 italic">"Untuk kebutuhan banner event, selalu order di Cipta Imaji. Desainnya kreatif dan selalu ready sebelum deadline."</p>
            </div>
            
            <!-- Testimonial 3 -->
            <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-gradient-to-r from-green-400 to-green-600 rounded-full flex items-center justify-center text-white font-bold mr-4">
                        DF
                    </div>
                    <div>
                        <h4 class="font-bold">Dewi Fitri</h4>
                        <p class="text-gray-500 text-sm">Mahasiswa</p>
                    </div>
                </div>
                <div class="flex text-yellow-400 mb-3">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <p class="text-gray-700 italic">"Order kartu nama untuk keperluan magang, hasilnya premium. Pelayanannya ramah dan fast respon via WhatsApp."</p>
            </div>
        </div>
    </div>
</section>

<!-- Final CTA -->
<section class="py-16 bg-gradient-to-r from-blue-800 to-blue-900 text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-4xl font-bold mb-6">Siap Mewujudkan Kreativitas Anda?</h2>
        <p class="text-xl mb-8 max-w-2xl mx-auto opacity-90">
            Bergabung dengan ribuan pelanggan puas yang telah mempercayai printing mereka kepada kami
        </p>
        
        <div class="flex flex-col md:flex-row justify-center gap-6 max-w-2xl mx-auto">
            <!-- WhatsApp Button -->
            <a href="{{ route('whatsapp.chat') }}" target="_blank" 
               class="bg-green-500 hover:bg-green-600 text-white px-8 py-4 rounded-xl font-bold transition duration-300 shadow-lg hover:shadow-xl flex items-center justify-center text-lg group">
                <div class="w-12 h-12 bg-white text-green-500 rounded-full flex items-center justify-center mr-4">
                    <i class="fab fa-whatsapp text-2xl"></i>
                </div>
                <div class="text-left">
                    <div class="font-bold text-lg">Chat via WhatsApp</div>
                    <div class="text-sm opacity-90">Respon cepat 24 jam</div>
                </div>
                <i class="fas fa-arrow-right ml-4 group-hover:translate-x-2 transition-transform"></i>
            </a>
            
            <!-- Call Button -->
            <a href="tel:{{ env('SITE_PHONE', '+6281234567890') }}" 
               class="bg-white hover:bg-gray-100 text-blue-800 px-8 py-4 rounded-xl font-bold transition duration-300 shadow-lg hover:shadow-xl flex items-center justify-center text-lg group">
                <div class="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-phone text-2xl"></i>
                </div>
                <div class="text-left">
                    <div class="font-bold text-lg">Telepon Kami</div>
                    <div class="text-sm">{{ env('SITE_PHONE', '+62 812-3456-7890') }}</div>
                </div>
                <i class="fas fa-arrow-right ml-4 group-hover:translate-x-2 transition-transform"></i>
            </a>
        </div>
        
        <!-- Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-16 max-w-3xl mx-auto">
            <div class="text-center">
                <div class="text-4xl font-bold mb-2">5000+</div>
                <div class="text-blue-200">Produk Terjual</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold mb-2">98%</div>
                <div class="text-blue-200">Kepuasan Pelanggan</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold mb-2">24<span class="text-2xl">jam</span></div>
                <div class="text-blue-200">Waktu Produksi</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold mb-2">1000+</div>
                <div class="text-blue-200">Pelanggan Setia</div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.group:hover .group-hover\:translate-x-2 {
    transform: translateX(0.5rem);
}

/* Animasi untuk steps */
@keyframes pulse-ring {
    0% { transform: scale(0.8); opacity: 0.8; }
    100% { transform: scale(1.2); opacity: 0; }
}

.animate-pulse-ring {
    animation: pulse-ring 2s infinite;
}
</style>
@endpush