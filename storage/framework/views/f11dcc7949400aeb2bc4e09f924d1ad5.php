

<?php $__env->startSection('title', 'Pembayaran - Cipta Imaji'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-[#f9f0f1] min-h-screen">
    <!-- Hero Section -->
    <div class="relative bg-[#193497] text-[#f9f0f1] overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-[#d2f801] rounded-full opacity-10 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-[#7209b7] rounded-full opacity-10 blur-3xl"></div>

        <div class="container mx-auto px-4 py-8 md:py-12 relative z-10">
            <div class="max-w-6xl mx-auto">
                <nav class="flex items-center space-x-2 text-sm mb-6">
                    <a href="<?php echo e(route('home')); ?>" class="text-blue-200 hover:text-white transition-colors">
                        <i class="fas fa-home"></i> Beranda
                    </a>
                    <i class="fas fa-chevron-right text-blue-300 text-xs"></i>
                    <a href="<?php echo e(route('orders.index')); ?>" class="text-blue-200 hover:text-white transition-colors">
                        Pesanan Saya
                    </a>
                    <i class="fas fa-chevron-right text-blue-300 text-xs"></i>
                    <span class="text-[#d2f801] font-semibold">Pembayaran</span>
                </nav>

                <h1 class="text-3xl md:text-5xl font-bold mb-3 leading-tight">
                    <i class="fas fa-qrcode text-[#d2f801] mr-3"></i>
                    Pembayaran <span class="text-[#d2f801]">Order</span>
                </h1>
                <p class="text-lg md:text-xl opacity-90">
                    Selesaikan pembayaran Anda dengan aman dan mudah
                </p>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8 md:py-12">
        <?php if(session('success')): ?>
        <div class="max-w-6xl mx-auto mb-8">
            <div class="bg-green-50 border-2 border-green-200 rounded-xl p-6">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 text-2xl mr-4"></i>
                    <span class="text-green-700 font-semibold"><?php echo e(session('success')); ?></span>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
        <div class="max-w-6xl mx-auto mb-8">
            <div class="bg-red-50 border-2 border-red-200 rounded-xl p-6">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 text-2xl mr-4"></i>
                    <span class="text-red-700 font-semibold"><?php echo e(session('error')); ?></span>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="max-w-6xl mx-auto">
            <!-- Error jika tidak ada payment -->
            <?php if(!$payment && !$order->snap_token): ?>
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100 p-8 mb-8">
                <div class="text-center py-12">
                    <div class="w-24 h-24 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-exclamation-triangle text-yellow-500 text-4xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Informasi Pembayaran Belum Tersedia</h3>
                    <p class="text-gray-600 mb-8 max-w-lg mx-auto text-lg">
                        Sistem sedang mempersiapkan metode pembayaran untuk pesanan Anda.
                        Silakan tunggu beberapa saat atau hubungi customer service.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="<?php echo e(route('orders.show', $order->id)); ?>" 
                           class="px-8 py-4 border-2 border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-all inline-flex items-center text-lg">
                            <i class="fas fa-arrow-left mr-3"></i>
                            Kembali ke Detail Pesanan
                        </a>
                        <button onclick="location.reload()" 
                                class="px-8 py-4 bg-[#193497] hover:bg-[#0f2354] text-white font-bold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 inline-flex items-center text-lg">
                            <i class="fas fa-sync-alt mr-3"></i>
                            Refresh Halaman
                        </button>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Main Payment Container -->
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Left Column: Order Details -->
                <div class="lg:w-2/3">
                    <!-- Order Card -->
                    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100 mb-8">
                        <div class="p-8 border-b border-gray-200">
                            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8">
                                <div class="flex items-center">
                                    <div class="w-14 h-14 bg-gradient-to-br from-[#193497] to-[#0f2354] rounded-xl flex items-center justify-center mr-5">
                                        <i class="fas fa-receipt text-white text-2xl"></i>
                                    </div>
                                    <div>
                                        <h2 class="text-2xl font-bold text-gray-900">Order #<?php echo e($order->order_code ?? $order->order_number); ?></h2>
                                        <p class="text-gray-600 text-sm mt-2">
                                            <i class="far fa-clock mr-2"></i>
                                            Dibuat: <?php echo e($order->created_at->translatedFormat('d F Y, H:i')); ?>

                                        </p>
                                    </div>
                                </div>

                                <div class="flex flex-col md:flex-row gap-4">
                                    <div class="px-5 py-3 bg-blue-100 text-[#193497] rounded-xl font-bold text-center min-w-[140px]">
                                        <p class="text-sm mb-1">Status Pesanan</p>
                                        <p class="text-lg"><?php echo e(ucfirst(str_replace('_', ' ', $order->status))); ?></p>
                                    </div>
                                    <div class="px-5 py-3 <?php echo e($order->payment_status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'); ?> rounded-xl font-bold text-center min-w-[140px]">
                                        <p class="text-sm mb-1">Status Pembayaran</p>
                                        <p class="text-lg"><?php echo e(ucfirst($order->payment_status)); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Items Summary -->
                        <div class="p-8">
                            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center pb-4 border-b border-gray-200">
                                <i class="fas fa-box-open text-[#193497] mr-3"></i>
                                Ringkasan Pesanan
                            </h3>

                            <div class="space-y-6">
                                <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex items-center justify-between py-4 border-b border-gray-100 hover:bg-gray-50 px-3 rounded-lg transition-colors">
                                    <div class="flex items-center">
                                        <?php if($item->product && $item->product->image_url): ?>
                                        <div class="w-20 h-20 bg-gray-100 rounded-xl overflow-hidden mr-5 flex-shrink-0">
                                            <img src="<?php echo e($item->product->image_url); ?>"
                                                 alt="<?php echo e($item->product_name ?? $item->product->name); ?>"
                                                 class="w-full h-full object-cover"
                                                 onerror="this.onerror=null; this.src='<?php echo e(asset('images/default-product.jpg')); ?>'">
                                        </div>
                                        <?php endif; ?>
                                        <div>
                                            <h4 class="font-bold text-gray-900 text-lg mb-1"><?php echo e($item->product_name ?? $item->product->name ?? 'Product'); ?></h4>
                                            <div class="flex items-center gap-4">
                                                <span class="text-gray-600 font-medium">
                                                    <?php echo e($item->quantity); ?> × Rp <?php echo e(number_format($item->price, 0, ',', '.')); ?>

                                                </span>
                                                <?php if($item->product && $item->product->category_name): ?>
                                                <span class="px-3 py-1 bg-blue-50 text-[#193497] rounded-lg text-sm font-semibold">
                                                    <?php echo e($item->product->category_name); ?>

                                                </span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="font-bold text-gray-900 text-xl">
                                        Rp <?php echo e(number_format($item->quantity * $item->price, 0, ',', '.')); ?>

                                    </span>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <!-- Total Summary -->
                                <div class="pt-6 space-y-4 bg-gray-50 p-6 rounded-2xl mt-4">
                                    <?php if($order->subtotal): ?>
                                    <div class="flex justify-between items-center py-2">
                                        <span class="text-gray-600 text-lg font-medium">Subtotal</span>
                                        <span class="font-bold text-gray-900 text-xl">Rp <?php echo e(number_format($order->subtotal, 0, ',', '.')); ?></span>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <?php if($order->shipping_cost): ?>
                                    <div class="flex justify-between items-center py-2">
                                        <span class="text-gray-600 text-lg font-medium">Biaya Pengiriman</span>
                                        <span class="font-bold text-gray-900 text-xl">Rp <?php echo e(number_format($order->shipping_cost, 0, ',', '.')); ?></span>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <?php if(($order->discount ?? 0) > 0): ?>
                                    <div class="flex justify-between items-center py-2">
                                        <span class="text-gray-600 text-lg font-medium">Diskon</span>
                                        <span class="font-bold text-green-600 text-xl">- Rp <?php echo e(number_format($order->discount, 0, ',', '.')); ?></span>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <div class="flex justify-between items-center pt-6 border-t-2 border-gray-300">
                                        <span class="text-2xl font-bold text-gray-900">Total Pembayaran</span>
                                        <span class="text-3xl font-bold text-[#193497]">
                                            <?php echo e($order->formatted_total ?? 'Rp ' . number_format($order->total_amount ?? $order->total, 0, ',', '.')); ?>

                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Help Section -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-question-circle text-[#193497] text-xl"></i>
                                </div>
                                <h4 class="font-bold text-gray-900 text-lg">Butuh Bantuan?</h4>
                            </div>
                            <p class="text-gray-600 mb-4 text-sm">
                                Hubungi customer service kami jika mengalami kendala dalam pembayaran.
                            </p>
                            <a href="<?php echo e(route('whatsapp.chat')); ?>"
                               class="inline-flex items-center text-[#193497] font-bold hover:text-[#0f2354] transition-colors text-sm">
                                <i class="fab fa-whatsapp mr-2 text-lg"></i>
                                Chat via WhatsApp
                            </a>
                        </div>

                        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-shield-alt text-green-600 text-xl"></i>
                                </div>
                                <h4 class="font-bold text-gray-900 text-lg">Pembayaran Aman</h4>
                            </div>
                            <p class="text-gray-600 text-sm">
                                Transaksi Anda dilindungi dengan sistem keamanan terenkripsi SSL 256-bit.
                            </p>
                        </div>

                        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-sync-alt text-purple-600 text-xl"></i>
                                </div>
                                <h4 class="font-bold text-gray-900 text-lg">Update Otomatis</h4>
                            </div>
                            <p class="text-gray-600 text-sm">
                                Status pembayaran akan otomatis terupdate dalam 1-2 menit setelah transfer berhasil.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Payment Method -->
                <div class="lg:w-1/3">
                    <div class="sticky top-6">
                        <!-- Payment Method Card -->
                        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100 mb-6">
                            <div class="p-8">
                                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center pb-4 border-b border-gray-200">
                                    <i class="fas fa-credit-card text-[#193497] mr-3"></i>
                                    Metode Pembayaran
                                </h3>

                                <?php if($order->snap_token): ?>
                                    <!-- Midtrans Payment -->
                                    <div class="text-center">
                                        <div class="mb-8">
                                            <div class="w-20 h-20 bg-gradient-to-br from-[#193497] to-[#0f2354] rounded-2xl flex items-center justify-center mx-auto mb-4">
                                                <i class="fas fa-credit-card text-white text-3xl"></i>
                                            </div>
                                            <h4 class="text-2xl font-bold text-gray-900 mb-2">Midtrans Payment</h4>
                                            <p class="text-gray-600 mb-1">Total yang harus dibayar:</p>
                                            <p class="text-3xl font-bold text-[#193497] mb-6">
                                                <?php echo e($order->formatted_total ?? 'Rp ' . number_format($order->total_amount ?? $order->total, 0, ',', '.')); ?>

                                            </p>
                                        </div>
                                        
                                        <!-- Midtrans Payment Button -->
                                        <button id="pay-button" 
                                                class="w-full py-5 bg-gradient-to-r from-[#193497] to-[#0f2354] hover:from-[#0f2354] hover:to-[#193497] text-white font-bold rounded-xl text-xl transition-all duration-300 shadow-lg hover:shadow-2xl transform hover:scale-[1.02] active:scale-100 flex items-center justify-center group mb-4">
                                            <i class="fas fa-lock mr-4 text-xl"></i>
                                            Bayar dengan Midtrans
                                            <i class="fas fa-arrow-right ml-4 group-hover:translate-x-1 transition-transform"></i>
                                        </button>
                                        
                                        <p class="text-sm text-gray-500 text-center">
                                            Klik tombol di atas untuk membuka halaman pembayaran Midtrans
                                        </p>
                                    </div>
                                    
                                    <script src="https://app.sandbox.midtrans.com/snap/snap.js" 
                                            data-client-key="<?php echo e(config('services.midtrans.client_key')); ?>"></script>
                                    <script>
                                        document.getElementById('pay-button').onclick = function(){
                                            // Add loading state
                                            const button = this;
                                            const originalHTML = button.innerHTML;
                                            button.innerHTML = '<i class="fas fa-spinner fa-spin mr-3"></i> Memproses...';
                                            button.disabled = true;
                                            
                                            setTimeout(() => {
                                                snap.pay('<?php echo e($order->snap_token); ?>', {
                                                    onSuccess: function(result){
                                                        button.innerHTML = '<i class="fas fa-check mr-3"></i> Pembayaran Berhasil';
                                                        setTimeout(() => {
                                                            window.location.reload();
                                                        }, 2000);
                                                    },
                                                    onPending: function(result){
                                                        button.innerHTML = '<i class="fas fa-clock mr-3"></i> Menunggu Pembayaran';
                                                        setTimeout(() => {
                                                            window.location.reload();
                                                        }, 3000);
                                                    },
                                                    onError: function(result){
                                                        button.innerHTML = originalHTML;
                                                        button.disabled = false;
                                                        alert('Pembayaran gagal, silakan coba lagi.');
                                                    },
                                                    onClose: function(){
                                                        button.innerHTML = originalHTML;
                                                        button.disabled = false;
                                                    }
                                                });
                                            }, 500);
                                        };
                                    </script>
                                    
                                <?php elseif($payment): ?>
                                    <!-- QRIS Payment -->
                                    <div class="text-center">
                                        <div class="mb-8">
                                            <div class="w-20 h-20 bg-gradient-to-br from-[#193497] to-[#0f2354] rounded-2xl flex items-center justify-center mx-auto mb-4">
                                                <i class="fas fa-qrcode text-white text-3xl"></i>
                                            </div>
                                            <h4 class="text-2xl font-bold text-gray-900 mb-2">QRIS Payment</h4>
                                            <p class="text-gray-600 mb-1">Total yang harus dibayar:</p>
                                            <p class="text-3xl font-bold text-[#193497] mb-6">
                                                <?php echo e($order->formatted_total ?? 'Rp ' . number_format($order->total_amount ?? $order->total, 0, ',', '.')); ?>

                                            </p>
                                        </div>
                                        
                                        <!-- QR Code Display -->
                                        <div class="bg-gradient-to-br from-[#193497] to-[#0f2354] rounded-2xl p-6 mb-6">
                                            <div class="bg-white p-5 rounded-xl inline-block">
                                                <?php if($payment->qr_code): ?>
                                                    <img src="<?php echo e($payment->qr_code); ?>"
                                                         alt="QRIS Payment"
                                                         class="w-56 h-56 mx-auto"
                                                         id="qris-image">
                                                <?php else: ?>
                                                    <div class="w-56 h-56 bg-gray-100 flex items-center justify-center rounded-lg">
                                                        <div class="text-center">
                                                            <i class="fas fa-qrcode text-gray-400 text-5xl mb-3"></i>
                                                            <p class="text-gray-500 font-bold">QRIS Code</p>
                                                            <p class="text-sm text-gray-400 mt-1"><?php echo e($order->order_code ?? $order->order_number); ?></p>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <div class="mt-6">
                                                <p class="text-white font-bold text-xl mb-1">
                                                    <?php echo e($order->formatted_total ?? 'Rp ' . number_format($order->total_amount ?? $order->total, 0, ',', '.')); ?>

                                                </p>
                                                <p class="text-blue-200 text-sm">Order #<?php echo e($order->order_code ?? $order->order_number); ?></p>
                                            </div>
                                        </div>

                                        <!-- Payment Status -->
                                        <div id="payment-status" class="mb-6">
                                            <?php if($payment->status === 'paid'): ?>
                                            <div class="inline-flex items-center px-6 py-3 bg-green-100 text-green-700 rounded-xl font-bold text-lg">
                                                <i class="fas fa-check-circle mr-3 text-xl"></i>
                                                Pembayaran Berhasil
                                            </div>
                                            <?php elseif($payment->status === 'expired'): ?>
                                            <div class="inline-flex items-center px-6 py-3 bg-red-100 text-red-700 rounded-xl font-bold text-lg">
                                                <i class="fas fa-exclamation-triangle mr-3 text-xl"></i>
                                                Pembayaran Kadaluarsa
                                            </div>
                                            <?php else: ?>
                                            <div class="inline-flex items-center px-6 py-3 bg-yellow-100 text-yellow-700 rounded-xl font-bold text-lg">
                                                <i class="fas fa-clock mr-3 text-xl"></i>
                                                Menunggu Pembayaran
                                            </div>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Countdown Timer -->
                                        <?php if($payment->expired_at && $payment->status === 'pending'): ?>
                                        <div class="mb-8">
                                            <p class="text-gray-600 text-sm mb-3">Selesaikan dalam:</p>
                                            <div class="text-4xl font-bold text-[#193497] mb-2" id="countdown-timer">
                                                <?php echo e($payment->expired_at->diff(\Carbon\Carbon::now())->format('%H:%I:%S')); ?>

                                            </div>
                                            <p class="text-sm text-gray-500">Jam:Menit:Detik</p>
                                        </div>
                                        <?php endif; ?>

                                        <!-- Action Buttons -->
                                        <div class="space-y-4">
                                            <?php if($payment->status === 'pending'): ?>
                                            <button onclick="checkPaymentStatus()"
                                                    class="w-full py-4 bg-gradient-to-r from-[#193497] to-[#0f2354] hover:from-[#0f2354] hover:to-[#193497] text-white font-bold rounded-xl text-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-[1.02] active:scale-100 flex items-center justify-center group">
                                                <i class="fas fa-sync-alt mr-3 group-hover:rotate-180 transition-transform duration-500"></i>
                                                Cek Status Pembayaran
                                            </button>
                                            <?php endif; ?>

                                            <div class="grid grid-cols-2 gap-3">
                                                <a href="<?php echo e(route('orders.show', $order->id)); ?>"
                                                   class="py-3 border-2 border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-all flex items-center justify-center text-sm">
                                                    <i class="fas fa-arrow-left mr-2"></i>
                                                    Kembali
                                                </a>

                                                <?php if($payment && $payment->qr_url && $payment->qr_url !== '#'): ?>
                                                <a href="<?php echo e($payment->qr_url); ?>"
                                                   target="_blank"
                                                   class="py-3 border-2 border-[#d2f801] bg-[#d2f801] hover:bg-[#b8e001] text-gray-900 font-bold rounded-xl transition-all flex items-center justify-center text-sm">
                                                    <i class="fas fa-external-link-alt mr-2"></i>
                                                    Buka QR
                                                </a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Payment Instructions -->
                            <div class="p-8 bg-blue-50 border-t border-blue-100">
                                <h4 class="font-bold text-gray-900 mb-4 flex items-center">
                                    <i class="fas fa-info-circle text-[#193497] mr-3"></i>
                                    Petunjuk Pembayaran
                                </h4>
                                <ul class="space-y-3 text-sm text-gray-700">
                                    <?php if($order->snap_token): ?>
                                    <li class="flex items-start">
                                        <span class="bg-[#193497] text-white rounded-full w-5 h-5 flex items-center justify-center text-xs mr-3 mt-0.5 flex-shrink-0">1</span>
                                        <span>Klik tombol "Bayar dengan Midtrans" di atas</span>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="bg-[#193497] text-white rounded-full w-5 h-5 flex items-center justify-center text-xs mr-3 mt-0.5 flex-shrink-0">2</span>
                                        <span>Pilih metode pembayaran yang tersedia (Bank Transfer, E-wallet, dll)</span>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="bg-[#193497] text-white rounded-full w-5 h-5 flex items-center justify-center text-xs mr-3 mt-0.5 flex-shrink-0">3</span>
                                        <span>Ikuti instruksi pembayaran di halaman Midtrans</span>
                                    </li>
                                    <?php elseif($payment): ?>
                                    <li class="flex items-start">
                                        <span class="bg-[#193497] text-white rounded-full w-5 h-5 flex items-center justify-center text-xs mr-3 mt-0.5 flex-shrink-0">1</span>
                                        <span>Buka aplikasi e-wallet atau mobile banking Anda</span>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="bg-[#193497] text-white rounded-full w-5 h-5 flex items-center justify-center text-xs mr-3 mt-0.5 flex-shrink-0">2</span>
                                        <span>Pilih fitur pembayaran QRIS atau Scan QR</span>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="bg-[#193497] text-white rounded-full w-5 h-5 flex items-center justify-center text-xs mr-3 mt-0.5 flex-shrink-0">3</span>
                                        <span>Arahkan kamera ke QR Code di atas</span>
                                    </li>
                                    <?php endif; ?>
                                    <li class="flex items-start">
                                        <span class="bg-[#193497] text-white rounded-full w-5 h-5 flex items-center justify-center text-xs mr-3 mt-0.5 flex-shrink-0">4</span>
                                        <span>Status akan otomatis terupdate dalam 1-2 menit</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        <!-- Important Note -->
                        <div class="bg-yellow-50 border-2 border-yellow-200 rounded-2xl p-6">
                            <div class="flex items-start">
                                <i class="fas fa-exclamation-circle text-yellow-600 text-xl mr-3 mt-1"></i>
                                <div>
                                    <h4 class="font-bold text-yellow-800 mb-2">Penting!</h4>
                                    <ul class="text-sm text-yellow-700 space-y-1">
                                        <li>• Jangan refresh halaman saat proses pembayaran</li>
                                        <li>• Simpan bukti pembayaran Anda</li>
                                        <li>• Hubungi customer service jika ada kendala</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<?php if($payment): ?>
<script>
    // Fungsi untuk cek status pembayaran (hanya untuk QRIS)
    function checkPaymentStatus() {
        const statusElement = document.getElementById('payment-status');
        const button = event?.currentTarget;
        const countdownElement = document.getElementById('countdown-timer');

        if (button) {
            button.disabled = true;
            const originalHTML = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin mr-3"></i> Memeriksa...';
        }

        fetch(`/orders/<?php echo e($order->id); ?>/check-payment-status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (data.status === 'paid') {
                    statusElement.innerHTML = `
                        <div class="inline-flex items-center px-6 py-3 bg-green-100 text-green-700 rounded-xl font-bold text-lg">
                            <i class="fas fa-check-circle mr-3 text-xl"></i>
                            Pembayaran Berhasil
                        </div>
                    `;

                    // Hide countdown timer
                    if (countdownElement) {
                        countdownElement.style.display = 'none';
                    }

                    // Disable check button
                    if (button) {
                        button.disabled = true;
                        button.innerHTML = '<i class="fas fa-check mr-3"></i> Berhasil';
                        button.classList.remove('hover:scale-[1.02]', 'hover:shadow-xl');
                    }

                    // Show success message
                    showNotification('success', 'Pembayaran berhasil diverifikasi! Status pesanan akan diperbarui.');

                    // Redirect after 5 seconds
                    setTimeout(() => {
                        window.location.href = '<?php echo e(route("orders.show", $order->id)); ?>';
                    }, 5000);
                } else if (data.status === 'expired') {
                    statusElement.innerHTML = `
                        <div class="inline-flex items-center px-6 py-3 bg-red-100 text-red-700 rounded-xl font-bold text-lg">
                            <i class="fas fa-exclamation-triangle mr-3 text-xl"></i>
                            Pembayaran Kadaluarsa
                        </div>
                    `;
                    showNotification('error', 'Waktu pembayaran telah habis. Silakan buat pesanan baru.');
                    
                    if (button) {
                        button.disabled = true;
                        button.innerHTML = '<i class="fas fa-times mr-3"></i> Kadaluarsa';
                    }
                } else {
                    showNotification('info', 'Masih menunggu pembayaran. Silakan scan QR Code di atas.');
                }
            } else {
                showNotification('error', data.message || 'Gagal memeriksa status pembayaran.');
            }

            if (button && data.status !== 'paid' && data.status !== 'expired') {
                button.disabled = false;
                button.innerHTML = originalHTML || '<i class="fas fa-sync-alt mr-3"></i> Cek Status Pembayaran';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('error', 'Terjadi kesalahan saat memeriksa status.');

            if (button) {
                button.disabled = false;
                button.innerHTML = '<i class="fas fa-sync-alt mr-3"></i> Cek Status Pembayaran';
            }
        });
    }

    // Countdown timer (hanya untuk QRIS pending)
    <?php if($payment->expired_at && $payment->status === 'pending'): ?>
    function updateCountdown() {
        const expiredAt = new Date('<?php echo e($payment->expired_at->toIso8601String()); ?>').getTime();
        const now = new Date().getTime();
        const distance = expiredAt - now;

        if (distance < 0) {
            document.getElementById('countdown-timer').innerHTML = "00:00:00";
            document.getElementById('countdown-timer').classList.add('text-red-600');
            checkPaymentStatus();
            return;
        }

        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        const countdownElement = document.getElementById('countdown-timer');
        countdownElement.innerHTML = 
            `<span class="${hours < 1 ? 'text-red-600' : ''}">${hours.toString().padStart(2, '0')}</span>:<span class="${hours < 1 && minutes < 10 ? 'text-red-600' : ''}">${minutes.toString().padStart(2, '0')}</span>:<span class="${hours < 1 && minutes < 5 ? 'text-red-600' : ''}">${seconds.toString().padStart(2, '0')}</span>`;
    }

    // Update countdown every second
    const countdownInterval = setInterval(updateCountdown, 1000);
    updateCountdown(); // Initial call
    <?php endif; ?>

    // Auto-check payment status every 30 seconds (hanya untuk QRIS pending)
    <?php if($payment && $payment->status === 'pending'): ?>
    const autoCheckInterval = setInterval(checkPaymentStatus, 30000);
    <?php endif; ?>
    <?php endif; ?>

    // Notification function
    function showNotification(type, message) {
        // Remove existing notifications
        const existingNotifications = document.querySelectorAll('.custom-notification');
        existingNotifications.forEach(notification => notification.remove());

        const notification = document.createElement('div');
        notification.className = `custom-notification fixed top-6 right-6 z-50 p-5 rounded-xl shadow-2xl ${
            type === 'success' ? 'bg-green-100 border-2 border-green-300 text-green-800' :
            type === 'error' ? 'bg-red-100 border-2 border-red-300 text-red-800' :
            'bg-blue-100 border-2 border-blue-300 text-blue-800'
        }`;
        notification.innerHTML = `
            <div class="flex items-center">
                <i class="fas ${
                    type === 'success' ? 'fa-check-circle' :
                    type === 'error' ? 'fa-exclamation-circle' :
                    'fa-info-circle'
                } mr-4 text-2xl"></i>
                <div>
                    <p class="font-bold text-lg">${message}</p>
                    <div class="w-full h-1 bg-current opacity-30 mt-2 rounded-full">
                        <div class="h-full bg-current rounded-full animate-shrink"></div>
                    </div>
                </div>
            </div>
        `;
        
        // Add CSS for animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes shrink {
                from { width: 100%; }
                to { width: 0%; }
            }
            .animate-shrink {
                animation: shrink 5s linear forwards;
            }
        `;
        document.head.appendChild(style);
        
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.remove();
            style.remove();
        }, 5000);
    }

    // Initial check on page load (hanya untuk QRIS pending)
    document.addEventListener('DOMContentLoaded', function() {
        <?php if($payment && $payment->status === 'pending'): ?>
        setTimeout(checkPaymentStatus, 3000);
        <?php endif; ?>
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\revisiimaji\resources\views/pages/orders/payment.blade.php ENDPATH**/ ?>