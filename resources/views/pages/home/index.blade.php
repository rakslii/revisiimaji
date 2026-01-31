@extends('layouts.app')

@section('title', 'Cipta Imaji - Digital Printing Terpercaya')

@section('content')
<!-- Hero Section dengan image 3D -->
<section class="relative bg-[#193497] text-white overflow-hidden min-h-screen flex items-center">
    <!-- Decorative Elements -->
    <div class="absolute top-20 right-20 w-96 h-96 bg-[#c0f820] rounded-full opacity-20 blur-3xl"></div>
    <div class="absolute bottom-20 left-20 w-96 h-96 bg-[#720e87] rounded-full opacity-20 blur-3xl"></div>
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] border-4 border-[#c0f820]/10 rounded-full"></div>
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] border-4 border-[#c0f820]/10 rounded-full"></div>
    
    <div class="container mx-auto px-4 py-20 relative z-10">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <!-- Left Content -->
            <div>
                <h1 class="text-5xl md:text-7xl font-bold mb-6 leading-tight">
                    Creative<br>
                    <span class="text-[#c0f820]">solutions</span>
                </h1>
                <p class="text-xl md:text-2xl mb-8 text-white/80 leading-relaxed">
                    Wujudkan ide kreatif Anda dengan layanan digital printing berkualitas premium. Dari konsep hingga hasil cetak yang memukau.
                </p>
                
                <div class="flex flex-wrap gap-4 mb-12">
                    <a href="{{ route('products.index') }}" 
                       class="bg-[#c0f820] text-[#193497] px-8 py-4 rounded-full font-bold hover:bg-[#d4ff40] transition duration-300 shadow-2xl hover:shadow-[#c0f820]/50 flex items-center text-lg">
                        Mulai Sekarang
                        <i class="fas fa-arrow-right ml-3"></i>
                    </a>
                    <a href="{{ route('whatsapp.chat') }}" target="_blank" 
                       class="bg-white/10 backdrop-blur-sm border-2 border-white text-white px-8 py-4 rounded-full font-bold hover:bg-white/20 transition duration-300 flex items-center text-lg">
                        <i class="fab fa-whatsapp mr-3"></i> Konsultasi
                    </a>
                </div>

                <!-- Stats Row -->
                <div class="grid grid-cols-3 gap-6">
                    <div>
                        <div class="text-3xl font-bold text-[#c0f820] mb-1">5000+</div>
                        <div class="text-sm text-white/70">Produk Terjual</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-[#c0f820] mb-1">98%</div>
                        <div class="text-sm text-white/70">Kepuasan</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-[#c0f820] mb-1">24h</div>
                        <div class="text-sm text-white/70">Produksi</div>
                    </div>
                </div>
            </div>

            <!-- Right Content - 3D Image sebagai pengganti circle -->
            <div class="relative">
                <div class="relative w-full h-[500px] flex items-center justify-center">
                    <!-- Main 3D Image -->
                    <div class="relative z-20 animate-float-slow">
                        <img src="{{ asset('img/MASKOT.png') }}" 
                             alt="Creative 3D Design" 
                             class="w-full max-w-[450px] h-auto object-contain"
                             style="filter: drop-shadow(0 25px 50px rgba(0,0,0,0.4));">
                    </div>
                    
                    <!-- Floating Cards -->
                    <div class="absolute top-10 right-10 bg-white/90 backdrop-blur-sm p-4 rounded-2xl shadow-2xl animate-float z-30">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-[#193497] to-[#1e40af] rounded-xl flex items-center justify-center">
                                <i class="fas fa-print text-white text-xl"></i>
                            </div>
                            <div>
                                <div class="text-xs text-gray-600">Fast Print</div>
                                <div class="font-bold text-[#193497]">24 Jam</div>
                            </div>
                        </div>
                    </div>

                    <div class="absolute bottom-20 left-10 bg-white/90 backdrop-blur-sm p-4 rounded-2xl shadow-2xl animate-float-delayed z-30">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-[#c0f820] to-[#d4ff40] rounded-xl flex items-center justify-center">
                                <i class="fas fa-shield-alt text-[#193497] text-xl"></i>
                            </div>
                            <div>
                                <div class="text-xs text-gray-600">Guarantee</div>
                                <div class="font-bold text-[#193497]">100%</div>
                            </div>
                        </div>
                    </div>

                    <div class="absolute top-1/2 right-0 bg-white/90 backdrop-blur-sm p-4 rounded-2xl shadow-2xl animate-float-slow z-30">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-[#720e87] to-[#9333ea] rounded-xl flex items-center justify-center">
                                <i class="fas fa-star text-white text-xl"></i>
                            </div>
                            <div>
                                <div class="text-xs text-gray-600">Rating</div>
                                <div class="font-bold text-[#193497]">4.9/5</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 text-center">
        <div class="text-sm text-white/70 mb-2">Scroll untuk lebih lanjut</div>
        <div class="w-6 h-10 border-2 border-gray-300 rounded-full flex justify-center">
            <div class="w-1 h-3 bg-gray-300 rounded-full mt-2 animate-bounce"></div>
        </div>
    </div>
</section>

<!-- Best Selling Products -->
@if($products->isNotEmpty())
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold mb-4">
                Produk <span class="text-[#193497]">Terlaris</span>
            </h2>
            <p class="text-gray-700 text-lg max-w-2xl mx-auto">
                Pilihan favorit pelanggan kami
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($products->take(4) as $product)
            <div class="group bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden">
                <!-- Image -->
                <div class="h-64 bg-gray-100 relative overflow-hidden">
                    <img src="{{ asset('storage/'.$product->image) }}"
                         alt="{{ $product->name }}"
                         class="w-full h-full object-cover"
                         onerror="this.onerror=null; this.src='{{ asset('images/default-product.jpg') }}'">

                    @if($loop->first)
                    <div class="absolute top-4 left-4 bg-[#ff0f0f] text-white px-4 py-2 rounded-full text-xs font-bold">
                        TERLARIS
                    </div>
                    @endif
                </div>

                <!-- Content -->
                <div class="p-6">
                    <h3 class="font-bold text-xl mb-3 group-hover:text-[#193497] transition-colors">
                        {{ $product->name }}
                    </h3>
                    <p class="text-gray-700 text-sm mb-4 line-clamp-2">
                        {{ Illuminate\Support\Str::limit($product->description, 60) }}
                    </p>

                    <!-- Rating -->
                    <div class="flex text-[#c0f820] mr-2 mb-4">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star text-xs drop-shadow-[0_0_1px_#193497]"></i>
                        @endfor
                    </div>

                    <!-- Price & Button -->
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="font-bold text-2xl text-[#193497]">
                                {{ number_format($product->price / 1000, 0) }}K
                            </div>
                            <div class="text-xs text-gray-600">per item</div>
                        </div>
                        <a href="{{ route('products.show', $product->id) }}" 
                           class="w-12 h-12 bg-[#193497] hover:bg-[#f72585] text-white rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
<!-- Creative Categories Section - COMPACT VERSION -->
<section class="py-16 bg-white relative overflow-hidden">
    <!-- Decorative Background -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-[#193497] opacity-5 blur-3xl"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-[#720e87] opacity-5 blur-3xl"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold mb-3">
                Jelajahi <span class="text-[#193497]">Kategori</span>
            </h2>
            <p class="text-gray-700 max-w-2xl mx-auto">
                Temukan produk terbaik dari berbagai kategori yang kami sediakan
            </p>
        </div>

        @if(isset($categories) && $categories->count() > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($categories as $category)
            <div class="group relative bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-transparent overflow-hidden">
                <!-- Image Container - Persegi Panjang -->
                <div class="relative h-48 overflow-hidden">
                    <!-- Main Image -->
                    @php
                        // Gunakan main_image_url dari accessor atau cek langsung
                        $mainImage = $category->main_image_url ?? null;
                        
                        // Fallback: cek apakah file ada di storage
                        if (!$mainImage && isset($category->featured_image_1) && !empty($category->featured_image_1)) {
                            $imagePath = $category->featured_image_1;
                            $storagePath = storage_path('app/public/' . $imagePath);
                            if (file_exists($storagePath)) {
                                $mainImage = asset('storage/' . $imagePath);
                            }
                        }
                    @endphp
                    
                    @if($mainImage)
                    <img src="{{ $mainImage }}" 
                         alt="{{ $category->name }}"
                         class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                    @else
                    <div class="w-full h-full bg-gradient-to-br from-[#193497] to-[#720e87] flex items-center justify-center">
                        <i class="fas {{ $category->icon ?? 'fa-image' }} text-white/40 text-4xl"></i>
                    </div>
                    @endif
                    
                    <!-- Small Thumbnail Images (3 kecil di atas gambar utama) -->
                    <div class="absolute top-3 right-3 flex space-x-1">
                        @for($i = 2; $i <= 4; $i++)
                            @php 
                                $imageField = 'featured_image_' . $i;
                                $imagePath = $category->$imageField ?? null;
                                $imageUrl = null;
                                
                                if ($imagePath) {
                                    $storagePath = storage_path('app/public/' . $imagePath);
                                    if (file_exists($storagePath)) {
                                        $imageUrl = asset('storage/' . $imagePath);
                                    }
                                }
                            @endphp
                            
                            @if($imageUrl)
                            <div class="w-8 h-8 rounded-md overflow-hidden border-2 border-white shadow-sm">
                                <img src="{{ $imageUrl }}" 
                                     alt=""
                                     class="w-full h-full object-cover">
                            </div>
                            @else
                            <div class="w-8 h-8 rounded-md bg-gradient-to-br 
                                @if($i == 2) from-[#c0f820] to-[#d4ff40]
                                @elseif($i == 3) from-[#f72585] to-[#ec4899]
                                @else from-[#ff0f0f] to-[#f87171]
                                @endif
                                border-2 border-white shadow-sm">
                            </div>
                            @endif
                        @endfor
                    </div>
                    
                    <!-- Category Icon Badge -->
                    <div class="absolute bottom-3 left-3">
                        @if($category->icon)
                        <div class="w-10 h-10 bg-white/90 backdrop-blur-sm rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas {{ $category->icon }} text-[#193497] text-lg"></i>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Overlay Gradient -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </div>
                
                <!-- Content -->
                <div class="p-4">
                    <h3 class="font-bold text-lg text-gray-900 group-hover:text-[#193497] transition-colors mb-2">
                        {{ $category->name }}
                    </h3>
                    
                    @if($category->description)
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                        {{ Illuminate\Support\Str::limit($category->description, 60) }}
                    </p>
                    @endif
                    
                    <!-- CTA Button -->
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-gray-500 font-medium">
                            Lihat produk
                        </span>
                        <a href="{{ route('products.index', ['category' => $category->id]) }}" 
                           class="w-8 h-8 bg-gradient-to-br from-[#193497] to-[#c0f820] text-white rounded-full flex items-center justify-center group-hover:scale-110 group-hover:rotate-12 transition-all duration-300 shadow-md">
                            <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- View All Button (HANYA JIKA ADA KATEGORI) -->
        <div class="text-center mt-10">
            <a href="{{ route('products.index') }}" 
               class="inline-flex items-center bg-white border border-[#193497] text-[#193497] hover:bg-[#193497] hover:text-white px-5 py-2.5 rounded-full text-sm font-medium transition-all duration-300 shadow-sm hover:shadow-md">
                Lihat Semua Kategori
                <i class="fas fa-arrow-right ml-2 text-xs"></i>
            </a>
        </div>
        
        @else
        <!-- TAMPILAN JIKA TIDAK ADA KATEGORI -->
        <div class="text-center py-12">
            <div class="inline-block p-6 bg-gray-50 rounded-2xl">
                <i class="fas fa-folder-open text-4xl text-gray-300 mb-4"></i>
                <p class="text-gray-500">Belum ada kategori tersedia</p>
                <p class="text-sm text-gray-400 mt-2">Kategori akan segera ditambahkan</p>
            </div>
        </div>
        @endif
    </div>
</section>
<!-- Process Steps -->
<section class="py-24 bg-gradient-to-br from-white via-gray-50 to-white">
    <!-- Decorative Background -->
    <div class="absolute top-0 left-0 w-full h-full opacity-5">
        <div class="absolute top-20 left-20 w-72 h-72 bg-[#193497] rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 right-20 w-72 h-72 bg-[#720e87] rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center mb-20">
            <h2 class="text-4xl md:text-5xl font-bold mb-4">
                Cara <span class="text-[#193497]">Kerja</span>
            </h2>
            <p class="text-gray-700 text-lg max-w-2xl mx-auto">
                4 langkah mudah untuk mewujudkan kebutuhan printing Anda
            </p>
        </div>

        <div class="max-w-6xl mx-auto">
            @php
            $steps = [
                [
                    'icon' => 'fa-search', 
                    'title' => 'Pilih Produk', 
                    'desc' => 'Browse katalog lengkap kami dan pilih produk yang sesuai dengan kebutuhan Anda', 
                    'gradient' => 'from-[#193497] to-[#193497]',
                    'bg' => 'bg-[#193497]'
                ],
                [
                    'icon' => 'fa-palette', 
                    'title' => 'Upload Desain', 
                    'desc' => 'Upload file desain Anda atau konsultasikan dengan tim desainer profesional kami', 
                    'gradient' => 'from-[#193497] to-[#193497]',
                    'bg' => 'bg-[#720e87]'
                ],
                [
                    'icon' => 'fa-credit-card', 
                    'title' => 'Bayar', 
                    'desc' => 'Pilih metode pembayaran yang paling nyaman untuk Anda', 
                    'gradient' => 'from-[#193497] to-[#193497]',
                    'bg' => 'bg-[#f72585]'
                ],
                [
                    'icon' => 'fa-rocket', 
                    'title' => 'Terima Produk', 
                    'desc' => 'Produk berkualitas tinggi dikirim langsung ke alamat Anda dengan aman', 
                    'gradient' => 'from-[#193497] to-[#193497]',
                    'bg' => 'bg-[#ff0f0f]'
                ]
            ];
            @endphp

            <div class="grid md:grid-cols-2 gap-8">
                @foreach($steps as $index => $step)
                <div class="group relative">
                    <!-- Main Card -->
                    <div class="bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 hover:border-transparent hover:-translate-y-2">
                        
                        <!-- Number Badge with Gradient -->
                        <div class="absolute -top-5 -left-5 w-16 h-16 bg-gradient-to-br {{ $step['gradient'] }} rounded-2xl flex items-center justify-center shadow-xl transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-300 z-20">
                            <span class="text-white font-bold text-2xl">{{ $index + 1 }}</span>
                        </div>

                        <!-- Content Wrapper -->
                        <div class="flex items-start gap-6">
                            <!-- Icon Container -->
                            <div class="w-20 h-20 bg-gradient-to-br {{ $step['gradient'] }} rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 flex-shrink-0">
                                <i class="fas {{ $step['icon'] }} text-white text-3xl"></i>
                            </div>
                            
                            <!-- Text Content -->
                            <div class="flex-1 pt-2">
                                <h3 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-[#193497] transition-colors">
                                    {{ $step['title'] }}
                                </h3>
                                <p class="text-gray-600 leading-relaxed text-sm">
                                    {{ $step['desc'] }}
                                </p>
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        <div class="mt-6 flex items-center gap-2">
                            @for($i = 0; $i < 4; $i++)
                            <div class="h-2 flex-1 rounded-full transition-all duration-500 {{ $i <= $index ? 'bg-gradient-to-r ' . $step['gradient'] : 'bg-gray-200' }}"></div>
                            @endfor
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Cipta Imaji Section -->
<section class="py-20 bg-gradient-to-br from-[#0f1f5c] to-[#193497] relative overflow-hidden">
    <!-- Decorative Background -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-[#c0f820] rounded-full opacity-10 blur-3xl"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-[#720e87] rounded-full opacity-10 blur-3xl"></div>

    <div class="container mx-auto px-4 relative z-10">
        <!-- Header -->
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-4">
                Mengapa Memilih <span class="text-[#c0f820]">Cipta Imaji</span>?
            </h2>
            <p class="text-white/80 text-lg max-w-2xl mx-auto">
                Kami memberikan layanan terbaik dengan kualitas premium untuk kepuasan Anda
            </p>
        </div>

        <!-- Features Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Feature 1 -->
            <div class="text-center group">
                <div class="w-20 h-20 bg-white/10 backdrop-blur-sm rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-white/20 group-hover:scale-110 transition-all duration-300">
                    <i class="fas fa-shipping-fast text-white text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-3">Gratis Ongkir</h3>
                <p class="text-white/70 text-sm leading-relaxed">
                    Gratis ongkir untuk order minimal Rp500.000 di area Jabodetabek
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="text-center group">
                <div class="w-20 h-20 bg-white/10 backdrop-blur-sm rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-white/20 group-hover:scale-110 transition-all duration-300">
                    <i class="fas fa-shield-alt text-white text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-3">Garansi 100%</h3>
                <p class="text-white/70 text-sm leading-relaxed">
                    Uang kembali 100% jika produk tidak sesuai dengan pesanan
                </p>
            </div>

            <!-- Feature 3 -->
            <div class="text-center group">
                <div class="w-20 h-20 bg-white/10 backdrop-blur-sm rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-white/20 group-hover:scale-110 transition-all duration-300">
                    <i class="fas fa-headset text-white text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-3">Support 24/7</h3>
                <p class="text-white/70 text-sm leading-relaxed">
                    Tim customer service siap membantu 24 jam via WhatsApp
                </p>
            </div>

            <!-- Feature 4 -->
            <div class="text-center group">
                <div class="w-20 h-20 bg-white/10 backdrop-blur-sm rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-white/20 group-hover:scale-110 transition-all duration-300">
                    <i class="fas fa-credit-card text-white text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-3">Pembayaran Lengkap</h3>
                <p class="text-white/70 text-sm leading-relaxed">
                    Bayar dengan QRIS, Transfer Bank, E-Wallet & COD (Jabodetabek)
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="py-24 bg-gradient-to-br from-[#193497] to-[#1e40af] relative overflow-hidden">
    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center mb-20">
            <div class="inline-block mb-4">
                <span class="bg-white/20 text-white px-6 py-2 rounded-full text-sm font-semibold border border-white/30">
                    ⭐ Testimonials
                </span>
            </div>
            <h2 class="text-4xl md:text-5xl font-bold mb-4 text-white">
                Kata <span class="text-[#c0f820]">Mereka</span>
            </h2>
            <p class="text-white/80 text-lg max-w-2xl mx-auto">
                Kepercayaan pelanggan adalah prioritas kami
            </p>
        </div>
        </div>

        <div class="max-w-6xl mx-auto">
            @php
            $testimonials = [
                [
                    'name' => 'Ahmad Surya', 
                    'role' => 'CEO Startup', 
                    'initial' => 'AS', 
                    'gradient' => 'from-[#193497] to-[#1e40af]',
                    'text' => 'Pelayanan sangat memuaskan! Hasil cetakan berkualitas tinggi dan pengerjaan cepat. Sangat recommended untuk kebutuhan printing.',
                    'rating' => 5
                ],
                [
                    'name' => 'Rina Wijaya', 
                    'role' => 'Event Organizer', 
                    'initial' => 'RW', 
                    'gradient' => 'from-[#720e87] to-[#9333ea]',
                    'text' => 'Tim Cipta Imaji sangat profesional dan responsif. Banner untuk event kami sempurna dan tepat waktu. Highly recommended!',
                    'rating' => 5
                ],
                [
                    'name' => 'Dewi Fitri', 
                    'role' => 'Marketing Manager', 
                    'initial' => 'DF', 
                    'gradient' => 'from-[#f72585] to-[#ec4899]',
                    'text' => 'Kualitas cetak terbaik yang pernah saya temui. Harga kompetitif dan hasilnya selalu memuaskan. Partner terpercaya!',
                    'rating' => 5
                ]
            ];
            @endphp

            <div class="grid md:grid-cols-3 gap-8">
                @foreach($testimonials as $testimonial)
                <div class="group relative">
                    <div class="absolute -top-4 -left-4 w-16 h-16 bg-gradient-to-br {{ $testimonial['gradient'] }} rounded-2xl flex items-center justify-center opacity-10 group-hover:opacity-20 transition-all duration-300 group-hover:scale-110">
                        <i class="fas fa-quote-left text-white text-2xl"></i>
                    </div>

                    <div class="bg-white p-8 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 hover:border-transparent hover:-translate-y-2 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br {{ $testimonial['gradient'] }} opacity-5 rounded-bl-full"></div>

                        <div class="flex items-center mb-6 relative z-10">
                            <div class="w-16 h-16 bg-gradient-to-br {{ $testimonial['gradient'] }} rounded-2xl flex items-center justify-center text-white font-bold text-xl shadow-lg group-hover:scale-110 group-hover:rotate-6 transition-all duration-300 flex-shrink-0">
                                {{ $testimonial['initial'] }}
                            </div>
                            
                            <div class="ml-4">
                                <h4 class="font-bold text-lg text-gray-900">{{ $testimonial['name'] }}</h4>
                                <p class="text-gray-500 text-sm">{{ $testimonial['role'] }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-1 mb-4">
                            @for($i = 0; $i < $testimonial['rating']; $i++)
                            <i class="fas fa-star text-[#c0f820] text-lg"></i>
                            @endfor
                        </div>

                        <div class="mb-4">
                            <i class="fas fa-quote-left text-3xl bg-gradient-to-br {{ $testimonial['gradient'] }} bg-clip-text text-transparent"></i>
                        </div>

                        <p class="text-gray-700 leading-relaxed mb-4 relative z-10">
                            {{ $testimonial['text'] }}
                        </p>

                        <div class="flex items-center gap-2 mt-6 pt-6 border-t border-gray-100">
                            <div class="w-6 h-6 bg-gradient-to-br {{ $testimonial['gradient'] }} rounded-full flex items-center justify-center">
                                <i class="fas fa-check text-white text-xs"></i>
                            </div>
                            <span class="text-sm text-gray-500 font-medium">Verified Customer</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>



<!-- CTA Section -->
<section class="py-24 bg-gradient-to-br from-[#193497] to-[#1e40af] text-white relative overflow-hidden">
    <!-- Background Blur -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-[#c0f820] rounded-full opacity-10 blur-3xl"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-[#720e87] rounded-full opacity-10 blur-3xl"></div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-5xl md:text-6xl font-bold mb-6">
                Siap Mulai Proyek Anda?
            </h2>
            <p class="text-xl mb-12 text-white/90 max-w-2xl mx-auto">
                Hubungi kami sekarang dan dapatkan konsultasi gratis
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-4 mb-16">
                <a href="{{ route('whatsapp.chat') }}" target="_blank"
                   class="bg-[#25D366] hover:bg-[#128C7E] text-white px-8 py-4 rounded-xl font-bold transition-all duration-300 shadow-lg hover:scale-105 flex items-center justify-center gap-3">
                    <i class="fab fa-whatsapp text-2xl"></i>
                    Chat WhatsApp
                </a>

                <a href="tel:{{ env('SITE_PHONE', '+6281234567890') }}"
                   class="bg-white/10 backdrop-blur-sm border-2 border-white/30 text-white px-8 py-4 rounded-xl font-bold transition-all duration-300 hover:bg-white hover:text-[#193497] hover:scale-105 flex items-center justify-center gap-3">
                    <i class="fas fa-phone"></i>
                    Telepon Kami
                </a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="text-5xl font-bold text-[#c0f820] mb-2">5K+</div>
                    <div class="text-white/70">Produk Terjual</div>
                </div>
                <div class="text-center">
                    <div class="text-5xl font-bold text-[#c0f820] mb-2">98%</div>
                    <div class="text-white/70">Kepuasan</div>
                </div>
                <div class="text-center">
                    <div class="text-5xl font-bold text-[#c0f820] mb-2">24h</div>
                    <div class="text-white/70">Produksi</div>
                </div>
                <div class="text-center">
                    <div class="text-5xl font-bold text-[#c0f820] mb-2">1K+</div>
                    <div class="text-white/70">Pelanggan</div>
                </div>
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

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

@keyframes float-delayed {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-15px); }
}

@keyframes float-slow {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

.animate-float {
    animation: float 3s ease-in-out infinite;
}

.animate-float-delayed {
    animation: float-delayed 4s ease-in-out infinite;
}

.animate-float-slow {
    animation: float-slow 5s ease-in-out infinite;
}

/* Custom styles untuk categories section */
.grid-rows-3 {
    grid-template-rows: repeat(3, minmax(0, 1fr));
}
</style>
@endpush