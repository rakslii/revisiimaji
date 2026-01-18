<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;

class MidtransService
{
    public function __construct()
    {
        // Debug: Log credentials (REMOVE IN PRODUCTION!)
        \Log::info('Midtrans Config', [
            'server_key' => substr(config('services.midtrans.server_key'), 0, 20) . '...',
            'client_key' => substr(config('services.midtrans.client_key'), 0, 20) . '...',
            'is_production' => config('services.midtrans.is_production'),
        ]);

        // Set Midtrans Configuration
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$clientKey = config('services.midtrans.client_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = config('services.midtrans.is_sanitized');
        Config::$is3ds = config('services.midtrans.is_3ds');
        
        // Disable SSL verification for development/sandbox
        // REMOVE THIS IN PRODUCTION!
        Config::$curlOptions = [
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Accept: application/json'
            ],
        ];
    }

    public function createTransaction($order, $cartItems)
    {
        $transactionDetails = [
            'order_id' => $order->order_code,
            'gross_amount' => (int) $order->total,
        ];

        $itemDetails = [];
        foreach ($cartItems as $item) {
            $itemDetails[] = [
                'id' => $item->product_id,
                'price' => (int) $item->price,
                'quantity' => $item->quantity,
                'name' => substr($item->product->name, 0, 50),
            ];
        }

        if ($order->shipping_cost > 0) {
            $itemDetails[] = [
                'id' => 'shipping',
                'price' => (int) $order->shipping_cost,
                'quantity' => 1,
                'name' => 'Ongkos Kirim',
            ];
        }

        $customerDetails = [
            'first_name' => $order->customer_name,
            'email' => $order->customer_email,
            'phone' => $order->customer_phone,
            'billing_address' => [
                'address' => $order->shipping_address,
                'city' => $order->shipping_city,
                'postal_code' => $order->shipping_postal_code,
            ],
            'shipping_address' => [
                'address' => $order->shipping_address,
                'city' => $order->shipping_city,
                'postal_code' => $order->shipping_postal_code,
            ],
        ];

        // Untuk testing sandbox, gunakan semua payment methods dulu
        // Setelah QRIS aktif, bisa diubah jadi ['qris'] saja
        $params = [
            'transaction_details' => $transactionDetails,
            'item_details' => $itemDetails,
            'customer_details' => $customerDetails,
            // Jangan set enabled_payments dulu, biar semua payment muncul
            'enabled_payments' => ['gopay'],
        ];

        try {
            \Log::info('Creating Midtrans transaction', [
                'order_code' => $order->order_code,
                'amount' => $order->total
            ]);
            
            $snapToken = Snap::getSnapToken($params);
            
            \Log::info('Snap token created successfully', [
                'order_code' => $order->order_code,
                'snap_token' => substr($snapToken, 0, 20) . '...'
            ]);
            
            return $snapToken;
        } catch (\Exception $e) {
            \Log::error('Midtrans Error Details', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
}