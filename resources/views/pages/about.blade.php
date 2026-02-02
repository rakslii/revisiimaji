@extends('layouts.app')

@section('title', 'Tentang Kami - Cipta Imaji')

@section('content')

<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-[#193497] via-[#1e40af] to-[#193497] text-white overflow-hidden min-h-[70vh] flex items-center">
    <!-- Minimal Background -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-20 right-20 w-96 h-96 bg-[#c0f820] rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 left-20 w-96 h-96 bg-[#720e87] rounded-full blur-3xl"></div>
    </div>

    <div class="container mx-auto px-4 py-20 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <div class="hero-badge inline-block mb-6">
                <span class="bg-white/20 backdrop-blur-sm text-white px-6 py-3 rounded-full text-sm font-semibold border border-white/30">
                    ✨ Sejak 2018
                </span>
            </div>
            
            <h1 class="hero-title text-5xl md:text-7xl font-bold mb-6 leading-tight">
                Mewujudkan Imajinasi
                <span class="block text-[#c0f820]">Menjadi Realitas</span>
            </h1>
            
            <p class="hero-subtitle text-xl md:text-2xl text-white/90 leading-relaxed">
                Lebih dari sekadar digital printing, kami adalah partner kreatif Anda dalam menciptakan karya visual yang memukau dan bermakna.
            </p>
        </div>
    </div>
</section>

<!-- Story Section -->
<section class="py-24 bg-white relative overflow-hidden">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="grid md:grid-cols-2 gap-16 items-center">
                <!-- Left Content -->
                <div class="story-content">
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

                    <div class="mt-8 flex flex-wrap gap-4 achievements">
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
                <div class="story-image">
                    <div class="relative">
                        <!-- Main Image Container -->
                        <div class="relative rounded-3xl overflow-hidden shadow-2xl">
                            <div class="aspect-w-4 aspect-h-5 bg-gradient-to-br from-[#193497] to-[#720e87]">
                                <img src="{{ asset('img/MASKOT.png') }}" 
                                     alt="Cipta Imaji Team" 
                                     class="w-full h-full object-contain p-8"
                                     style="filter: drop-shadow(0 20px 40px rgba(0,0,0,0.3));">
                            </div>
                        </div>

                        <!-- Floating Stats Cards -->
                        <div class="floating-stat-1 absolute -bottom-6 -left-6 bg-white p-6 rounded-2xl shadow-2xl">
                            <div class="text-3xl font-bold text-[#193497]">2018</div>
                            <div class="text-sm text-gray-600">Tahun Berdiri</div>
                        </div>

                        <div class="floating-stat-2 absolute -top-6 -right-6 bg-white p-6 rounded-2xl shadow-2xl">
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
<section class="py-24 bg-gradient-to-br from-gray-50 to-white">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16 section-header">
                <h2 class="text-4xl md:text-5xl font-bold mb-4">
                    Visi & <span class="text-[#193497]">Misi</span>
                </h2>
                <p class="text-gray-700 text-lg max-w-2xl mx-auto">
                    Arah dan tujuan kami dalam melayani kebutuhan printing Anda
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <!-- Vision Card -->
                <div class="vision-card group">
                    <div class="bg-white rounded-3xl p-10 border-2 border-gray-100 hover:border-[#193497] transition-colors duration-300">
                        <div class="w-20 h-20 bg-gradient-to-br from-[#193497] to-[#1e40af] rounded-2xl flex items-center justify-center mb-6">
                            <i class="fas fa-eye text-white text-3xl"></i>
                        </div>
                        
                        <h3 class="text-3xl font-bold text-gray-900 mb-4">Visi Kami</h3>
                        
                        <p class="text-gray-700 leading-relaxed text-lg">
                            Menjadi perusahaan digital printing terdepan di Indonesia yang dikenal karena kualitas premium, inovasi berkelanjutan, dan kepuasan pelanggan yang konsisten. Kami berkomitmen untuk terus berkembang bersama teknologi dan kebutuhan pasar.
                        </p>
                    </div>
                </div>

                <!-- Mission Card -->
                <div class="mission-card group">
                    <div class="bg-white rounded-3xl p-10 border-2 border-gray-100 hover:border-[#720e87] transition-colors duration-300">
                        <div class="w-20 h-20 bg-gradient-to-br from-[#720e87] to-[#9333ea] rounded-2xl flex items-center justify-center mb-6">
                            <i class="fas fa-bullseye text-white text-3xl"></i>
                        </div>
                        
                        <h3 class="text-3xl font-bold text-gray-900 mb-4">Misi Kami</h3>
                        
                        <ul class="space-y-4 text-gray-700 mission-list">
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
<section class="py-24 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16 section-header">
                <h2 class="text-4xl md:text-5xl font-bold mb-4">
                    Nilai-Nilai <span class="text-[#193497]">Kami</span>
                </h2>
                <p class="text-gray-700 text-lg max-w-2xl mx-auto">
                    Prinsip yang menjadi fondasi dalam setiap pekerjaan kami
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 values-grid">
                @php
                $values = [
                    [
                        'icon' => 'fa-star',
                        'title' => 'Kualitas',
                        'desc' => 'Kami tidak pernah berkompromi dengan kualitas. Setiap produk melewati quality control ketat.',
                        'gradient' => 'from-[#193497] to-[#1e40af]'
                    ],
                    [
                        'icon' => 'fa-rocket',
                        'title' => 'Inovasi',
                        'desc' => 'Terus belajar dan mengadopsi teknologi terbaru untuk hasil yang lebih baik.',
                        'gradient' => 'from-[#720e87] to-[#9333ea]'
                    ],
                    [
                        'icon' => 'fa-heart',
                        'title' => 'Integritas',
                        'desc' => 'Transparansi dan kejujuran dalam setiap transaksi dan komunikasi dengan klien.',
                        'gradient' => 'from-[#f72585] to-[#ec4899]'
                    ],
                    [
                        'icon' => 'fa-users',
                        'title' => 'Kolaborasi',
                        'desc' => 'Mendengarkan kebutuhan klien dan bekerja sama untuk hasil terbaik.',
                        'gradient' => 'from-[#ff0f0f] to-[#f87171]'
                    ]
                ];
                @endphp

                @foreach($values as $value)
                <div class="value-card">
                    <div class="bg-white border-2 border-gray-100 rounded-3xl p-8 hover:border-transparent hover:shadow-2xl transition-all duration-300 h-full">
                        <div class="w-16 h-16 bg-gradient-to-br {{ $value['gradient'] }} rounded-2xl flex items-center justify-center mb-6">
                            <i class="fas {{ $value['icon'] }} text-white text-2xl"></i>
                        </div>
                        
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">
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
<section class="py-24 bg-gradient-to-br from-gray-50 to-white">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16 section-header">
                <h2 class="text-4xl md:text-5xl font-bold mb-4">
                    Tim <span class="text-[#193497]">Profesional</span>
                </h2>
                <p class="text-gray-700 text-lg max-w-2xl mx-auto">
                    Orang-orang berbakat di balik setiap karya Cipta Imaji
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 team-grid">
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
                <div class="team-card">
                    <div class="bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-shadow duration-300 border border-gray-100">
                        <!-- Avatar -->
                        <div class="w-24 h-24 bg-gradient-to-br {{ $member['gradient'] }} rounded-2xl flex items-center justify-center text-white font-bold text-3xl mx-auto mb-6">
                            {{ $member['initial'] }}
                        </div>
                        
                        <div class="text-center">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $member['name'] }}</h3>
                            <div class="text-sm font-semibold text-[#193497] mb-4">{{ $member['role'] }}</div>
                            <p class="text-gray-600 text-sm leading-relaxed">{{ $member['desc'] }}</p>
                        </div>

                        <!-- Social Links -->
                        <div class="flex justify-center gap-3 mt-6 pt-6 border-t border-gray-100">
                            <a href="#" class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center hover:bg-[#193497] hover:text-white transition-colors duration-300">
                                <i class="fab fa-linkedin-in text-sm"></i>
                            </a>
                            <a href="#" class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center hover:bg-[#193497] hover:text-white transition-colors duration-300">
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
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-20 right-20 w-96 h-96 bg-[#c0f820] rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 left-20 w-96 h-96 bg-[#720e87] rounded-full blur-3xl"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16 section-header">
                <h2 class="text-4xl md:text-5xl font-bold text-white mb-4">
                    Pencapaian <span class="text-[#c0f820]">Kami</span>
                </h2>
                <p class="text-white/80 text-lg max-w-2xl mx-auto">
                    Angka-angka yang berbicara tentang dedikasi dan kualitas kami
                </p>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 stats-grid">
                @php
                $stats = [
                    ['number' => '5000', 'label' => 'Produk Terjual', 'icon' => 'fa-box', 'suffix' => '+'],
                    ['number' => '1000', 'label' => 'Klien Puas', 'icon' => 'fa-users', 'suffix' => '+'],
                    ['number' => '98', 'label' => 'Kepuasan', 'icon' => 'fa-smile', 'suffix' => '%'],
                    ['number' => '24', 'label' => 'Fast Production', 'icon' => 'fa-clock', 'suffix' => 'h']
                ];
                @endphp

                @foreach($stats as $stat)
                <div class="stat-card text-center">
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/20 hover:bg-white/20 transition-all duration-300">
                        <div class="w-16 h-16 bg-white/20 rounded-xl flex items-center justify-center mx-auto mb-4">
                            <i class="fas {{ $stat['icon'] }} text-white text-2xl"></i>
                        </div>
                        <div class="text-5xl font-bold text-white mb-2 counter" data-target="{{ $stat['number'] }}" data-suffix="{{ $stat['suffix'] }}">0{{ $stat['suffix'] }}</div>
                        <div class="text-white/80">{{ $stat['label'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Technology & Equipment -->
<section class="py-24 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16 section-header">
                <h2 class="text-4xl md:text-5xl font-bold mb-4">
                    Teknologi & <span class="text-[#193497]">Peralatan</span>
                </h2>
                <p class="text-gray-700 text-lg max-w-2xl mx-auto">
                    Kami menggunakan mesin dan teknologi terkini untuk hasil maksimal
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 tech-grid">
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
                <div class="tech-card">
                    <div class="bg-gradient-to-br {{ $tech['gradient'] }} rounded-3xl p-8 hover:shadow-2xl transition-shadow duration-300">
                        <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center mb-6">
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
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 right-0 w-96 h-96 bg-[#c0f820] rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-[#720e87] rounded-full blur-3xl"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto text-center cta-content">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                Siap Bekerja Sama?
            </h2>
            <p class="text-xl text-white/90 mb-12 max-w-2xl mx-auto">
                Mari wujudkan proyek impian Anda bersama tim profesional Cipta Imaji. Konsultasi gratis untuk Anda!
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-4 cta-buttons">
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
/* Clean Base Styles */
html {
    scroll-behavior: smooth;
}

/* Aspect Ratio Helper */
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

/* Smooth Transitions */
a, button, .transition-all {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
</style>
@endpush

@push('scripts')
<!-- GSAP Core -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<!-- GSAP ScrollTrigger -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>

<script>
// ==================== GSAP ANIMATIONS ====================

document.addEventListener('DOMContentLoaded', function() {
    
    // Register ScrollTrigger plugin
    gsap.registerPlugin(ScrollTrigger);

    // ==================== HERO SECTION ====================
    const heroTimeline = gsap.timeline();
    
    heroTimeline
        .from('.hero-badge', {
            opacity: 0,
            y: -30,
            duration: 0.8,
            ease: 'power3.out'
        })
        .from('.hero-title', {
            opacity: 0,
            y: 50,
            duration: 1,
            ease: 'power3.out'
        }, '-=0.4')
        .from('.hero-subtitle', {
            opacity: 0,
            y: 30,
            duration: 0.8,
            ease: 'power3.out'
        }, '-=0.6');

    // ==================== STORY SECTION ====================
    gsap.from('.story-content', {
        scrollTrigger: {
            trigger: '.story-content',
            start: 'top 80%',
            toggleActions: 'play none none none'
        },
        opacity: 0,
        x: -50,
        duration: 1,
        ease: 'power3.out'
    });

    gsap.from('.story-image', {
        scrollTrigger: {
            trigger: '.story-image',
            start: 'top 80%',
            toggleActions: 'play none none none'
        },
        opacity: 0,
        x: 50,
        duration: 1,
        ease: 'power3.out'
    });

    // Floating stats animation
    gsap.to('.floating-stat-1, .floating-stat-2', {
        y: -20,
        duration: 2,
        ease: 'power1.inOut',
        yoyo: true,
        repeat: -1
    });

    gsap.from('.achievements > div', {
        scrollTrigger: {
            trigger: '.achievements',
            start: 'top 90%',
            toggleActions: 'play none none none'
        },
        opacity: 0,
        y: 30,
        stagger: 0.2,
        duration: 0.8,
        ease: 'power3.out'
    });

    // ==================== SECTION HEADERS ====================
    gsap.utils.toArray('.section-header').forEach(header => {
        gsap.from(header, {
            scrollTrigger: {
                trigger: header,
                start: 'top 85%',
                toggleActions: 'play none none none'
            },
            opacity: 0,
            y: 30,
            duration: 0.8,
            ease: 'power3.out'
        });
    });

    // ==================== VISION & MISSION ====================
    gsap.from('.vision-card', {
        scrollTrigger: {
            trigger: '.vision-card',
            start: 'top 80%',
            toggleActions: 'play none none none'
        },
        opacity: 0,
        x: -50,
        duration: 0.8,
        ease: 'power3.out'
    });

    gsap.from('.mission-card', {
        scrollTrigger: {
            trigger: '.mission-card',
            start: 'top 80%',
            toggleActions: 'play none none none'
        },
        opacity: 0,
        x: 50,
        duration: 0.8,
        ease: 'power3.out'
    });

    gsap.from('.mission-list li', {
        scrollTrigger: {
            trigger: '.mission-list',
            start: 'top 85%',
            toggleActions: 'play none none none'
        },
        opacity: 0,
        x: -20,
        stagger: 0.1,
        duration: 0.6,
        ease: 'power3.out'
    });

    // ==================== VALUES GRID ====================
    gsap.from('.value-card', {
        scrollTrigger: {
            trigger: '.values-grid',
            start: 'top 75%',
            toggleActions: 'play none none none'
        },
        opacity: 0,
        y: 50,
        stagger: 0.15,
        duration: 0.8,
        ease: 'power3.out'
    });

    // ==================== TEAM GRID ====================
    gsap.from('.team-card', {
        scrollTrigger: {
            trigger: '.team-grid',
            start: 'top 75%',
            toggleActions: 'play none none none'
        },
        opacity: 0,
        y: 50,
        stagger: 0.15,
        duration: 0.8,
        ease: 'power3.out'
    });

    // ==================== STATS COUNTER ====================
    const counters = document.querySelectorAll('.counter');
    
    counters.forEach(counter => {
        const target = parseInt(counter.dataset.target);
        const suffix = counter.dataset.suffix || '';
        
        gsap.from(counter, {
            scrollTrigger: {
                trigger: counter,
                start: 'top 80%',
                toggleActions: 'play none none none'
            },
            textContent: 0,
            duration: 2,
            ease: 'power2.out',
            snap: { textContent: 1 },
            onUpdate: function() {
                counter.textContent = Math.ceil(this.targets()[0].textContent) + suffix;
            }
        });
    });

    // ==================== STATS CARDS ====================
    gsap.from('.stat-card', {
        scrollTrigger: {
            trigger: '.stats-grid',
            start: 'top 75%',
            toggleActions: 'play none none none'
        },
        opacity: 0,
        scale: 0.8,
        stagger: 0.15,
        duration: 0.8,
        ease: 'back.out(1.7)'
    });

    // ==================== TECHNOLOGY CARDS ====================
    gsap.from('.tech-card', {
        scrollTrigger: {
            trigger: '.tech-grid',
            start: 'top 75%',
            toggleActions: 'play none none none'
        },
        opacity: 0,
        y: 50,
        stagger: 0.2,
        duration: 0.8,
        ease: 'power3.out'
    });

    // ==================== CTA SECTION ====================
    gsap.from('.cta-content h2', {
        scrollTrigger: {
            trigger: '.cta-content',
            start: 'top 80%',
            toggleActions: 'play none none none'
        },
        opacity: 0,
        y: 30,
        duration: 0.8,
        ease: 'power3.out'
    });

    gsap.from('.cta-content p', {
        scrollTrigger: {
            trigger: '.cta-content',
            start: 'top 80%',
            toggleActions: 'play none none none'
        },
        opacity: 0,
        y: 20,
        duration: 0.8,
        delay: 0.2,
        ease: 'power3.out'
    });

    gsap.from('.cta-buttons a', {
        scrollTrigger: {
            trigger: '.cta-buttons',
            start: 'top 85%',
            toggleActions: 'play none none none'
        },
        opacity: 0,
        y: 30,
        stagger: 0.2,
        duration: 0.8,
        ease: 'power3.out'
    });

    // ==================== HOVER ANIMATIONS ====================
    
    // Card hover effects
    document.querySelectorAll('.value-card, .team-card, .tech-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            gsap.to(this, {
                y: -8,
                duration: 0.3,
                ease: 'power2.out'
            });
        });
        
        card.addEventListener('mouseleave', function() {
            gsap.to(this, {
                y: 0,
                duration: 0.3,
                ease: 'power2.out'
            });
        });
    });

    // Icon rotation on hover
    document.querySelectorAll('.value-card .w-16, .team-card .w-24, .tech-card .w-16').forEach(icon => {
        const parent = icon.closest('.value-card, .team-card, .tech-card');
        
        parent.addEventListener('mouseenter', function() {
            gsap.to(icon, {
                scale: 1.1,
                rotation: 360,
                duration: 0.6,
                ease: 'back.out(1.7)'
            });
        });
        
        parent.addEventListener('mouseleave', function() {
            gsap.to(icon, {
                scale: 1,
                rotation: 0,
                duration: 0.4,
                ease: 'power2.out'
            });
        });
    });

    // ==================== SCROLL PROGRESS BAR ====================
    gsap.to('.progress-bar', {
        scaleX: 1,
        ease: 'none',
        scrollTrigger: {
            trigger: 'body',
            start: 'top top',
            end: 'bottom bottom',
            scrub: true
        }
    });

    // Create progress bar element
    const progressBar = document.createElement('div');
    progressBar.className = 'progress-bar';
    progressBar.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background: linear-gradient(90deg, #193497, #c0f820);
        transform-origin: left;
        transform: scaleX(0);
        z-index: 9999;
    `;
    document.body.appendChild(progressBar);

    console.log('✨ GSAP animations initialized');
});
</script>
@endpush