@extends('layouts.app')

@section('title', 'Cipta Imaji - Digital Printing Terpercaya')

@section('content')
<!-- Hero Section dengan image 3D -->
<section class="relative bg-[#193497] text-white overflow-hidden min-h-screen flex items-center">
    <!-- Decorative Elements -->
    <div class="absolute top-20 right-20 w-96 h-96 bg-[#d2f801] rounded-full opacity-20 blur-3xl"></div>
    <div class="absolute bottom-20 left-20 w-96 h-96 bg-[#7209b7] rounded-full opacity-20 blur-3xl"></div>
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] border-4 border-[#d2f801]/10 rounded-full"></div>
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] border-4 border-[#d2f801]/10 rounded-full"></div>
    
    <div class="container mx-auto px-4 py-20 relative z-10">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <!-- Left Content -->
            <div>
                <h1 class="text-5xl md:text-7xl font-bold mb-6 leading-tight">
                    Creative<br>
                    <span class="text-[#d2f801]">solutions</span>
                </h1>
                <p class="text-xl md:text-2xl mb-8 text-[#f9f0f1]/80 leading-relaxed">
                    Wujudkan ide kreatif Anda dengan layanan digital printing berkualitas premium. Dari konsep hingga hasil cetak yang memukau.
                </p>
                
                <div class="flex flex-wrap gap-4 mb-12">
                    <a href="{{ route('products.index') }}" 
                       class="bg-[#d2f801] text-blue-900 px-8 py-4 rounded-full font-bold hover:bg-yellow-300 transition duration-300 shadow-2xl hover:shadow-yellow-400/50 flex items-center text-lg">
                        Mulai Sekarang
                        <i class="fas fa-arrow-right ml-3"></i>
                    </a>
                    <a href="{{ route('whatsapp.chat') }}" target="_blank" 
                       class="bg-[#f9f0f1]/10 backdrop-blur-sm border-2 border-white text-white px-8 py-4 rounded-full font-bold hover:bg-[#f9f0f1]/20 transition duration-300 flex items-center text-lg">
                        <i class="fab fa-whatsapp mr-3"></i> Konsultasi
                    </a>
                </div>

                <!-- Stats Row -->
                <div class="grid grid-cols-3 gap-6">
                    <div>
                        <div class="text-3xl font-bold text-[#d2f801] mb-1">5000+</div>
                        <div class="text-sm text-[#f9f0f1]/70">Produk Terjual</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-[#d2f801] mb-1">98%</div>
                        <div class="text-sm text-[#f9f0f1]/70">Kepuasan</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-[#d2f801] mb-1">24h</div>
                        <div class="text-sm text-[#f9f0f1]/70">Produksi</div>
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
                    <div class="absolute top-10 right-10 bg-[#f9f0f1]/90 backdrop-blur-sm p-4 rounded-2xl shadow-2xl animate-float z-30">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-gradient-to-br bg-[#193497] rounded-xl flex items-center justify-center">
                                <i class="fas fa-print text-white text-xl"></i>
                            </div>
                            <div>
                                <div class="text-xs text-[#191f01]/60">Fast Print</div>
                                <div class="font-bold text-[#191f01]">24 Jam</div>
                            </div>
                        </div>
                    </div>

                    <div class="absolute bottom-20 left-10 bg-[#f9f0f1]/90 backdrop-blur-sm p-4 rounded-2xl shadow-2xl animate-float-delayed z-30">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-gradient-to-br bg-[#d2f801] rounded-xl flex items-center justify-center">
                                <i class="fas fa-shield-alt text-white text-xl"></i>
                            </div>
                            <div>
                                <div class="text-xs text-[#191f01]/60">Guarantee</div>
                                <div class="font-bold text-[#191f01]">100%</div>
                            </div>
                        </div>
                    </div>

                    <div class="absolute top-1/2 right-0 bg-[#f9f0f1]/90 backdrop-blur-sm p-4 rounded-2xl shadow-2xl animate-float-slow z-30">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-gradient-to-br bg-[#7209b7] rounded-xl flex items-center justify-center">
                                <i class="fas fa-star text-white text-xl"></i>
                            </div>
                            <div>
                                <div class="text-xs text-[#191f01]/60">Rating</div>
                                <div class="font-bold text-[#191f01]">4.9/5</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 text-center">
        <div class="text-sm text-[#f9f0f1]/70 mb-2">Scroll untuk lebih lanjut</div>
        <div class="w-6 h-10 border-2 border-gray-300 rounded-full flex justify-center">
            <div class="w-1 h-3 bg-gray-300 rounded-full mt-2 animate-bounce"></div>
        </div>
    </div>
</section>

<style>
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

@keyframes float-delayed {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-15px); }
}

@keyframes float-slow {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-15px) rotate(2deg); }
}

.animate-float {
    animation: float 3s ease-in-out infinite;
}

.animate-float-delayed {
    animation: float-delayed 4s ease-in-out infinite;
}

.animate-float-slow {
    animation: float-slow 6s ease-in-out infinite;
}
</style>
<!-- Product Categories Grid -->
<section class="py-20 bg-[#f9f0f1]">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold mb-4">
                Kategori <span class="text-[#193497]">Produk</span>
            </h2>
            <p class="text-[#191f01]/70 text-lg max-w-2xl mx-auto">
                Pilihan lengkap untuk semua kebutuhan printing Anda
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Category Card 1 -->
            <div class="group relative overflow-hidden rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 cursor-pointer">
                <div class="h-80 bg-gradient-to-br bg-[#193497] p-8 flex flex-col justify-between relative">
                    <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity duration-500"></div>
                    
                    <div class="relative z-10">
                        <div class="w-16 h-16 bg-[#f9f0f1]/20 backdrop-blur-sm rounded-2xl flex items-center justify-center mb-4">
                            <i class="fas fa-bolt text-white text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-2">Produk Instan</h3>
                        <p class="text-blue-100">Cetak cepat dalam 24 jam</p>
                    </div>

                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <span class="bg-[#f9f0f1] text-blue-700 px-4 py-2 rounded-full text-sm font-bold">
                                Mulai 25K
                            </span>
                            <div class="w-12 h-12 bg-[#f9f0f1]/20 backdrop-blur-sm rounded-full flex items-center justify-center group-hover:bg-[#f9f0f1] group-hover:scale-110 transition-all duration-300">
                                <i class="fas fa-arrow-right text-white group-hover:text-blue-700"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Category Card 2 -->
            <div class="group relative overflow-hidden rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 cursor-pointer">
                <div class="h-80 bg-gradient-to-br bg-[#7209b7] p-8 flex flex-col justify-between relative">
                    <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity duration-500"></div>
                    
                    <div class="relative z-10">
                        <div class="w-16 h-16 bg-[#f9f0f1]/20 backdrop-blur-sm rounded-2xl flex items-center justify-center mb-4">
                            <i class="fas fa-palette text-white text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-2">Custom Design</h3>
                        <p class="text-purple-100">Desain sesuai keinginan</p>
                    </div>

                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <span class="bg-[#f9f0f1] text-purple-700 px-4 py-2 rounded-full text-sm font-bold">
                                Konsultasi
                            </span>
                            <div class="w-12 h-12 bg-[#f9f0f1]/20 backdrop-blur-sm rounded-full flex items-center justify-center group-hover:bg-[#f9f0f1] group-hover:scale-110 transition-all duration-300">
                                <i class="fas fa-arrow-right text-white group-hover:text-purple-700"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Category Card 3 -->
            <div class="group relative overflow-hidden rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 cursor-pointer">
                <div class="h-80 bg-gradient-to-br bg-[#f72585] p-8 flex flex-col justify-between relative">
                    <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity duration-500"></div>
                    
                    <div class="relative z-10">
                        <div class="w-16 h-16 bg-[#f9f0f1]/20 backdrop-blur-sm rounded-2xl flex items-center justify-center mb-4">
                            <i class="fas fa-briefcase text-white text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-2">Corporate</h3>
                        <p class="text-pink-100">Paket branding perusahaan</p>
                    </div>

                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <span class="bg-[#f9f0f1] text-pink-700 px-4 py-2 rounded-full text-sm font-bold">
                                Spesial
                            </span>
                            <div class="w-12 h-12 bg-[#f9f0f1]/20 backdrop-blur-sm rounded-full flex items-center justify-center group-hover:bg-[#f9f0f1] group-hover:scale-110 transition-all duration-300">
                                <i class="fas fa-arrow-right text-white group-hover:text-pink-700"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Category Card 4 -->
            <div class="group relative overflow-hidden rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 cursor-pointer">
                <div class="h-80 bg-gradient-to-br bg-[#f91f01] p-8 flex flex-col justify-between relative">
                    <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity duration-500"></div>
                    
                    <div class="relative z-10">
                        <div class="w-16 h-16 bg-[#f9f0f1]/20 backdrop-blur-sm rounded-2xl flex items-center justify-center mb-4">
                            <i class="fas fa-gift text-white text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-2">Event Package</h3>
                        <p class="text-orange-100">Solusi acara & event</p>
                    </div>

                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <span class="bg-[#f9f0f1] text-orange-700 px-4 py-2 rounded-full text-sm font-bold">
                                Promo
                            </span>
                            <div class="w-12 h-12 bg-[#f9f0f1]/20 backdrop-blur-sm rounded-full flex items-center justify-center group-hover:bg-[#f9f0f1] group-hover:scale-110 transition-all duration-300">
                                <i class="fas fa-arrow-right text-white group-hover:text-orange-700"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Banner Manajemen -->
<section class="py-20 bg-[#193497]">
    <div class="container mx-auto px-4">
        <div class="bg-[#f9f0f1] rounded-3xl shadow-2xl overflow-hidden">
            <div class="grid md:grid-cols-2 gap-8 items-center">
                <!-- Left Content -->
                <div class="p-12">
                    <h2 class="text-4xl font-bold mb-6 text-[#191f01]">
                        Banner Management
                    </h2>
                    <p class="text-[#191f01]/70 text-lg mb-8">
                        Kelola semua kebutuhan banner untuk bisnis dan event Anda dengan mudah. Dari desain hingga pemasangan.
                    </p>
                    
                    <div class="grid grid-cols-2 gap-6 mb-8">
                        <div class="bg-[#193497]/10 p-6 rounded-2xl">
                            <div class="text-3xl font-bold text-[#193497] mb-2">100+</div>
                            <div class="text-sm text-[#191f01]/70">Desain Template</div>
                        </div>
                        <div class="bg-[#7209b7]/10 p-6 rounded-2xl">
                            <div class="text-3xl font-bold text-[#7209b7] mb-2">24h</div>
                            <div class="text-sm text-[#191f01]/70">Pengerjaan</div>
                        </div>
                    </div>

                    <a href="{{ route('products.index') }}" 
                       class="inline-flex items-center bg-[#193497] text-white px-8 py-4 rounded-full font-bold hover:shadow-2xl transition-all duration-300">
                        Lihat Katalog
                        <i class="fas fa-arrow-right ml-3"></i>
                    </a>
                </div>

                <!-- Right Visual -->
                <div class="bg-[#7209b7] h-full min-h-[400px] flex items-center justify-center relative">
                    <div class="absolute inset-0 bg-black opacity-10"></div>
                    <i class="fas fa-image text-white text-9xl opacity-20"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Best Selling Products -->
@if($products->isNotEmpty())
<section class="py-20 bg-[#f9f0f1]">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold mb-4">
                Produk <span class="text-[#193497]">Terlaris</span>
            </h2>
            <p class="text-[#191f01]/70 text-lg max-w-2xl mx-auto">
                Pilihan favorit pelanggan kami
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($products->take(4) as $product)
            <div class="group bg-[#f9f0f1] rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden">
                <!-- Image -->
                <div class="h-64 bg-gradient-to-br from-blue-100 to-purple-100 relative overflow-hidden">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <i class="fas fa-print text-blue-300 text-7xl group-hover:scale-110 transition-transform duration-500"></i>
                    </div>
                    @if($loop->first)
                    <div class="absolute top-4 left-4 bg-[#f91f01] text-white px-4 py-2 rounded-full text-xs font-bold">
                        TERLARIS
                    </div>
                    @endif
                </div>

                <!-- Content -->
                <div class="p-6">
                    <h3 class="font-bold text-xl mb-3 group-hover:text-[#193497] transition-colors">
                        {{ $product->name }}
                    </h3>
                    <p class="text-[#191f01]/70 text-sm mb-4 line-clamp-2">
                        {{ Str::limit($product->description, 60) }}
                    </p>

                    <!-- Rating -->
                    <div class="flex text-[#d2f801] mr-2">
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
                            <div class="text-xs text-[#191f01]/60">per item</div>
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

<!-- Process Steps -->
<section class="py-20 bg-[#f9f0f1]">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold mb-4">
                Cara <span class="text-[#193497]">Kerja</span>
            </h2>
            <p class="text-[#191f01]/70 text-lg max-w-2xl mx-auto">
                Proses mudah dan cepat
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            @php
            $steps = [
                ['icon' => 'fa-mouse-pointer', 'title' => 'Pilih Produk', 'desc' => 'Browse katalog dan pilih produk'],
                ['icon' => 'fa-file-upload', 'title' => 'Upload Desain', 'desc' => 'Upload file atau minta bantuan'],
                ['icon' => 'fa-credit-card', 'title' => 'Bayar', 'desc' => 'Pilih metode pembayaran'],
                ['icon' => 'fa-shipping-fast', 'title' => 'Terima', 'desc' => 'Produk dikirim ke alamat']
            ];
            @endphp

            @foreach($steps as $index => $step)
            <div class="text-center relative">
                <div class="w-20 h-20 bg-[#7209b7] rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg relative z-10">
                    <i class="fas {{ $step['icon'] }} text-white text-3xl"></i>
                </div>
                
                @if($index < 3)
                <div class="hidden md:block absolute top-10 left-[60%] w-[80%] h-1 bg-[#193497] opacity-20"></div>
                @endif

                <div class="absolute -top-2 -left-2 w-10 h-10 bg-[#d2f801] rounded-full flex items-center justify-center font-bold text-blue-900 shadow-lg">
                    {{ $index + 1 }}
                </div>

                <h3 class="text-xl font-bold mb-2">{{ $step['title'] }}</h3>
                <p class="text-[#191f01]/70">{{ $step['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="py-20 bg-[#f9f0f1]">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold mb-4">
                Kata <span class="text-[#193497]">Mereka</span>
            </h2>
            <p class="text-[#191f01]/70 text-lg max-w-2xl mx-auto">
                Testimoni dari pelanggan setia kami
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @php
            $testimonials = [
                ['name' => 'Ahmad Surya', 'role' => 'CEO Startup', 'initial' => 'AS', 'color' => 'blue'],
                ['name' => 'Rina Wijaya', 'role' => 'Event Organizer', 'initial' => 'RW', 'color' => 'purple'],
                ['name' => 'Dewi Fitri', 'role' => 'Marketing Manager', 'initial' => 'DF', 'color' => 'pink']
            ];
            @endphp

            @foreach($testimonials as $testimonial)
            <div class="bg-[#f9f0f1] p-8 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300">
                <div class="flex items-center mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-{{ $testimonial['color'] }}-400 to-{{ $testimonial['color'] }}-600 rounded-2xl flex items-center justify-center text-white font-bold text-xl mr-4">
                        {{ $testimonial['initial'] }}
                    </div>
                    <div>
                        <h4 class="font-bold text-lg">{{ $testimonial['name'] }}</h4>
                        <p class="text-[#191f01]/60 text-sm">{{ $testimonial['role'] }}</p>
                    </div>
                </div>

                <div class="flex mb-4">
    @for($i = 0; $i < 5; $i++)
    <i class="fas fa-star text-[#d2f801] drop-shadow-[0_0_1px_#193497]"></i>
    @endfor
</div>


                <p class="text-gray-700 leading-relaxed">
                    "Pelayanan sangat memuaskan! Hasil cetakan berkualitas tinggi dan pengerjaan cepat. Sangat recommended untuk kebutuhan printing."
                </p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-[#193497] text-white relative overflow-hidden">
    <!-- Decorative Elements -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-[#d2f801] rounded-full opacity-10 blur-3xl"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-[#7209b7] rounded-full opacity-10 blur-3xl"></div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl md:text-6xl font-bold mb-6">
                Siap Mulai Proyek Anda?
            </h2>
            <p class="text-xl mb-12 text-[#f9f0f1]/80">
                Hubungi kami sekarang dan dapatkan konsultasi gratis untuk kebutuhan printing Anda
            </p>

            <div class="flex flex-col md:flex-row justify-center gap-6 mb-16">
                <a href="{{ route('whatsapp.chat') }}" target="_blank"
                   class="group bg-[#7209b7] hover:bg-[#f72585] text-white px-10 py-5 rounded-full font-bold transition-all duration-300 shadow-2xl hover:shadow-green-500/50 flex items-center justify-center text-lg">
                    <i class="fab fa-whatsapp text-2xl mr-3"></i>
                    Chat WhatsApp
                    <i class="fas fa-arrow-right ml-3 group-hover:translate-x-2 transition-transform"></i>
                </a>

                <a href="tel:{{ env('SITE_PHONE', '+6281234567890') }}"
                   class="group bg-[#f9f0f1] hover:bg-gray-100 text-blue-900 px-10 py-5 rounded-full font-bold transition-all duration-300 shadow-2xl flex items-center justify-center text-lg">
                    <i class="fas fa-phone text-2xl mr-3"></i>
                    Telepon Kami
                    <i class="fas fa-arrow-right ml-3 group-hover:translate-x-2 transition-transform"></i>
                </a>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 max-w-3xl mx-auto">
                <div class="text-center">
                    <div class="text-5xl font-bold mb-2 text-[#d2f801]">5K+</div>
                    <div class="text-[#f9f0f1]/70">Produk Terjual</div>
                </div>
                <div class="text-center">
                    <div class="text-5xl font-bold mb-2 text-[#d2f801]">98%</div>
                    <div class="text-[#f9f0f1]/70">Kepuasan</div>
                </div>
                <div class="text-center">
                    <div class="text-5xl font-bold mb-2 text-[#d2f801]">24h</div>
                    <div class="text-[#f9f0f1]/70">Produksi</div>
                </div>
                <div class="text-center">
                    <div class="text-5xl font-bold mb-2 text-[#d2f801]">1K+</div>
                    <div class="text-[#f9f0f1]/70">Pelanggan</div>
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
</style>