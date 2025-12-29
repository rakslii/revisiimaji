@extends('layouts.app')

@section('title', 'Produk Digital Printing - Cipta Imaji')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white">
        <div class="container mx-auto px-4 py-8 md:py-12">
            <h1 class="text-3xl md:text-4xl font-bold mb-4">Katalog Produk Printing</h1>
            <p class="text-lg opacity-90 max-w-2xl">
                Temukan berbagai produk digital printing untuk kebutuhan bisnis, acara, dan personal Anda.
            </p>
            
            <!-- Search Box -->
            <form action="{{ route('products.index') }}" method="GET" class="mt-6 max-w-2xl">
                <div class="relative">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Cari produk (contoh: brosur, kartu nama, banner...)"
                           class="w-full px-6 py-4 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-lg">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Filters -->
            <div class="lg:w-1/4">
                <div class="bg-white rounded-xl shadow-sm p-6 sticky top-6">
                    <!-- Categories -->
                    <div class="mb-8">
                        <h3 class="font-bold text-lg mb-4 text-gray-800 flex items-center">
                            <i class="fas fa-tags mr-2 text-blue-600"></i>
                            Kategori Produk
                        </h3>
                        <div class="space-y-2">
                            <a href="{{ route('products.index') }}" 
                               class="block px-4 py-2 rounded-lg {{ !request('category') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-600 hover:bg-gray-50' }}">
                                <i class="fas fa-th-large mr-2"></i>
                                Semua Produk
                            </a>
                            
                            @if($instantCategories->isNotEmpty())
                            <div class="mt-4">
                                <h4 class="font-semibold text-gray-700 mb-2 text-sm uppercase tracking-wider">Produk Instan</h4>
                                <div class="space-y-1 pl-2">
                                    @foreach($instantCategories as $category)
                                    <a href="{{ route('products.index', ['category' => $category->slug]) }}"
                                       class="block px-4 py-2 rounded-lg {{ request('category') == $category->slug ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-600 hover:bg-gray-50' }}">
                                        <i class="fas fa-rocket mr-2 text-blue-500"></i>
                                        {{ $category->name }}
                                    </a>
                                    @endforeach
                                    <a href="{{ route('products.index', ['category' => 'instan']) }}"
                                       class="block px-4 py-2 rounded-lg {{ request('category') == 'instan' ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-600 hover:bg-gray-50' }}">
                                        <i class="fas fa-bolt mr-2 text-blue-500"></i>
                                        Semua Produk Instan
                                    </a>
                                </div>
                            </div>
                            @endif
                            
                            @if($customCategories->isNotEmpty())
                            <div class="mt-4">
                                <h4 class="font-semibold text-gray-700 mb-2 text-sm uppercase tracking-wider">Produk Custom</h4>
                                <div class="space-y-1 pl-2">
                                    @foreach($customCategories as $category)
                                    <a href="{{ route('products.index', ['category' => $category->slug]) }}"
                                       class="block px-4 py-2 rounded-lg {{ request('category') == $category->slug ? 'bg-purple-50 text-purple-600 font-semibold' : 'text-gray-600 hover:bg-gray-50' }}">
                                        <i class="fas fa-paint-brush mr-2 text-purple-500"></i>
                                        {{ $category->name }}
                                    </a>
                                    @endforeach
                                    <a href="{{ route('products.index', ['category' => 'non-instan']) }}"
                                       class="block px-4 py-2 rounded-lg {{ request('category') == 'non-instan' ? 'bg-purple-50 text-purple-600 font-semibold' : 'text-gray-600 hover:bg-gray-50' }}">
                                        <i class="fas fa-gem mr-2 text-purple-500"></i>
                                        Semua Produk Custom
                                    </a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Sort Options -->
                    <div>
                        <h3 class="font-bold text-lg mb-4 text-gray-800 flex items-center">
                            <i class="fas fa-sort-amount-down mr-2 text-blue-600"></i>
                            Urutkan
                        </h3>
                        <form id="sortForm">
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="radio" name="sort" value="latest" 
                                           {{ $selectedSort == 'latest' ? 'checked' : '' }}
                                           onchange="this.form.submit()"
                                           class="mr-3">
                                    <span>Terbaru</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="sort" value="popular" 
                                           {{ $selectedSort == 'popular' ? 'checked' : '' }}
                                           onchange="this.form.submit()"
                                           class="mr-3">
                                    <span>Terlaris</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="sort" value="price_asc" 
                                           {{ $selectedSort == 'price_asc' ? 'checked' : '' }}
                                           onchange="this.form.submit()"
                                           class="mr-3">
                                    <span>Harga: Rendah ke Tinggi</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="sort" value="price_desc" 
                                           {{ $selectedSort == 'price_desc' ? 'checked' : '' }}
                                           onchange="this.form.submit()"
                                           class="mr-3">
                                    <span>Harga: Tinggi ke Rendah</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="sort" value="discount" 
                                           {{ $selectedSort == 'discount' ? 'checked' : '' }}
                                           onchange="this.form.submit()"
                                           class="mr-3">
                                    <span>Diskon Terbesar</span>
                                </label>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:w-3/4">
                <!-- Results Header -->
                <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">
                            @if(request('search'))
                                Hasil pencarian "{{ request('search') }}"
                            @elseif(request('category'))
                                {{ $selectedCategory == 'instan' ? 'Produk Instan' : ($selectedCategory == 'non-instan' ? 'Produk Custom' : 'Kategori: ' . ($categories->flatten()->where('slug', request('category'))->first()->name ?? '')) }}
                            @else
                                Semua Produk
                            @endif
                        </h2>
                        <p class="text-gray-600 mt-1">
                            Menampilkan {{ $products->total() }} produk
                        </p>
                    </div>
                    
                    <div class="mt-4 md:mt-0">
                        <div class="flex items-center space-x-4">
                            <span class="text-gray-600 hidden md:block">Tampilkan:</span>
                            <div class="flex bg-gray-100 rounded-lg p-1">
                                <button class="p-2 rounded-lg bg-white shadow-sm">
                                    <i class="fas fa-th-large"></i>
                                </button>
                                <button class="p-2 rounded-lg text-gray-500 hover:text-gray-700">
                                    <i class="fas fa-list"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products Grid -->
                <x-partials.products.grid :products="$products" />

                <!-- Pagination -->
                @if($products->hasPages())
                <div class="mt-12">
                    {{ $products->withQueryString()->links() }}
                </div>
                @endif
                
                <!-- Call to Action -->
                <div class="mt-12 bg-gradient-to-r from-blue-50 to-white rounded-2xl p-8 border border-blue-100">
                    <div class="text-center">
                        <i class="fas fa-headset text-blue-500 text-4xl mb-4"></i>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Butuh Produk Custom?</h3>
                        <p class="text-gray-600 mb-6 max-w-lg mx-auto">
                            Kami siap membantu mewujudkan desain sesuai kebutuhan Anda. Konsultasi gratis!
                        </p>
                        <a href="{{ route('whatsapp.chat') }}" target="_blank"
                           class="inline-flex items-center bg-green-500 hover:bg-green-600 text-white font-semibold px-6 py-3 rounded-lg transition-colors">
                            <i class="fab fa-whatsapp mr-2 text-xl"></i>
                            Konsultasi via WhatsApp
                        </a>
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

/* Custom pagination styling */
.pagination {
    display: flex;
    justify-content: center;
    list-style: none;
    padding: 0;
}

.pagination li {
    margin: 0 2px;
}

.pagination li a,
.pagination li span {
    display: block;
    padding: 8px 16px;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.3s;
}

.pagination li.active span {
    background-color: #3b82f6;
    color: white;
}

.pagination li:not(.active):not(.disabled) a {
    color: #4b5563;
    border: 1px solid #e5e7eb;
}

.pagination li:not(.active):not(.disabled) a:hover {
    background-color: #f3f4f6;
    border-color: #d1d5db;
}

.pagination li.disabled span {
    color: #9ca3af;
    cursor: not-allowed;
}
</style>
@endpush

@push('scripts')
<script>
// Form submission for sort
document.getElementById('sortForm').addEventListener('change', function(e) {
    if (e.target.name === 'sort') {
        // Get current URL parameters
        const url = new URL(window.location.href);
        url.searchParams.set('sort', e.target.value);
        window.location.href = url.toString();
    }
});
</script>
@endpush