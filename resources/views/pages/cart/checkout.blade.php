@extends('layouts.app')

@section('title', 'Checkout - Cipta Imaji')

@section('content')
    <div class="bg-gradient-to-b from-gray-50 to-white min-h-screen">
        <!-- Hero Section -->
        <div class="relative bg-gradient-to-r from-blue-900 via-purple-900 to-blue-900 text-white overflow-hidden">
            <div class="absolute top-0 right-0 w-96 h-96 bg-yellow-400 rounded-full opacity-10 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-purple-500 rounded-full opacity-10 blur-3xl"></div>

            <div class="container mx-auto px-4 py-8 md:py-12 relative z-10">
                <div class="max-w-4xl">
                    <nav class="flex items-center space-x-2 text-sm mb-6">
                        <a href="{{ route('home') }}" class="text-blue-200 hover:text-yellow-400 transition-colors">
                            <i class="fas fa-home"></i> Beranda
                        </a>
                        <i class="fas fa-chevron-right text-blue-300 text-xs"></i>
                        <a href="{{ route('cart.index') }}"
                            class="text-blue-200 hover:text-yellow-400 transition-colors">Keranjang</a>
                        <i class="fas fa-chevron-right text-blue-300 text-xs"></i>
                        <span class="text-yellow-400 font-semibold">Checkout</span>
                    </nav>

                    <h1 class="text-3xl md:text-5xl font-bold mb-3 leading-tight">
                        <i class="fas fa-shopping-bag text-yellow-400 mr-3"></i>
                        Checkout <span class="text-yellow-400">Pesanan</span>
                    </h1>
                    <p class="text-lg md:text-xl opacity-90">
                        Lengkapi data dan selesaikan pembayaran Anda
                    </p>
                </div>
            </div>
        </div>

        <div class="container mx-auto px-4 py-8 md:py-12">
            <!-- Error Messages -->
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-2 border-red-200 rounded-xl p-6">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-circle text-red-500 text-2xl mr-4 mt-1"></i>
                        <div class="flex-1">
                            <h3 class="text-red-800 font-bold text-lg mb-2">Ada kesalahan pada form:</h3>
                            <ul class="list-disc list-inside space-y-1 text-red-700">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-red-50 border-2 border-red-200 rounded-xl p-6">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 text-2xl mr-4"></i>
                        <span class="text-red-700 font-semibold">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <form action="{{ route('cart.process') }}" method="POST" id="checkoutForm">
                @csrf
                
                <div class="flex flex-col lg:flex-row gap-8">
                    <!-- Main Content -->
                    <div class="lg:w-2/3 space-y-6">
                        <!-- Customer Information -->
                        <div class="bg-white rounded-3xl shadow-xl p-6 md:p-8 border border-gray-100">
                            <div class="flex items-center mb-6">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-user text-white text-xl"></i>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold text-gray-800">Informasi Pelanggan</h2>
                                    <p class="text-gray-600 text-sm">Data diri untuk pengiriman dan konfirmasi</p>
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">
                                        Nama Lengkap <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="name"
                                        value="{{ old('name', auth()->user()->name ?? '') }}" required
                                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all outline-none @error('name') border-red-500 @enderror"
                                        placeholder="Masukkan nama lengkap">
                                    @error('name')
                                        <p class="text-red-500 text-sm mt-1"><i
                                                class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">
                                        Nomor WhatsApp <span class="text-red-500">*</span>
                                    </label>
                                    <input type="tel" name="phone"
                                        value="{{ old('phone', auth()->user()->phone ?? '') }}" required
                                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all outline-none @error('phone') border-red-500 @enderror"
                                        placeholder="08123456789">
                                    @error('phone')
                                        <p class="text-red-500 text-sm mt-1"><i
                                                class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-gray-700 font-semibold mb-2">
                                        Email <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" name="email"
                                        value="{{ old('email', auth()->user()->email ?? '') }}" required
                                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all outline-none @error('email') border-red-500 @enderror"
                                        placeholder="email@example.com">
                                    @error('email')
                                        <p class="text-red-500 text-sm mt-1"><i
                                                class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-gray-700 font-semibold mb-2">
                                        Alamat Lengkap <span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="address" rows="3" required
                                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all outline-none @error('address') border-red-500 @enderror"
                                        placeholder="Jalan, Nomor Rumah, RT/RW, Kelurahan, Kecamatan">{{ old('address', auth()->user()->address ?? '') }}</textarea>
                                    @error('address')
                                        <p class="text-red-500 text-sm mt-1"><i
                                                class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">
                                        Kota/Kabupaten <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="city" value="{{ old('city') }}" required
                                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all outline-none @error('city') border-red-500 @enderror"
                                        placeholder="Contoh: Bandung">
                                    @error('city')
                                        <p class="text-red-500 text-sm mt-1"><i
                                                class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">
                                        Kode Pos <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="postal_code" value="{{ old('postal_code') }}" required
                                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all outline-none @error('postal_code') border-red-500 @enderror"
                                        placeholder="40xxx">
                                    @error('postal_code')
                                        <p class="text-red-500 text-sm mt-1"><i
                                                class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Shipping Method -->
                        <div class="bg-white rounded-3xl shadow-xl p-6 md:p-8 border border-gray-100">
                            <div class="flex items-center mb-6">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-truck text-white text-xl"></i>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold text-gray-800">Metode Pengiriman</h2>
                                    <p class="text-gray-600 text-sm">Pilih cara pengiriman yang Anda inginkan</p>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <label
                                    class="flex items-start p-4 rounded-xl border-2 border-gray-200 cursor-pointer hover:border-blue-500 transition-all group has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                                    <input type="radio" name="shipping_method" value="pickup"
                                        class="mt-1 mr-4 w-5 h-5 accent-blue-600"
                                        {{ old('shipping_method', 'pickup') == 'pickup' ? 'checked' : '' }}>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="font-bold text-gray-800 text-lg">Ambil di Toko</span>
                                            <span class="text-green-600 font-bold text-lg">GRATIS</span>
                                        </div>
                                        <p class="text-gray-600 text-sm">Jl. Contoh Alamat Toko, Bandung</p>
                                        <p class="text-blue-600 text-sm mt-1"><i class="fas fa-clock mr-1"></i> Siap
                                            diambil dalam 24 jam</p>
                                    </div>
                                </label>

                                <label
                                    class="flex items-start p-4 rounded-xl border-2 border-gray-200 cursor-pointer hover:border-blue-500 transition-all group has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                                    <input type="radio" name="shipping_method" value="delivery"
                                        class="mt-1 mr-4 w-5 h-5 accent-blue-600"
                                        {{ old('shipping_method') == 'delivery' ? 'checked' : '' }}>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="font-bold text-gray-800 text-lg">Delivery/Kurir</span>
                                            <span class="text-blue-600 font-bold text-lg">Rp 15.000</span>
                                        </div>
                                        <p class="text-gray-600 text-sm">Khusus area Bandung dan sekitarnya</p>
                                        <p class="text-blue-600 text-sm mt-1"><i class="fas fa-shipping-fast mr-1"></i>
                                            Estimasi 1-2 hari kerja</p>
                                    </div>
                                </label>

                                <label
                                    class="flex items-start p-4 rounded-xl border-2 border-gray-200 cursor-pointer hover:border-blue-500 transition-all group has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                                    <input type="radio" name="shipping_method" value="cargo"
                                        class="mt-1 mr-4 w-5 h-5 accent-blue-600"
                                        {{ old('shipping_method') == 'cargo' ? 'checked' : '' }}>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="font-bold text-gray-800 text-lg">Cargo/Ekspedisi</span>
                                            <span class="text-blue-600 font-bold text-lg">Rp 25.000+</span>
                                        </div>
                                        <p class="text-gray-600 text-sm">Untuk luar kota Bandung</p>
                                        <p class="text-blue-600 text-sm mt-1"><i class="fas fa-box mr-1"></i> Estimasi 3-5
                                            hari kerja</p>
                                    </div>
                                </label>
                            </div>
                            @error('shipping_method')
                                <p class="text-red-500 text-sm mt-2"><i
                                        class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Payment Method -->
                        <div class="bg-white rounded-3xl shadow-xl p-6 md:p-8 border border-gray-100">
                            <div class="flex items-center mb-6">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-credit-card text-white text-xl"></i>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold text-gray-800">Metode Pembayaran</h2>
                                    <p class="text-gray-600 text-sm">Pilih metode pembayaran yang tersedia</p>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <label
                                    class="flex items-center p-4 rounded-xl border-2 border-gray-200 cursor-pointer hover:border-blue-500 transition-all group has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                                    <input type="radio" name="payment_method" value="transfer"
                                        class="mr-4 w-5 h-5 accent-blue-600"
                                        {{ old('payment_method', 'transfer') == 'transfer' ? 'checked' : '' }}>
                                    <div class="flex-1">
                                        <div class="flex items-center">
                                            <i class="fas fa-university text-blue-600 text-2xl mr-4"></i>
                                            <div>
                                                <span class="font-bold text-gray-800 text-lg block">Transfer Bank</span>
                                                <span class="text-gray-600 text-sm">BCA, Mandiri, BRI</span>
                                            </div>
                                        </div>
                                    </div>
                                </label>

                                <label
                                    class="flex items-center p-4 rounded-xl border-2 border-gray-200 cursor-pointer hover:border-blue-500 transition-all group has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                                    <input type="radio" name="payment_method" value="cash"
                                        class="mr-4 w-5 h-5 accent-blue-600"
                                        {{ old('payment_method') == 'cash' ? 'checked' : '' }}>
                                    <div class="flex-1">
                                        <div class="flex items-center">
                                            <i class="fas fa-money-bill-wave text-green-600 text-2xl mr-4"></i>
                                            <div>
                                                <span class="font-bold text-gray-800 text-lg block">Cash on Delivery</span>
                                                <span class="text-gray-600 text-sm">Bayar saat terima barang</span>
                                            </div>
                                        </div>
                                    </div>
                                </label>

                                <label
                                    class="flex items-center p-4 rounded-xl border-2 border-gray-200 cursor-pointer hover:border-blue-500 transition-all group has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                                    <input type="radio" name="payment_method" value="ewallet"
                                        class="mr-4 w-5 h-5 accent-blue-600"
                                        {{ old('payment_method') == 'ewallet' ? 'checked' : '' }}>
                                    <div class="flex-1">
                                        <div class="flex items-center">
                                            <i class="fas fa-wallet text-purple-600 text-2xl mr-4"></i>
                                            <div>
                                                <span class="font-bold text-gray-800 text-lg block">E-Wallet</span>
                                                <span class="text-gray-600 text-sm">GoPay, OVO, Dana, ShopeePay</span>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            @error('payment_method')
                                <p class="text-red-500 text-sm mt-2"><i
                                        class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Order Notes -->
                        <div class="bg-white rounded-3xl shadow-xl p-6 md:p-8 border border-gray-100">
                            <div class="flex items-center mb-4">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-comment-dots text-white text-xl"></i>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold text-gray-800">Catatan Pesanan</h2>
                                    <p class="text-gray-600 text-sm">Tambahkan catatan khusus (opsional)</p>
                                </div>
                            </div>

                            <textarea name="notes" rows="4"
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all outline-none"
                                placeholder="Contoh: Tolong kirim sebelum jam 5 sore, Untuk hadiah, dll.">{{ old('notes') }}</textarea>
                        </div>
                    </div>

                    <!-- Order Summary Sidebar -->
                    <div class="lg:w-1/3">
                        <div class="bg-white rounded-3xl shadow-xl p-6 border border-gray-100 sticky top-6">
                            <div class="flex items-center mb-6">
                                <div
                                    class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center mr-3">
                                    <i class="fas fa-receipt text-white"></i>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800">Ringkasan Pesanan</h3>
                            </div>

                            <!-- Hidden inputs for cart items (OUTSIDE the display div) -->
                            @foreach($cartItems ?? [] as $index => $item)
                                <input type="hidden" name="items[{{ $index }}][product_id]" value="{{ $item->product_id }}">
                                <input type="hidden" name="items[{{ $index }}][quantity]" value="{{ $item->quantity }}">
                                <input type="hidden" name="items[{{ $index }}][price]" value="{{ $item->price }}">
                            @endforeach

                            <!-- Cart Items Display -->
                            <div class="space-y-4 mb-6 max-h-64 overflow-y-auto">
                                @forelse($cartItems ?? [] as $item)
                                    <div class="flex gap-3 pb-4 border-b border-gray-100">
                                        <img src="{{ $item->product->image_url ?? 'https://via.placeholder.com/80' }}"
                                            alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded-lg">
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-semibold text-gray-800 text-sm line-clamp-2">
                                                {{ $item->product->name }}</h4>
                                            <p class="text-gray-600 text-xs mt-1">Qty: {{ $item->quantity }}</p>
                                            <p class="text-blue-600 font-bold text-sm mt-1">Rp
                                                {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-4 text-gray-500">
                                        <i class="fas fa-shopping-cart text-3xl mb-2"></i>
                                        <p class="text-sm">Keranjang kosong</p>
                                    </div>
                                @endforelse
                            </div>

                            <!-- Price Summary -->
                            <div class="space-y-3 mb-6">
                                <div class="flex justify-between text-gray-700">
                                    <span>Subtotal</span>
                                    <span class="font-semibold">Rp {{ number_format($subtotal ?? 0, 0, ',', '.') }}</span>
                                </div>

                                <div class="flex justify-between text-gray-700">
                                    <span>Ongkos Kirim</span>
                                    <span class="font-semibold shipping-cost">Rp 0</span>
                                </div>

                                @if (isset($discount) && $discount > 0)
                                    <div class="flex justify-between text-green-600">
                                        <span>Diskon</span>
                                        <span class="font-semibold">-Rp {{ number_format($discount, 0, ',', '.') }}</span>
                                    </div>
                                @endif

                                <div class="border-t border-gray-200 pt-3">
                                    <div class="flex justify-between items-center">
                                        <span class="text-xl font-bold text-gray-800">Total</span>
                                        <span class="text-2xl font-bold text-blue-600" id="totalPrice">
                                            Rp {{ number_format($total ?? 0, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" id="submitBtn"
                                class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-bold py-4 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 mb-4">
                                <i class="fas fa-check-circle mr-2"></i>
                                Proses Pesanan
                            </button>

                            <a href="{{ route('cart.index') }}"
                                class="block w-full text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 rounded-xl transition-colors">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Kembali ke Keranjang
                            </a>

                            <!-- Trust Badges -->
                            <div class="mt-6 pt-6 border-t border-gray-200 space-y-3">
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
            </form>

            <!-- Help Section -->
            <div
                class="mt-12 relative bg-gradient-to-r from-blue-900 via-purple-900 to-blue-900 text-white rounded-3xl p-8 md:p-12 overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-yellow-400 rounded-full opacity-10 blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-purple-500 rounded-full opacity-10 blur-3xl"></div>

                <div class="text-center relative z-10">
                    <div
                        class="w-16 h-16 bg-yellow-400 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-2xl">
                        <i class="fas fa-question-circle text-blue-900 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl md:text-3xl font-bold mb-3">
                        Butuh <span class="text-yellow-400">Bantuan</span>?
                    </h3>
                    <p class="text-lg mb-6 opacity-90 max-w-2xl mx-auto">
                        Tim customer service kami siap membantu proses pemesanan Anda
                    </p>
                    <a href="{{ route('whatsapp.chat') }}" target="_blank"
                        class="inline-flex items-center justify-center bg-yellow-400 hover:bg-yellow-300 text-blue-900 font-bold px-8 py-4 rounded-xl transition-all duration-300 shadow-2xl hover:shadow-yellow-400/50 transform hover:scale-105">
                        <i class="fab fa-whatsapp mr-3 text-2xl"></i>
                        <span class="text-lg">Chat via WhatsApp</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('styles')
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        input[type="radio"] {
            accent-color: #3b82f6;
        }

        /* Custom Scrollbar */
        .overflow-y-auto::-webkit-scrollbar {
            width: 6px;
        }

        .overflow-y-auto::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb {
            background: #3b82f6;
            border-radius: 10px;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb:hover {
            background: #2563eb;
        }
    </style>
@endpush

@push('scripts')
    <script>
        console.log('Checkout page loaded');

        // Update shipping cost based on selected method
        document.querySelectorAll('input[name="shipping_method"]').forEach(radio => {
            radio.addEventListener('change', function() {
                console.log('Shipping method changed to:', this.value);

                const shippingCostElement = document.querySelector('.shipping-cost');
                const totalElement = document.getElementById('totalPrice');

                const subtotal = {{ $subtotal ?? 0 }};
                const discount = {{ $discount ?? 0 }};

                let shippingCost = 0;

                if (this.value === 'delivery') {
                    shippingCost = 15000;
                } else if (this.value === 'cargo') {
                    shippingCost = 25000;
                } else {
                    shippingCost = 0;
                }

                // Update ongkir
                shippingCostElement.textContent =
                    'Rp ' + shippingCost.toLocaleString('id-ID');

                // Hitung total
                const total = subtotal + shippingCost - discount;

                // Update total harga
                totalElement.textContent =
                    'Rp ' + total.toLocaleString('id-ID');
            });
        });

        // Optional: prevent double submit
        document.getElementById('checkoutForm').addEventListener('submit', function() {
            const btn = document.getElementById('submitBtn');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Memproses...';
        });
    </script>
@endpush
