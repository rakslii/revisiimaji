<!-- resources/views/pages/admin/orders/pdf/address.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Alamat Pengiriman - Order #{{ $order->order_code }}</title>
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
        <div class="subtitle">Order #{{ $order->order_code }}</div>
    </div>
    
    <!-- Info Order -->
    <div class="section">
        <div class="section-title">INFORMASI ORDER</div>
        <div class="info-row">
            <span class="label">No. Order:</span>
            <span class="value">{{ $order->order_code }}</span>
        </div>
        <div class="info-row">
            <span class="label">Tanggal:</span>
            <span class="value">{{ $order->created_at->format('d F Y H:i') }}</span>
        </div>
        <div class="info-row">
            <span class="label">Status:</span>
            <span class="value">{{ strtoupper(str_replace('_', ' ', $order->status)) }}</span>
        </div>
    </div>
    
    <!-- Info Customer -->
    <div class="section">
        <div class="section-title">DATA PENERIMA</div>
        <div class="info-row">
            <span class="label">Nama:</span>
            <span class="value">{{ $order->user->name ?? $order->location->recipient_name ?? 'N/A' }}</span>
        </div>
        <div class="info-row">
            <span class="label">Telepon:</span>
            <span class="value">{{ $order->user->phone ?? $order->location->recipient_phone ?? 'N/A' }}</span>
        </div>
        <div class="info-row">
            <span class="label">Email:</span>
            <span class="value">{{ $order->user->email ?? 'N/A' }}</span>
        </div>
    </div>
    
    <!-- Alamat Pengiriman -->
    <div class="section">
        <div class="section-title">ALAMAT PENGIRIMAN</div>
        @if($order->location)
        <div class="info-row">
            <span class="label">Alamat Lengkap:</span>
            <span class="value">{{ $order->location->full_address }}</span>
        </div>
        <div class="info-row">
            <span class="label">Kota/Kabupaten:</span>
            <span class="value">{{ $order->location->city }}</span>
        </div>
        <div class="info-row">
            <span class="label">Provinsi:</span>
            <span class="value">{{ $order->location->province }}</span>
        </div>
        <div class="info-row">
            <span class="label">Kode Pos:</span>
            <span class="value">{{ $order->location->postal_code }}</span>
        </div>
        <div class="info-row">
            <span class="label">Jenis Alamat:</span>
            <span class="value">{{ $order->location->name }} {{ $order->location->is_primary ? '(Utama)' : '' }}</span>
        </div>
        @elseif($order->shipping_address)
        <div class="info-row">
            <span class="label">Alamat:</span>
            <span class="value">{{ $order->shipping_address }}</span>
        </div>
        @if($order->shipping_note)
        <div class="info-row">
            <span class="label">Catatan:</span>
            <span class="value">{{ $order->shipping_note }}</span>
        </div>
        @endif
        @else
        <div class="info-row">
            <span class="value">Alamat tidak tersedia</span>
        </div>
        @endif
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
                @foreach($order->items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->product->name ?? 'Produk tidak ditemukan' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align: right; font-weight: bold;">Total:</td>
                    <td style="font-weight: bold;">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
    
    <!-- Notes -->
    @if($order->notes)
    <div class="section">
        <div class="section-title">CATATAN ORDER</div>
        <div class="notes">{{ $order->notes }}</div>
    </div>
    @endif
    
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
        <div style="margin: 10px 0;">[QR CODE FOR ORDER #{{ $order->order_code }}]</div>
        <small>Scan untuk verifikasi order</small>
    </div>
    
    <div class="footer">
        Dokumen ini dicetak pada {{ date('d F Y H:i:s') }}<br>
        {{ config('app.name') }} - Delivery Address
    </div>
</body>
</html>