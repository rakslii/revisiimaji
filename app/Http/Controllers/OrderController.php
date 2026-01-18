<?php

namespace App\Http\Controllers;

use App\Models\Order;
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

    public function payment($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $order = Order::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        if (!$order->snap_token) {
            return redirect()
                ->route('orders.show', $order->id)
                ->with('error', 'Token pembayaran belum tersedia');
        }

        return view('pages.orders.payment', [
            'order' => $order,
            'snapToken' => $order->snap_token,
        ]);
    }



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

        $orders = Order::with(['items.product', 'payment', 'location'])
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

        $order = Order::with(['items.product', 'location', 'payment'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('pages.orders.show', [
            'order' => $order
        ]);
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
            $payment = $this->paymentService->createQRISPayment($order);

            return response()->json([
                'message' => 'Order berhasil dibuat',
                'order' => $order->load(['items.product', 'location', 'payment']),
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
