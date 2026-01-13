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
                
                <!-- Search Box -->
                <form action="{{ route('products.index') }}" method="GET" class="max-w-3xl">
                    <div class="relative">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Cari produk: brosur, banner, kartu nama..."
                               class="w-full px-6 py-5 pr-16 rounded-2xl bg-[#f9f0f1] text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-yellow-400/50 shadow-2xl text-lg">
                        <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-[#d2f801] hover:bg-yellow-300 text-blue-900 p-4 rounded-xl transition-colors shadow-lg">
                            <i class="fas fa-search text-xl"></i>
                        </button>
                    </div>
                </form>

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
                    <!-- Categories -->
                    <div class="mb-8">
                        <h3 class="font-bold text-xl mb-6 text-gray-800 flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-br bg-[#193497] rounded-xl flex items-center justify-center mr-3">
                                <i class="fas fa-tags text-white"></i>
                            </div>
                            Kategori
                        </h3>
                        <div class="space-y-2">
                            <a href="{{ route('products.index') }}" 
                               class="group flex items-center px-4 py-3 rounded-xl transition-all duration-300 {{ !request('category') ? 'bg-[#193497] text-white shadow-lg' : 'text-gray-600 hover:bg-gray-50' }}">
                                <i class="fas fa-th-large mr-3 {{ !request('category') ? 'text-[#d2f801]' : 'text-[#193497]' }}"></i>
                                <span class="font-semibold">Semua Produk</span>
                                @if(!request('category'))
                                <i class="fas fa-check ml-auto"></i>
                                @endif
                            </a>
                            
                            @if($instantCategories->isNotEmpty())
                            <div class="mt-6">
                                <h4 class="font-bold text-gray-700 mb-3 text-sm uppercase tracking-wider flex items-center">
                                    <div class="w-2 h-2 bg-blue-500 rounded-full mr-2"></div>
                                    Produk Instan
                                </h4>
                                <div class="space-y-1 pl-2">
                                    @foreach($instantCategories as $category)
                                    <a href="{{ route('products.index', ['category' => $category->slug]) }}"
                                       class="group flex items-center px-4 py-3 rounded-xl transition-all duration-300 {{ request('category') == $category->slug ? 'bg-blue-50 text-[#193497] font-semibold border-2 border-[#193497]/30' : 'text-gray-600 hover:bg-gray-50' }}">
                                        <i class="fas fa-rocket mr-3 text-[#193497]"></i>
                                        <span>{{ $category->name }}</span>
                                    </a>
                                    @endforeach
                                    <a href="{{ route('products.index', ['category' => 'instan']) }}"
                                       class="group flex items-center px-4 py-3 rounded-xl transition-all duration-300 {{ request('category') == 'instan' ? 'bg-blue-50 text-[#193497] font-semibold border-2 border-[#193497]/30' : 'text-gray-600 hover:bg-gray-50' }}">
                                        <i class="fas fa-bolt mr-3 text-[#193497]"></i>
                                        <span>Lihat Semua Instan</span>
                                    </a>
                                </div>
                            </div>
                            @endif
                            
                            @if($customCategories->isNotEmpty())
                            <div class="mt-6">
                                <h4 class="font-bold text-gray-700 mb-3 text-sm uppercase tracking-wider flex items-center">
                                    <div class="w-2 h-2 bg-[#7209b7] rounded-full mr-2"></div>
                                    Produk Custom
                                </h4>
                                <div class="space-y-1 pl-2">
                                    @foreach($customCategories as $category)
                                    <a href="{{ route('products.index', ['category' => $category->slug]) }}"
                                       class="group flex items-center px-4 py-3 rounded-xl transition-all duration-300 {{ request('category') == $category->slug ? 'bg-purple-50 text-[#7209b7] font-semibold border-2 border-purple-200' : 'text-gray-600 hover:bg-gray-50' }}">
                                        <i class="fas fa-paint-brush mr-3 text-[#7209b7]"></i>
                                        <span>{{ $category->name }}</span>
                                    </a>
                                    @endforeach
                                    <a href="{{ route('products.index', ['category' => 'non-instan']) }}"
                                       class="group flex items-center px-4 py-3 rounded-xl transition-all duration-300 {{ request('category') == 'non-instan' ? 'bg-purple-50 text-[#7209b7] font-semibold border-2 border-purple-200' : 'text-gray-600 hover:bg-gray-50' }}">
                                        <i class="fas fa-gem mr-3 text-[#7209b7]"></i>
                                        <span>Lihat Semua Custom</span>
                                    </a>
                                </div>
                            </div>
                            @endif
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
                        <form id="sortForm">
                            <div class="space-y-2">
                                <label class="flex items-center px-4 py-3 rounded-xl cursor-pointer transition-all duration-300 {{ $selectedSort == 'latest' ? 'bg-[#193497]/10 border-2 border-[#193497]/30' : 'hover:bg-gray-50' }}">
                                    <input type="radio" name="sort" value="latest" 
                                           {{ $selectedSort == 'latest' ? 'checked' : '' }}
                                           onchange="this.form.submit()"
                                           class="mr-3 w-5 h-5">
                                    <span class="font-medium {{ $selectedSort == 'latest' ? 'text-[#193497]' : 'text-gray-700' }}">Terbaru</span>
                                </label>
                                <label class="flex items-center px-4 py-3 rounded-xl cursor-pointer transition-all duration-300 {{ $selectedSort == 'popular' ? 'bg-[#193497]/10 border-2 border-[#193497]/30' : 'hover:bg-gray-50' }}">
                                    <input type="radio" name="sort" value="popular" 
                                           {{ $selectedSort == 'popular' ? 'checked' : '' }}
                                           onchange="this.form.submit()"
                                           class="mr-3 w-5 h-5">
                                    <span class="font-medium {{ $selectedSort == 'popular' ? 'text-[#193497]' : 'text-gray-700' }}">Terlaris</span>
                                </label>
                                <label class="flex items-center px-4 py-3 rounded-xl cursor-pointer transition-all duration-300 {{ $selectedSort == 'price_asc' ? 'bg-[#193497]/10 border-2 border-[#193497]/30' : 'hover:bg-gray-50' }}">
                                    <input type="radio" name="sort" value="price_asc" 
                                           {{ $selectedSort == 'price_asc' ? 'checked' : '' }}
                                           onchange="this.form.submit()"
                                           class="mr-3 w-5 h-5">
                                    <span class="font-medium {{ $selectedSort == 'price_asc' ? 'text-[#193497]' : 'text-gray-700' }}">Harga Terendah</span>
                                </label>
                                <label class="flex items-center px-4 py-3 rounded-xl cursor-pointer transition-all duration-300 {{ $selectedSort == 'price_desc' ? 'bg-[#193497]/10 border-2 border-[#193497]/30' : 'hover:bg-gray-50' }}">
                                    <input type="radio" name="sort" value="price_desc" 
                                           {{ $selectedSort == 'price_desc' ? 'checked' : '' }}
                                           onchange="this.form.submit()"
                                           class="mr-3 w-5 h-5">
                                    <span class="font-medium {{ $selectedSort == 'price_desc' ? 'text-[#193497]' : 'text-gray-700' }}">Harga Tertinggi</span>
                                </label>
                                <label class="flex items-center px-4 py-3 rounded-xl cursor-pointer transition-all duration-300 {{ $selectedSort == 'discount' ? 'bg-[#193497]/10 border-2 border-[#193497]/30' : 'hover:bg-gray-50' }}">
                                    <input type="radio" name="sort" value="discount" 
                                           {{ $selectedSort == 'discount' ? 'checked' : '' }}
                                           onchange="this.form.submit()"
                                           class="mr-3 w-5 h-5">
                                    <span class="font-medium {{ $selectedSort == 'discount' ? 'text-[#193497]' : 'text-gray-700' }}">Diskon Terbesar</span>
                                </label>
                            </div>
                        </form>
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
                            <h2 class="text-3xl font-bold text-gray-800 mb-2">
                                @if(request('search'))
                                    <i class="fas fa-search text-[#193497] mr-2"></i>
                                    "{{ request('search') }}"
                                @elseif(request('category'))
                                    @if($selectedCategory == 'instan')
                                        <i class="fas fa-bolt text-[#193497] mr-2"></i>
                                        Produk Instan
                                    @elseif($selectedCategory == 'non-instan')
                                        <i class="fas fa-gem text-[#7209b7] mr-2"></i>
                                        Produk Custom
                                    @else
                                        <i class="fas fa-tag text-[#193497] mr-2"></i>
                                        {{ $categories->flatten()->where('slug', request('category'))->first()->name ?? '' }}
                                    @endif
                                @else
                                    <i class="fas fa-th-large text-[#193497] mr-2"></i>
                                    Semua Produk
                                @endif
                            </h2>
                            <p class="text-gray-600 flex items-center">
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

                <!-- Products Grid -->
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
                            <a href="{{ route('products.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold transition-colors">
                                <i class="fas fa-th-large mr-2"></i> Lihat Semua Produk
                            </a>
                            <a href="{{ route('whatsapp.chat') }}" target="_blank" class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-xl font-semibold transition-colors">
                                <i class="fab fa-whatsapp mr-2"></i> Konsultasi
                            </a>
                        </div>
                    </div>
                @endif

                <!-- Pagination -->
                @if($products->hasPages())
                <div class="mt-12">
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
</style>
@endpush

@push('scripts')
<script>
// Form submission for sort
document.getElementById('sortForm').addEventListener('change', function(e) {
    if (e.target.name === 'sort') {
        const url = new URL(window.location.href);
        url.searchParams.set('sort', e.target.value);
        window.location.href = url.toString();
    }
});
</script>
@endpush