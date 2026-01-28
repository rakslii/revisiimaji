<!-- resources/views/pages/admin/orders/pdf/address.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Alamat Pengiriman - Order #<?php echo e($order->order_code); ?></title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .title { font-size: 18px; font-weight: bold; margin-bottom: 5px; }
        .subtitle { font-size: 14px; color: #666; margin-bottom: 20px; }
        .section { margin-bottom: 15px; }
        .section-title { font-weight: bold; font-size: 14px; margin-bottom: 5px; border-bottom: 1px solid #ddd; padding-bottom: 3px; }
        .info-row { margin-bottom: 5px; }
        .label { font-weight: bold; display: inline-block; width: 120px; }
        .value { display: inline-block; }
        .table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        .table th { background-color: #f8f9fa; border: 1px solid #dee2e6; padding: 8px; text-align: left; }
        .table td { border: 1px solid #dee2e6; padding: 8px; }
        .notes { margin-top: 20px; padding: 10px; background-color: #f8f9fa; border-radius: 5px; }
        .footer { margin-top: 30px; font-size: 10px; color: #666; text-align: center; }
        .qr-code { text-align: center; margin: 20px 0; }
        .instructions { margin-top: 15px; padding: 10px; border: 1px dashed #ddd; background-color: #fff8e1; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">ALAMAT PENGIRIMAN</div>
        <div class="subtitle">Order #<?php echo e($order->order_code); ?></div>
    </div>
    
    <!-- Info Order -->
    <div class="section">
        <div class="section-title">INFORMASI ORDER</div>
        <div class="info-row">
            <span class="label">No. Order:</span>
            <span class="value"><?php echo e($order->order_code); ?></span>
        </div>
        <div class="info-row">
            <span class="label">Tanggal:</span>
            <span class="value"><?php echo e($order->created_at->format('d F Y H:i')); ?></span>
        </div>
        <div class="info-row">
            <span class="label">Status:</span>
            <span class="value"><?php echo e(strtoupper(str_replace('_', ' ', $order->status))); ?></span>
        </div>
    </div>
    
    <!-- Info Customer -->
    <div class="section">
        <div class="section-title">DATA PENERIMA</div>
        <div class="info-row">
            <span class="label">Nama:</span>
            <span class="value"><?php echo e($order->user->name ?? $order->location->recipient_name ?? 'N/A'); ?></span>
        </div>
        <div class="info-row">
            <span class="label">Telepon:</span>
            <span class="value"><?php echo e($order->user->phone ?? $order->location->recipient_phone ?? 'N/A'); ?></span>
        </div>
        <div class="info-row">
            <span class="label">Email:</span>
            <span class="value"><?php echo e($order->user->email ?? 'N/A'); ?></span>
        </div>
    </div>
    
    <!-- Alamat Pengiriman -->
    <div class="section">
        <div class="section-title">ALAMAT PENGIRIMAN</div>
        <?php if($order->location): ?>
        <div class="info-row">
            <span class="label">Alamat Lengkap:</span>
            <span class="value"><?php echo e($order->location->full_address); ?></span>
        </div>
        <div class="info-row">
            <span class="label">Kota/Kabupaten:</span>
            <span class="value"><?php echo e($order->location->city); ?></span>
        </div>
        <div class="info-row">
            <span class="label">Provinsi:</span>
            <span class="value"><?php echo e($order->location->province); ?></span>
        </div>
        <div class="info-row">
            <span class="label">Kode Pos:</span>
            <span class="value"><?php echo e($order->location->postal_code); ?></span>
        </div>
        <div class="info-row">
            <span class="label">Jenis Alamat:</span>
            <span class="value"><?php echo e($order->location->name); ?> <?php echo e($order->location->is_primary ? '(Utama)' : ''); ?></span>
        </div>
        <?php elseif($order->shipping_address): ?>
        <div class="info-row">
            <span class="label">Alamat:</span>
            <span class="value"><?php echo e($order->shipping_address); ?></span>
        </div>
        <?php if($order->shipping_note): ?>
        <div class="info-row">
            <span class="label">Catatan:</span>
            <span class="value"><?php echo e($order->shipping_note); ?></span>
        </div>
        <?php endif; ?>
        <?php else: ?>
        <div class="info-row">
            <span class="value">Alamat tidak tersedia</span>
        </div>
        <?php endif; ?>
    </div>
    
    <!-- Daftar Barang -->
    <div class="section">
        <div class="section-title">DAFTAR BARANG</div>
        <table class="table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Produk</th>
                    <th width="15%">Qty</th>
                    <th width="20%">Harga</th>
                    <th width="20%">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($index + 1); ?></td>
                    <td><?php echo e($item->product->name ?? 'Produk tidak ditemukan'); ?></td>
                    <td><?php echo e($item->quantity); ?></td>
                    <td>Rp <?php echo e(number_format($item->price, 0, ',', '.')); ?></td>
                    <td>Rp <?php echo e(number_format($item->total, 0, ',', '.')); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align: right; font-weight: bold;">Total:</td>
                    <td style="font-weight: bold;">Rp <?php echo e(number_format($order->total, 0, ',', '.')); ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
    
    <!-- Notes -->
    <?php if($order->notes): ?>
    <div class="section">
        <div class="section-title">CATATAN ORDER</div>
        <div class="notes"><?php echo e($order->notes); ?></div>
    </div>
    <?php endif; ?>
    
    <!-- Instructions for Courier -->
    <div class="instructions">
        <strong>PETUNJUK UNTUK KURIR:</strong><br>
        1. Konfirmasi penerimaan paket dengan penerima<br>
        2. Minta tanda tangan penerima pada bukti pengiriman<br>
        3. Jika penerima tidak ada, hubungi nomor di atas<br>
        4. Laporkan masalah pengiriman ke dispatch center
    </div>
    
    <!-- QR Code (optional) -->
    <div class="qr-code">
        <!-- You can add QR code here using a library -->
        <div style="margin: 10px 0;">[QR CODE FOR ORDER #<?php echo e($order->order_code); ?>]</div>
        <small>Scan untuk verifikasi order</small>
    </div>
    
    <div class="footer">
        Dokumen ini dicetak pada <?php echo e(date('d F Y H:i:s')); ?><br>
        <?php echo e(config('app.name')); ?> - Delivery Address
    </div>
</body>
</html><?php /**PATH C:\laragon\www\IMAJI\revisiimaji\resources\views\pages\admin\orders\pdf\address.blade.php ENDPATH**/ ?>