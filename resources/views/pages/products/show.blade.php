@extends('layouts.app')

@section('title', $product->name . ' - Cipta Imaji')

@section('content')
<div class="bg-[#f9f0f1] min-h-screen py-8">
    <div class="container mx-auto px-4">
        <!-- Breadcrumb Modern -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm">
                <li>
                    <a href="{{ route('home') }}" class="text-gray-500 hover:text-[#193497] transition-colors">
                        <i class="fas fa-home mr-1"></i> Beranda
                    </a>
                </li>
                <li><i class="fas fa-chevron-right text-gray-300 text-xs"></i></li>
                <li>
                    <a href="{{ route('products.index') }}" class="text-gray-500 hover:text-[#193497] transition-colors">Produk</a>
                </li>
                <li><i class="fas fa-chevron-right text-gray-300 text-xs"></i></li>
                <li class="font-semibold text-[#193497] truncate max-w-xs">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="bg-[#f9f0f1] rounded-3xl shadow-2xl overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">
                <!-- Product Images Section -->
                <div class="p-8 lg:p-12 bg-[#f9f0f1]">
                    <!-- Main Image -->
                    <div class="bg-[#f9f0f1] rounded-3xl h-[450px] flex items-center justify-center mb-6 relative overflow-hidden group">
                        <div class=""></div>
                        <i class="fas fa-print text-blue-200 text-9xl relative z-10 group-hover:scale-110 transition-transform duration-500"></i>
                        
                        <!-- Badges -->
                        <div class="absolute top-4 left-4 flex flex-col gap-2">
                            @if($product->discount_percent > 0)
                                <span class="bg-[#f91f01] text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg">
                                    -{{ $product->discount_percent }}% OFF
                                </span>
                            @endif
                            @if($product->category === 'instan')
                                <span class="bg-[#193497] text-[#f9f0f1] border border-[#f9f0f1] px-4 py-2 rounded-full text-sm font-bold shadow-lg">
                                    <i class="fas fa-bolt mr-1"></i> Instan
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Thumbnails -->
                    <div class="grid grid-cols-4 gap-3">
                        @for($i = 0; $i < 4; $i++)
                        <div class="bg-[#f9f0f1] rounded-2xl h-24 flex items-center justify-center cursor-pointer hover:ring-4 ring-[#193497] transition-all duration-300 group">
                            <i class="fas fa-image text-gray-300 text-2xl group-hover:text-blue-500 transition-colors"></i>
                        </div>
                        @endfor
                    </div>

                    <!-- Share & Wishlist -->
                    <div class="flex gap-3 mt-6">
                        <button class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 py-3 rounded-full font-semibold transition-all duration-300 flex items-center justify-center">
                            <i class="fas fa-heart mr-2"></i> Wishlist
                        </button>
                        <button class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 py-3 rounded-full font-semibold transition-all duration-300 flex items-center justify-center">
                            <i class="fas fa-share-alt mr-2"></i> Bagikan
                        </button>
                    </div>
                </div>

                <!-- Product Info Section -->
                <div class="p-8 lg:p-12">
                    <!-- Category Badges -->
                    <div class="flex flex-wrap items-center gap-2 mb-4">
                        @if($product->category)
                            <span class="px-4 py-2 text-xs font-bold rounded-full {{ $product->category === 'instan' ? 'bg-blue-100 text-[#193497]' : 'bg-purple-100 text-purple-600' }}">
                                {{ $product->category === 'instan' ? 'PRODUK INSTAN' : 'PRODUK CUSTOM' }}
                            </span>
                        @endif
                        
                        @if($productCategory)
                            <span class="px-4 py-2 text-xs font-bold rounded-full bg-gray-100 text-gray-700">
                                {{ strtoupper($productCategory->name) }}
                            </span>
                        @endif
                    </div>

                    <!-- Product Name -->
                    <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4 leading-tight">
                        {{ $product->name }}
                    </h1>
                    
                    <!-- Short Description -->
                    @if($product->short_description)
                        <p class="text-gray-600 text-lg mb-6 leading-relaxed">{{ $product->short_description }}</p>
                    @endif

                    <!-- Rating & Sales -->
                    <div class="flex items-center gap-6 mb-8 pb-8 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="flex text-[#d2f801] drop-shadow-[0_0_1px_#193497] drop-shadow-[0_0_1px_#193497] drop-shadow-[0_0_1px_#193497] mr-2">
                                @php $rating = $product->rating ?? 4.5; @endphp
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= floor($rating) ? '' : 'text-gray-300' }}"></i>
                                @endfor
                            </div>
                            <span class="text-gray-700 font-semibold">{{ number_format($rating, 1) }}</span>
                        </div>
                        
                        <div class="h-6 w-px bg-gray-300"></div>
                        
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-shopping-bag mr-2"></i>
                            <span><strong>{{ $product->sales_count ?? 127 }}</strong> Terjual</span>
                        </div>
                        
                        <div class="h-6 w-px bg-gray-300"></div>
                        
                        <div class="flex items-center">
                            <div class="w-3 h-3 hover:bg-[#193497] rounded-full mr-2 animate-pulse"></div>
                            <span class="text-[#d2f801] drop-shadow-[0_0_1px_#193497] drop-shadow-[0_0_1px_#193497] font-semibold">Stok: {{ $product->stock }}</span>
                        </div>
                    </div>

                    <!-- Price Section -->
                    <div class="mb-8">
                        @if($product->discount_percent > 0)
                            @php
                                $discountedPrice = $product->price - ($product->price * $product->discount_percent / 100);
                            @endphp
                            <div class="flex items-end gap-4 mb-3">
                                <span class="text-5xl font-bold text-red-600">
                                    Rp {{ number_format($discountedPrice, 0, ',', '.') }}
                                </span>
                                <span class="text-2xl text-gray-400 line-through mb-1">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                            </div>
                            <div class="inline-flex items-center bg-red-100 text-red-600 px-4 py-2 rounded-full">
                                <i class="fas fa-tag mr-2"></i>
                                <span class="font-bold">Hemat Rp {{ number_format($product->price * $product->discount_percent / 100, 0, ',', '.') }}</span>
                            </div>
                        @else
                            <span class="text-5xl font-bold text-[#193497]">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                        @endif
                    </div>

                    <!-- Specifications -->
                    @if($product->specifications && !empty($product->specifications))
                        <div class="mb-8 bg-gradient-to-r from-blue-50 to-purple-50 rounded-2xl p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-info-circle text-[#193497] mr-2"></i>
                                Spesifikasi Produk
                            </h3>
                            <div class="space-y-3">
                                @php
                                    $specs = is_array($product->specifications) 
                                        ? $product->specifications 
                                        : (is_string($product->specifications) ? json_decode($product->specifications, true) : []);
                                @endphp
                                
                                @if(is_array($specs) && count($specs) > 0)
                                    @foreach($specs as $key => $value)
                                        <div class="flex items-center">
                                            <span class="font-semibold text-gray-700 min-w-[140px]">
                                                {{ ucfirst(str_replace('_', ' ', $key)) }}
                                            </span>
                                            <span class="text-gray-600">: {{ $value }}</span>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Order Form -->
                    <div class="bg-[#f9f0f1] rounded-2xl p-6 mb-8 border-2 border-gray-200">
                        <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                            <i class="fas fa-shopping-cart text-[#193497] mr-2"></i>
                            Atur Pesanan
                        </h3>
                        
                        <!-- Quantity Selector -->
                        <div class="mb-6">
                            <label class="block text-gray-700 font-semibold mb-3">Jumlah</label>
                            <div class="flex items-center gap-4">
                                <div class="flex items-center bg-[#f9f0f1] rounded-xl border-2 border-gray-200 overflow-hidden">
                                    <button type="button"
    class="qty-minus w-12 h-12 bg-gray-100 hover:bg-[#193497] hover:text-white flex items-center justify-center transition-colors">
    <i class="fas fa-minus"></i>
</button>

<input type="number"
    id="quantity"
    value="{{ $product->min_order }}"
    min="{{ $product->min_order }}"
    class="w-20 h-12 text-center border-none font-bold text-xl focus:outline-none">

<button type="button"
    class="qty-plus w-12 h-12 bg-gray-100 hover:bg-[#193497] hover:text-white flex items-center justify-center transition-colors">
    <i class="fas fa-plus"></i>
</button>

                                </div>
                                <span class="text-gray-600">Min. order: <strong>{{ $product->min_order }} pcs</strong></span>
                            </div>
                        </div>

                        <!-- Total Price Display -->
                        <div class="bg-[#193497] rounded-2xl p-6 text-white mb-6">
                            <div class="flex justify-between items-center">
                                <div>
                                    <div class="text-sm opacity-90 mb-1">Total Harga</div>
                                    <div id="total-price" class="text-3xl font-bold">
                                        @if($product->discount_percent > 0)
                                            Rp {{ number_format(($product->price - ($product->price * $product->discount_percent / 100)) * $product->min_order, 0, ',', '.') }}
                                        @else
                                            Rp {{ number_format($product->price * $product->min_order, 0, ',', '.') }}
                                        @endif
                                    </div>
                                </div>
                                <i class="fas fa-calculator text-5xl opacity-20"></i>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="grid grid-cols-1 gap-4">
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" id="add-to-cart-form" class="w-full">
                                @csrf
                                <input type="hidden" name="quantity" id="form-quantity" value="{{ $product->min_order }}">
                                <button type="submit" 
                                        class="w-full bg-gradient-to-r from-[#193497] to-[#142a7a] hover:from-blue-700 hover:to-blue-800 text-white font-bold py-4 px-6 rounded-xl flex items-center justify-center transition-all duration-300 shadow-lg hover:shadow-2xl transform hover:scale-[1.02]">
                                    <i class="fas fa-shopping-cart mr-3 text-xl"></i>
                                    <span class="text-lg">Tambah ke Keranjang</span>
                                </button>
                            </form>
                            
                            <button onclick="buyNow()" 
                                    class="w-full bg-[#193497] hover:bg-[#193497] text-white font-bold py-4 px-6 rounded-xl flex items-center justify-center transition-all duration-300 shadow-lg hover:shadow-2xl transform hover:scale-[1.02]">
                                <i class="fas fa-bolt mr-3 text-xl"></i>
                                <span class="text-lg">Beli Sekarang</span>
                            </button>
                            
                            <a href="{{ route('whatsapp.chat') }}" target="_blank"
                               class="w-full bg-[#193497] hover:bg-[#193497] text-white font-bold py-4 px-6 rounded-xl flex items-center justify-center transition-all duration-300 shadow-lg hover:shadow-2xl transform hover:scale-[1.02]">
                                <i class="fab fa-whatsapp mr-3 text-2xl"></i>
                                <span class="text-lg">Konsultasi via WhatsApp</span>
                            </a>
                        </div>
                    </div>

                    <!-- Features Grid -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-blue-50 rounded-xl p-4 flex items-center">
                            <div class="w-12 h-12 bg-[#193497] rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-shipping-fast text-white text-xl"></i>
                            </div>
                            <div>
                                <div class="text-xs text-gray-600">Pengiriman</div>
                                <div class="font-bold text-gray-800 text-sm">Gratis Ongkir*</div>
                            </div>
                        </div>
                        
                        <div class="bg-green-50 rounded-xl p-4 flex items-center">
                            <div class="w-12 h-12 bg-[#193497] rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-shield-alt text-white text-xl"></i>
                            </div>
                            <div>
                                <div class="text-xs text-gray-600">Garansi</div>
                                <div class="font-bold text-gray-800 text-sm">100% Original</div>
                            </div>
                        </div>
                        
                        <div class="bg-purple-50 rounded-xl p-4 flex items-center">
                            <div class="w-12 h-12 bg-purple-600 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-clock text-white text-xl"></i>
                            </div>
                            <div>
                                <div class="text-xs text-gray-600">Waktu</div>
                                <div class="font-bold text-gray-800 text-sm">
                                    @if($product->category === 'instan')
                                        24 Jam
                                    @else
                                        3-7 Hari
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-orange-50 rounded-xl p-4 flex items-center">
                            <div class="w-12 h-12 bg-orange-600 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-headset text-white text-xl"></i>
                            </div>
                            <div>
                                <div class="text-xs text-gray-600">Support</div>
                                <div class="font-bold text-gray-800 text-sm">24/7 Online</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs Section -->
            <div class="border-t border-gray-200">
                <div class="flex border-b border-gray-200">
                    <button class="tab-button active px-8 py-4 font-bold text-[#193497] border-b-4 border-[#193497] transition-colors" data-tab="description">
                        Deskripsi
                    </button>
                    <button class="tab-button px-8 py-4 font-bold text-gray-600 hover:text-[#193497] transition-colors" data-tab="reviews">
                        Ulasan ({{ rand(10, 50) }})
                    </button>
                    <button class="tab-button px-8 py-4 font-bold text-gray-600 hover:text-[#193497] transition-colors" data-tab="shipping">
                        Pengiriman
                    </button>
                </div>

                <!-- Tab Content -->
                <div class="p-8 lg:p-12">
                    <!-- Description Tab -->
                    <div id="description-tab" class="tab-content">
                        <h2 class="text-3xl font-bold text-gray-800 mb-6">Deskripsi Produk</h2>
                        <div class="prose max-w-none text-gray-700 text-lg leading-relaxed whitespace-pre-line">
                            {{ $product->description }}
                        </div>
                    </div>

                    <!-- Reviews Tab -->
                    <div id="reviews-tab" class="tab-content hidden">
                        <h2 class="text-3xl font-bold text-gray-800 mb-6">Ulasan Pelanggan</h2>
                        <div class="space-y-6">
                            @for($i = 0; $i < 3; $i++)
                            <div class="bg-gray-50 rounded-2xl p-6">
                                <div class="flex items-center mb-4">
                                    <div class="w-12 h-12 bg-[#193497] rounded-full flex items-center justify-center text-white font-bold mr-4">
                                        {{ chr(65 + $i) }}
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-800">Pelanggan {{ $i + 1 }}</h4>
                                        <div class="flex text-[#d2f801] drop-shadow-[0_0_1px_#193497] drop-shadow-[0_0_1px_#193497] drop-shadow-[0_0_1px_#193497] text-sm">
                                            @for($j = 0; $j < 5; $j++)
                                            <i class="fas fa-star"></i>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                                <p class="text-gray-700">Produk sangat bagus, kualitas cetakan tajam dan warna sesuai dengan ekspektasi. Pengiriman cepat dan packing rapi. Recommended!</p>
                            </div>
                            @endfor
                        </div>
                    </div>

                    <!-- Shipping Tab -->
                    <div id="shipping-tab" class="tab-content hidden">
                        <h2 class="text-3xl font-bold text-gray-800 mb-6">Informasi Pengiriman</h2>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="bg-blue-50 rounded-2xl p-6">
                                <h3 class="font-bold text-xl mb-4">Gratis Ongkir</h3>
                                <p class="text-gray-700 mb-4">Untuk pembelian minimal Rp 500.000 ke seluruh area Jabodetabek</p>
                                <ul class="space-y-2 text-gray-600">
                                    <li><i class="fas fa-check text-[#d2f801] drop-shadow-[0_0_1px_#193497] mr-2"></i> Jakarta</li>
                                    <li><i class="fas fa-check text-[#d2f801] drop-shadow-[0_0_1px_#193497] mr-2"></i> Bogor</li>
                                    <li><i class="fas fa-check text-[#d2f801] drop-shadow-[0_0_1px_#193497] mr-2"></i> Depok</li>
                                    <li><i class="fas fa-check text-[#d2f801] drop-shadow-[0_0_1px_#193497] mr-2"></i> Tangerang</li>
                                    <li><i class="fas fa-check text-[#d2f801] drop-shadow-[0_0_1px_#193497] mr-2"></i> Bekasi</li>
                                </ul>
                            </div>
                            
                            <div class="bg-purple-50 rounded-2xl p-6">
                                <h3 class="font-bold text-xl mb-4">Estimasi Pengiriman</h3>
                                <ul class="space-y-3">
                                    <li class="flex items-center">
                                        <i class="fas fa-shipping-fast text-purple-600 mr-3"></i>
                                        <span class="text-gray-700"><strong>Same Day:</strong> Order sebelum 12:00</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-truck text-purple-600 mr-3"></i>
                                        <span class="text-gray-700"><strong>Next Day:</strong> 1-2 hari kerja</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-box text-purple-600 mr-3"></i>
                                        <span class="text-gray-700"><strong>Regular:</strong> 2-3 hari kerja</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->isNotEmpty())
            <div class="mt-16">
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-800">Produk Terkait</h2>
                        <p class="text-gray-600 mt-2">Pelanggan juga melihat produk ini</p>
                    </div>
                    <a href="{{ route('products.index') }}" class="text-[#193497] hover:text-blue-800 font-semibold flex items-center">
                        Lihat Semua <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $relatedProduct)
                        <x-ui.product-card :product="$relatedProduct" />
                    @endforeach
                </div>
            </div>
        @endif

        <!-- CTA Banner -->
        <div class="mt-16 bg-[#193497] text-white rounded-3xl p-12 text-center relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-yellow-400 rounded-full opacity-10 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-purple-500 rounded-full opacity-10 blur-3xl"></div>
            
            <div class="relative z-10">
                <h3 class="text-4xl font-bold mb-4">Butuh Desain Custom?</h3>
                <p class="text-xl mb-8 opacity-90 max-w-2xl mx-auto">
                    Tim desainer profesional kami siap membantu mewujudkan ide kreatif Anda
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('whatsapp.chat') }}" target="_blank"
                       class="bg-yellow-400 hover:bg-yellow-300 text-blue-900 font-bold px-8 py-4 rounded-full transition-all duration-300 shadow-xl hover:shadow-2xl flex items-center justify-center">
                        <i class="fab fa-whatsapp mr-3 text-xl"></i> Konsultasi Gratis
                    </a>
                    <a href="{{ route('products.index') }}"
                       class="bg-[#f9f0f1]/10 hover:bg-[#f9f0f1]/20 backdrop-blur-sm border-2 border-white text-white font-bold px-8 py-4 rounded-full transition-all duration-300 flex items-center justify-center">
                        <i class="fas fa-th mr-3"></i> Lihat Katalog
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.prose {
    line-height: 1.8;
}
.prose p {
    margin-bottom: 1rem;
}
.tab-button.active {
    color: #2563eb;
    border-bottom-color: #2563eb;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const minusBtn = document.querySelector('.qty-minus');
    const plusBtn  = document.querySelector('.qty-plus');
    const qtyInput = document.getElementById('quantity');
    const formQty  = document.getElementById('form-quantity');
    const totalEl  = document.getElementById('total-price');

    const unitPrice = {{ $product->discount_percent > 0
        ? $product->price - ($product->price * $product->discount_percent / 100)
        : $product->price }};
    const minOrder = {{ $product->min_order }};

    function formatRupiah(val) {
        return 'Rp ' + val.toLocaleString('id-ID');
    }

    function updateTotal() {
        let qty = parseInt(qtyInput.value);
        if (qty < minOrder) qty = minOrder;

        qtyInput.value = qty;
        formQty.value = qty;
        totalEl.textContent = formatRupiah(unitPrice * qty);
    }

    minusBtn.addEventListener('click', () => {
        let qty = parseInt(qtyInput.value);
        if (qty > minOrder) {
            qtyInput.value = qty - 1;
            updateTotal();
        }
    });

    plusBtn.addEventListener('click', () => {
        qtyInput.value = parseInt(qtyInput.value) + 1;
        updateTotal();
    });

    qtyInput.addEventListener('change', updateTotal);

    updateTotal();
});

function buyNow() {
    const qty = document.getElementById('quantity').value;
    window.location.href = "{{ route('cart.checkout') }}?quantity=" + qty;
}
</script>
@endpush
