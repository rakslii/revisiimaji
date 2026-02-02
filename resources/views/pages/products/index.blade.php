@extends('layouts.app')

@section('title', 'Produk Digital Printing - Cipta Imaji')

@section('content')
<div class="bg-white min-h-screen">
    <!-- Hero Section - Clean & Minimal -->
    <div class="relative bg-gradient-to-br from-[#193497] to-[#1e40af] text-white overflow-hidden">
        <!-- Subtle Background Elements -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute top-0 right-0 w-96 h-96 bg-[#d2f801] rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-[#7209b7] rounded-full blur-3xl"></div>
        </div>

        <div class="container mx-auto px-4 py-16 md:py-20 relative z-10">
            <div class="max-w-4xl mx-auto text-center hero-content">
                <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">
                    Katalog <span class="text-[#d2f801]">Produk</span>
                </h1>
                <p class="text-xl md:text-2xl opacity-90 mb-10 max-w-2xl mx-auto">
                    Temukan solusi printing terbaik untuk kebutuhan bisnis dan personal Anda
                </p>

                <!-- Clean Search Box -->
                <div class="max-w-2xl mx-auto mb-8">
                    <div class="relative">
                        <input type="text"
                               id="liveSearchInput"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Cari produk..."
                               class="w-full px-6 py-5 pr-16 rounded-2xl bg-white/10 backdrop-blur-md text-white placeholder-white/60 border-2 border-white/20 focus:outline-none focus:border-[#d2f801] focus:bg-white/15 transition-all text-lg">
                        <button type="button" id="searchButton" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-[#d2f801] hover:bg-yellow-300 text-[#193497] p-4 rounded-xl transition-all">
                            <i class="fas fa-search text-xl"></i>
                        </button>
                    </div>
                    <div id="searchResultsInfo" class="text-white/80 mt-3 text-sm hidden">
                        <i class="fas fa-spinner fa-spin mr-2"></i>
                        <span>Mencari...</span>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="grid grid-cols-3 gap-6 max-w-xl mx-auto stats-grid">
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl font-bold text-[#d2f801] mb-1">{{ $products->total() }}+</div>
                        <div class="text-sm text-white/70">Produk</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl font-bold text-[#d2f801] mb-1">24h</div>
                        <div class="text-sm text-white/70">Produksi</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl font-bold text-[#d2f801] mb-1">100%</div>
                        <div class="text-sm text-white/70">Garansi</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8 md:py-12">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Filters - Cleaner Design -->
            <div class="lg:w-1/4">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-6 filter-sidebar">
                    <!-- Categories -->
                    <div class="mb-8">
                        <h3 class="font-bold text-lg mb-4 text-gray-900 flex items-center">
                            <i class="fas fa-tags text-[#193497] mr-2"></i>
                            Kategori
                        </h3>
                        <div class="space-y-2">
                            <!-- Semua Produk -->
                            <button type="button"
                                   onclick="applyFilter('category', '')"
                                   class="w-full group flex items-center px-4 py-3 rounded-xl transition-all duration-300 {{ !request('category') ? 'bg-[#193497] text-white' : 'text-gray-700 hover:bg-gray-50' }}">
                                <i class="fas fa-th-large mr-3 {{ !request('category') ? 'text-[#d2f801]' : 'text-[#193497]' }}"></i>
                                <span class="font-medium">Semua Produk</span>
                                @if(!request('category'))
                                <i class="fas fa-check ml-auto text-[#d2f801]"></i>
                                @endif
                            </button>

                            <!-- Produk Instan -->
                            <button type="button"
                                   onclick="applyFilter('category', 'instan')"
                                   class="w-full group flex items-center px-4 py-3 rounded-xl transition-all duration-300 {{ request('category') == 'instan' ? 'bg-[#193497]/10 text-[#193497] font-medium border border-[#193497]/20' : 'text-gray-700 hover:bg-gray-50' }}">
                                <i class="fas fa-bolt mr-3 text-[#193497]"></i>
                                <span>Produk Instan</span>
                                @if(request('category') == 'instan')
                                <i class="fas fa-check ml-auto text-[#193497]"></i>
                                @endif
                            </button>

                            <!-- Produk Non-Instan -->
                            <button type="button"
                                   onclick="applyFilter('category', 'non-instan')"
                                   class="w-full group flex items-center px-4 py-3 rounded-xl transition-all duration-300 {{ request('category') == 'non-instan' ? 'bg-[#7209b7]/10 text-[#7209b7] font-medium border border-[#7209b7]/20' : 'text-gray-700 hover:bg-gray-50' }}">
                                <i class="fas fa-gem mr-3 text-[#7209b7]"></i>
                                <span>Produk Non Instan</span>
                                @if(request('category') == 'non-instan')
                                <i class="fas fa-check ml-auto text-[#7209b7]"></i>
                                @endif
                            </button>
                        </div>
                    </div>

                    <!-- Sort Options -->
                    <div class="pt-6 border-t border-gray-100">
                        <h3 class="font-bold text-lg mb-4 text-gray-900 flex items-center">
                            <i class="fas fa-sort-amount-down text-[#193497] mr-2"></i>
                            Urutkan
                        </h3>
                        <div id="sortForm">
                            <div class="space-y-2">
                                <label class="flex items-center px-4 py-3 rounded-xl cursor-pointer transition-all duration-300 {{ $selectedSort == 'latest' ? 'bg-[#193497]/5 border border-[#193497]/20' : 'hover:bg-gray-50' }}">
                                    <input type="radio" name="sort" value="latest"
                                           {{ $selectedSort == 'latest' ? 'checked' : '' }}
                                           onchange="applyFilter('sort', 'latest')"
                                           class="mr-3 w-4 h-4 text-[#193497] focus:ring-[#193497] border-gray-300">
                                    <span class="text-sm {{ $selectedSort == 'latest' ? 'text-[#193497] font-medium' : 'text-gray-700' }}">Terbaru</span>
                                </label>
                                <label class="flex items-center px-4 py-3 rounded-xl cursor-pointer transition-all duration-300 {{ $selectedSort == 'popular' ? 'bg-[#193497]/5 border border-[#193497]/20' : 'hover:bg-gray-50' }}">
                                    <input type="radio" name="sort" value="popular"
                                           {{ $selectedSort == 'popular' ? 'checked' : '' }}
                                           onchange="applyFilter('sort', 'popular')"
                                           class="mr-3 w-4 h-4 text-[#193497] focus:ring-[#193497] border-gray-300">
                                    <span class="text-sm {{ $selectedSort == 'popular' ? 'text-[#193497] font-medium' : 'text-gray-700' }}">Terlaris</span>
                                </label>
                                <label class="flex items-center px-4 py-3 rounded-xl cursor-pointer transition-all duration-300 {{ $selectedSort == 'price_asc' ? 'bg-[#193497]/5 border border-[#193497]/20' : 'hover:bg-gray-50' }}">
                                    <input type="radio" name="sort" value="price_asc"
                                           {{ $selectedSort == 'price_asc' ? 'checked' : '' }}
                                           onchange="applyFilter('sort', 'price_asc')"
                                           class="mr-3 w-4 h-4 text-[#193497] focus:ring-[#193497] border-gray-300">
                                    <span class="text-sm {{ $selectedSort == 'price_asc' ? 'text-[#193497] font-medium' : 'text-gray-700' }}">Harga Terendah</span>
                                </label>
                                <label class="flex items-center px-4 py-3 rounded-xl cursor-pointer transition-all duration-300 {{ $selectedSort == 'price_desc' ? 'bg-[#193497]/5 border border-[#193497]/20' : 'hover:bg-gray-50' }}">
                                    <input type="radio" name="sort" value="price_desc"
                                           {{ $selectedSort == 'price_desc' ? 'checked' : '' }}
                                           onchange="applyFilter('sort', 'price_desc')"
                                           class="mr-3 w-4 h-4 text-[#193497] focus:ring-[#193497] border-gray-300">
                                    <span class="text-sm {{ $selectedSort == 'price_desc' ? 'text-[#193497] font-medium' : 'text-gray-700' }}">Harga Tertinggi</span>
                                </label>
                                <label class="flex items-center px-4 py-3 rounded-xl cursor-pointer transition-all duration-300 {{ $selectedSort == 'discount' ? 'bg-[#193497]/5 border border-[#193497]/20' : 'hover:bg-gray-50' }}">
                                    <input type="radio" name="sort" value="discount"
                                           {{ $selectedSort == 'discount' ? 'checked' : '' }}
                                           onchange="applyFilter('sort', 'discount')"
                                           class="mr-3 w-4 h-4 text-[#193497] focus:ring-[#193497] border-gray-300">
                                    <span class="text-sm {{ $selectedSort == 'discount' ? 'text-[#193497] font-medium' : 'text-gray-700' }}">Diskon Terbesar</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Promo Banner - Cleaner -->
                    <div class="mt-8 bg-gradient-to-br from-[#f91f01] to-[#ff4500] text-white rounded-xl p-6 text-center promo-banner">
                        <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-gift text-white text-2xl"></i>
                        </div>
                        <h4 class="font-bold text-white mb-2">Promo Spesial!</h4>
                        <p class="text-white/90 text-sm mb-4">Diskon hingga 30% untuk order pertama</p>
                        <a href="{{ route('whatsapp.chat') }}" target="_blank" class="inline-block bg-white text-[#f91f01] px-6 py-2.5 rounded-lg font-bold text-sm hover:bg-gray-100 transition-all">
                            Klaim Sekarang
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:w-3/4">
                <!-- Results Header - Cleaner -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8 results-header">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-1" id="resultsTitle">
                                @if(request('search'))
                                    <i class="fas fa-search text-[#193497] mr-2"></i>
                                    "{{ request('search') }}"
                                @elseif(request('category'))
                                    @if(request('category') == 'instan')
                                        <i class="fas fa-bolt text-[#193497] mr-2"></i>
                                        Produk Instan
                                    @elseif(request('category') == 'non-instan')
                                        <i class="fas fa-gem text-[#7209b7] mr-2"></i>
                                        Produk Non Instan
                                    @else
                                        <i class="fas fa-th-large text-[#193497] mr-2"></i>
                                        Semua Produk
                                    @endif
                                @else
                                    <i class="fas fa-th-large text-[#193497] mr-2"></i>
                                    Semua Produk
                                @endif
                            </h2>
                            <p class="text-gray-600 text-sm" id="resultsCount">
                                <strong>{{ $products->total() }}</strong> produk ditemukan
                            </p>
                        </div>

                        <div class="flex items-center gap-3">
                            <span class="text-gray-600 text-sm hidden md:block">Tampilan:</span>
                            <div class="flex bg-gray-100 rounded-lg p-1">
                                <button class="p-2.5 rounded-md bg-white shadow-sm transition-all">
                                    <i class="fas fa-th-large text-[#193497]"></i>
                                </button>
                                <button class="p-2.5 rounded-md text-gray-400 hover:text-gray-700 transition-all">
                                    <i class="fas fa-list"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products Grid Container -->
                <div id="productsContainer">
                    @if($products->count() > 0)
                        <x-partials.products.grid :products="$products" />
                    @else
                        <!-- Empty State - Cleaner -->
                        <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center">
                            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-search text-gray-400 text-3xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">Produk Tidak Ditemukan</h3>
                            <p class="text-gray-600 mb-8 max-w-md mx-auto">
                                Maaf, kami tidak menemukan produk yang sesuai dengan pencarian Anda. Coba kata kunci lain atau hubungi kami.
                            </p>
                            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                                <button onclick="resetFilters()" class="bg-[#193497] hover:bg-[#1e40af] text-white px-6 py-3 rounded-xl font-medium transition-all">
                                    <i class="fas fa-th-large mr-2"></i> Lihat Semua Produk
                                </button>
                                <a href="{{ route('whatsapp.chat') }}" target="_blank" class="bg-[#25D366] hover:bg-[#128C7E] text-white px-6 py-3 rounded-xl font-medium transition-all">
                                    <i class="fab fa-whatsapp mr-2"></i> Konsultasi
                                </a>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Pagination Container -->
                @if($products->hasPages())
                <div id="paginationContainer" class="mt-12">
                    <div class="flex justify-center">
                        {{ $products->withQueryString()->links() }}
                    </div>
                </div>
                @endif

                <!-- Call to Action - Cleaner Design -->
                <div class="mt-12 relative bg-gradient-to-br from-[#193497] to-[#1e40af] text-white rounded-2xl p-10 overflow-hidden cta-section">
                    <!-- Subtle Background -->
                    <div class="absolute inset-0 opacity-5">
                        <div class="absolute top-0 right-0 w-64 h-64 bg-[#d2f801] rounded-full blur-3xl"></div>
                        <div class="absolute bottom-0 left-0 w-64 h-64 bg-[#7209b7] rounded-full blur-3xl"></div>
                    </div>

                    <div class="text-center relative z-10">
                        <div class="w-16 h-16 bg-[#d2f801] rounded-xl flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-headset text-[#193497] text-2xl"></i>
                        </div>
                        <h3 class="text-3xl md:text-4xl font-bold mb-4">
                            Butuh Produk <span class="text-[#d2f801]">Custom</span>?
                        </h3>
                        <p class="text-lg md:text-xl mb-8 opacity-90 max-w-2xl mx-auto">
                            Tim desainer profesional kami siap membantu mewujudkan ide kreatif Anda. Konsultasi gratis!
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('whatsapp.chat') }}" target="_blank"
                               class="group inline-flex items-center justify-center bg-[#d2f801] hover:bg-yellow-300 text-[#193497] font-bold px-8 py-4 rounded-xl transition-all duration-300 shadow-lg">
                                <i class="fab fa-whatsapp mr-3 text-xl"></i>
                                <span>Chat WhatsApp</span>
                                <i class="fas fa-arrow-right ml-3 group-hover:translate-x-1 transition-transform"></i>
                            </a>
                            <a href="tel:{{ env('SITE_PHONE', '+6281234567890') }}"
                               class="inline-flex items-center justify-center bg-white/10 backdrop-blur-sm border-2 border-white/30 text-white hover:bg-white hover:text-[#193497] font-bold px-8 py-4 rounded-xl transition-all duration-300">
                                <i class="fas fa-phone mr-3"></i>
                                <span>Telepon Kami</span>
                            </a>
                        </div>

                        <!-- Trust Badges -->
                        <div class="grid grid-cols-3 gap-6 mt-10 max-w-xl mx-auto">
                            <div class="text-center">
                                <div class="text-3xl font-bold text-[#d2f801] mb-1">5K+</div>
                                <div class="text-sm text-white/70">Produk Terjual</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-[#d2f801] mb-1">98%</div>
                                <div class="text-sm text-white/70">Kepuasan</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-[#d2f801] mb-1">1K+</div>
                                <div class="text-sm text-white/70">Review Positif</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Clean Base Styles */
.line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Clean Pagination */
.pagination {
    display: flex;
    justify-content: center;
    list-style: none;
    padding: 0;
    gap: 6px;
}

.pagination li a,
.pagination li span {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 42px;
    height: 42px;
    padding: 0 14px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 500;
    font-size: 14px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.pagination li.active span {
    background: #193497;
    color: white;
    box-shadow: 0 2px 8px rgba(25, 52, 151, 0.3);
}

.pagination li:not(.active):not(.disabled) a {
    color: #6b7280;
    background: white;
    border: 1px solid #e5e7eb;
}

.pagination li:not(.active):not(.disabled) a:hover {
    background: #f9fafb;
    border-color: #193497;
    color: #193497;
    transform: translateY(-1px);
}

.pagination li.disabled span {
    color: #d1d5db;
    cursor: not-allowed;
    background: #f9fafb;
    border: 1px solid #e5e7eb;
}

/* Loading Spinner */
.loading-spinner {
    border: 3px solid #f3f3f3;
    border-top: 3px solid #193497;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 1s linear infinite;
    margin: 20px auto;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Smooth Transitions */
* {
    transition-property: background-color, border-color, color, fill, stroke, opacity, box-shadow, transform;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}
</style>
@endpush

@push('scripts')
<script>
console.log('🔧 Products page loaded - Debug mode ON');

// State variables
let currentFilters = {
    search: "{{ request('search', '') }}",
    category: "{{ request('category', '') }}",
    sort: "{{ $selectedSort ?? 'latest' }}",
    page: {{ request('page', 1) }}
};

let isSearching = false;

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    console.log('📍 DOM loaded, current filters:', currentFilters);
    
    // Initial UI state
    updateCategoryUI(currentFilters.category);
    updateSortUI(currentFilters.sort);
    
    // Setup search
    const searchInput = document.getElementById('liveSearchInput');
    const searchButton = document.getElementById('searchButton');
    
    if (searchInput) {
        searchInput.value = currentFilters.search;
        
        // Search on Enter
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                console.log('🔍 Enter key pressed');
                applyFilter('search', this.value);
            }
        });
        
        // Search on input with debounce
        let searchTimeout;
        searchInput.addEventListener('input', function(e) {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                console.log('🔍 Input changed:', this.value);
                applyFilter('search', this.value);
            }, 500);
        });
    }
    
    if (searchButton) {
        searchButton.addEventListener('click', function() {
            console.log('🔍 Search button clicked');
            applyFilter('search', searchInput.value);
        });
    }
    
    console.log('✅ Initialization complete');
});

// Apply filter function - FIXED
function applyFilter(type, value) {
    console.log(`🎯 applyFilter called: ${type} = "${value}"`);
    
    // Update filter
    currentFilters[type] = value;
    
    // Reset page for non-page filters
    if (type !== 'page') {
        currentFilters.page = 1;
    }
    
    console.log('📋 Updated filters:', currentFilters);
    
    // Update UI
    updateCategoryUI(currentFilters.category);
    updateSortUI(currentFilters.sort);
    
    // Update URL
    updateURL();
    
    // Update results title
    updateResultsTitle();
    
    // Perform search
    performLiveSearch();
}

// Update category buttons UI - FIXED
function updateCategoryUI(category) {
    console.log('🎨 Updating category UI for:', category);
    
    // Get all category buttons
    const buttons = document.querySelectorAll('[onclick*="applyFilter(\'category\'"]');
    
    buttons.forEach(button => {
        // Extract value from onclick attribute
        const onclickAttr = button.getAttribute('onclick');
        const match = onclickAttr.match(/applyFilter\('category',\s*'([^']*)'/);
        
        if (match) {
            const buttonValue = match[1]; // '' (empty), 'instan', or 'non-instan'
            const isActive = buttonValue === category;
            
            console.log(`   Button "${buttonValue}": ${isActive ? 'active' : 'inactive'}`);
            
            // Reset all active classes
            button.classList.remove(
                'bg-[#193497]', 'text-white',
                'bg-[#193497]/10', 'text-[#193497]', 'font-medium', 'border', 'border-[#193497]/20',
                'bg-[#7209b7]/10', 'text-[#7209b7]', 'font-medium', 'border', 'border-[#7209b7]/20'
            );
            
            // Remove check icons
            const checkIcon = button.querySelector('.fa-check');
            if (checkIcon) {
                checkIcon.remove();
            }
            
            // Set classes based on value and active state
            if (isActive) {
                if (buttonValue === '') {
                    // All Products - active
                    button.classList.add('bg-[#193497]', 'text-white');
                    // Add check icon
                    button.innerHTML += '<i class="fas fa-check ml-auto text-[#d2f801]"></i>';
                } else if (buttonValue === 'instan') {
                    // Instan - active
                    button.classList.add('bg-[#193497]/10', 'text-[#193497]', 'font-medium', 'border', 'border-[#193497]/20');
                    // Add check icon
                    button.innerHTML += '<i class="fas fa-check ml-auto text-[#193497]"></i>';
                } else if (buttonValue === 'non-instan') {
                    // Non-Instan - active
                    button.classList.add('bg-[#7209b7]/10', 'text-[#7209b7]', 'font-medium', 'border', 'border-[#7209b7]/20');
                    // Add check icon
                    button.innerHTML += '<i class="fas fa-check ml-auto text-[#7209b7]"></i>';
                }
            } else {
                // Not active - set default classes
                button.classList.add('text-gray-700', 'hover:bg-gray-50');
            }
        }
    });
}

// Update sort UI
function updateSortUI(sortValue) {
    console.log('🎨 Updating sort UI for:', sortValue);
    
    // Update radio buttons
    document.querySelectorAll('input[name="sort"]').forEach(radio => {
        const isChecked = radio.value === sortValue;
        radio.checked = isChecked;
        
        const label = radio.closest('label');
        if (label) {
            // Reset classes
            label.classList.remove('bg-[#193497]/5', 'border', 'border-[#193497]/20');
            
            // Add active classes if checked
            if (isChecked) {
                label.classList.add('bg-[#193497]/5', 'border', 'border-[#193497]/20');
            }
            
            // Update text color
            const span = label.querySelector('span');
            if (span) {
                span.classList.toggle('text-[#193497]', isChecked);
                span.classList.toggle('font-medium', isChecked);
                span.classList.toggle('text-gray-700', !isChecked);
            }
        }
    });
}

// Update browser URL
function updateURL() {
    console.log('🌐 Updating URL');
    
    const url = new URL(window.location.href);
    
    // Clear params
    ['search', 'category', 'sort', 'page'].forEach(param => {
        url.searchParams.delete(param);
    });
    
    // Add current filters
    Object.keys(currentFilters).forEach(key => {
        if (currentFilters[key] && currentFilters[key] !== '') {
            url.searchParams.set(key, currentFilters[key]);
        }
    });
    
    window.history.replaceState({}, '', url.toString());
    console.log('   New URL:', url.toString());
}

// Update results title
function updateResultsTitle() {
    const titleElement = document.getElementById('resultsTitle');
    if (!titleElement) return;
    
    let titleHtml = '';
    
    if (currentFilters.search) {
        titleHtml = `<i class="fas fa-search text-[#193497] mr-2"></i>"${currentFilters.search}"`;
    } else if (currentFilters.category) {
        if (currentFilters.category === 'instan') {
            titleHtml = `<i class="fas fa-bolt text-[#193497] mr-2"></i>Produk Instan`;
        } else if (currentFilters.category === 'non-instan') {
            titleHtml = `<i class="fas fa-gem text-[#7209b7] mr-2"></i>Produk Non Instan`;
        } else {
            titleHtml = `<i class="fas fa-th-large text-[#193497] mr-2"></i>Semua Produk`;
        }
    } else {
        titleHtml = `<i class="fas fa-th-large text-[#193497] mr-2"></i>Semua Produk`;
    }
    
    titleElement.innerHTML = titleHtml;
}

// Perform live search
async function performLiveSearch() {
    if (isSearching) {
        console.log('⏳ Search already in progress');
        return;
    }
    
    isSearching = true;
    console.log('🚀 Starting live search with:', currentFilters);
    
    // Show loading
    const resultsInfo = document.getElementById('searchResultsInfo');
    if (resultsInfo) {
        resultsInfo.classList.remove('hidden');
        resultsInfo.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i><span>Mencari...</span>';
    }
    
    try {
        // Prepare data
        const formData = new FormData();
        formData.append('search', currentFilters.search || '');
        formData.append('category', currentFilters.category || '');
        formData.append('sort', currentFilters.sort || 'latest');
        formData.append('page', currentFilters.page || 1);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}');
        
        console.log('📤 Sending POST to:', '{{ route("products.live-search") }}');
        
        // Send request
        const response = await fetch('{{ route("products.live-search") }}', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            body: formData
        });
        
        console.log('📥 Response status:', response.status);
        const data = await response.json();
        console.log('📊 Response data:', data);
        
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${data.message || 'Server error'}`);
        }
        
        if (data.success) {
            console.log('✅ Search successful, updating UI');
            
            // Update products grid
            document.getElementById('productsContainer').innerHTML = data.html;
            
            // Update pagination
            const paginationContainer = document.getElementById('paginationContainer');
            if (data.pagination) {
                if (!paginationContainer) {
                    const newDiv = document.createElement('div');
                    newDiv.id = 'paginationContainer';
                    newDiv.className = 'mt-12';
                    newDiv.innerHTML = '<div class="flex justify-center">' + data.pagination + '</div>';
                    document.getElementById('productsContainer').after(newDiv);
                } else {
                    paginationContainer.innerHTML = '<div class="flex justify-center">' + data.pagination + '</div>';
                }
            } else if (paginationContainer) {
                paginationContainer.remove();
            }
            
            // Update results count
            const resultsCount = document.getElementById('resultsCount');
            if (resultsCount) {
                resultsCount.innerHTML = `<strong>${data.total}</strong> produk ditemukan`;
            }
            
        } else {
            throw new Error(data.message || 'Search failed');
        }
        
    } catch (error) {
        console.error('❌ Live search error:', error);
        
        // Show error
        document.getElementById('productsContainer').innerHTML = `
            <div class="bg-red-50 border border-red-200 rounded-2xl p-8 text-center">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-exclamation-circle text-red-500 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-red-800 mb-2">Terjadi Kesalahan</h3>
                <p class="text-red-600 mb-4">${error.message}</p>
                <button onclick="performLiveSearch()" 
                        class="bg-red-600 hover:bg-red-700 text-white px-6 py-2.5 rounded-lg font-medium transition-all">
                    <i class="fas fa-redo mr-2"></i>Coba Lagi
                </button>
            </div>
        `;
    } finally {
        // Hide loading
        if (resultsInfo) {
            resultsInfo.classList.add('hidden');
        }
        
        isSearching = false;
        console.log('🏁 Search completed');
        
        // Reattach pagination listeners
        setTimeout(attachPaginationListeners, 100);
    }
}

// Attach pagination listeners
function attachPaginationListeners() {
    console.log('📄 Attaching pagination listeners');
    document.querySelectorAll('.pagination a').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const url = new URL(this.href);
            const page = url.searchParams.get('page');
            if (page) {
                console.log('📄 Pagination to page:', page);
                applyFilter('page', page);
            }
        });
    });
}

// Reset all filters
function resetFilters() {
    console.log('🔄 Resetting all filters');
    currentFilters = {
        search: '',
        category: '',
        sort: 'latest',
        page: 1
    };
    
    // Clear search input
    const searchInput = document.getElementById('liveSearchInput');
    if (searchInput) searchInput.value = '';
    
    // Update UI
    updateCategoryUI('');
    updateSortUI('latest');
    updateResultsTitle();
    
    // Perform search
    performLiveSearch();
}

// Export functions untuk testing
window.applyFilter = applyFilter;
window.performLiveSearch = performLiveSearch;
window.currentFilters = currentFilters;
window.updateCategoryUI = updateCategoryUI;
</script>
@endpush