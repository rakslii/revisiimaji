@extends('layouts.app')

@section('title', 'Tentang Kami - Cipta Imaji')

@section('content')

<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-[#193497] via-[#1e40af] to-[#193497] text-white overflow-hidden min-h-[70vh] flex items-center">
    <!-- Animated Background -->
    <div class="absolute inset-0">
        <div class="absolute top-20 right-20 w-96 h-96 bg-[#c0f820] rounded-full opacity-20 blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 left-20 w-96 h-96 bg-[#720e87] rounded-full opacity-20 blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/2 right-1/3 w-64 h-64 bg-[#f72585] rounded-full opacity-10 blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <!-- Floating Shapes -->
    <div class="absolute inset-0 overflow-hidden opacity-10">
        <div class="absolute top-40 left-20 w-32 h-32 border-4 border-white rounded-3xl rotate-12 animate-float"></div>
        <div class="absolute bottom-40 right-40 w-24 h-24 border-4 border-[#c0f820] rounded-full animate-float-delayed"></div>
        <div class="absolute top-60 right-20 w-20 h-20 bg-white/20 rounded-2xl rotate-45 animate-float-slow"></div>
    </div>

    <div class="container mx-auto px-4 py-20 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <div class="inline-block mb-6 animate-fade-in-down">
                <span class="bg-white/20 backdrop-blur-sm text-white px-6 py-3 rounded-full text-sm font-semibold border border-white/30">
                    ✨ Sejak 2018
                </span>
            </div>
            
            <h1 class="text-5xl md:text-7xl font-bold mb-6 leading-tight">
                Mewujudkan Imajinasi
                <span class="block text-[#c0f820]">Menjadi Realitas</span>
            </h1>
            
            <p class="text-xl md:text-2xl text-white/90 leading-relaxed animate-fade-in" style="animation-delay: 0.2s;">
                Lebih dari sekadar digital printing, kami adalah partner kreatif Anda dalam menciptakan karya visual yang memukau dan bermakna.
            </p>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce">
        <i class="fas fa-chevron-down text-white/50 text-2xl"></i>
    </div>
</section>

<!-- Story Section -->
<section class="py-24 bg-white relative overflow-hidden">
    <div class="absolute top-0 right-0 w-96 h-96 bg-[#193497] opacity-5 blur-3xl"></div>
    
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="grid md:grid-cols-2 gap-16 items-center">
                <!-- Left Content -->
                <div class="order-2 md:order-1">
                    <div class="inline-block mb-4">
                        <span class="bg-[#193497]/10 text-[#193497] px-4 py-2 rounded-full text-sm font-semibold">
                            📖 Cerita Kami
                        </span>
                    </div>
                    
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                        Perjalanan <span class="text-[#193497]">Cipta Imaji</span>
                    </h2>
                    
                    <div class="space-y-6 text-gray-700 leading-relaxed">
                        <p class="text-lg">
                            Berawal dari sebuah mimpi sederhana di tahun <strong>2018</strong>, Cipta Imaji didirikan oleh sekelompok profesional muda yang memiliki passion mendalam di bidang desain grafis dan teknologi printing. Kami percaya bahwa setiap brand, bisnis, dan individu memiliki cerita unik yang layak untuk diceritakan dengan cara yang menarik.
                        </p>
                        
                        <p>
                            Dari ruang kecil dengan satu mesin printer, kini kami telah berkembang menjadi salah satu penyedia layanan digital printing terpercaya di Jakarta. Dengan lebih dari <strong>5.000+ produk terjual</strong> dan <strong>1.000+ klien puas</strong>, kami terus berinovasi untuk memberikan hasil terbaik.
                        </p>
                        
                        <p>
                            Nama <strong>"Cipta Imaji"</strong> sendiri merepresentasikan filosofi kami - menciptakan (cipta) hasil nyata dari imajinasi yang tak terbatas. Setiap proyek adalah kanvas baru, setiap klien adalah partner kolaboratif dalam proses kreatif.
                        </p>
                    </div>

                    <div class="mt-8 flex flex-wrap gap-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-[#193497] rounded-full flex items-center justify-center">
                                <i class="fas fa-trophy text-[#c0f820] text-xl"></i>
                            </div>
                            <div>
                                <div class="font-bold text-gray-900">ISO Certified</div>
                                <div class="text-sm text-gray-600">Quality Assured</div>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-[#720e87] rounded-full flex items-center justify-center">
                                <i class="fas fa-award text-white text-xl"></i>
                            </div>
                            <div>
                                <div class="font-bold text-gray-900">Best Service</div>
                                <div class="text-sm text-gray-600">Award 2023</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Visual -->
                <div class="order-1 md:order-2">
                    <div class="relative">
                        <!-- Main Image Container -->
                        <div class="relative rounded-3xl overflow-hidden shadow-2xl hover-lift smooth-transition">
                            <div class="aspect-w-4 aspect-h-5 bg-gradient-to-br from-[#193497] to-[#720e87]">
                                <img src="{{ asset('img/MASKOT.png') }}" 
                                     alt="Cipta Imaji Team" 
                                     class="w-full h-full object-contain p-8 animate-float"
                                     style="filter: drop-shadow(0 20px 40px rgba(0,0,0,0.3));">
                            </div>
                        </div>

                        <!-- Floating Stats Cards -->
                        <div class="absolute -bottom-6 -left-6 bg-white p-6 rounded-2xl shadow-2xl hover-lift animate-float stagger-1">
                            <div class="text-3xl font-bold text-[#193497]">2018</div>
                            <div class="text-sm text-gray-600">Tahun Berdiri</div>
                        </div>

                        <div class="absolute -top-6 -right-6 bg-white p-6 rounded-2xl shadow-2xl hover-lift animate-float stagger-2">
                            <div class="text-3xl font-bold text-[#720e87]">5000+</div>
                            <div class="text-sm text-gray-600">Produk Terjual</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission & Vision -->
<section class="py-24 bg-gradient-to-br from-gray-50 to-white relative overflow-hidden">
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-[#720e87] opacity-5 blur-3xl"></div>
    
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-4">
                    Visi & <span class="text-[#193497]">Misi</span>
                </h2>
                <p class="text-gray-700 text-lg max-w-2xl mx-auto">
                    Arah dan tujuan kami dalam melayani kebutuhan printing Anda
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <!-- Vision Card -->
                <div class="group relative hover-lift smooth-transition">
                    <div class="absolute inset-0 bg-gradient-to-br from-[#193497] to-[#1e40af] rounded-3xl opacity-5"></div>
                    <div class="relative bg-white rounded-3xl p-10 border-2 border-gray-100 hover:border-[#193497] smooth-transition">
                        <div class="w-20 h-20 bg-gradient-to-br from-[#193497] to-[#1e40af] rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 smooth-transition">
                            <i class="fas fa-eye text-white text-3xl"></i>
                        </div>
                        
                        <h3 class="text-3xl font-bold text-gray-900 mb-4">Visi Kami</h3>
                        
                        <p class="text-gray-700 leading-relaxed text-lg">
                            Menjadi perusahaan digital printing terdepan di Indonesia yang dikenal karena kualitas premium, inovasi berkelanjutan, dan kepuasan pelanggan yang konsisten. Kami berkomitmen untuk terus berkembang bersama teknologi dan kebutuhan pasar.
                        </p>
                    </div>
                </div>

                <!-- Mission Card -->
                <div class="group relative hover-lift smooth-transition">
                    <div class="absolute inset-0 bg-gradient-to-br from-[#720e87] to-[#9333ea] rounded-3xl opacity-5"></div>
                    <div class="relative bg-white rounded-3xl p-10 border-2 border-gray-100 hover:border-[#720e87] smooth-transition">
                        <div class="w-20 h-20 bg-gradient-to-br from-[#720e87] to-[#9333ea] rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 smooth-transition">
                            <i class="fas fa-bullseye text-white text-3xl"></i>
                        </div>
                        
                        <h3 class="text-3xl font-bold text-gray-900 mb-4">Misi Kami</h3>
                        
                        <ul class="space-y-4 text-gray-700">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-[#720e87] mt-1 mr-3"></i>
                                <span>Memberikan produk berkualitas tinggi dengan harga kompetitif</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-[#720e87] mt-1 mr-3"></i>
                                <span>Menggunakan teknologi printing terkini dan ramah lingkungan</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-[#720e87] mt-1 mr-3"></i>
                                <span>Memberikan pelayanan cepat, responsif, dan profesional</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-[#720e87] mt-1 mr-3"></i>
                                <span>Membangun hubungan jangka panjang dengan setiap klien</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Core Values -->
<section class="py-24 bg-white relative overflow-hidden">
    <div class="absolute top-0 right-0 w-96 h-96 bg-[#f72585] opacity-5 blur-3xl"></div>
    
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-4">
                    Nilai-Nilai <span class="text-[#193497]">Kami</span>
                </h2>
                <p class="text-gray-700 text-lg max-w-2xl mx-auto">
                    Prinsip yang menjadi fondasi dalam setiap pekerjaan kami
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                @php
                $values = [
                    [
                        'icon' => 'fa-star',
                        'title' => 'Kualitas',
                        'desc' => 'Kami tidak pernah berkompromi dengan kualitas. Setiap produk melewati quality control ketat.',
                        'gradient' => 'from-[#193497] to-[#1e40af]',
                        'delay' => '0s'
                    ],
                    [
                        'icon' => 'fa-rocket',
                        'title' => 'Inovasi',
                        'desc' => 'Terus belajar dan mengadopsi teknologi terbaru untuk hasil yang lebih baik.',
                        'gradient' => 'from-[#720e87] to-[#9333ea]',
                        'delay' => '0.1s'
                    ],
                    [
                        'icon' => 'fa-heart',
                        'title' => 'Integritas',
                        'desc' => 'Transparansi dan kejujuran dalam setiap transaksi dan komunikasi dengan klien.',
                        'gradient' => 'from-[#f72585] to-[#ec4899]',
                        'delay' => '0.2s'
                    ],
                    [
                        'icon' => 'fa-users',
                        'title' => 'Kolaborasi',
                        'desc' => 'Mendengarkan kebutuhan klien dan bekerja sama untuk hasil terbaik.',
                        'gradient' => 'from-[#ff0f0f] to-[#f87171]',
                        'delay' => '0.3s'
                    ]
                ];
                @endphp

                @foreach($values as $value)
                <div class="group hover-lift smooth-transition" style="animation-delay: {{ $value['delay'] }};">
                    <div class="bg-white border-2 border-gray-100 rounded-3xl p-8 hover:border-transparent hover:shadow-2xl smooth-transition h-full">
                        <div class="w-16 h-16 bg-gradient-to-br {{ $value['gradient'] }} rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 smooth-transition">
                            <i class="fas {{ $value['icon'] }} text-white text-2xl"></i>
                        </div>
                        
                        <h3 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-[#193497] smooth-transition">
                            {{ $value['title'] }}
                        </h3>
                        
                        <p class="text-gray-600 leading-relaxed">
                            {{ $value['desc'] }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-24 bg-gradient-to-br from-gray-50 to-white relative overflow-hidden">
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-[#c0f820] opacity-5 blur-3xl"></div>
    
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-4">
                    Tim <span class="text-[#193497]">Profesional</span>
                </h2>
                <p class="text-gray-700 text-lg max-w-2xl mx-auto">
                    Orang-orang berbakat di balik setiap karya Cipta Imaji
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                @php
                $team = [
                    [
                        'name' => 'Budi Santoso',
                        'role' => 'Founder & CEO',
                        'initial' => 'BS',
                        'gradient' => 'from-[#193497] to-[#1e40af]',
                        'desc' => 'Visioner dengan 10+ tahun pengalaman di industri printing'
                    ],
                    [
                        'name' => 'Siti Nurhaliza',
                        'role' => 'Creative Director',
                        'initial' => 'SN',
                        'gradient' => 'from-[#720e87] to-[#9333ea]',
                        'desc' => 'Expert desainer grafis dengan portfolio internasional'
                    ],
                    [
                        'name' => 'Andi Wijaya',
                        'role' => 'Production Manager',
                        'initial' => 'AW',
                        'gradient' => 'from-[#f72585] to-[#ec4899]',
                        'desc' => 'Spesialis quality control dan optimasi proses produksi'
                    ],
                    [
                        'name' => 'Rina Kusuma',
                        'role' => 'Customer Relations',
                        'initial' => 'RK',
                        'gradient' => 'from-[#ff0f0f] to-[#f87171]',
                        'desc' => 'Memastikan setiap klien mendapat layanan terbaik'
                    ]
                ];
                @endphp

                @foreach($team as $member)
                <div class="group hover-lift smooth-transition {{ 'stagger-' . ($loop->index + 1) }}">
                    <div class="bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl smooth-transition border border-gray-100 hover:border-transparent card-tilt">
                        <!-- Avatar -->
                        <div class="w-24 h-24 bg-gradient-to-br {{ $member['gradient'] }} rounded-2xl flex items-center justify-center text-white font-bold text-3xl mx-auto mb-6 group-hover:scale-110 smooth-transition">
                            {{ $member['initial'] }}
                        </div>
                        
                        <div class="text-center">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $member['name'] }}</h3>
                            <div class="text-sm font-semibold text-[#193497] mb-4">{{ $member['role'] }}</div>
                            <p class="text-gray-600 text-sm leading-relaxed">{{ $member['desc'] }}</p>
                        </div>

                        <!-- Social Links -->
                        <div class="flex justify-center gap-3 mt-6 pt-6 border-t border-gray-100">
                            <a href="#" class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center hover:bg-[#193497] hover:text-white smooth-transition">
                                <i class="fab fa-linkedin-in text-sm"></i>
                            </a>
                            <a href="#" class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center hover:bg-[#193497] hover:text-white smooth-transition">
                                <i class="fab fa-instagram text-sm"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-24 bg-gradient-to-br from-[#193497] to-[#1e40af] relative overflow-hidden">
    <!-- Animated Background -->
    <div class="absolute inset-0">
        <div class="absolute top-20 right-20 w-96 h-96 bg-[#c0f820] rounded-full opacity-10 blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 left-20 w-96 h-96 bg-[#720e87] rounded-full opacity-10 blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-white mb-4">
                    Pencapaian <span class="text-[#c0f820]">Kami</span>
                </h2>
                <p class="text-white/80 text-lg max-w-2xl mx-auto">
                    Angka-angka yang berbicara tentang dedikasi dan kualitas kami
                </p>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
                @php
                $stats = [
                    ['number' => '5000+', 'label' => 'Produk Terjual', 'icon' => 'fa-box'],
                    ['number' => '1000+', 'label' => 'Klien Puas', 'icon' => 'fa-users'],
                    ['number' => '98%', 'label' => 'Kepuasan', 'icon' => 'fa-smile'],
                    ['number' => '24h', 'label' => 'Fast Production', 'icon' => 'fa-clock']
                ];
                @endphp

                @foreach($stats as $index => $stat)
                <div class="text-center animate-fade-in-up" style="animation-delay: {{ $index * 0.1 }}s;">
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/20 hover:bg-white/20 transition-all duration-300 group">
                        <div class="w-16 h-16 bg-white/20 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas {{ $stat['icon'] }} text-white text-2xl"></i>
                        </div>
                        <div class="text-5xl font-bold text-white mb-2">{{ $stat['number'] }}</div>
                        <div class="text-white/80">{{ $stat['label'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Technology & Equipment -->
<section class="py-24 bg-white relative overflow-hidden">
    <div class="absolute top-0 left-0 w-96 h-96 bg-[#193497] opacity-5 blur-3xl"></div>
    
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-4">
                    Teknologi & <span class="text-[#193497]">Peralatan</span>
                </h2>
                <p class="text-gray-700 text-lg max-w-2xl mx-auto">
                    Kami menggunakan mesin dan teknologi terkini untuk hasil maksimal
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                @php
                $technologies = [
                    [
                        'icon' => 'fa-print',
                        'title' => 'Digital Printing HD',
                        'desc' => 'Mesin printing resolusi tinggi untuk hasil detail dan warna akurat',
                        'gradient' => 'from-[#193497] to-[#1e40af]'
                    ],
                    [
                        'icon' => 'fa-cut',
                        'title' => 'Precision Cutting',
                        'desc' => 'Mesin cutting otomatis dengan presisi tinggi untuk finishing sempurna',
                        'gradient' => 'from-[#720e87] to-[#9333ea]'
                    ],
                    [
                        'icon' => 'fa-palette',
                        'title' => 'Color Management',
                        'desc' => 'Sistem kalibrasi warna profesional untuk konsistensi hasil',
                        'gradient' => 'from-[#f72585] to-[#ec4899]'
                    ]
                ];
                @endphp

                @foreach($technologies as $tech)
                <div class="group hover-lift smooth-transition {{ 'stagger-' . ($loop->index + 3) }}">
                    <div class="bg-gradient-to-br {{ $tech['gradient'] }} rounded-3xl p-8 hover:shadow-2xl smooth-transition">
                        <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 smooth-transition">
                            <i class="fas {{ $tech['icon'] }} text-white text-2xl"></i>
                        </div>
                        
                        <h3 class="text-2xl font-bold text-white mb-4">{{ $tech['title'] }}</h3>
                        <p class="text-white/90 leading-relaxed">{{ $tech['desc'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-24 bg-gradient-to-br from-[#193497] to-[#1e40af] relative overflow-hidden">
    <div class="absolute top-0 right-0 w-96 h-96 bg-[#c0f820] rounded-full opacity-10 blur-3xl"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-[#720e87] rounded-full opacity-10 blur-3xl"></div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                Siap Bekerja Sama?
            </h2>
            <p class="text-xl text-white/90 mb-12 max-w-2xl mx-auto">
                Mari wujudkan proyek impian Anda bersama tim profesional Cipta Imaji. Konsultasi gratis untuk Anda!
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('whatsapp.chat') }}" target="_blank"
                   class="bg-[#25D366] hover:bg-[#128C7E] text-white px-8 py-4 rounded-xl font-bold transition-all duration-300 shadow-lg hover:scale-105 flex items-center justify-center gap-3">
                    <i class="fab fa-whatsapp text-2xl"></i>
                    Hubungi Kami
                </a>

                <a href="{{ route('products.index') }}"
                   class="bg-white text-[#193497] hover:bg-[#c0f820] hover:text-[#193497] px-8 py-4 rounded-xl font-bold transition-all duration-300 shadow-lg hover:scale-105 flex items-center justify-center gap-3">
                    <i class="fas fa-shopping-bag"></i>
                    Lihat Produk
                </a>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
/* MODERN PROFESSIONAL ANIMATIONS */

/* Fade In Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

/* Slide Animations */
@keyframes slideInLeft {
    from {
        opacity: 0;
        transform: translateX(-50px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(50px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Scale Animation */
@keyframes scaleIn {
    from {
        opacity: 0;
        transform: scale(0.9);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

/* Gradient Shift */
@keyframes gradientShift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

/* Subtle Float */
@keyframes subtleFloat {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

/* Progress Bar */
@keyframes shimmer {
    0% { background-position: -1000px 0; }
    100% { background-position: 1000px 0; }
}

/* Counter Animation */
@keyframes countUp {
    from { opacity: 0; }
    to { opacity: 1; }
}

/* Glow Effect */
@keyframes subtleGlow {
    0%, 100% {
        box-shadow: 0 0 20px rgba(192, 248, 32, 0.2);
    }
    50% {
        box-shadow: 0 0 30px rgba(192, 248, 32, 0.4);
    }
}

/* Apply Animations */
.animate-fade-in-up {
    animation: fadeInUp 0.8s ease-out forwards;
}

.animate-fade-in-down {
    animation: fadeInDown 0.8s ease-out forwards;
}

.animate-fade-in {
    animation: fadeIn 0.8s ease-out forwards;
}

.animate-slide-in-left {
    animation: slideInLeft 0.8s ease-out forwards;
}

.animate-slide-in-right {
    animation: slideInRight 0.8s ease-out forwards;
}

.animate-scale-in {
    animation: scaleIn 0.6s ease-out forwards;
}

.animate-gradient {
    background-size: 200% 200%;
    animation: gradientShift 8s ease infinite;
}

.animate-float {
    animation: subtleFloat 4s ease-in-out infinite;
}

.animate-shimmer {
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    background-size: 1000px 100%;
    animation: shimmer 2s infinite;
}

.animate-glow {
    animation: subtleGlow 3s ease-in-out infinite;
}

/* Stagger Delays */
.stagger-1 { animation-delay: 0.1s; }
.stagger-2 { animation-delay: 0.2s; }
.stagger-3 { animation-delay: 0.3s; }
.stagger-4 { animation-delay: 0.4s; }
.stagger-5 { animation-delay: 0.5s; }

/* Hover Effects */
.hover-lift {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.hover-lift:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.hover-scale {
    transition: transform 0.3s ease;
}

.hover-scale:hover {
    transform: scale(1.05);
}

.hover-glow:hover {
    box-shadow: 0 0 30px rgba(192, 248, 32, 0.3);
}

/* Card 3D Tilt Effect */
.card-tilt {
    transform-style: preserve-3d;
    transition: transform 0.3s ease;
}

/* Text Gradient */
.text-gradient {
    background: linear-gradient(135deg, #193497, #c0f820);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Smooth Transitions */
.smooth-transition {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Aspect Ratio */
.aspect-w-4 {
    position: relative;
    padding-bottom: calc(5 / 4 * 100%);
}

.aspect-h-5 > * {
    position: absolute;
    height: 100%;
    width: 100%;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
}

/* Scroll Behavior */
html {
    scroll-behavior: smooth;
}

/* Particle Background */
.particles {
    position: absolute;
    width: 100%;
    height: 100%;
    overflow: hidden;
    pointer-events: none;
    opacity: 0.3;
}

.particle {
    position: absolute;
    width: 2px;
    height: 2px;
    background: rgba(192, 248, 32, 0.4);
    border-radius: 50%;
    animation: particleFloat 20s infinite linear;
}

@keyframes particleFloat {
    0% {
        transform: translateY(100vh) translateX(0);
        opacity: 0;
    }
    10% {
        opacity: 1;
    }
    90% {
        opacity: 1;
    }
    100% {
        transform: translateY(-100vh) translateX(50px);
        opacity: 0;
    }
}
</style>
@endpush

@push('scripts')
<script>
// MODERN PROFESSIONAL ANIMATIONS

document.addEventListener('DOMContentLoaded', function() {
    
    // ==================== SUBTLE PARTICLE SYSTEM ====================
    function createParticles() {
        const heroSection = document.querySelector('section');
        if (heroSection && !heroSection.querySelector('.particles')) {
            const particles = document.createElement('div');
            particles.className = 'particles';
            
            for (let i = 0; i < 20; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 20 + 's';
                particles.appendChild(particle);
            }
            
            heroSection.appendChild(particles);
        }
    }
    
    createParticles();

    // ==================== SCROLL REVEAL ANIMATIONS ====================
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in-up');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observe sections and cards
    document.querySelectorAll('section > div, .group, .grid > div').forEach(element => {
        observer.observe(element);
    });

    // ==================== SMOOTH SCROLL PROGRESS ====================
    const progressBar = document.createElement('div');
    progressBar.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        height: 3px;
        background: linear-gradient(90deg, #193497, #c0f820);
        z-index: 9999;
        transition: width 0.2s ease;
    `;
    document.body.appendChild(progressBar);
    
    window.addEventListener('scroll', () => {
        const windowHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (window.pageYOffset / windowHeight) * 100;
        progressBar.style.width = scrolled + '%';
    });

    // ==================== CARD 3D TILT ====================
    document.querySelectorAll('.card-tilt').forEach(card => {
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            
            const rotateX = (y - centerY) / 20;
            const rotateY = (centerX - x) / 20;
            
            card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
        });
        
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'perspective(1000px) rotateX(0) rotateY(0)';
        });
    });

    // ==================== STATS COUNTER ====================
    function animateCounter(element, target, duration = 2000) {
        let start = 0;
        const increment = target / (duration / 16);
        const suffix = element.dataset.suffix || '';
        
        const timer = setInterval(() => {
            start += increment;
            if (start >= target) {
                element.textContent = target + suffix;
                clearInterval(timer);
            } else {
                element.textContent = Math.floor(start) + suffix;
            }
        }, 16);
    }
    
    const statsObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const text = entry.target.textContent;
                const match = text.match(/\d+/);
                
                if (match) {
                    const number = parseInt(match[0]);
                    entry.target.dataset.suffix = text.replace(/\d+/, '').trim();
                    animateCounter(entry.target, number);
                    statsObserver.unobserve(entry.target);
                }
            }
        });
    });
    
    document.querySelectorAll('.text-5xl, .text-3xl').forEach(stat => {
        if (stat.textContent.match(/\d+/)) {
            statsObserver.observe(stat);
        }
    });

    // ==================== PARALLAX EFFECT ====================
    let ticking = false;
    
    window.addEventListener('scroll', () => {
        if (!ticking) {
            window.requestAnimationFrame(() => {
                const scrolled = window.pageYOffset;
                
                // Parallax for background shapes
                document.querySelectorAll('.absolute.blur-3xl').forEach((bg, index) => {
                    const speed = (index + 1) * 0.2;
                    bg.style.transform = `translateY(${scrolled * speed}px)`;
                });
                
                ticking = false;
            });
            ticking = true;
        }
    });

    console.log('✨ Professional animations loaded');
});
</script>
@endpush
