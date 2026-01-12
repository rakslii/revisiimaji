@extends('layouts.app')

@section('title', 'Checkout - Cipta Imaji')

@push('styles')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #3b82f6; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #2563eb; }
</style>
@endpush

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

            <form action="{{ route('cart.process') }}" method="POST" id="checkoutForm" enctype="multipart/form-data">
                @csrf
                
                <div class="flex flex-col lg:flex-row gap-8">
                    <!-- Main Content -->
                    <div class="lg:w-2/3 space-y-6">
                        <!-- Upload Design Section -->
                        <div class="bg-white rounded-3xl shadow-xl p-6 md:p-8 border border-gray-100">
                            <div class="flex items-center mb-6">
                                <div class="w-12 h-12 bg-gradient-to-br from-pink-500 to-rose-600 rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-images text-white text-xl"></i>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold text-gray-800">Upload Design</h2>
                                    <p class="text-gray-600 text-sm">Upload file design Anda (maks. 10MB)</p>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div class="relative">
                                    <input type="file" 
                                           name="design_files[]" 
                                           id="designFiles" 
                                           multiple 
                                           accept="image/*,.pdf,.ai,.psd,.cdr"
                                           class="hidden"
                                           onchange="handleFileSelect(event)">
                                    
                                    <label for="designFiles" class="flex flex-col items-center justify-center w-full h-48 border-3 border-dashed border-gray-300 rounded-2xl cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition-all duration-300">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <i class="fas fa-cloud-upload-alt text-5xl text-gray-400 mb-4"></i>
                                            <p class="mb-2 text-sm text-gray-600">
                                                <span class="font-bold">Klik untuk upload</span> atau drag & drop
                                            </p>
                                            <p class="text-xs text-gray-500">PNG, JPG, PDF, AI, PSD, CDR (Max 10MB)</p>
                                        </div>
                                    </label>
                                </div>

                                <!-- Preview Container -->
                                <div id="filePreview" class="hidden grid grid-cols-2 md:grid-cols-3 gap-4"></div>

                                <!-- Notes for Design -->
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">
                                        <i class="fas fa-pencil-alt mr-2"></i>
                                        Catatan Design (Opsional)
                                    </label>
                                    <textarea name="design_notes" 
                                              rows="3"
                                              class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all outline-none"
                                              placeholder="Contoh: Tolong ubah warna menjadi biru, gunakan font yang lebih bold, dll.">{{ old('design_notes') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Customer Information -->
                        <div class="bg-white rounded-3xl shadow-xl p-6 md:p-8 border border-gray-100">
                            <div class="flex items-center mb-6">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center mr-4">
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
                                        <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
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
                                        <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
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
                                        <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                     <!-- Shipping Address with Maps -->
<div class="bg-white rounded-3xl shadow-xl p-6 md:p-8 border border-gray-100">
    <div class="flex items-center mb-6">
        <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-orange-600 rounded-xl flex items-center justify-center mr-4">
            <i class="fas fa-map-marker-alt text-white text-xl"></i>
        </div>
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Alamat Pengiriman</h2>
            <p class="text-gray-600 text-sm">Tentukan lokasi pengiriman dengan akurat</p>
        </div>
    </div>

    <!-- Leaflet Maps -->
    <div class="mb-6">
        <div id="map" class="w-full h-80 rounded-2xl border-2 border-gray-200 overflow-hidden"></div>
        
        <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $userLocation->latitude ?? '') }}">
        <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $userLocation->longitude ?? '') }}">
        
        <p class="text-sm text-gray-600 mt-3 flex items-center">
            <i class="fas fa-info-circle text-blue-500 mr-2"></i>
            Klik pada peta untuk menentukan lokasi pengiriman atau gunakan tombol di bawah untuk lokasi saat ini
        </p>
        <button type="button" 
                onclick="getCurrentLocation()"
                class="mt-3 px-4 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 font-semibold rounded-lg transition-colors inline-flex items-center">
            <i class="fas fa-crosshairs mr-2"></i>
            Gunakan Lokasi Saya
        </button>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <div class="md:col-span-2">
            <label class="block text-gray-700 font-semibold mb-2">
                Alamat Lengkap <span class="text-red-500">*</span>
            </label>
            <textarea name="address" 
                      id="address"
                      rows="3" 
                      required
                      class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all outline-none @error('address') border-red-500 @enderror"
                      placeholder="Jalan, Nomor Rumah, RT/RW, Kelurahan, Kecamatan">{{ old('address', $userLocation->address ?? $user->address ?? '') }}</textarea>
            @error('address')
                <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-gray-700 font-semibold mb-2">
                Kota/Kabupaten <span class="text-red-500">*</span>
            </label>
            <input type="text" name="city" id="city" 
                   value="{{ old('city', $userLocation->city ?? $user->city ?? '') }}" 
                   required
                   class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all outline-none @error('city') border-red-500 @enderror"
                   placeholder="Contoh: Bandung">
            @error('city')
                <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-gray-700 font-semibold mb-2">
                Kode Pos <span class="text-red-500">*</span>
            </label>
            <input type="text" name="postal_code" id="postal_code" 
                   value="{{ old('postal_code', $userLocation->postal_code ?? $user->postal_code ?? '') }}" 
                   required
                   class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all outline-none @error('postal_code') border-red-500 @enderror"
                   placeholder="40xxx">
            @error('postal_code')
                <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>

                        <!-- Shipping Method -->
                        <div class="bg-white rounded-3xl shadow-xl p-6 md:p-8 border border-gray-100">
                            <div class="flex items-center mb-6">
                                <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-truck text-white text-xl"></i>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold text-gray-800">Metode Pengiriman</h2>
                                    <p class="text-gray-600 text-sm">Pilih cara pengiriman yang Anda inginkan</p>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <label class="flex items-start p-4 rounded-xl border-2 border-gray-200 cursor-pointer hover:border-blue-500 transition-all group has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                                    <input type="radio" name="shipping_method" value="pickup"
                                        class="mt-1 mr-4 w-5 h-5 accent-blue-600"
                                        {{ old('shipping_method', 'pickup') == 'pickup' ? 'checked' : '' }}>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="font-bold text-gray-800 text-lg">Ambil di Toko</span>
                                            <span class="text-green-600 font-bold text-lg">GRATIS</span>
                                        </div>
                                        <p class="text-gray-600 text-sm">Jl. Contoh Alamat Toko, Bandung</p>
                                        <p class="text-blue-600 text-sm mt-1"><i class="fas fa-clock mr-1"></i> Siap diambil dalam 24 jam</p>
                                    </div>
                                </label>

                                <label class="flex items-start p-4 rounded-xl border-2 border-gray-200 cursor-pointer hover:border-blue-500 transition-all group has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                                    <input type="radio" name="shipping_method" value="delivery"
                                        class="mt-1 mr-4 w-5 h-5 accent-blue-600"
                                        {{ old('shipping_method') == 'delivery' ? 'checked' : '' }}>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="font-bold text-gray-800 text-lg">Delivery/Kurir</span>
                                            <span class="text-blue-600 font-bold text-lg">Rp 15.000</span>
                                        </div>
                                        <p class="text-gray-600 text-sm">Khusus area Bandung dan sekitarnya</p>
                                        <p class="text-blue-600 text-sm mt-1"><i class="fas fa-shipping-fast mr-1"></i> Estimasi 1-2 hari kerja</p>
                                    </div>
                                </label>

                                <label class="flex items-start p-4 rounded-xl border-2 border-gray-200 cursor-pointer hover:border-blue-500 transition-all group has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                                    <input type="radio" name="shipping_method" value="cargo"
                                        class="mt-1 mr-4 w-5 h-5 accent-blue-600"
                                        {{ old('shipping_method') == 'cargo' ? 'checked' : '' }}>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="font-bold text-gray-800 text-lg">Cargo/Ekspedisi</span>
                                            <span class="text-blue-600 font-bold text-lg">Rp 25.000+</span>
                                        </div>
                                        <p class="text-gray-600 text-sm">Untuk luar kota Bandung</p>
                                        <p class="text-blue-600 text-sm mt-1"><i class="fas fa-box mr-1"></i> Estimasi 3-5 hari kerja</p>
                                    </div>
                                </label>
                            </div>
                            @error('shipping_method')
                                <p class="text-red-500 text-sm mt-2"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Payment Method -->
                        <div class="bg-white rounded-3xl shadow-xl p-6 md:p-8 border border-gray-100">
                            <div class="flex items-center mb-6">
                                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-credit-card text-white text-xl"></i>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold text-gray-800">Metode Pembayaran</h2>
                                    <p class="text-gray-600 text-sm">Pilih metode pembayaran yang tersedia</p>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <label class="flex items-center p-4 rounded-xl border-2 border-gray-200 cursor-pointer hover:border-blue-500 transition-all group has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
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

                                <label class="flex items-center p-4 rounded-xl border-2 border-gray-200 cursor-pointer hover:border-blue-500 transition-all group has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
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

                                <label class="flex items-center p-4 rounded-xl border-2 border-gray-200 cursor-pointer hover:border-blue-500 transition-all group has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
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
                                <p class="text-red-500 text-sm mt-2"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Order Notes -->
                        <div class="bg-white rounded-3xl shadow-xl p-6 md:p-8 border border-gray-100">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-xl flex items-center justify-center mr-4">
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
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center mr-3">
                                    <i class="fas fa-receipt text-white"></i>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800">Ringkasan Pesanan</h3>
                            </div>

                            <!-- Hidden inputs for cart items -->
                            @foreach($cartItems ?? [] as $index => $item)
                                <input type="hidden" name="items[{{ $index }}][product_id]" value="{{ $item->product_id }}">
                                <input type="hidden" name="items[{{ $index }}][quantity]" value="{{ $item->quantity }}">
                                <input type="hidden" name="items[{{ $index }}][price]" value="{{ $item->price }}">
                            @endforeach

                            <!-- Cart Items Display -->
                            <div class="space-y-4 mb-6 max-h-64 overflow-y-auto custom-scrollbar">
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
                                 <div class="flex justify-between text-lg font-bold text-gray-800">
                                    <span>Total</span>
                                    <span class="text-blue-600 total-price">
                                        Rp {{ number_format(($subtotal ?? 0) - ($discount ?? 0), 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>

                            <button type="submit"
                                class="w-full py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold rounded-xl hover:from-blue-700 hover:to-purple-700 transition-all duration-300 flex items-center justify-center gap-2">
                                <i class="fas fa-lock"></i>
                                Proses Checkout
                            </button>

                            <p class="text-xs text-gray-500 text-center mt-4">
                                Dengan melanjutkan, Anda menyetujui syarat & ketentuan kami
                            </p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endsection
@push('scripts')
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    // ================= UPLOAD PREVIEW =================
    function handleFileSelect(event) {
        const files = event.target.files;
        const preview = document.getElementById('filePreview');
        preview.innerHTML = '';
        preview.classList.remove('hidden');

        Array.from(files).forEach(file => {
            const reader = new FileReader();
            reader.onload = e => {
                const div = document.createElement('div');
                div.className = 'relative border-2 border-gray-200 rounded-xl p-2 hover:border-blue-400 transition-all';
                
                if (file.type.startsWith('image/')) {
                    div.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-32 object-cover rounded-lg">
                        <span class="absolute top-2 right-2 bg-black/70 text-white text-xs px-2 py-1 rounded-lg">
                            ${file.name.length > 15 ? file.name.substring(0, 15) + '...' : file.name}
                        </span>
                        <button type="button" onclick="removeFile(this)" class="absolute top-2 left-2 bg-red-500 hover:bg-red-600 text-white w-6 h-6 rounded-full flex items-center justify-center">
                            <i class="fas fa-times text-xs"></i>
                        </button>
                    `;
                } else {
                    div.innerHTML = `
                        <div class="w-full h-32 flex flex-col items-center justify-center bg-gradient-to-br from-blue-50 to-purple-50 rounded-lg">
                            <i class="fas fa-file-alt text-4xl text-blue-500 mb-2"></i>
                            <span class="text-xs text-gray-700 px-2 text-center font-semibold">
                                ${file.name.length > 15 ? file.name.substring(0, 15) + '...' : file.name}
                            </span>
                        </div>
                        <button type="button" onclick="removeFile(this)" class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white w-6 h-6 rounded-full flex items-center justify-center">
                            <i class="fas fa-times text-xs"></i>
                        </button>
                    `;
                }
                preview.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }

    function removeFile(btn) {
        btn.parentElement.remove();
        const preview = document.getElementById('filePreview');
        if (preview.children.length === 0) {
            preview.classList.add('hidden');
            document.getElementById('designFiles').value = '';
        }
    }

    // ================= LEAFLET MAPS (GRATIS!) =================
    let map, marker;

    document.addEventListener('DOMContentLoaded', function() {
        initMap();
    });

    function initMap() {
    // Ambil koordinat dari database (jika ada)
    const savedLat = document.getElementById('latitude').value;
    const savedLng = document.getElementById('longitude').value;
    
    let initialLat = -6.9175;  // Default Bandung
    let initialLng = 107.6191;
    let initialZoom = 13;
    
    // Jika ada koordinat tersimpan, gunakan itu
    if (savedLat && savedLng && savedLat !== '' && savedLng !== '') {
        initialLat = parseFloat(savedLat);
        initialLng = parseFloat(savedLng);
        initialZoom = 16; // Zoom lebih dekat jika ada lokasi tersimpan
    }
    
    map = L.map('map').setView([initialLat, initialLng], initialZoom);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap',
        maxZoom: 19
    }).addTo(map);
    
    // Auto place marker jika ada koordinat tersimpan
    if (savedLat && savedLng && savedLat !== '' && savedLng !== '') {
        placeMarker(initialLat, initialLng);
    }
    
    map.on('click', function(e) {
        placeMarker(e.latlng.lat, e.latlng.lng);
        getAddress(e.latlng.lat, e.latlng.lng);
    });
}

    function placeMarker(lat, lng) {
        if (marker) {
            map.removeLayer(marker);
        }
        
        marker = L.marker([lat, lng], {
            icon: L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            })
        }).addTo(map);
        
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;
        
        marker.bindPopup('<b>📍 Lokasi Pengiriman</b><br>Klik untuk confirm').openPopup();
    }

    function getAddress(lat, lng) {
        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
            .then(response => response.json())
            .then(data => {
                if (data.address) {
                    const addr = data.address;
                    const fullAddress = data.display_name;
                    const city = addr.city || addr.town || addr.village || addr.county || '';
                    const postcode = addr.postcode || '';
                    
                    document.getElementById('address').value = fullAddress;
                    if (city) document.getElementById('city').value = city;
                    if (postcode) document.getElementById('postal_code').value = postcode;
                }
            })
            .catch(err => console.log('Error:', err));
    }

    function getCurrentLocation() {
        if (!navigator.geolocation) {
            alert('Browser Anda tidak mendukung fitur lokasi');
            return;
        }
        
        const btn = event.target;
        const originalHTML = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mencari lokasi...';
        btn.disabled = true;
        
        navigator.geolocation.getCurrentPosition(
            function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                
                map.setView([lat, lng], 16);
                placeMarker(lat, lng);
                getAddress(lat, lng);
                
                btn.innerHTML = originalHTML;
                btn.disabled = false;
            },
            function(error) {
                alert('Tidak dapat mengakses lokasi: ' + error.message);
                btn.innerHTML = originalHTML;
                btn.disabled = false;
            }
        );
    }

    // ================= SHIPPING COST =================
    const shippingRadios = document.querySelectorAll('input[name="shipping_method"]');
    const shippingCostEl = document.querySelector('.shipping-cost');
    const totalPriceEl = document.querySelector('.total-price');

    const subtotal = {{ $subtotal ?? 0 }};
    const discount = {{ $discount ?? 0 }};

    shippingRadios.forEach(radio => {
        radio.addEventListener('change', () => {
            let cost = 0;
            if (radio.value === 'delivery') cost = 15000;
            if (radio.value === 'cargo') cost = 25000;

            shippingCostEl.textContent = 'Rp ' + cost.toLocaleString('id-ID');
            totalPriceEl.textContent = 'Rp ' + (subtotal - discount + cost).toLocaleString('id-ID');
        });
    });

    // ================= FORM VALIDATION =================
    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
        const lat = document.getElementById('latitude').value;
        const lng = document.getElementById('longitude').value;
        
        if (!lat || !lng) {
            e.preventDefault();
            alert('⚠️ Mohon tentukan lokasi pengiriman pada peta!\n\nKlik pada peta atau gunakan tombol "Gunakan Lokasi Saya"');
            document.getElementById('map').scrollIntoView({ behavior: 'smooth', block: 'center' });
            return false;
        }
    });
</script>
@endpush
