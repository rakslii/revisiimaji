<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Location;
use App\Models\PromoCode;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService = null)
    {
        $this->middleware('auth:sanctum')->only(['userOrders', 'show', 'store', 'checkPromoCode']);
        $this->paymentService = $paymentService;
    }

    /**
     * ========== WEB METHODS ==========
     */

    /**
     * Display user orders for WEB
     */
    public function index()
    {
        // Use web guard (session) instead of sanctum
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $orders = Order::with(['items.product', 'payments', 'location'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pages.orders.index', [
            'orders' => $orders
        ]);
    }

    /**
     * Display order detail for WEB
     */
    public function showOrder($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $order = Order::with(['items.product', 'location', 'payments'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('pages.orders.show', [
            'order' => $order
        ]);
    }

    /**
     * Display payment page for order.
     */
    public function payment($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $order = Order::where('user_id', Auth::id())
            ->with(['items.product', 'payments'])
            ->findOrFail($id);

        // Jika ada snap_token (Midtrans), tampilkan dengan Midtrans
        if ($order->snap_token) {
            return view('pages.orders.payment', [
                'order' => $order,
                'snapToken' => $order->snap_token,
                'payment' => null,
            ]);
        }

        // Pastikan ada payment record untuk QRIS
        $payment = $order->payments()->latest()->first();

        if (!$payment) {
            // Buat payment record jika belum ada
            $payment = Payment::create([
                'order_id' => $order->id,
                'payment_method' => 'qris',
                'status' => Payment::STATUS_PENDING,
                'amount' => $order->total,
                'expired_at' => now()->addHours(1),
                'qr_code' => $this->generateQRCode($order),
                'qr_url' => '#',
                'external_id' => 'QR-' . $order->order_code . '-' . time(),
            ]);
        }

        return view('pages.orders.payment', compact('order', 'payment'));
    }

    /**
     * Check payment status.
     */
    public function checkPaymentStatus(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $order = Order::where('user_id', Auth::id())->findOrFail($id);
        $payment = $order->payments()->latest()->first();

        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'Payment record not found'
            ]);
        }

        // Di production, ini akan memanggil API payment gateway
        // Untuk demo, kita simulasikan random status update

        $status = $payment->status;

        // Simulasi: kadang-kadang status berubah menjadi paid
        if ($payment->status === Payment::STATUS_PENDING && rand(1, 10) === 1) {
            $status = Payment::STATUS_PAID;
            $payment->update([
                'status' => Payment::STATUS_PAID,
                'payment_data' => ['verified_at' => now()]
            ]);

            $order->update([
                'payment_status' => 'paid',
                'status' => 'processing',
                'paid_at' => now()
            ]);
        }

        // Simulasi: jika sudah expired
        if ($payment->expired_at && $payment->expired_at->isPast() && $payment->status === Payment::STATUS_PENDING) {
            $status = Payment::STATUS_EXPIRED;
            $payment->update(['status' => Payment::STATUS_EXPIRED]);
        }

        return response()->json([
            'success' => true,
            'status' => $status,
            'order_status' => $order->status,
            'payment_status' => $order->payment_status,
            'message' => 'Payment status checked successfully'
        ]);
    }

    /**
     * Generate QR code for order (demo version).
     */
    private function generateQRCode($order)
    {
        $orderCode = $order->order_code;
        $amount = $order->total;

        // Untuk demo: generate QR code dengan data order
        // Di production, ini akan datang dari Midtrans/Xendit/dll
        $qrData = "Order: {$orderCode}|Amount: {$amount}|Date: " . now()->format('YmdHis');

        // Menggunakan QR code generator online untuk demo
        return "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($qrData);
    }

    /**
     * Create new order
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'location_id' => 'required|exists:locations,id',
            'promo_code' => 'nullable|string',
            'notes' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        return DB::transaction(function () use ($request) {
            $user = Auth::user();

            // Validate location belongs to user
            $location = Location::where('id', $request->location_id)
                ->where('user_id', $user->id)
                ->firstOrFail();

            // Calculate totals
            $items = $request->items;
            $totalAmount = 0;
            $orderItems = [];

            foreach ($items as $itemData) {
                $product = Product::active()->findOrFail($itemData['product_id']);

                // Check stock
                if ($product->stock < $itemData['quantity']) {
                    throw new \Exception("Stok produk {$product->name} tidak mencukupi");
                }

                // Check minimum order
                if ($product->min_order > $itemData['quantity']) {
                    throw new \Exception("Minimal order untuk {$product->name} adalah {$product->min_order}");
                }

                $price = $product->price;
                $itemTotal = $price * $itemData['quantity'];
                $totalAmount += $itemTotal;

                $orderItems[] = [
                    'product_id' => $product->id,
                    'quantity' => $itemData['quantity'],
                    'price' => $price,
                    'total' => $itemTotal,
                ];
            }

            // Apply promo code
            $discountAmount = 0;
            $promoCodeId = null;

            if ($request->promo_code) {
                $promoCode = PromoCode::where('code', $request->promo_code)->first();

                if ($promoCode && $promoCode->isValid()) {
                    $discountAmount = $promoCode->applyTo($totalAmount);
                    $promoCodeId = $promoCode->id;
                    $promoCode->markAsUsed();
                }
            }

            $finalAmount = max(0, $totalAmount - $discountAmount);

            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => Order::generateOrderNumber(),
                'total_amount' => $totalAmount,
                'discount_amount' => $discountAmount,
                'final_amount' => $finalAmount,
                'promo_code_id' => $promoCodeId,
                'location_id' => $location->id,
                'status' => Order::STATUS_PENDING,
                'payment_status' => Order::PAYMENT_PENDING,
                'notes' => $request->notes,
            ]);

            // Create order items
            foreach ($orderItems as $itemData) {
                $order->items()->create($itemData);

                // Update product stock and sales count
                $product = Product::find($itemData['product_id']);
                $product->decrement('stock', $itemData['quantity']);
                $product->increment('sales_count');
            }

            // Create QRIS payment
            if ($this->paymentService) {
                $payment = $this->paymentService->createQRISPayment($order);
            } else {
                // Fallback jika payment service tidak tersedia
                $payment = Payment::create([
                    'order_id' => $order->id,
                    'payment_method' => 'qris',
                    'status' => Payment::STATUS_PENDING,
                    'amount' => $finalAmount,
                    'expired_at' => now()->addHours(1),
                    'qr_code' => $this->generateQRCode($order),
                    'qr_url' => '#',
                    'external_id' => 'QR-' . $order->order_number . '-' . time(),
                ]);
            }

            return response()->json([
                'message' => 'Order berhasil dibuat',
                'order' => $order->load(['items.product', 'location', 'payments']),
                'payment' => $payment,
            ], 201);
        });
    }

    /**
     * Check promo code validity
     */
    public function checkPromoCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string',
            'total_amount' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $promoCode = PromoCode::where('code', $request->code)->first();

        if (!$promoCode || !$promoCode->isValid()) {
            return response()->json([
                'valid' => false,
                'message' => 'Kode promo tidak valid atau sudah kadaluarsa',
            ]);
        }

        if ($promoCode->min_purchase && $request->total_amount < $promoCode->min_purchase) {
            return response()->json([
                'valid' => false,
                'message' => 'Minimal pembelian Rp ' . number_format($promoCode->min_purchase, 0, ',', '.'),
            ]);
        }

        $discount = $promoCode->applyTo($request->total_amount);

        return response()->json([
            'valid' => true,
            'promo' => [
                'id' => $promoCode->id,
                'code' => $promoCode->code,
                'name' => $promoCode->name,
                'type' => $promoCode->type,
                'value' => $promoCode->value,
                'discount' => $discount,
                'min_purchase' => $promoCode->min_purchase,
            ],
            'discount' => $discount,
            'message' => 'Kode promo berhasil diterapkan',
        ]);
    }
}
