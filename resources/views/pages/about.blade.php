@extends('layouts.app')

@section('title', 'Tentang Kami - Cipta Imaji')

@section('content')

@php
// Ambil semua section yang aktif dan diurutkan
$sections = \App\Models\AboutUsSection::active()->ordered()->get();

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
$teamMembers = \App\Models\TeamMember::active()->ordered()->get();
$achievements = \App\Models\Achievement::active()->ordered()->get();
$coreValues = \App\Models\CoreValue::active()->ordered()->get();
@endphp

@if($heroSection)
<!-- Hero Section - FIXED STYLING -->
<section class="relative bg-gradient-to-br from-[#193497] via-[#1e40af] to-[#193497] text-white overflow-hidden min-h-[70vh] flex items-center">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-20 right-20 w-96 h-96 bg-[#c0f820] rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 left-20 w-96 h-96 bg-[#720e87] rounded-full blur-3xl"></div>
    </div>

    <div class="container mx-auto px-4 py-20 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            @if($heroSection->data && isset($heroSection->data['badge']))
            <div class="hero-badge inline-block mb-6">
                <span class="bg-white/20 backdrop-blur-sm text-white px-6 py-3 rounded-full text-sm font-semibold border border-white/30">
                    {{ $heroSection->data['badge'] }}
                </span>
            </div>
            @endif
            
            <h1 class="hero-title text-4xl md:text-6xl lg:text-7xl font-bold mb-6 leading-tight dynamic-text">
                {!! nl2br(e($heroSection->title)) !!}
            </h1>
            
            @if($heroSection->subtitle)
            <p class="hero-subtitle text-lg md:text-xl lg:text-2xl text-white/90 leading-relaxed mb-8 dynamic-paragraph">
                {{ $heroSection->subtitle }}
            </p>
            @endif
            
            @if($heroSection->content)
            <div class="mt-6 text-base md:text-lg text-white/80 dynamic-content">
                {!! $heroSection->content !!}
            </div>
            @endif
        </div>
    </div>
</section>
@endif

@if($storySection)
<!-- Story Section - FIXED STYLING -->
<section class="py-16 md:py-20 lg:py-24 bg-white relative overflow-hidden">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-8 lg:gap-16 items-center">
                <!-- Left Content -->
                <div class="story-content">
                    @if($storySection->icon)
                    <div class="inline-block mb-4">
                        <span class="bg-[#193497]/10 text-[#193497] px-4 py-2 rounded-full text-sm font-semibold">
                            <i class="{{ $storySection->icon }} mr-2"></i>
                            {{ $storySection->data['badge'] ?? 'Cerita Kami' }}
                        </span>
                    </div>
                    @endif
                    
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-6 dynamic-heading">
                        {!! nl2br(e($storySection->title)) !!}
                    </h2>
                    
                    @if($storySection->subtitle)
                    <p class="text-gray-600 text-lg mb-8 dynamic-subtitle">
                        {{ $storySection->subtitle }}
                    </p>
                    @endif
                    
                    @if($storySection->content)
                    <div class="space-y-4 text-gray-700 leading-relaxed dynamic-content text-base md:text-lg">
                        {!! $storySection->content !!}
                    </div>
                    @endif

                    @if($storySection->data && isset($storySection->data['achievements']))
                    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6 achievements">
                        @foreach($storySection->data['achievements'] as $achievement)
                        <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-xl">
                            <div class="flex-shrink-0 w-12 h-12 bg-[#193497] rounded-xl flex items-center justify-center">
                                <i class="{{ $achievement['icon'] ?? 'fas fa-trophy' }} text-[#c0f820] text-xl"></i>
                            </div>
                            <div class="flex-grow">
                                <div class="font-bold text-gray-900 text-lg mb-1">{{ $achievement['title'] }}</div>
                                <div class="text-sm text-gray-600">{{ $achievement['description'] ?? '' }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                <!-- Right Visual -->
                <div class="story-image mt-8 lg:mt-0">
                    <div class="relative">
                        <!-- Main Image Container - FIXED -->
                        <div class="relative rounded-3xl overflow-hidden shadow-2xl bg-gradient-to-br from-[#193497] to-[#720e87] p-8">
                            @if($storySection->data && isset($storySection->data['image']))
                            <img src="{{ asset('storage/' . $storySection->data['image']) }}" 
                                 alt="{{ $storySection->title }}" 
                                 class="w-full h-auto object-contain dynamic-image"
                                 style="filter: drop-shadow(0 20px 40px rgba(0,0,0,0.3));">
                            @else
                            <img src="{{ asset('img/MASKOT.png') }}" 
                                 alt="Cipta Imaji Team" 
                                 class="w-full h-auto object-contain dynamic-image"
                                 style="filter: drop-shadow(0 20px 40px rgba(0,0,0,0.3));">
                            @endif
                        </div>

                        <!-- Floating Stats Cards -->
                        @if($storySection->data && isset($storySection->data['stats']))
                            @foreach($storySection->data['stats'] as $index => $stat)
                            <div class="absolute @if($index == 0)-bottom-4 -left-4 md:-bottom-6 md:-left-6 @else -top-4 -right-4 md:-top-6 md:-right-6 @endif bg-white p-4 md:p-6 rounded-2xl shadow-2xl floating-stat">
                                <div class="text-2xl md:text-3xl font-bold text-[#193497]">{{ $stat['value'] }}</div>
                                <div class="text-xs md:text-sm text-gray-600 whitespace-nowrap">{{ $stat['label'] }}</div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

@if($missionSection)
<!-- Mission & Vision - FIXED STYLING -->
<section class="py-16 md:py-20 lg:py-24 bg-gradient-to-br from-gray-50 to-white">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12 lg:mb-16 section-header">
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4 dynamic-heading">
                    {!! nl2br(e($missionSection->title)) !!}
                </h2>
                @if($missionSection->subtitle)
                <p class="text-gray-700 text-base md:text-lg lg:text-xl max-w-2xl mx-auto dynamic-subtitle">
                    {{ $missionSection->subtitle }}
                </p>
                @endif
            </div>

            @php
            $missionData = $missionSection->data ?? [];
            $visionData = $missionData['vision'] ?? null;
            $missionList = $missionData['mission'] ?? [];
            @endphp

            <div class="grid lg:grid-cols-2 gap-8">
                <!-- Vision Card - FIXED -->
                @if($visionData)
                <div class="vision-card group h-full">
                    <div class="bg-white rounded-3xl p-6 md:p-8 lg:p-10 border-2 border-gray-100 hover:border-[#193497] transition-colors duration-300 h-full flex flex-col">
                        <div class="w-16 h-16 md:w-20 md:h-20 bg-gradient-to-br from-[#193497] to-[#1e40af] rounded-2xl flex items-center justify-center mb-6">
                            <i class="fas fa-eye text-white text-2xl md:text-3xl"></i>
                        </div>
                        
                        <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">{{ $visionData['title'] ?? 'Visi Kami' }}</h3>
                        
                        <p class="text-gray-700 leading-relaxed text-base md:text-lg dynamic-content flex-grow">
                            {{ $visionData['description'] ?? '' }}
                        </p>
                    </div>
                </div>
                @endif

                <!-- Mission Card - FIXED -->
                @if(!empty($missionList))
                <div class="mission-card group h-full">
                    <div class="bg-white rounded-3xl p-6 md:p-8 lg:p-10 border-2 border-gray-100 hover:border-[#720e87] transition-colors duration-300 h-full flex flex-col">
                        <div class="w-16 h-16 md:w-20 md:h-20 bg-gradient-to-br from-[#720e87] to-[#9333ea] rounded-2xl flex items-center justify-center mb-6">
                            <i class="fas fa-bullseye text-white text-2xl md:text-3xl"></i>
                        </div>
                        
                        <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">Misi Kami</h3>
                        
                        <ul class="space-y-3 md:space-y-4 text-gray-700 mission-list dynamic-list flex-grow">
                            @foreach($missionList as $mission)
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-[#720e87] mt-1 mr-3 flex-shrink-0"></i>
                                <span class="text-base md:text-lg">{{ $mission }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endif

@if($valuesSection && $coreValues->count() > 0)
<!-- Core Values - FIXED STYLING -->
<section class="py-16 md:py-20 lg:py-24 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12 lg:mb-16 section-header">
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4 dynamic-heading">
                    {!! nl2br(e($valuesSection->title)) !!}
                </h2>
                @if($valuesSection->subtitle)
                <p class="text-gray-700 text-base md:text-lg lg:text-xl max-w-2xl mx-auto dynamic-subtitle">
                    {{ $valuesSection->subtitle }}
                </p>
                @endif
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 values-grid">
                @foreach($coreValues as $value)
                <div class="value-card h-full">
                    <div class="bg-white border-2 border-gray-100 rounded-3xl p-6 hover:border-transparent hover:shadow-2xl transition-all duration-300 h-full flex flex-col">
                        <!-- Icon dengan gradient FIXED -->
                        <div class="w-14 h-14 md:w-16 md:h-16 bg-gradient-to-br from-[#193497] to-[#1e40af] rounded-2xl flex items-center justify-center mb-6">
                            <i class="{{ $value->icon }} text-white text-xl md:text-2xl"></i>
                        </div>
                        
                        <h3 class="text-xl md:text-2xl font-bold text-gray-900 mb-4 value-title">
                            {{ $value->title }}
                        </h3>
                        
                        <p class="text-gray-600 leading-relaxed text-base md:text-lg value-description flex-grow">
                            {{ $value->description }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

@if($teamSection && $teamMembers->count() > 0)
<!-- Team Section - FIXED STYLING -->
<section class="py-16 md:py-20 lg:py-24 bg-gradient-to-br from-gray-50 to-white">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12 lg:mb-16 section-header">
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4 dynamic-heading">
                    {!! nl2br(e($teamSection->title)) !!}
                </h2>
                @if($teamSection->subtitle)
                <p class="text-gray-700 text-base md:text-lg lg:text-xl max-w-2xl mx-auto dynamic-subtitle">
                    {{ $teamSection->subtitle }}
                </p>
                @endif
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 team-grid">
                @foreach($teamMembers as $member)
                <div class="team-card">
                    <div class="bg-white rounded-3xl p-6 shadow-lg hover:shadow-2xl transition-shadow duration-300 border border-gray-100 h-full flex flex-col">
                        <!-- Avatar dengan gradient FIXED -->
                        <div class="w-20 h-20 md:w-24 md:h-24 bg-gradient-to-br from-[#193497] to-[#1e40af] rounded-2xl flex items-center justify-center text-white font-bold text-2xl mx-auto mb-6 overflow-hidden">
                            @if($member->image)
                            <img src="{{ $member->image_url }}" alt="{{ $member->name }}" class="w-full h-full object-cover">
                            @else
                            <span class="text-2xl">{{ $member->avatar_initials }}</span>
                            @endif
                        </div>
                        
                        <div class="text-center flex-grow">
                            <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-2 team-name">{{ $member->name }}</h3>
                            <div class="text-sm font-semibold text-[#193497] mb-4 team-position">{{ $member->position }}</div>
                            @if($member->bio)
                            <p class="text-gray-600 text-sm md:text-base leading-relaxed team-bio flex-grow">{{ Str::limit($member->bio, 120) }}</p>
                            @endif
                        </div>

                        <!-- Social Links -->
                        @if($member->social_links)
                        @php
                            $socialLinks = $member->social_links;
                            if (is_string($socialLinks)) {
                                $socialLinks = json_decode($socialLinks, true);
                            }
                            $socialLinks = is_array($socialLinks) ? $socialLinks : [];
                        @endphp
                        
                        @if(count($socialLinks) > 0)
                        <div class="flex justify-center gap-2 mt-6 pt-6 border-t border-gray-100">
                            @foreach($socialLinks as $platform => $link)
                                @if($link && !empty(trim($link)))
                                <a href="{{ $link }}" target="_blank" 
                                   class="w-8 h-8 md:w-10 md:h-10 bg-gray-100 rounded-full flex items-center justify-center hover:bg-[#193497] hover:text-white transition-colors duration-300"
                                   title="{{ ucfirst($platform) }}">
                                    <i class="fab fa-{{ $platform }} text-sm"></i>
                                </a>
                                @endif
                            @endforeach
                        </div>
                        @endif
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

@if($statsSection && $achievements->count() > 0)
<!-- Stats Section - FIXED STYLING -->
<section class="py-16 md:py-20 lg:py-24 bg-gradient-to-br from-[#193497] to-[#1e40af] relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-20 right-20 w-96 h-96 bg-[#c0f820] rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 left-20 w-96 h-96 bg-[#720e87] rounded-full blur-3xl"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12 lg:mb-16 section-header">
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4 dynamic-heading">
                    {!! nl2br(e($statsSection->title)) !!}
                </h2>
                @if($statsSection->subtitle)
                <p class="text-white/80 text-base md:text-lg lg:text-xl max-w-2xl mx-auto dynamic-subtitle">
                    {{ $statsSection->subtitle }}
                </p>
                @endif
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 stats-grid">
                @foreach($achievements as $achievement)
                <div class="stat-card h-full">
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 md:p-8 border border-white/20 hover:bg-white/20 transition-all duration-300 h-full flex flex-col">
                        @if($achievement->icon)
                        <div class="w-14 h-14 md:w-16 md:h-16 bg-white/20 rounded-xl flex items-center justify-center mx-auto mb-4">
                            <i class="{{ $achievement->icon }} text-white text-xl md:text-2xl"></i>
                        </div>
                        @endif
                        <div class="text-4xl md:text-5xl font-bold text-white mb-2 counter" 
                             data-target="{{ $achievement->value }}" 
                             data-suffix="{{ $achievement->suffix }}">
                            0{{ $achievement->suffix }}
                        </div>
                        <div class="text-white/80 text-base md:text-lg mb-2 stat-title">{{ $achievement->title }}</div>
                        @if($achievement->description)
                        <div class="text-white/60 text-sm md:text-base stat-description flex-grow">{{ $achievement->description }}</div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

@if($technologySection)
<!-- Technology & Equipment - FIXED STYLING -->
<section class="py-16 md:py-20 lg:py-24 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12 lg:mb-16 section-header">
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4 dynamic-heading">
                    {!! nl2br(e($technologySection->title)) !!}
                </h2>
                @if($technologySection->subtitle)
                <p class="text-gray-700 text-base md:text-lg lg:text-xl max-w-2xl mx-auto dynamic-subtitle">
                    {{ $technologySection->subtitle }}
                </p>
                @endif
            </div>

            @php
            $techData = $technologySection->data ?? [];
            @endphp

            @if(isset($techData['technologies']) && is_array($techData['technologies']))
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 tech-grid">
                @foreach($techData['technologies'] as $tech)
                <div class="tech-card h-full">
                    <!-- Tech card dengan gradient FIXED -->
                    <div class="bg-gradient-to-br from-[#193497] to-[#1e40af] rounded-3xl p-6 md:p-8 hover:shadow-2xl transition-shadow duration-300 h-full flex flex-col">
                        @if($tech['icon'] ?? false)
                        <div class="w-14 h-14 md:w-16 md:h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center mb-6">
                            <i class="{{ $tech['icon'] }} text-white text-xl md:text-2xl"></i>
                        </div>
                        @endif
                        
                        <h3 class="text-xl md:text-2xl font-bold text-white mb-4 tech-title">{{ $tech['title'] ?? '' }}</h3>
                        <p class="text-white/90 leading-relaxed text-base md:text-lg tech-description flex-grow">{{ $tech['description'] ?? '' }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</section>
@endif

@if($ctaSection)
<!-- CTA Section - FIXED STYLING -->
<section class="py-16 md:py-20 lg:py-24 bg-gradient-to-br from-[#193497] to-[#1e40af] relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 right-0 w-96 h-96 bg-[#c0f820] rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-[#720e87] rounded-full blur-3xl"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto text-center cta-content">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-6 dynamic-heading">
                {!! nl2br(e($ctaSection->title)) !!}
            </h2>
            
            @if($ctaSection->subtitle)
            <p class="text-lg md:text-xl text-white/90 mb-8 md:mb-12 max-w-2xl mx-auto dynamic-subtitle">
                {{ $ctaSection->subtitle }}
            </p>
            @endif

            @if($ctaSection->content)
            <div class="text-base md:text-lg text-white/80 mb-8 md:mb-12 dynamic-content">
                {!! $ctaSection->content !!}
            </div>
            @endif

            @php
            $ctaData = $ctaSection->data ?? [];
            @endphp

            @if(isset($ctaData['buttons']) && is_array($ctaData['buttons']))
            <div class="flex flex-col sm:flex-row justify-center gap-4 cta-buttons">
                @foreach($ctaData['buttons'] as $button)
                <a href="{{ $button['url'] ?? '#' }}" 
                   target="{{ $button['target'] ?? '_self' }}"
                   class="px-6 py-3 md:px-8 md:py-4 rounded-xl font-bold transition-all duration-300 shadow-lg hover:scale-105 flex items-center justify-center gap-3 text-center dynamic-button"
                   style="background-color: {{ $button['bg_color'] ?? '#25D366' }}; color: {{ $button['text_color'] ?? '#ffffff' }}">
                    @if($button['icon'] ?? false)
                    <i class="{{ $button['icon'] }} text-lg md:text-xl"></i>
                    @endif
                    <span class="text-sm md:text-base">{{ $button['text'] ?? 'Hubungi Kami' }}</span>
                </a>
                @endforeach
            </div>
            @else
            <!-- Default CTA buttons - FIXED -->
            <div class="flex flex-col sm:flex-row justify-center gap-4 cta-buttons">
                <a href="{{ route('whatsapp.chat') }}" target="_blank"
                   class="bg-[#25D366] hover:bg-[#128C7E] text-white px-6 py-3 md:px-8 md:py-4 rounded-xl font-bold transition-all duration-300 shadow-lg hover:scale-105 flex items-center justify-center gap-3 text-center dynamic-button">
                    <i class="fab fa-whatsapp text-lg md:text-xl"></i>
                    <span class="text-sm md:text-base">Hubungi Kami</span>
                </a>

                <a href="{{ route('products.index') }}"
                   class="bg-white text-[#193497] hover:bg-[#c0f820] hover:text-[#193497] px-6 py-3 md:px-8 md:py-4 rounded-xl font-bold transition-all duration-300 shadow-lg hover:scale-105 flex items-center justify-center gap-3 text-center dynamic-button">
                    <i class="fas fa-shopping-bag"></i>
                    <span class="text-sm md:text-base">Lihat Produk</span>
                </a>
            </div>
            @endif
        </div>
    </div>
</section>
@endif

@endsection

@push('styles')
<style>
/* ==================== CONTAINER STYLES - MEMBUAT SECTION TERLIHAT JELAS ==================== */

/* Container utama setiap section */
section {
    position: relative;
    scroll-margin-top: 80px; /* Memberi jarak saat anchor scroll */
}

/* Efek pemisah antar section - garis gradient halus */
section:not(:last-child)::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 80%;
    max-width: 1200px;
    height: 2px;
    background: linear-gradient(90deg, 
        transparent 0%, 
        rgba(25, 52, 151, 0.1) 20%,
        rgba(25, 52, 151, 0.3) 50%,
        rgba(25, 52, 151, 0.1) 80%,
        transparent 100%
    );
    z-index: 5;
}

/* Container dalam dengan background yang jelas */
.container {
    position: relative;
    z-index: 2;
}

/* Background pattern halus untuk membedakan section */
section:nth-child(even) {
    background-color: #fafbfc;
}

section:nth-child(odd) {
    background-color: #ffffff;
}

/* Card container dengan border dan shadow */
.value-card > div,
.team-card > div,
.tech-card > div,
.stat-card > div,
.vision-card > div,
.mission-card > div {
    background: white;
    border: 1px solid rgba(0, 0, 0, 0.05);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    transition: all 0.3s ease;
}

.value-card > div:hover,
.team-card > div:hover,
.tech-card > div:hover,
.stat-card > div:hover,
.vision-card > div:hover,
.mission-card > div:hover {
    border-color: rgba(25, 52, 151, 0.2);
    box-shadow: 0 20px 25px -5px rgba(25, 52, 151, 0.1), 0 10px 10px -5px rgba(25, 52, 151, 0.04);
    transform: translateY(-2px);
}

/* Section header dengan underline */
.section-header {
    position: relative;
    padding-bottom: 1.5rem;
    margin-bottom: 2rem;
}

.section-header::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background: linear-gradient(90deg, #193497, #720e87);
    border-radius: 2px;
}

/* Untuk header di kiri (story section) */
.story-content .section-header::after {
    left: 0;
    transform: none;
}

/* Divider visual antar elemen */
.achievements > div {
    border: 1px solid rgba(0, 0, 0, 0.05);
    background: white;
}

/* Stats card dengan efek kaca */
.stat-card > div {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.stat-card > div:hover {
    background: rgba(255, 255, 255, 0.15);
    border-color: rgba(255, 255, 255, 0.3);
}

/* Shadow yang lebih tegas untuk floating elements */
.floating-stat {
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.15), 0 10px 10px -5px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.8);
}

/* Responsive spacing */
@media (min-width: 768px) {
    section {
        padding-top: 6rem;
        padding-bottom: 6rem;
    }
    
    .section-header {
        margin-bottom: 3rem;
    }
}

@media (max-width: 767px) {
    section {
        padding-top: 4rem;
        padding-bottom: 4rem;
    }
    
    /* Hilangkan garis pemisah di mobile */
    section:not(:last-child)::after {
        width: 90%;
        height: 1px;
    }
}

/* Dynamic Text Sizing - PRIMARY (always applied) */
.dynamic-text {
    font-size: clamp(2rem, 5vw, 4.5rem);
    line-height: 1.2;
    word-wrap: break-word;
    overflow-wrap: break-word;
    hyphens: auto;
}

.dynamic-heading {
    font-size: clamp(1.75rem, 4vw, 3.5rem);
    line-height: 1.3;
    word-wrap: break-word;
    overflow-wrap: break-word;
}

.dynamic-subtitle {
    font-size: clamp(1rem, 2vw, 1.5rem);
    line-height: 1.6;
}

.dynamic-content {
    font-size: clamp(0.875rem, 1.5vw, 1.125rem);
    line-height: 1.7;
}

.dynamic-content p {
    margin-bottom: 1rem;
}

.dynamic-content ul, .dynamic-content ol {
    padding-left: 1.5rem;
    margin-bottom: 1rem;
}

.dynamic-content li {
    margin-bottom: 0.5rem;
}

.dynamic-paragraph {
    word-wrap: break-word;
    overflow-wrap: break-word;
}

.dynamic-list li {
    margin-bottom: 0.75rem;
    word-wrap: break-word;
}

/* Value Card Height Adjustment */
.value-card {
    height: 100%;
}

.value-card > div {
    display: flex;
    flex-direction: column;
    min-height: 280px;
}

.value-description {
    flex-grow: 1;
}

/* Team Card Adjustments */
.team-card > div {
    display: flex;
    flex-direction: column;
    min-height: 380px;
}

.team-bio {
    flex-grow: 1;
    word-wrap: break-word;
    overflow-wrap: break-word;
}

.team-name {
    font-size: clamp(1rem, 2vw, 1.25rem);
}

.team-position {
    font-size: clamp(0.875rem, 1.5vw, 1rem);
}

/* Tech Card Adjustments */
.tech-card > div {
    display: flex;
    flex-direction: column;
    min-height: 260px;
}

.tech-description {
    flex-grow: 1;
    word-wrap: break-word;
    overflow-wrap: break-word;
}

/* Button Responsive */
.dynamic-button {
    font-size: clamp(0.875rem, 1.5vw, 1rem);
    min-height: 48px;
    white-space: nowrap;
}

/* Image Responsive */
.dynamic-image {
    max-height: 500px;
    object-fit: contain;
}

/* Stats Counter Responsive */
.counter {
    font-size: clamp(2.5rem, 5vw, 4rem);
}

.stat-title {
    font-size: clamp(0.875rem, 1.5vw, 1.125rem);
}

.stat-description {
    font-size: clamp(0.75rem, 1.2vw, 0.875rem);
}

/* Mobile Responsive Adjustments */
@media (max-width: 640px) {
    .story-image {
        margin-top: 2rem;
    }
    
    .floating-stat {
        padding: 0.75rem !important;
    }
    
    .floating-stat div:first-child {
        font-size: 1.25rem !important;
    }
    
    .achievements {
        grid-template-columns: 1fr !important;
    }
    
    .value-card > div {
        min-height: 320px;
    }
    
    .team-card > div {
        min-height: 420px;
    }
    
    .tech-card > div {
        min-height: 280px;
    }
}

/* Tablet Responsive */
@media (min-width: 641px) and (max-width: 1024px) {
    .values-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .tech-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .value-card > div {
        min-height: 300px;
    }
    
    .team-card > div {
        min-height: 400px;
    }
    
    .tech-card > div {
        min-height: 280px;
    }
}

/* Desktop Adjustments */
@media (min-width: 1025px) {
    .text-length-long .value-card > div {
        min-height: 320px;
    }
    
    .text-length-long .team-card > div {
        min-height: 420px;
    }
    
    .text-length-long .tech-card > div {
        min-height: 300px;
    }
    
    .text-length-short .value-card > div {
        min-height: 260px;
    }
    
    .text-length-short .team-card > div {
        min-height: 360px;
    }
    
    .text-length-short .tech-card > div {
        min-height: 240px;
    }
}

/* Text Length Detection */
.text-length-long .dynamic-content,
.text-length-long .dynamic-subtitle {
    font-size: 0.9em;
    line-height: 1.8;
}

.text-length-medium .dynamic-content,
.text-length-medium .dynamic-subtitle {
    font-size: 1em;
    line-height: 1.6;
}

.text-length-short .dynamic-content,
.text-length-short .dynamic-subtitle {
    font-size: 1.1em;
    line-height: 1.5;
}

.text-length-long .value-card,
.text-length-long .team-card,
.text-length-long .tech-card {
    margin-bottom: 1rem;
}

.text-length-long .dynamic-list li {
    margin-bottom: 1rem;
}

.text-length-short .dynamic-list li {
    margin-bottom: 0.5rem;
}

/* Flex layout */
.flex-grow {
    flex-grow: 1;
}

.flex-col {
    display: flex;
    flex-direction: column;
}

/* Smooth Transitions */
a, button, .transition-all {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Scroll Progress Bar */
.progress-bar {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 3px;
    background: linear-gradient(90deg, #193497, #c0f820);
    transform-origin: left;
    transform: scaleX(0);
    z-index: 9999;
}

/* Ensure proper text wrapping */
.break-words {
    word-break: break-word;
}

/* Line clamping for very long text */
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-4 {
    display: -webkit-box;
    -webkit-line-clamp: 4;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endpush
@push('scripts')
<!-- GSAP Core -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<!-- GSAP ScrollTrigger -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>

<script>
// ==================== SIMPLE TEXT LENGTH ADJUSTMENT ====================
function adjustTextBasedOnLength() {
    console.log('🔧 Adjusting text based on length...');
    
    document.querySelectorAll('.dynamic-content, .dynamic-subtitle, .value-description, .team-bio, .tech-description').forEach(element => {
        const text = element.textContent.trim();
        const length = text.length;
        
        element.classList.remove('text-length-long', 'text-length-medium', 'text-length-short');
        
        if (length > 500) {
            element.classList.add('text-length-long');
        } else if (length > 200) {
            element.classList.add('text-length-medium');
        } else {
            element.classList.add('text-length-short');
        }
    });

    document.querySelectorAll('.value-card, .team-card, .tech-card').forEach(card => {
        const description = card.querySelector('.value-description, .team-bio, .tech-description');
        if (description) {
            const text = description.textContent.trim();
            const length = text.length;
            
            card.classList.remove('text-length-long', 'text-length-medium', 'text-length-short');
            
            if (length > 500) {
                card.classList.add('text-length-long');
            } else if (length > 200) {
                card.classList.add('text-length-medium');
            } else {
                card.classList.add('text-length-short');
            }
        }
    });

    document.querySelectorAll('.dynamic-list').forEach(list => {
        const items = list.querySelectorAll('li');
        let totalLength = 0;
        items.forEach(item => {
            totalLength += item.textContent.trim().length;
        });
        
        const avgLength = totalLength / items.length;
        
        list.classList.remove('text-length-long', 'text-length-medium', 'text-length-short');
        
        if (avgLength > 100) {
            list.classList.add('text-length-long');
        } else if (avgLength > 50) {
            list.classList.add('text-length-medium');
        } else {
            list.classList.add('text-length-short');
        }
    });

    console.log('✅ Text adjustment completed');
}

// ==================== GSAP ANIMATIONS ====================

document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Page loaded, initializing...');
    
    setTimeout(() => {
        adjustTextBasedOnLength();
    }, 100);
    
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            console.log('🔄 Window resized, readjusting...');
            adjustTextBasedOnLength();
            ScrollTrigger.refresh();
        }, 250);
    });

    gsap.registerPlugin(ScrollTrigger);

    // ==================== HERO SECTION ====================
    @if($heroSection)
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
    @endif

    // ==================== STORY SECTION ====================
    @if($storySection)
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

    gsap.to('.floating-stat', {
        y: -15,
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
    @endif

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
    @if($missionSection)
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
    @endif

    // ==================== VALUES GRID ====================
    @if($valuesSection && $coreValues->count() > 0)
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
    @endif

    // ==================== TEAM GRID ====================
    @if($teamSection && $teamMembers->count() > 0)
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
    @endif

    // ==================== STATS COUNTER ====================
    @if($statsSection && $achievements->count() > 0)
    const counters = document.querySelectorAll('.counter');
    
    counters.forEach(counter => {
        const target = parseInt(counter.dataset.target);
        const suffix = counter.dataset.suffix || '';
        
        gsap.to(counter, {
            scrollTrigger: {
                trigger: counter,
                start: 'top 80%',
                toggleActions: 'play none none none'
            },
            innerHTML: target + suffix,
            duration: 2,
            ease: 'power2.out',
            snap: { innerHTML: 1 },
            onUpdate: function() {
                const value = Math.ceil(parseInt(this.targets()[0].innerHTML.replace(suffix, '')) || 0);
                counter.innerHTML = value + suffix;
            }
        });
    });

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
    @endif

    // ==================== TECHNOLOGY CARDS ====================
    @if($technologySection)
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
    @endif

    // ==================== CTA SECTION ====================
    @if($ctaSection)
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
    @endif

    // ==================== HOVER ANIMATIONS ====================
    
    document.querySelectorAll('.value-card, .team-card, .tech-card, .stat-card').forEach(card => {
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
    const progressBar = document.createElement('div');
    progressBar.className = 'progress-bar';
    document.body.appendChild(progressBar);

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

    console.log('✨ GSAP animations initialized with dynamic text adjustment');
});

window.reAdjustLayout = function() {
    console.log('🔄 Manual layout adjustment triggered');
    adjustTextBasedOnLength();
    ScrollTrigger.refresh();
};

window.addEventListener('load', function() {
    console.log('🖼️ All assets loaded, final adjustment');
    setTimeout(adjustTextBasedOnLength, 500);
});
</script>
@endpush