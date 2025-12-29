@extends('layouts.app')

@section('title', $product->name . ' - Cipta Imaji')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="container mx-auto px-4">
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm text-gray-600">
                <li>
                    <a href="{{ route('home') }}" class="hover:text-blue-600">Beranda</a>
                </li>
                <li>
                    <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                </li>
                <li>
                    <a href="{{ route('products.index') }}" class="hover:text-blue-600">Produk</a>
                </li>
                <li>
                    <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                </li>
                <li class="font-semibold text-gray-800 truncate max-w-xs">
                    {{ $product->name }}
                </li>
            </ol>
        </nav>

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-8">
                <!-- Product Images -->
                <div>
                    <!-- Main Image -->
                    <div class="bg-gradient-to-br from-blue-50 to-gray-100 rounded-xl h-96 flex items-center justify-center mb-4">
                        <i class="fas fa-print text-blue-200 text-8xl"></i>
                    </div>
                    
                    <!-- Thumbnails (placeholder) -->
                    <div class="grid grid-cols-4 gap-3">
                        @for($i = 0; $i < 4; $i++)
                        <div class="bg-gray-100 rounded-lg h-20 flex items-center justify-center">
                            <i class="fas fa-image text-gray-300 text-xl"></i>
                        </div>
                        @endfor
                    </div>
                </div>

                <!-- Product Info -->
                <div>
                    <!-- Category & Badges -->
                    <div class="flex items-center gap-3 mb-4">
                        @if($product->category)
                            <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                {{ $product->category === 'instan' ? 'bg-blue-100 text-blue-600' : 'bg-purple-100 text-purple-600' }}">
                                {{ $product->category === 'instan' ? 'Produk Instan' : 'Produk Custom' }}
                            </span>
                        @endif
                        
                        @if($productCategory)
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-600">
                                {{ $productCategory->name }}
                            </span>
                        @endif
                        
                        @if($product->discount_percent > 0)
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-600">
                                -{{ $product->discount_percent }}% OFF
                            </span>
                        @endif
                    </div>

                    <!-- Product Name -->
                    <h1 class="text-3xl font-bold text-gray-800 mb-3">{{ $product->name }}</h1>
                    
                    <!-- Short Description -->
                    @if($product->short_description)
                        <p class="text-gray-600 text-lg mb-6">{{ $product->short_description }}</p>
                    @endif

                    <!-- Rating -->
                    <div class="flex items-center mb-6">
                        <div class="flex text-yellow-400 mr-2">
                            @php
                                $rating = $product->rating ?? 0;
                            @endphp
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($rating))
                                    <i class="fas fa-star"></i>
                                @elseif($i == ceil($rating) && $rating - floor($rating) >= 0.3)
                                    <i class="fas fa-star-half-alt"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                        </div>
                        <span class="text-gray-600 mr-4">{{ number_format($rating, 1) }} ({{ $product->sales_count ?? 0 }} terjual)</span>
                        <span class="text-green-600 font-semibold">
                            <i class="fas fa-check-circle mr-1"></i>
                            Stok: {{ $product->stock }}
                        </span>
                    </div>

                    <!-- Price -->
                    <div class="mb-8">
                        @if($product->discount_percent > 0)
                            @php
                                $discountedPrice = $product->price - ($product->price * $product->discount_percent / 100);
                            @endphp
                            <div class="flex items-center gap-4">
                                <span class="text-4xl font-bold text-red-600">
                                    Rp {{ number_format($discountedPrice, 0, ',', '.') }}
                                </span>
                                <span class="text-2xl text-gray-400 line-through">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                                <span class="text-lg font-semibold text-red-600">
                                    Hemat {{ number_format($product->price * $product->discount_percent / 100, 0, ',', '.') }}
                                </span>
                            </div>
                        @else
                            <span class="text-4xl font-bold text-blue-600">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                        @endif
                    </div>

                    <!-- Specifications -->
                    @if($product->specifications && !empty($product->specifications))
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Spesifikasi Produk</h3>
                            <div class="grid grid-cols-2 gap-3">
                                @php
                                    // Handle both array and JSON string
                                    $specs = is_array($product->specifications) 
                                        ? $product->specifications 
                                        : (is_string($product->specifications) ? json_decode($product->specifications, true) : []);
                                @endphp
                                
                                @if(is_array($specs) && count($specs) > 0)
                                    @foreach($specs as $key => $value)
                                        <div class="flex">
                                            <span class="font-medium text-gray-600 min-w-32">
                                                {{ ucfirst(str_replace('_', ' ', $key)) }}:
                                            </span>
                                            <span class="text-gray-800">{{ $value }}</span>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Order Form -->
                    <div class="bg-gray-50 rounded-xl p-6 mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Pesan Sekarang</h3>
                        
                        <!-- Quantity Selector -->
                        <div class="mb-6">
                            <label class="block text-gray-700 mb-2">Jumlah Pesanan</label>
                            <div class="flex items-center">
                                <button type="button" class="w-10 h-10 bg-gray-200 rounded-l-lg flex items-center justify-center hover:bg-gray-300">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" 
                                       id="quantity"
                                       value="{{ $product->min_order }}"
                                       min="{{ $product->min_order }}"
                                       class="w-16 h-10 text-center border-y border-gray-300">
                                <button type="button" class="w-10 h-10 bg-gray-200 rounded-r-lg flex items-center justify-center hover:bg-gray-300">
                                    <i class="fas fa-plus"></i>
                                </button>
                                <span class="ml-4 text-gray-600">Min. order: {{ $product->min_order }} pcs</span>
                            </div>
                        </div>

                        <!-- Total Price -->
                        <div class="mb-6 p-4 bg-white rounded-lg border border-gray-200">
                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-gray-700">Total:</span>
                                <span id="total-price" class="text-2xl font-bold text-blue-600">
                                    @if($product->discount_percent > 0)
                                        Rp {{ number_format(($product->price - ($product->price * $product->discount_percent / 100)) * $product->min_order, 0, ',', '.') }}
                                    @else
                                        Rp {{ number_format($product->price * $product->min_order, 0, ',', '.') }}
                                    @endif
                                </span>
                            </div>
                        </div>
<!-- Action Buttons -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <form action="{{ route('cart.add', $product->id) }}" method="POST" id="add-to-cart-form" class="w-full">
        @csrf
        <input type="hidden" name="quantity" id="form-quantity" value="{{ $product->min_order }}">
        <button type="submit" 
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg flex items-center justify-center transition-colors">
            <i class="fas fa-shopping-cart mr-3"></i>
            Tambah ke Keranjang
        </button>
    </form>
    
    <a href="{{ route('whatsapp.chat') }}" target="_blank"
       class="bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-6 rounded-lg flex items-center justify-center transition-colors">
        <i class="fab fa-whatsapp mr-3 text-xl"></i>
        Konsultasi via WA
    </a>
</div>

                    <!-- Additional Info -->
                    <div class="grid grid-cols-2 gap-4 text-sm text-gray-600">
                        <div class="flex items-center">
                            <i class="fas fa-shipping-fast text-blue-500 mr-2"></i>
                            <span>Gratis ongkir min. Rp 500.000</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-undo text-blue-500 mr-2"></i>
                            <span>Garansi kualitas 100%</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-clock text-blue-500 mr-2"></i>
                            <span>
                                @if($product->category === 'instan')
                                    Siap dalam 24 jam
                                @else
                                    Proses 3-7 hari
                                @endif
                            </span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-headset text-blue-500 mr-2"></i>
                            <span>Support 24/7 via WhatsApp</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description Tab -->
            <div class="border-t border-gray-200">
                <div class="p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Deskripsi Produk</h2>
                    <div class="prose max-w-none text-gray-700 whitespace-pre-line">
                        {{ $product->description }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->isNotEmpty())
            <div class="mt-12">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Produk Terkait</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $relatedProduct)
                        <x-ui.product-card :product="$relatedProduct" />
                    @endforeach
                </div>
            </div>
        @endif

        <!-- CTA Section -->
        <div class="mt-12 bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-2xl p-8 text-center">
            <h3 class="text-2xl font-bold mb-4">Butuh Produk Custom?</h3>
            <p class="text-lg mb-6 opacity-90 max-w-2xl mx-auto">
                Kami siap membantu mendesain produk sesuai kebutuhan spesifik Anda. 
                Konsultasi gratis dengan tim desainer kami.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('whatsapp.chat') }}" target="_blank"
                   class="bg-white text-blue-600 hover:bg-gray-100 font-semibold px-8 py-3 rounded-lg transition-colors">
                    <i class="fab fa-whatsapp mr-2"></i> Konsultasi Sekarang
                </a>
                <a href="{{ route('products.index') }}"
                   class="bg-transparent border-2 border-white text-white hover:bg-white hover:text-blue-600 font-semibold px-8 py-3 rounded-lg transition-colors">
                    <i class="fas fa-shopping-bag mr-2"></i> Lihat Produk Lainnya
                </a>
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
.whitespace-pre-line {
    white-space: pre-line;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Quantity selector functionality
    const minusBtn = document.querySelector('button:nth-of-type(1)');
    const plusBtn = document.querySelector('button:nth-of-type(2)');
    const quantityInput = document.getElementById('quantity');
    const formQuantityInput = document.getElementById('form-quantity');
    const totalPriceEl = document.getElementById('total-price');
    const addToCartForm = document.getElementById('add-to-cart-form');
    const addToCartBtn = addToCartForm?.querySelector('button[type="submit"]');
    
    // Product price data
    const unitPrice = {{ $product->discount_percent > 0 ? 
        $product->price - ($product->price * $product->discount_percent / 100) : 
        $product->price }};
    const minOrder = {{ $product->min_order }};
    
    // Format currency
    function formatCurrency(amount) {
        return 'Rp ' + amount.toLocaleString('id-ID');
    }
    
    // Update total price and form quantity
    function updateTotalPrice() {
        const quantity = parseInt(quantityInput.value);
        const total = unitPrice * quantity;
        totalPriceEl.textContent = formatCurrency(total);
        
        // Sync dengan form hidden input
        if (formQuantityInput) {
            formQuantityInput.value = quantity;
        }
    }
    
    // Minus button
    minusBtn?.addEventListener('click', function() {
        let current = parseInt(quantityInput.value);
        if (current > minOrder) {
            quantityInput.value = current - 1;
            updateTotalPrice();
        }
    });
    
    // Plus button
    plusBtn?.addEventListener('click', function() {
        let current = parseInt(quantityInput.value);
        quantityInput.value = current + 1;
        updateTotalPrice();
    });
    
    // Input change
    quantityInput?.addEventListener('change', function() {
        let value = parseInt(this.value);
        if (value < minOrder) {
            this.value = minOrder;
        }
        updateTotalPrice();
    });
    
    // Form submission
    addToCartForm?.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const quantity = parseInt(quantityInput.value);
        
        // Show loading state
        if (addToCartBtn) {
            const originalText = addToCartBtn.innerHTML;
            addToCartBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Menambahkan...';
            addToCartBtn.disabled = true;
        }
        
        // Submit form via AJAX atau langsung submit
        fetch(this.action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
            },
            body: new URLSearchParams(new FormData(this))
        })
        .then(response => {
            if (response.ok) {
                return response.json();
            }
            throw new Error('Network response was not ok.');
        })
        .then(data => {
            // Show success message
            showNotification(`✅ ${quantity} pcs "${@json($product->name)}" telah ditambahkan ke keranjang!`, 'success');
            
            // Update cart counter if exists
            updateCartCounter();
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('❌ Gagal menambahkan ke keranjang. Silakan coba lagi.', 'error');
        })
        .finally(() => {
            // Reset button
            if (addToCartBtn) {
                addToCartBtn.innerHTML = '<i class="fas fa-shopping-cart mr-3"></i> Tambah ke Keranjang';
                addToCartBtn.disabled = false;
            }
        });
    });
    
    // Notification function
    function showNotification(message, type = 'success') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg text-white font-semibold transform transition-transform duration-300 ${
            type === 'success' ? 'bg-green-500' : 'bg-red-500'
        }`;
        notification.innerHTML = `
            <div class="flex items-center">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} mr-3"></i>
                <span>${message}</span>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
    
    // Update cart counter (if you have one)
    function updateCartCounter() {
        const cartCounter = document.querySelector('.cart-counter');
        if (cartCounter) {
            const current = parseInt(cartCounter.textContent) || 0;
            cartCounter.textContent = current + 1;
            cartCounter.classList.remove('hidden');
        }
    }
    
    // Initialize total price
    updateTotalPrice();
});
</script>
@endpush