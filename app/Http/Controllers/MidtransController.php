<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
    }

    public function notification(Request $request)
    {
        try {
            $notification = new Notification();

            $transactionStatus = $notification->transaction_status;
            $fraudStatus = $notification->fraud_status ?? null;
            $orderId = $notification->order_id;

            \Log::info('Midtrans Notification', [
                'order_id' => $orderId,
                'transaction_status' => $transactionStatus,
                'fraud_status' => $fraudStatus
            ]);

            // Find order
            $order = Order::where('order_code', $orderId)->first();

            if (!$order) {
                \Log::error('Order not found: ' . $orderId);
                return response()->json(['message' => 'Order not found'], 404);
            }

            // Handle transaction status
            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'accept') {
                    $order->update([
                        'payment_status' => 'paid',
                        'status' => 'processing'
                    ]);
                }
            } else if ($transactionStatus == 'settlement') {
                $order->update([
                    'payment_status' => 'paid',
                    'status' => 'processing'
                ]);
            } else if ($transactionStatus == 'pending') {
                $order->update([
                    'payment_status' => 'unpaid'
                ]);
            } else if ($transactionStatus == 'deny') {
                $order->update([
                    'payment_status' => 'failed'
                ]);
            } else if ($transactionStatus == 'expire') {
                $order->update([
                    'payment_status' => 'expired'
                ]);
            } else if ($transactionStatus == 'cancel') {
                $order->update([
                    'payment_status' => 'cancelled'
                ]);
            }

            return response()->json(['message' => 'Notification handled successfully']);

        } catch (\Exception $e) {
            \Log::error('Midtrans Notification Error: ' . $e->getMessage());
            return response()->json(['message' => 'Error processing notification'], 500);
        }
    }
}