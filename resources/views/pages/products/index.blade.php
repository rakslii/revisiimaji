@extends('layouts.app')

@section('title', 'Produk Digital Printing - Cipta Imaji')

@section('content')
<div class="bg-gradient-to-b from-gray-50 to-white min-h-screen">
    <!-- Hero Section -->
    <div class="relative bg-[#193497] text-white overflow-hidden">
        <!-- Decorative Elements -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-[#d2f801] rounded-full opacity-10 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-[#7209b7] rounded-full opacity-10 blur-3xl"></div>

        <div class="container mx-auto px-4 py-12 md:py-16 relative z-10">
            <div class="max-w-4xl">
                <h1 class="text-4xl md:text-6xl font-bold mb-4 leading-tight">
                    Katalog <span class="text-[#d2f801]">Produk</span>
                </h1>
                <p class="text-xl md:text-2xl opacity-90 mb-8">
                    Temukan solusi printing terbaik untuk kebutuhan bisnis dan personal Anda
                </p>

                <!-- Search Box - MODIFIED FOR LIVE SEARCH -->
                <div class="max-w-3xl">
                    <div class="relative">
                        <input type="text"
                               id="liveSearchInput"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Cari produk: brosur, banner, kartu nama..."
                               class="w-full px-6 py-5 pr-16 rounded-2xl bg-[#f9f0f1] text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-yellow-400/50 shadow-2xl text-lg">
                        <button type="button" id="searchButton" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-[#d2f801] hover:bg-yellow-300 text-blue-900 p-4 rounded-xl transition-colors shadow-lg">
                            <i class="fas fa-search text-xl"></i>
                        </button>
                    </div>
                    <div id="searchResultsInfo" class="text-white mt-2 text-sm hidden">
                        <i class="fas fa-spinner fa-spin mr-2"></i>
                        <span>Mencari...</span>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="grid grid-cols-3 gap-6 mt-8">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-[#d2f801]">{{ $products->total() }}+</div>
                        <div class="text-sm text-[#f9f0f1]/70">Produk Tersedia</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-[#d2f801]">24h</div>
                        <div class="text-sm text-[#f9f0f1]/70">Produksi Cepat</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-[#d2f801]">100%</div>
                        <div class="text-sm text-[#f9f0f1]/70">Garansi Kualitas</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8 md:py-12">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Filters -->
            <div class="lg:w-1/4">
                <div class="bg-[#f9f0f1] rounded-3xl shadow-xl p-6 sticky top-6 border border-gray-100">
                    <!-- Categories - SIMPLIFIED TO ONLY INSTAN & NON-INSTAN -->
                    <div class="mb-8">
                        <h3 class="font-bold text-xl mb-6 text-gray-800 flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-br bg-[#193497] rounded-xl flex items-center justify-center mr-3">
                                <i class="fas fa-tags text-white"></i>
                            </div>
                            Kategori
                        </h3>
                        <div class="space-y-2">
                            <a href="{{ route('products.index') }}"
                               class="group flex items-center px-4 py-3 rounded-xl transition-all duration-300 {{ !request('category') ? 'bg-[#193497] text-white shadow-lg' : 'text-gray-600 hover:bg-gray-50' }}"
                               onclick="applyFilter('category', '')">
                                <i class="fas fa-th-large mr-3 {{ !request('category') ? 'text-[#d2f801]' : 'text-[#193497]' }}"></i>
                                <span class="font-semibold">Semua Produk</span>
                                @if(!request('category'))
                                <i class="fas fa-check ml-auto"></i>
                                @endif
                            </a>

                            <!-- Produk Instan -->
                            <a href="#"
                               onclick="applyFilter('category', 'instan')"
                               class="group flex items-center px-4 py-3 rounded-xl transition-all duration-300 {{ request('category') == 'instan' ? 'bg-blue-50 text-[#193497] font-semibold border-2 border-[#193497]/30' : 'text-gray-600 hover:bg-gray-50' }}">
                                <i class="fas fa-bolt mr-3 text-[#193497]"></i>
                                <span>Produk Instan</span>
                                @if(request('category') == 'instan')
                                <i class="fas fa-check ml-auto text-[#193497]"></i>
                                @endif
                            </a>

                            <!-- Produk Non-Instan -->
                            <a href="#"
                               onclick="applyFilter('category', 'non-instan')"
                               class="group flex items-center px-4 py-3 rounded-xl transition-all duration-300 {{ request('category') == 'non-instan' ? 'bg-purple-50 text-[#7209b7] font-semibold border-2 border-purple-200' : 'text-gray-600 hover:bg-gray-50' }}">
                                <i class="fas fa-gem mr-3 text-[#7209b7]"></i>
                                <span>Produk Non Instan</span>
                                @if(request('category') == 'non-instan')
                                <i class="fas fa-check ml-auto text-[#7209b7]"></i>
                                @endif
                            </a>
                        </div>
                    </div>

                    <!-- Sort Options -->
                    <div class="pt-6 border-t border-gray-200">
                        <h3 class="font-bold text-xl mb-6 text-gray-800 flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-br bg-[#f91f01] rounded-xl flex items-center justify-center mr-3">
                                <i class="fas fa-sort-amount-down text-white"></i>
                            </div>
                            Urutkan
                        </h3>
                        <div id="sortForm">
                            <div class="space-y-2">
                                <label class="flex items-center px-4 py-3 rounded-xl cursor-pointer transition-all duration-300 {{ $selectedSort == 'latest' ? 'bg-[#193497]/10 border-2 border-[#193497]/30' : 'hover:bg-gray-50' }}">
                                    <input type="radio" name="sort" value="latest"
                                           {{ $selectedSort == 'latest' ? 'checked' : '' }}
                                           onchange="applyFilter('sort', 'latest')"
                                           class="mr-3 w-5 h-5">
                                    <span class="font-medium {{ $selectedSort == 'latest' ? 'text-[#193497]' : 'text-gray-700' }}">Terbaru</span>
                                </label>
                                <label class="flex items-center px-4 py-3 rounded-xl cursor-pointer transition-all duration-300 {{ $selectedSort == 'popular' ? 'bg-[#193497]/10 border-2 border-[#193497]/30' : 'hover:bg-gray-50' }}">
                                    <input type="radio" name="sort" value="popular"
                                           {{ $selectedSort == 'popular' ? 'checked' : '' }}
                                           onchange="applyFilter('sort', 'popular')"
                                           class="mr-3 w-5 h-5">
                                    <span class="font-medium {{ $selectedSort == 'popular' ? 'text-[#193497]' : 'text-gray-700' }}">Terlaris</span>
                                </label>
                                <label class="flex items-center px-4 py-3 rounded-xl cursor-pointer transition-all duration-300 {{ $selectedSort == 'price_asc' ? 'bg-[#193497]/10 border-2 border-[#193497]/30' : 'hover:bg-gray-50' }}">
                                    <input type="radio" name="sort" value="price_asc"
                                           {{ $selectedSort == 'price_asc' ? 'checked' : '' }}
                                           onchange="applyFilter('sort', 'price_asc')"
                                           class="mr-3 w-5 h-5">
                                    <span class="font-medium {{ $selectedSort == 'price_asc' ? 'text-[#193497]' : 'text-gray-700' }}">Harga Terendah</span>
                                </label>
                                <label class="flex items-center px-4 py-3 rounded-xl cursor-pointer transition-all duration-300 {{ $selectedSort == 'price_desc' ? 'bg-[#193497]/10 border-2 border-[#193497]/30' : 'hover:bg-gray-50' }}">
                                    <input type="radio" name="sort" value="price_desc"
                                           {{ $selectedSort == 'price_desc' ? 'checked' : '' }}
                                           onchange="applyFilter('sort', 'price_desc')"
                                           class="mr-3 w-5 h-5">
                                    <span class="font-medium {{ $selectedSort == 'price_desc' ? 'text-[#193497]' : 'text-gray-700' }}">Harga Tertinggi</span>
                                </label>
                                <label class="flex items-center px-4 py-3 rounded-xl cursor-pointer transition-all duration-300 {{ $selectedSort == 'discount' ? 'bg-[#193497]/10 border-2 border-[#193497]/30' : 'hover:bg-gray-50' }}">
                                    <input type="radio" name="sort" value="discount"
                                           {{ $selectedSort == 'discount' ? 'checked' : '' }}
                                           onchange="applyFilter('sort', 'discount')"
                                           class="mr-3 w-5 h-5">
                                    <span class="font-medium {{ $selectedSort == 'discount' ? 'text-[#193497]' : 'text-gray-700' }}">Diskon Terbesar</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Promo Banner -->
                    <div class="mt-8 bg-[#f91f01] text-[#f9f0f1] rounded-2xl p-6 text-center">
                        <i class="fas fa-gift text-white text-4xl mb-3"></i>
                        <h4 class="font-bold text-white mb-2">Promo Spesial!</h4>
                        <p class="text-white text-sm mb-4">Diskon hingga 30% untuk order pertama</p>
                        <a href="{{ route('whatsapp.chat') }}" target="_blank" class="inline-block bg-[#f9f0f1] text-orange-600 px-4 py-2 rounded-full font-bold text-sm hover:bg-gray-100 transition-colors">
                            Klaim Sekarang
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:w-3/4">
                <!-- Results Header -->
                <div class="bg-[#f9f0f1] rounded-3xl shadow-lg p-6 mb-8 border border-gray-100">
                    <div class="flex flex-col md:flex-row md:items-center justify-between">
                        <div>
                            <h2 class="text-3xl font-bold text-gray-800 mb-2" id="resultsTitle">
                                @if(request('search'))
                                    <i class="fas fa-search text-[#193497] mr-2"></i>
                                    "{{ request('search') }}"
                                @elseif(request('category'))
                                    @if($selectedCategory == 'instan')
                                        <i class="fas fa-bolt text-[#193497] mr-2"></i>
                                        Produk Instan
                                    @elseif($selectedCategory == 'non-instan')
                                        <i class="fas fa-gem text-[#7209b7] mr-2"></i>
                                        Produk Non Instan
                                    @else
                                        <i class="fas fa-tag text-[#193497] mr-2"></i>
                                        Semua Produk
                                    @endif
                                @else
                                    <i class="fas fa-th-large text-[#193497] mr-2"></i>
                                    Semua Produk
                                @endif
                            </h2>
                            <p class="text-gray-600 flex items-center" id="resultsCount">
                                <i class="fas fa-box mr-2 text-[#193497]"></i>
                                <strong>{{ $products->total() }}</strong>&nbsp;produk ditemukan
                            </p>
                        </div>

                        <div class="mt-4 md:mt-0">
                            <div class="flex items-center space-x-3">
                                <span class="text-gray-600 hidden md:block font-medium">Tampilan:</span>
                                <div class="flex bg-gray-100 rounded-xl p-1">
                                    <button class="p-3 rounded-lg bg-[#f9f0f1] shadow-md transition-all">
                                        <i class="fas fa-th-large text-[#193497]"></i>
                                    </button>
                                    <button class="p-3 rounded-lg text-gray-500 hover:text-gray-700 transition-all">
                                        <i class="fas fa-list"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products Grid Container -->
                <div id="productsContainer">
                    @if($products->count() > 0)
                        <x-partials.products.grid :products="$products" />
                    @else
                        <!-- Empty State -->
                        <div class="bg-[#f9f0f1] rounded-3xl shadow-lg p-12 text-center">
                            <i class="fas fa-search text-gray-300 text-8xl mb-6"></i>
                            <h3 class="text-2xl font-bold text-gray-800 mb-3">Produk Tidak Ditemukan</h3>
                            <p class="text-gray-600 mb-8 max-w-md mx-auto">
                                Maaf, kami tidak menemukan produk yang sesuai dengan pencarian Anda. Coba kata kunci lain atau hubungi kami untuk produk custom.
                            </p>
                            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                                <button onclick="resetFilters()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold transition-colors">
                                    <i class="fas fa-th-large mr-2"></i> Lihat Semua Produk
                                </button>
                                <a href="{{ route('whatsapp.chat') }}" target="_blank" class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-xl font-semibold transition-colors">
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

                <!-- Call to Action -->
                <div class="mt-12 relative bg-gradient-to-r bg-[#193497] text-white rounded-3xl p-12 overflow-hidden">
                    <!-- Decorative Elements -->
                    <div class="absolute top-0 right-0 w-64 h-64 bg-[#d2f801] rounded-full opacity-10 blur-3xl"></div>
                    <div class="absolute bottom-0 left-0 w-64 h-64 bg-[#7209b7] rounded-full opacity-10 blur-3xl"></div>

                    <div class="text-center relative z-10">
                        <div class="w-20 h-20 bg-[#d2f801] rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-2xl">
                            <i class="fas fa-headset text-blue-900 text-4xl"></i>
                        </div>
                        <h3 class="text-3xl md:text-4xl font-bold mb-4">
                            Butuh Produk <span class="text-[#d2f801]">Custom</span>?
                        </h3>
                        <p class="text-xl mb-8 opacity-90 max-w-2xl mx-auto">
                            Tim desainer profesional kami siap membantu mewujudkan ide kreatif Anda. Konsultasi gratis tanpa biaya!
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('whatsapp.chat') }}" target="_blank"
                               class="group inline-flex items-center justify-center bg-[#d2f801] hover:bg-yellow-300 text-blue-900 font-bold px-8 py-4 rounded-xl transition-all duration-300 shadow-2xl hover:shadow-yellow-400/50 transform hover:scale-105">
                                <i class="fab fa-whatsapp mr-3 text-2xl"></i>
                                <span class="text-lg">Chat WhatsApp</span>
                                <i class="fas fa-arrow-right ml-3 group-hover:translate-x-2 transition-transform"></i>
                            </a>
                            <a href="tel:{{ env('SITE_PHONE', '+6281234567890') }}"
                               class="inline-flex items-center justify-center bg-[#f9f0f1]/10 backdrop-blur-sm border-2 border-white text-white hover:bg-[#f9f0f1] hover:text-blue-900 font-bold px-8 py-4 rounded-xl transition-all duration-300">
                                <i class="fas fa-phone mr-3 text-xl"></i>
                                <span class="text-lg">Telepon Kami</span>
                            </a>
                        </div>

                        <!-- Trust Badges -->
                        <div class="grid grid-cols-3 gap-6 mt-12 max-w-2xl mx-auto">
                            <div class="text-center">
                                <div class="text-4xl font-bold text-[#d2f801] mb-1">5K+</div>
                                <div class="text-sm text-[#f9f0f1]/70">Produk Terjual</div>
                            </div>
                            <div class="text-center">
                                <div class="text-4xl font-bold text-[#d2f801] mb-1">98%</div>
                                <div class="text-sm text-[#f9f0f1]/70">Kepuasan</div>
                            </div>
                            <div class="text-center">
                                <div class="text-4xl font-bold text-[#d2f801] mb-1">1K+</div>
                                <div class="text-sm text-[#f9f0f1]/70">Review Positif</div>
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

/* Custom Radio Button */
input[type="radio"] {
    accent-color: #193497;
}

/* Pagination Styling */
.pagination {
    display: flex;
    justify-content: center;
    list-style: none;
    padding: 0;
    gap: 8px;
}

.pagination li a,
.pagination li span {
    display: flex;
    align-items: center;
    justify-center;
    min-width: 48px;
    height: 48px;
    padding: 0 16px;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s;
}

.pagination li.active span {
    background: #193497;
    color: white;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
}

.pagination li:not(.active):not(.disabled) a {
    color: #4b5563;
    background: white;
    border: 2px solid #e5e7eb;
}

.pagination li:not(.active):not(.disabled) a:hover {
    background: #f3f4f6;
    border-color: #3b82f6;
    color: #3b82f6;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.pagination li.disabled span {
    color: #9ca3af;
    cursor: not-allowed;
    background: #f9fafb;
}

/* Loading Animation */
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
</style>
@endpush

@push('scripts')
<script>
// State variables
let currentFilters = {
    search: "{{ request('search', '') }}",
    category: "{{ request('category', '') }}",
    sort: "{{ $selectedSort }}",
    page: 1
};

let searchTimeout = null;
let isSearching = false;

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    // Setup search input
    const searchInput = document.getElementById('liveSearchInput');
    const searchButton = document.getElementById('searchButton');

    // Search on input with debounce
    searchInput.addEventListener('input', function(e) {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            currentFilters.search = e.target.value;
            currentFilters.page = 1; // Reset to first page on new search
            performLiveSearch();
        }, 500); // 500ms debounce
    });

    // Search on button click
    searchButton.addEventListener('click', function() {
        currentFilters.search = searchInput.value;
        currentFilters.page = 1;
        performLiveSearch();
    });

    // Search on Enter key
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            currentFilters.search = searchInput.value;
            currentFilters.page = 1;
            performLiveSearch();
        }
    });

    // Update URL with current filters
    updateURL();
});
// Apply filter function
function applyFilter(type, value) {
    currentFilters[type] = value;
    if (type !== 'page') {
        currentFilters.page = 1; // Reset to first page when changing filters
    }
    
    // Update UI untuk radio buttons jika type adalah 'sort'
    if (type === 'sort') {
        updateSortUI(value);
    }
    
    updateURL();
    performLiveSearch();
}

// Update UI untuk sort radio buttons
function updateSortUI(selectedValue) {
    // Reset semua radio buttons
    document.querySelectorAll('input[name="sort"]').forEach(radio => {
        radio.checked = false;
        
        // Hapus class active dari parent label
        const label = radio.closest('label');
        if (label) {
            label.classList.remove('bg-[#193497]/10', 'border-2', 'border-[#193497]/30');
            
            // Update text color
            const span = label.querySelector('span');
            if (span) {
                span.classList.remove('text-[#193497]');
                span.classList.add('text-gray-700');
            }
        }
    });
    
    // Set radio button yang dipilih
    const selectedRadio = document.querySelector(`input[name="sort"][value="${selectedValue}"]`);
    if (selectedRadio) {
        selectedRadio.checked = true;
        
        // Add class active ke parent label
        const label = selectedRadio.closest('label');
        if (label) {
            label.classList.add('bg-[#193497]/10', 'border-2', 'border-[#193497]/30');
            
            // Update text color
            const span = label.querySelector('span');
            if (span) {
                span.classList.remove('text-gray-700');
                span.classList.add('text-[#193497]');
            }
        }
    }
}
// Update browser URL without reload
function updateURL() {
    const url = new URL(window.location.href);

    // Clear existing params
    ['search', 'category', 'sort', 'page'].forEach(param => {
        url.searchParams.delete(param);
    });

    // Add active filters
    Object.keys(currentFilters).forEach(key => {
        if (currentFilters[key]) {
            url.searchParams.set(key, currentFilters[key]);
        }
    });

    // Update browser URL without reload
    window.history.replaceState({}, '', url.toString());

    // Update page title
    updateResultsTitle();
}

// Update results title
function updateResultsTitle() {
    const titleElement = document.getElementById('resultsTitle');
    let titleHtml = '';

    if (currentFilters.search) {
        titleHtml = `<i class="fas fa-search text-[#193497] mr-2"></i>"${currentFilters.search}"`;
    } else if (currentFilters.category) {
        if (currentFilters.category === 'instan') {
            titleHtml = `<i class="fas fa-bolt text-[#193497] mr-2"></i>Produk Instan`;
        } else if (currentFilters.category === 'non-instan') {
            titleHtml = `<i class="fas fa-gem text-[#7209b7] mr-2"></i>Produk Non Instan`;
        }
    } else {
        titleHtml = `<i class="fas fa-th-large text-[#193497] mr-2"></i>Semua Produk`;
    }

    titleElement.innerHTML = titleHtml;
}

// Perform live search
function performLiveSearch() {
    if (isSearching) return;

    isSearching = true;

    // Show loading
    const resultsInfo = document.getElementById('searchResultsInfo');
    resultsInfo.classList.remove('hidden');
    resultsInfo.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i><span>Mencari...</span>';

    // Prepare form data
    const formData = new FormData();
    formData.append('search', currentFilters.search);
    formData.append('category', currentFilters.category);
    formData.append('sort', currentFilters.sort);
    formData.append('page', currentFilters.page);
    formData.append('_token', '{{ csrf_token() }}');

    // Send AJAX request
    fetch('{{ route("products.live-search") }}', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        },
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Update products grid
            document.getElementById('productsContainer').innerHTML = data.html;

            // Update pagination
            const paginationContainer = document.getElementById('paginationContainer');
            if (data.pagination) {
                if (!paginationContainer) {
                    const newPagination = document.createElement('div');
                    newPagination.id = 'paginationContainer';
                    newPagination.className = 'mt-12';
                    newPagination.innerHTML = '<div class="flex justify-center">' + data.pagination + '</div>';
                    document.getElementById('productsContainer').after(newPagination);
                } else {
                    paginationContainer.innerHTML = '<div class="flex justify-center">' + data.pagination + '</div>';
                }
            } else {
                if (paginationContainer) {
                    paginationContainer.remove();
                }
            }

            // Update results count
            document.getElementById('resultsCount').innerHTML =
                `<i class="fas fa-box mr-2 text-[#193497]"></i>
                 <strong>${data.total}</strong>&nbsp;produk ditemukan`;

            // Update quick stats
            document.querySelector('.grid.grid-cols-3.gap-6.mt-8 .text-center:nth-child(1) .text-3xl').textContent = `${data.total}+`;

            // Hide loading
            resultsInfo.classList.add('hidden');
        } else {
            throw new Error(data.message || 'Search failed');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        resultsInfo.innerHTML = '<i class="fas fa-exclamation-triangle mr-2"></i><span>Terjadi kesalahan</span>';
        setTimeout(() => {
            resultsInfo.classList.add('hidden');
        }, 3000);
    })
    .finally(() => {
        isSearching = false;

        // Reattach pagination event listeners
        attachPaginationListeners();
    });
}

// Attach event listeners to pagination links
function attachPaginationListeners() {
    document.querySelectorAll('.pagination a').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();

            const url = new URL(this.href);
            const page = url.searchParams.get('page');

            if (page) {
                currentFilters.page = page;
                updateURL();
                performLiveSearch();
            }
        });
    });
}

// Initial attachment of pagination listeners
attachPaginationListeners();
</script>
@endpush
