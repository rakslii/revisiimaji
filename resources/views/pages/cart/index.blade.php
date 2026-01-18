@extends('layouts.app')

@section('title', 'Keranjang Belanja - Cipta Imaji')

@section('content')
<div class="bg-[#f9f0f1] min-h-screen">
    <!-- Hero Section -->
    <div class="relative bg-[#193497] text-[#f9f0f1] overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-[#d2f801] rounded-full opacity-10 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-[#7209b7] rounded-full opacity-10 blur-3xl"></div>

        <div class="container mx-auto px-4 py-8 md:py-12 relative z-10">
            <div class="max-w-4xl">
                <nav class="flex items-center space-x-2 text-sm mb-6">
                    <a href="{{ route('home') }}" class="text-blue-200 hover:text-white transition-colors">
                        <i class="fas fa-home"></i> Beranda
                    </a>
                    <i class="fas fa-chevron-right text-blue-300 text-xs"></i>
                    <span class="text-[#d2f801] font-semibold">Keranjang Belanja</span>
                </nav>

                <h1 class="text-3xl md:text-5xl font-bold mb-3 leading-tight">
                    <i class="fas fa-shopping-cart text-[#d2f801] mr-3"></i>
                    Keranjang <span class="text-[#d2f801]">Belanja</span>
                </h1>
                <p class="text-lg md:text-xl opacity-90">
                    Review produk yang ingin Anda beli
                </p>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8 md:py-12">
        @if(session('success'))
        <div class="mb-6 bg-green-50 border-2 border-green-200 rounded-xl p-6">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 text-2xl mr-4"></i>
                <span class="text-green-700 font-semibold">{{ session('success') }}</span>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-6 bg-red-50 border-2 border-red-200 rounded-xl p-6">
            <div class="flex items-start">
                <i class="fas fa-exclamation-circle text-red-500 text-2xl mr-4 mt-1"></i>
                <div class="flex-1">
                    <span class="text-red-700 font-semibold">{{ session('error') }}</span>
                    @if(session('unavailable'))
                    <ul class="mt-2 space-y-1 text-sm text-red-600">
                        @foreach(session('unavailable') as $message)
                        <li class="ml-4 list-disc">{{ $message }}</li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>
        </div>
        @endif

        @if(empty($cartItems))
        <!-- Empty Cart -->
        <div class="bg-white rounded-3xl shadow-xl p-8 md:p-12 text-center border border-gray-100">
            <div class="w-24 h-24 bg-blue-50 border-2 border-[#193497] rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-shopping-cart text-[#193497] text-4xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-3">Keranjang Anda Kosong</h3>
            <p class="text-gray-600 max-w-md mx-auto mb-8 text-lg">
                Tambahkan produk yang Anda sukai ke keranjang untuk memulai belanja.
            </p>
            <a href="{{ route('products.index') }}" 
               class="inline-flex items-center px-8 py-4 bg-[#193497] hover:bg-[#0f2354] text-white font-bold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                <i class="fas fa-store mr-3 text-xl"></i>
                Mulai Belanja
            </a>
        </div>
        @else
        <!-- Cart with Items -->
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Cart Items -->
            <div class="lg:w-2/3">
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                    <div class="p-6 md:p-8 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-br from-[#193497] to-[#0f2354] rounded-xl flex items-center justify-center mr-4">
                                <i class="fas fa-box-open text-white text-xl"></i>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">Produk di Keranjang</h2>
                                <p class="text-gray-600 text-sm mt-1">{{ count($cartItems) }} produk</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="divide-y divide-gray-100">
                        @foreach($cartItems as $cartItem)
                        <div class="p-6 md:p-8 hover:bg-gray-50 transition-colors">
                            <div class="flex flex-col sm:flex-row gap-6">
                                <!-- Product Image -->
                                <div class="flex-shrink-0">
                                    <img src="{{ $cartItem['product']->getFirstMediaUrl('products') ?: asset('images/default-product.png') }}" 
                                         alt="{{ $cartItem['product']->name }}"
                                         class="w-32 h-32 object-cover rounded-2xl shadow-md">
                                </div>
                                
                                <!-- Product Info -->
                                <div class="flex-1">
                                    <div class="flex flex-col sm:flex-row justify-between gap-4">
                                        <div class="flex-1">
                                            <h4 class="font-bold text-gray-900 text-lg mb-2">{{ $cartItem['product']->name }}</h4>
                                            <div class="inline-block px-3 py-1 bg-blue-100 text-[#193497] rounded-lg text-sm font-semibold mb-3">
                                                <i class="fas fa-tag mr-1"></i>
                                                {{ $cartItem['product']->category->name ?? 'Uncategorized' }}
                                            </div>
                                            
                                            @if(!$cartItem['available'])
                                            <div class="mt-3 flex items-center bg-red-50 text-red-600 px-4 py-2 rounded-lg text-sm font-semibold">
                                                <i class="fas fa-exclamation-circle mr-2"></i>
                                                {{ $cartItem['message'] }}
                                            </div>
                                            @endif
                                        </div>
                                        
                                        <div class="text-right">
                                            <p class="font-bold text-gray-900 text-xl mb-1">{{ $cartItem['item']->formatted_price }}</p>
                                            @if($cartItem['product']->price != $cartItem['item']->price)
                                            <p class="text-sm text-gray-500 line-through">Rp {{ number_format($cartItem['product']->price, 0, ',', '.') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Quantity Controls -->
                                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mt-6 gap-4">
                                        <div class="flex items-center gap-4">
                                            <form action="{{ route('cart.update', $cartItem['item']->id) }}" method="POST" class="flex items-center">
                                                @csrf
                                                <button type="button" 
                                                        onclick="updateQuantity({{ $cartItem['item']->id }}, -1)"
                                                        class="w-10 h-10 flex items-center justify-center border-2 border-gray-300 rounded-l-xl hover:bg-gray-100 transition-colors">
                                                    <i class="fas fa-minus text-gray-700"></i>
                                                </button>
                                                
                                                <input type="number" 
                                                       id="quantity-{{ $cartItem['item']->id }}"
                                                       name="quantity"
                                                       value="{{ $cartItem['quantity'] }}"
                                                       min="1"
                                                       max="{{ $cartItem['product']->stock }}"
                                                       class="w-16 h-10 text-center border-t-2 border-b-2 border-gray-300 focus:outline-none font-semibold text-gray-900"
                                                       onchange="submitQuantity({{ $cartItem['item']->id }})">
                                                
                                                <button type="button" 
                                                        onclick="updateQuantity({{ $cartItem['item']->id }}, 1)"
                                                        class="w-10 h-10 flex items-center justify-center border-2 border-gray-300 rounded-r-xl hover:bg-gray-100 transition-colors">
                                                    <i class="fas fa-plus text-gray-700"></i>
                                                </button>
                                            </form>
                                            
                                            <div class="flex items-center bg-gray-100 px-3 py-2 rounded-lg">
                                                <i class="fas fa-warehouse text-gray-700 mr-2"></i>
                                                <span class="text-sm text-gray-700 font-semibold">
                                                    Stok: {{ $cartItem['product']->stock }}
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center gap-4">
                                            <p id="total-{{ $cartItem['item']->id }}" class="font-bold text-gray-900 text-xl">
                                                {{ 'Rp ' . number_format($cartItem['total'], 0, ',', '.') }}
                                            </p>
                                            
                                            <form action="{{ route('cart.remove', $cartItem['item']->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="w-10 h-10 flex items-center justify-center bg-red-50 hover:bg-red-100 text-red-500 hover:text-red-700 rounded-xl transition-all">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Cart Actions -->
                    <div class="p-6 md:p-8 border-t border-gray-200 flex flex-col sm:flex-row justify-between gap-4">
                        <a href="{{ route('products.index') }}" 
                           class="px-6 py-3 border-2 border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-all inline-flex items-center justify-center">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Lanjutkan Belanja
                        </a>
                        
                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    onclick="return confirm('Kosongkan seluruh keranjang?')"
                                    class="px-6 py-3 border-2 border-red-500 text-red-500 font-bold rounded-xl hover:bg-red-50 transition-all inline-flex items-center">
                                <i class="fas fa-trash mr-2"></i>
                                Kosongkan Keranjang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Order Summary -->
            <div class="lg:w-1/3">
                <div class="bg-white rounded-3xl shadow-xl p-6 md:p-8 sticky top-6 border border-gray-100">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center mr-3">
                            <i class="fas fa-receipt text-white"></i>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900">Ringkasan Pesanan</h2>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between py-3 border-b border-gray-100">
                            <span class="text-gray-600 font-medium">Subtotal</span>
                            <span id="subtotal" class="font-bold text-gray-900">
                                {{ 'Rp ' . number_format($subtotal, 0, ',', '.') }}
                            </span>
                        </div>
                        
                        <div class="flex justify-between py-3 border-b border-gray-100">
                            <span class="text-gray-600 font-medium">Pengiriman</span>
                            <span class="font-bold text-gray-900">Rp 15.000</span>
                        </div>
                        
                        <div class="flex justify-between py-3 border-b border-gray-100">
                            <span class="text-gray-600 font-medium">Diskon</span>
                            <span class="font-bold text-green-600">Rp 0</span>
                        </div>
                        
                        <div class="flex justify-between py-4 border-t-2 border-gray-200">
                            <span class="text-lg font-bold text-gray-900">Total</span>
                            <span id="grand-total" class="text-2xl font-bold text-[#193497]">
                                {{ 'Rp ' . number_format($subtotal + 15000, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="mt-8 space-y-4">
                        @if(auth()->check())
                            @php
                                $hasAddress = auth()->user()->locations()->exists();
                                $allAvailable = collect($cartItems)->every(fn($item) => $item['available']);
                            @endphp
                            
                            @if($allAvailable)
                                <a href="{{ route('cart.checkout') }}" 
                                   class="block w-full py-4 bg-[#193497] hover:bg-[#0f2354] text-white font-bold rounded-xl text-center transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                                    <i class="fas fa-shopping-bag mr-2"></i>
                                    Lanjut ke Checkout
                                </a>
                            @else
                                <button disabled
                                        class="block w-full py-4 bg-gray-300 text-gray-500 font-bold rounded-xl text-center cursor-not-allowed">
                                    Beberapa produk tidak tersedia
                                </button>
                            @endif
                            
                            @if(!$hasAddress)
                            <div class="p-4 bg-yellow-50 border-2 border-yellow-200 rounded-xl">
                                <div class="flex items-start">
                                    <i class="fas fa-exclamation-triangle text-yellow-600 mr-3 mt-1"></i>
                                    <p class="text-sm text-yellow-700">
                                        Anda belum memiliki alamat pengiriman. 
                                        <a href="{{ route('profile.index') }}" class="underline font-bold hover:text-yellow-800">Tambahkan alamat</a> sebelum checkout.
                                    </p>
                                </div>
                            </div>
                            @endif
                        @else
                            <a href="{{ route('login') }}" 
                               class="block w-full py-4 bg-[#193497] hover:bg-[#0f2354] text-white font-bold rounded-xl text-center transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                                <i class="fas fa-sign-in-alt mr-2"></i>
                                Login untuk Checkout
                            </a>
                            <p class="text-sm text-gray-600 text-center">
                                Atau <a href="{{ route('register') }}" class="text-[#193497] hover:underline font-semibold">buat akun baru</a>
                            </p>
                        @endif
                        
                        <div class="pt-6 border-t border-gray-100">
                            <h4 class="font-bold text-gray-900 mb-4 flex items-center">
                                <i class="fas fa-credit-card text-[#193497] mr-2"></i>
                                Metode Pembayaran
                            </h4>
                            <div class="grid grid-cols-3 gap-3">
                                <div class="border-2 border-gray-200 rounded-xl p-3 text-center hover:border-[#193497] hover:bg-blue-50 transition-all cursor-pointer">
                                    <i class="fas fa-qrcode text-[#193497] text-2xl mb-2"></i>
                                    <p class="text-xs font-bold text-gray-700">QRIS</p>
                                </div>
                                <div class="border-2 border-gray-200 rounded-xl p-3 text-center hover:border-[#193497] hover:bg-blue-50 transition-all cursor-pointer">
                                    <i class="fas fa-credit-card text-[#193497] text-2xl mb-2"></i>
                                    <p class="text-xs font-bold text-gray-700">Kartu</p>
                                </div>
                                <div class="border-2 border-gray-200 rounded-xl p-3 text-center hover:border-[#193497] hover:bg-blue-50 transition-all cursor-pointer">
                                    <i class="fas fa-university text-[#193497] text-2xl mb-2"></i>
                                    <p class="text-xs font-bold text-gray-700">Transfer</p>
                                </div>
                            </div>
                        </div>

                        <!-- Trust Badges -->
                        <div class="pt-6 border-t border-gray-100 space-y-3">
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-shield-alt text-green-500 mr-3"></i>
                                <span>Transaksi Aman & Terpercaya</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-medal text-yellow-500 mr-3"></i>
                                <span>Kualitas Premium Terjamin</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-headset text-blue-500 mr-3"></i>
                                <span>Customer Service 24/7</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
function updateQuantity(itemId, change) {
    const input = document.getElementById('quantity-' + itemId);
    let newQuantity = parseInt(input.value) + change;
    
    const max = parseInt(input.getAttribute('max'));
    
    if (newQuantity < 1) newQuantity = 1;
    if (newQuantity > max) newQuantity = max;
    
    input.value = newQuantity;
    submitQuantity(itemId);
}

function submitQuantity(itemId) {
    const input = document.getElementById('quantity-' + itemId);
    const quantity = input.value;
    
    fetch(`/cart/${itemId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ quantity: quantity })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update total per item
            const totalEl = document.getElementById('total-' + itemId);
            if (totalEl && data.item_total) {
                totalEl.textContent = data.item_total;
            }

            // Update subtotal
            const subtotalEl = document.getElementById('subtotal');
            if (subtotalEl && data.subtotal) {
                subtotalEl.textContent = data.subtotal;
            }

            // Update grand total
            const grandTotalEl = document.getElementById('grand-total');
            if (grandTotalEl && data.grand_total) {
                grandTotalEl.textContent = data.grand_total;
            }

            // Update cart count di navbar (optional)
            if (data.cart_count !== undefined) {
                const cartCount = document.getElementById('cart-count');
                if (cartCount) {
                    cartCount.textContent = data.cart_count;
                }
            }
        } else {
            alert(data.message || 'Gagal memperbarui jumlah');
            location.reload(); // Reload kalo error biar data tetep konsisten
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan');
        location.reload();
    });
}

function updateCartCount() {
    fetch('/cart/count')
        .then(response => response.json())
        .then(data => {
            const cartCount = document.getElementById('cart-count');
            if (cartCount) {
                cartCount.textContent = data.count;
                cartCount.classList.toggle('hidden', data.count === 0);
            }
        });
}

document.addEventListener('DOMContentLoaded', function() {
    updateCartCount();
    setInterval(updateCartCount, 30000);
});
</script>
@endpush