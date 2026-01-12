<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\PromoCode;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function __construct(
        private PaymentService $paymentService
    ) {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        }
        
        $cartItems = [];
        $subtotal = 0;
        
        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            if ($product && $product->is_active) {
                $itemTotal = $product->price * $item['quantity'];
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'total' => $itemTotal
                ];
                $subtotal += $itemTotal;
            }
        }
        
        // Apply promo code if exists
        $discount = 0;
        $promoCode = null;
        
        if ($request->has('promo_code')) {
            $promoCode = PromoCode::where('code', $request->promo_code)
                ->where('is_active', true)
                ->where('valid_from', '<=', now())
                ->where('valid_until', '>=', now())
                ->where('used_count', '<', DB::raw('quota'))
                ->first();
                
            if ($promoCode && $subtotal >= ($promoCode->min_purchase ?? 0)) {
                if ($promoCode->type === 'percentage') {
                    $discount = ($subtotal * $promoCode->value) / 100;
                } else {
                    $discount = $promoCode->value;
                }
            }
        }
        
        // Shipping cost (simple calculation)
        $shippingCost = 10000; // Flat rate for now
        $total = $subtotal - $discount + $shippingCost;
        
        // User locations
        $user = auth()->user();
        $locations = $user->locations()->orderBy('is_primary', 'desc')->get();
        $userLocation = $locations->first(); // Ambil alamat utama/pertama

        return view('checkout.index', compact(
            'cartItems', 
            'subtotal', 
            'discount', 
            'shippingCost', 
            'total',
            'locations',
            'promoCode',
            'user',
            'userLocation'
        ));
    }

    public function process(Request $request)
    {
        $request->validate([
            'location_id' => 'required|exists:locations,id',
            'shipping_note' => 'nullable|string|max:500'
        ]);
        
        DB::beginTransaction();
        
        try {
            $cart = session()->get('cart', []);
            $user = auth()->user();
            $location = $user->locations()->findOrFail($request->location_id);
            
            // Calculate order total
            $subtotal = 0;
            foreach ($cart as $productId => $item) {
                $product = Product::findOrFail($productId);
                $subtotal += $product->price * $item['quantity'];
            }
            
            $shippingCost = 10000;
            $discount = 0;
            $promoCode = null;
            
            // Check promo code
            if ($request->has('promo_code')) {
                $promoCode = PromoCode::where('code', $request->promo_code)
                    ->where('is_active', true)
                    ->where('valid_from', '<=', now())
                    ->where('valid_until', '>=', now())
                    ->where('used_count', '<', DB::raw('quota'))
                    ->first();
                    
                if ($promoCode && $subtotal >= ($promoCode->min_purchase ?? 0)) {
                    if ($promoCode->type === 'percentage') {
                        $discount = ($subtotal * $promoCode->value) / 100;
                    } else {
                        $discount = $promoCode->value;
                    }
                    
                    // Increment used count
                    $promoCode->increment('used_count');
                }
            }
            
            $total = $subtotal - $discount + $shippingCost;
            
            // Create order
            $order = Order::create([
                'order_code' => 'CI-' . time() . '-' . rand(100, 999),
                'user_id' => $user->id,
                'shipping_address' => $location->full_address,
                'shipping_note' => $request->shipping_note,
                'latitude' => $location->latitude,
                'longitude' => $location->longitude,
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'discount' => $discount,
                'total' => $total,
                'status' => 'waiting_payment',
                'promo_code' => $promoCode?->code,
            ]);
            
            // Create order items
            foreach ($cart as $productId => $item) {
                $product = Product::findOrFail($productId);
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'total' => $product->price * $item['quantity'],
                ]);
                
                // Reduce stock
                $product->decrement('stock', $item['quantity']);
            }
            
            // Create payment
            $payment = $this->paymentService->createQrisPayment($order);
            
            // Clear cart
            session()->forget('cart');
            
            DB::commit();
            
            return redirect()->route('checkout.success', $order)->with('success', 'Pesanan berhasil dibuat!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Checkout Error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat proses checkout: ' . $e->getMessage());
        }
    }

    public function success(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        
        $payment = $order->payment;
        
        return view('checkout.success', compact('order', 'payment'));
    }
}