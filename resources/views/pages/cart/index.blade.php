@extends('layouts.app')

@section('title', 'Keranjang Belanja - Cipta Imaji')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Keranjang Belanja</h1>
            <p class="text-gray-600 mt-2">Review produk yang ingin Anda beli</p>
        </div>

        @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                <span class="text-green-700">{{ session('success') }}</span>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                <div>
                    <span class="text-red-700">{{ session('error') }}</span>
                    @if(session('unavailable'))
                    <ul class="mt-2 text-sm text-red-600">
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
        <div class="bg-white rounded-2xl shadow-sm p-8 text-center">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-shopping-cart text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">Keranjang Anda kosong</h3>
            <p class="text-gray-500 max-w-md mx-auto mb-6">
                Tambahkan produk yang Anda sukai ke keranjang untuk memulai belanja.
            </p>
            <a href="{{ route('products.index') }}" 
               class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-colors">
                <i class="fas fa-store mr-2"></i>
                Mulai Belanja
            </a>
        </div>
        @else
        <!-- Cart with Items -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-xl font-bold text-gray-800">Produk di Keranjang</h2>
                        <p class="text-gray-600 text-sm mt-1">{{ count($cartItems) }} produk</p>
                    </div>
                    
                    <div class="divide-y divide-gray-100">
                        @foreach($cartItems as $cartItem)
                        <div class="p-6 hover:bg-gray-50 transition-colors">
                            <div class="flex flex-col sm:flex-row gap-4">
                                <!-- Product Image -->
                                <div class="flex-shrink-0">
                                    <img src="{{ $cartItem['product']->getFirstMediaUrl('products') ?: asset('images/default-product.png') }}" 
                                         alt="{{ $cartItem['product']->name }}"
                                         class="w-24 h-24 object-cover rounded-xl">
                                </div>
                                
                                <!-- Product Info -->
                                <div class="flex-1">
                                    <div class="flex justify-between">
                                        <div>
                                            <h4 class="font-bold text-gray-800">{{ $cartItem['product']->name }}</h4>
                                            <p class="text-gray-600 text-sm mt-1">{{ $cartItem['product']->category->name ?? 'Uncategorized' }}</p>
                                            
                                            @if(!$cartItem['available'])
                                            <div class="mt-2 flex items-center text-red-600 text-sm">
                                                <i class="fas fa-exclamation-circle mr-2"></i>
                                                {{ $cartItem['message'] }}
                                            </div>
                                            @endif
                                        </div>
                                        
                                        <div class="text-right">
                                            <p class="font-bold text-gray-800">{{ $cartItem['item']->formatted_price }}</p>
                                            @if($cartItem['product']->price != $cartItem['item']->price)
                                            <p class="text-sm text-gray-500 line-through">Rp {{ number_format($cartItem['product']->price, 0, ',', '.') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Quantity Controls -->
                                    <div class="flex items-center justify-between mt-4">
                                        <div class="flex items-center">
                                            <form action="{{ route('cart.update', $cartItem['item']->id) }}" method="POST" class="flex items-center">
                                                @csrf
                                                <button type="button" 
                                                        onclick="updateQuantity({{ $cartItem['item']->id }}, -1)"
                                                        class="w-8 h-8 flex items-center justify-center border border-gray-300 rounded-l-lg hover:bg-gray-100">
                                                    <i class="fas fa-minus text-gray-600"></i>
                                                </button>
                                                
                                                <input type="number" 
                                                       id="quantity-{{ $cartItem['item']->id }}"
                                                       name="quantity"
                                                       value="{{ $cartItem['quantity'] }}"
                                                       min="1"
                                                       max="{{ $cartItem['product']->stock }}"
                                                       class="w-12 h-8 text-center border-t border-b border-gray-300 focus:outline-none"
                                                       onchange="submitQuantity({{ $cartItem['item']->id }})">
                                                
                                                <button type="button" 
                                                        onclick="updateQuantity({{ $cartItem['item']->id }}, 1)"
                                                        class="w-8 h-8 flex items-center justify-center border border-gray-300 rounded-r-lg hover:bg-gray-100">
                                                    <i class="fas fa-plus text-gray-600"></i>
                                                </button>
                                            </form>
                                            
                                            <span class="ml-4 text-sm text-gray-600">
                                                Stok: {{ $cartItem['product']->stock }}
                                            </span>
                                        </div>
                                        
                                        <div class="flex items-center space-x-4">
                                            <p class="font-bold text-gray-800">
                                                {{ 'Rp ' . number_format($cartItem['total'], 0, ',', '.') }}
                                            </p>
                                            
                                            <form action="{{ route('cart.remove', $cartItem['item']->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-500 hover:text-red-700">
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
                    <div class="p-6 border-t border-gray-200 flex justify-between">
                        <a href="{{ route('products.index') }}" 
                           class="px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-colors inline-flex items-center">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Lanjutkan Belanja
                        </a>
                        
                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    onclick="return confirm('Kosongkan seluruh keranjang?')"
                                    class="px-6 py-3 border border-red-300 text-red-600 font-semibold rounded-xl hover:bg-red-50 transition-colors inline-flex items-center">
                                <i class="fas fa-trash mr-2"></i>
                                Kosongkan Keranjang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm p-6 sticky top-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Ringkasan Pesanan</h2>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between py-3 border-b border-gray-100">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-semibold">{{ 'Rp ' . number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        
                        <div class="flex justify-between py-3 border-b border-gray-100">
                            <span class="text-gray-600">Pengiriman</span>
                            <span class="font-semibold">Rp 15.000</span>
                        </div>
                        
                        <div class="flex justify-between py-3 border-b border-gray-100">
                            <span class="text-gray-600">Diskon</span>
                            <span class="font-semibold text-green-600">Rp 0</span>
                        </div>
                        
                        <div class="flex justify-between py-4 border-t border-gray-200">
                            <span class="text-lg font-bold text-gray-800">Total</span>
                            <span class="text-2xl font-bold text-blue-600">
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
                                   class="block w-full py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-center transition-colors">
                                    Lanjut ke Checkout
                                </a>
                            @else
                                <button disabled
                                        class="block w-full py-4 bg-gray-300 text-gray-500 font-bold rounded-xl text-center cursor-not-allowed">
                                    Beberapa produk tidak tersedia
                                </button>
                            @endif
                            
                            @if(!$hasAddress)
                            <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-xl">
                                <p class="text-sm text-yellow-700">
                                    <i class="fas fa-exclamation-triangle mr-2"></i>
                                    Anda belum memiliki alamat pengiriman. 
                                    <a href="{{ route('profile.index') }}" class="underline font-semibold">Tambahkan alamat</a> sebelum checkout.
                                </p>
                            </div>
                            @endif
                        @else
                            <a href="{{ route('login') }}" 
                               class="block w-full py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-center transition-colors">
                                Login untuk Checkout
                            </a>
                            <p class="text-sm text-gray-500 text-center mt-2">
                                Atau <a href="{{ route('register') }}" class="text-blue-600 hover:underline">buat akun baru</a>
                            </p>
                        @endif
                        
                        <div class="pt-6 border-t border-gray-100">
                            <h4 class="font-bold text-gray-800 mb-3">Metode Pembayaran</h4>
                            <div class="grid grid-cols-3 gap-3">
                                <div class="border border-gray-200 rounded-lg p-3 text-center">
                                    <i class="fas fa-qrcode text-green-600 text-2xl mb-2"></i>
                                    <p class="text-xs font-semibold">QRIS</p>
                                </div>
                                <div class="border border-gray-200 rounded-lg p-3 text-center">
                                    <i class="fas fa-credit-card text-blue-600 text-2xl mb-2"></i>
                                    <p class="text-xs font-semibold">Kartu</p>
                                </div>
                                <div class="border border-gray-200 rounded-lg p-3 text-center">
                                    <i class="fas fa-university text-purple-600 text-2xl mb-2"></i>
                                    <p class="text-xs font-semibold">Transfer</p>
                                </div>
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
    
    // Get max from input attribute
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
            location.reload();
        } else {
            alert(data.message || 'Gagal memperbarui jumlah');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan');
    });
}

// Update cart count in navbar
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

// Update count on page load
document.addEventListener('DOMContentLoaded', function() {
    updateCartCount();
    
    // Update count every 30 seconds
    setInterval(updateCartCount, 30000);
});
</script>
@endpush