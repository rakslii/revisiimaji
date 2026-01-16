@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
<section class="relative bg-[#193497] text-white overflow-hidden min-h-screen">
    <!-- Decorative Blobs -->
    <div class="absolute top-20 right-20 w-96 h-96 bg-[#d2f801] rounded-full opacity-20 blur-3xl"></div>
    <div class="absolute bottom-20 left-20 w-96 h-96 bg-[#193497] rounded-full opacity-20 blur-3xl"></div>

    <div class="container mx-auto px-4 py-20 relative z-10 max-w-4xl">

        <!-- Header -->
        <div class="mb-10">
            <h1 class="text-4xl md:text-5xl font-bold mb-2">
                Detail <span class="text-[#d2f801]">Pesanan</span>
            </h1>
            <p class="text-[#f9f0f1]/70">
                Kode Order: <span class="font-semibold">{{ $order->order_code }}</span>
            </p>
        </div>

        <!-- Status Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 shadow-xl">
                <p class="text-sm text-[#f9f0f1]/70 mb-1">Status Pesanan</p>
                <p class="text-xl font-bold capitalize">
                    {{ str_replace('_', ' ', $order->status) }}
                </p>
            </div>

            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 shadow-xl">
                <p class="text-sm text-[#f9f0f1]/70 mb-1">Status Pembayaran</p>
                <p class="text-xl font-bold capitalize">
                    {{ $order->payment_status }}
                </p>
            </div>
        </div>

        <!-- Alamat -->
        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 shadow-xl mb-8">
            <h2 class="text-xl font-bold mb-3">Alamat Pengiriman</h2>
            <p class="text-[#f9f0f1]/80">
                {{ $order->shipping_address }}
            </p>

            @if($order->shipping_note)
                <p class="text-sm text-[#f9f0f1]/70 mt-2">
                    Catatan: {{ $order->shipping_note }}
                </p>
            @endif
        </div>

        <!-- Ringkasan -->
        <div class="bg-white rounded-3xl p-8 shadow-2xl mb-8 text-[#191f01]">
            <h2 class="text-2xl font-bold mb-6">Ringkasan Pembayaran</h2>

            <div class="space-y-3">
                <div class="flex justify-between">
                    <span>Subtotal</span>
                    <span class="font-semibold">
                        Rp {{ number_format($order->subtotal, 0, ',', '.') }}
                    </span>
                </div>

                <div class="flex justify-between">
                    <span>Ongkir</span>
                    <span class="font-semibold">
                        Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}
                    </span>
                </div>

                <div class="flex justify-between text-[#f91f01]">
                    <span>Diskon</span>
                    <span>
                        - Rp {{ number_format($order->discount, 0, ',', '.') }}
                    </span>
                </div>

                <hr>

                <div class="flex justify-between text-xl font-bold text-[#193497]">
                    <span>Total</span>
                    <span>
                        Rp {{ number_format($order->total, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Payment Method -->
        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 shadow-xl mb-8">
            <h2 class="text-xl font-bold mb-2">Metode Pembayaran</h2>
            <p class="text-[#f9f0f1]/80">
                {{ $order->payment_method ?? 'Belum dipilih' }}
            </p>
        </div>

        <!-- Notes -->
        @if($order->notes)
        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 shadow-xl mb-8">
            <h2 class="text-xl font-bold mb-2">Catatan</h2>
            <p class="text-[#f9f0f1]/80">
                {{ $order->notes }}
            </p>
        </div>
        @endif

        <!-- Footer -->
        <div class="text-sm text-[#f9f0f1]/50 text-center">
            Dibuat pada {{ $order->created_at->format('d M Y H:i') }}
        </div>

    </div>
</section>
@endsection
