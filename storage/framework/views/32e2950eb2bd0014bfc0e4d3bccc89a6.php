

<?php $__env->startSection('title', 'Pembayaran - Cipta Imaji'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-gradient-to-b from-gray-50 to-white min-h-screen">
    <!-- Hero Section -->
    <div class="relative bg-[#193497] text-white overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-[#d2f801] rounded-full opacity-10 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-[#193497] rounded-full opacity-10 blur-3xl"></div>

        <div class="container mx-auto px-4 py-8 md:py-12 relative z-10">
            <div class="max-w-4xl">
                <h1 class="text-3xl md:text-5xl font-bold mb-3 leading-tight">
                    <i class="fas fa-credit-card text-[#d2f801] mr-3"></i>
                    Pembayaran <span class="text-[#d2f801]">QRIS</span>
                </h1>
                <p class="text-lg md:text-xl opacity-90">
                    Scan QRIS untuk menyelesaikan pembayaran
                </p>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8 md:py-12">
        <div class="max-w-4xl mx-auto">
            <!-- Order Info -->
            <div class="bg-white rounded-3xl shadow-xl p-6 md:p-8 border border-gray-100 mb-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Order #<?php echo e($order->order_code); ?></h2>
                        <p class="text-gray-600"><?php echo e($order->created_at->format('d M Y, H:i')); ?></p>
                    </div>
                    <div class="text-right">
                        <p class="text-gray-600 text-sm mb-1">Total Pembayaran</p>
                        <p class="text-3xl font-bold text-[#193497]">Rp <?php echo e(number_format($order->total, 0, ',', '.')); ?></p>
                    </div>
                </div>

                <!-- Payment Status -->
                <div id="paymentStatus" class="mb-6">
                    <?php if($order->payment_status === 'unpaid'): ?>
                        <div class="bg-yellow-50 border-2 border-yellow-200 rounded-xl p-4">
                            <div class="flex items-center">
                                <i class="fas fa-clock text-yellow-500 text-2xl mr-4"></i>
                                <div>
                                    <h3 class="text-yellow-800 font-bold text-lg">Menunggu Pembayaran</h3>
                                    <p class="text-yellow-700 text-sm">Silakan scan QRIS untuk melanjutkan pembayaran</p>
                                </div>
                            </div>
                        </div>
                    <?php elseif($order->payment_status === 'paid'): ?>
                        <div class="bg-green-50 border-2 border-green-200 rounded-xl p-4">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 text-2xl mr-4"></i>
                                <div>
                                    <h3 class="text-green-800 font-bold text-lg">Pembayaran Berhasil</h3>
                                    <p class="text-green-700 text-sm">Terima kasih, pembayaran Anda telah diterima</p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Midtrans Snap -->
                <div id="snap-container" class="mb-6"></div>

                <button id="pay-button" 
                        class="w-full py-4 bg-gradient-to-r from-[#193497] to-[#2547c9] text-white font-bold rounded-xl hover:shadow-lg transition-all duration-300 flex items-center justify-center gap-2">
                    <i class="fas fa-qrcode"></i>
                    Bayar dengan QRIS
                </button>

                <!-- Instructions -->
                <div class="mt-6 bg-blue-50 rounded-xl p-4">
                    <h3 class="font-bold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-info-circle text-[#193497] mr-2"></i>
                        Cara Pembayaran:
                    </h3>
                    <ol class="list-decimal list-inside space-y-2 text-gray-700 text-sm">
                        <li>Klik tombol "Bayar dengan QRIS"</li>
                        <li>Scan QR Code menggunakan aplikasi mobile banking atau e-wallet Anda</li>
                        <li>Konfirmasi pembayaran di aplikasi</li>
                        <li>Tunggu konfirmasi pembayaran berhasil</li>
                    </ol>
                </div>

                <!-- Order Items -->
                <div class="mt-6 border-t pt-6">
                    <h3 class="font-bold text-gray-800 mb-4">Detail Pesanan:</h3>
                    <div class="space-y-3">
                        <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-3">
                                    <?php if($item->product && $item->product->image_url): ?>
                                        <img src="<?php echo e($item->product->image_url); ?>" 
                                             alt="<?php echo e($item->product_name); ?>" 
                                             class="w-12 h-12 object-cover rounded-lg">
                                    <?php endif; ?>
                                    <div>
                                        <p class="font-semibold text-gray-800"><?php echo e($item->product_name); ?></p>
                                        <p class="text-sm text-gray-600"><?php echo e($item->quantity); ?> x Rp <?php echo e(number_format($item->price, 0, ',', '.')); ?></p>
                                    </div>
                                </div>
                                <p class="font-bold text-gray-800">Rp <?php echo e(number_format($item->subtotal, 0, ',', '.')); ?></p>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <div class="mt-4 pt-4 border-t space-y-2">
                        <div class="flex justify-between text-gray-700">
                            <span>Subtotal</span>
                            <span>Rp <?php echo e(number_format($order->subtotal, 0, ',', '.')); ?></span>
                        </div>
                        <div class="flex justify-between text-gray-700">
                            <span>Ongkos Kirim</span>
                            <span>Rp <?php echo e(number_format($order->shipping_cost, 0, ',', '.')); ?></span>
                        </div>
                        <?php if($order->discount > 0): ?>
                            <div class="flex justify-between text-green-600">
                                <span>Diskon</span>
                                <span>- Rp <?php echo e(number_format($order->discount, 0, ',', '.')); ?></span>
                            </div>
                        <?php endif; ?>
                        <div class="flex justify-between text-xl font-bold text-gray-800 pt-2 border-t">
                            <span>Total</span>
                            <span class="text-[#193497]">Rp <?php echo e(number_format($order->total, 0, ',', '.')); ?></span>
                        </div>
                    </div>
                </div>

                <!-- Back Button -->
                <div class="mt-6 flex gap-3">
                    <a href="<?php echo e(route('orders.show', $order->id)); ?>" 
                       class="flex-1 py-3 bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold rounded-xl transition-all text-center">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Detail Pesanan
                    </a>
                    <button id="checkStatus" 
                            class="flex-1 py-3 bg-blue-100 hover:bg-blue-200 text-blue-800 font-semibold rounded-xl transition-all">
                        <i class="fas fa-sync-alt mr-2"></i>
                        Cek Status Pembayaran
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?php echo e(config('services.midtrans.client_key')); ?>"></script>

<script>
    const payButton = document.getElementById('pay-button');
    const checkStatusBtn = document.getElementById('checkStatus');
    const snapToken = '<?php echo e($order->snap_token); ?>';
    const orderId = '<?php echo e($order->id); ?>';

    // Pay Button Click
    payButton.addEventListener('click', function() {
        snap.pay(snapToken, {
            onSuccess: function(result) {
                console.log('Payment success:', result);
                checkPaymentStatus();
            },
            onPending: function(result) {
                console.log('Payment pending:', result);
                alert('Pembayaran sedang diproses. Silakan selesaikan pembayaran Anda.');
            },
            onError: function(result) {
                console.log('Payment error:', result);
                alert('Terjadi kesalahan saat memproses pembayaran.');
            },
            onClose: function() {
                console.log('Payment popup closed');
            }
        });
    });

    // Check Status Button
    checkStatusBtn.addEventListener('click', function() {
        checkPaymentStatus();
    });

    // Auto check status every 5 seconds if unpaid
    <?php if($order->payment_status === 'unpaid'): ?>
        setInterval(function() {
            checkPaymentStatus(true);
        }, 5000);
    <?php endif; ?>

    function checkPaymentStatus(silent = false) {
        if (!silent) {
            checkStatusBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengecek...';
            checkStatusBtn.disabled = true;
        }

        fetch(`/orders/${orderId}/check-payment-status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (data.payment_status === 'paid') {
                    // Update UI
                    document.getElementById('paymentStatus').innerHTML = `
                        <div class="bg-green-50 border-2 border-green-200 rounded-xl p-4">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 text-2xl mr-4"></i>
                                <div>
                                    <h3 class="text-green-800 font-bold text-lg">Pembayaran Berhasil</h3>
                                    <p class="text-green-700 text-sm">Terima kasih, pembayaran Anda telah diterima</p>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    payButton.innerHTML = '<i class="fas fa-check mr-2"></i>Pembayaran Berhasil';
                    payButton.disabled = true;
                    payButton.classList.remove('from-[#193497]', 'to-[#2547c9]');
                    payButton.classList.add('bg-green-500');

                    // Redirect after 2 seconds
                    setTimeout(() => {
                        window.location.href = `/orders/${orderId}`;
                    }, 2000);
                }
            }
        })
        .catch(error => {
            console.error('Error checking payment status:', error);
        })
        .finally(() => {
            if (!silent) {
                checkStatusBtn.innerHTML = '<i class="fas fa-sync-alt mr-2"></i>Cek Status Pembayaran';
                checkStatusBtn.disabled = false;
            }
        });
    }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\revisiimaji\resources\views\pages\orders\payment.blade.php ENDPATH**/ ?>