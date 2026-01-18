<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    protected $midtrans;

    public function __construct(MidtransService $midtrans)
    {
        $this->middleware('auth')->only(['checkout', 'processCheckout']);
        $this->midtrans = $midtrans;
    }

    public function index()
    {
        $cart = Cart::getCurrentCart();
        $items = $cart->items()->with('product')->get();

        $subtotal = 0;
        $cartItems = [];

        foreach ($items as $item) {
            if ($item->product && $item->product->is_active) {
                $itemTotal = $item->price * $item->quantity;
                $cartItems[] = [
                    'item' => $item,
                    'product' => $item->product,
                    'quantity' => $item->quantity,
                    'total' => $itemTotal,
                    'available' => $item->isAvailable(),
                    'message' => $item->getAvailabilityMessage()
                ];
                $subtotal += $itemTotal;
            }
        }

        return view('pages.cart.index', compact('cartItems', 'subtotal', 'cart'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->stock
        ]);

        if (!$product->is_active) {
            return redirect()->back()->with('error', 'Produk tidak tersedia.');
        }

        if ($product->stock < $request->quantity) {
            return redirect()->back()->with('error', 'Stok tidak cukup.');
        }

        $cart = Cart::getCurrentCart();
        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        if ($cartItem) {
            $newQty = $cartItem->quantity + $request->quantity;
            if ($newQty > $product->stock) {
                return redirect()->back()->with('error', 'Stok tidak cukup untuk menambah jumlah ini.');
            }
            $cartItem->update(['quantity' => $newQty]);
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->price
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = Cart::getCurrentCart();
        $item = $cart->items()->findOrFail($itemId);
        $product = $item->product;

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan.'
            ], 404);
        }

        if ($request->quantity > $product->stock) {
            return response()->json([
                'success' => false,
                'message' => 'Stok hanya tersisa ' . $product->stock
            ], 400);
        }

        $item->update(['quantity' => $request->quantity]);

        // Hitung ulang total
        $cart = $cart->fresh();
        $items = $cart->items()->with('product')->get();

        $subtotal = 0;
        foreach ($items as $cartItem) {
            if ($cartItem->product && $cartItem->product->is_active) {
                $subtotal += $cartItem->price * $cartItem->quantity;
            }
        }

        $shipping = 15000;
        $grandTotal = $subtotal + $shipping;
        $itemTotal = $item->price * $item->quantity;

        return response()->json([
            'success' => true,
            'item_total' => 'Rp ' . number_format($itemTotal, 0, ',', '.'),
            'subtotal' => 'Rp ' . number_format($subtotal, 0, ',', '.'),
            'grand_total' => 'Rp ' . number_format($grandTotal, 0, ',', '.'),
            'cart_count' => $cart->total_items
        ]);
    }

    public function remove($itemId)
    {
        $cart = Cart::getCurrentCart();
        $item = $cart->items()->find($itemId);

        if ($item) {
            $item->delete();
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil dihapus dari keranjang.');
    }

    public function clear()
    {
        $cart = Cart::getCurrentCart();
        $cart->items()->delete();

        return redirect()->route('cart.index')->with('success', 'Keranjang berhasil dikosongkan.');
    }

    public function checkout()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $cart = Cart::getCurrentCart();
        $cartItems = $cart->items()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong.');
        }

        // Check unavailable items
        $unavailableItems = [];
        foreach ($cartItems as $item) {
            if (!$item->isAvailable()) {
                $unavailableItems[] = $item->product->name . ' - ' . $item->getAvailabilityMessage();
            }
        }

        if (!empty($unavailableItems)) {
            return redirect()->route('cart.index')
                ->with('error', 'Beberapa produk tidak tersedia')
                ->with('unavailable', $unavailableItems);
        }

        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item->price * $item->quantity;
        }

        $discount = 0;
        $total = $subtotal - $discount;

        // FIX: Pastikan user dan userLocation ada
        $user = Auth::user();
        $userLocation = null; // Set default jika tidak ada lokasi tersimpan

        return view('pages.cart.checkout', compact('cartItems', 'subtotal', 'discount', 'total', 'user', 'userLocation'));
    }

    public function processCheckout(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'shipping_method' => 'required|in:pickup,delivery,cargo',
            'design_files.*' => 'nullable|file|max:10240',
            'design_notes' => 'nullable|string|max:1000',
            'notes' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();

        try {
            $cart = Cart::getCurrentCart();
            $cartItems = $cart->items()->with('product')->get();

            if ($cartItems->isEmpty()) {
                throw new \Exception('Keranjang belanja kosong.');
            }

            // Calculate shipping cost
            $shippingCost = 0;
            switch ($validated['shipping_method']) {
                case 'delivery':
                    $shippingCost = 15000;
                    break;
                case 'cargo':
                    $shippingCost = 25000;
                    break;
            }

            // Calculate totals
            $subtotal = 0;
            foreach ($cartItems as $item) {
                if ($item->quantity > $item->product->stock) {
                    throw new \Exception("Stok {$item->product->name} tidak mencukupi.");
                }
                $subtotal += $item->price * $item->quantity;
            }

            $discount = 0;
            $total = $subtotal + $shippingCost - $discount;

            // Create order
            $orderCode = 'CI-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
            
            $order = Order::create([
                'order_code' => $orderCode,
                'user_id' => Auth::id(),
                'customer_name' => $validated['name'],
                'customer_phone' => $validated['phone'],
                'customer_email' => $validated['email'],
                'shipping_address' => $validated['address'],
                'shipping_city' => $validated['city'],
                'shipping_postal_code' => $validated['postal_code'],
                'shipping_method' => $validated['shipping_method'],
                'payment_method' => 'qris',
                'notes' => $validated['notes'] ?? null,
                'design_notes' => $validated['design_notes'] ?? null,
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'discount' => $discount,
                'total' => $total,
                'status' => 'pending',
                'payment_status' => 'unpaid',
            ]);

            // Upload design files
            if ($request->hasFile('design_files')) {
                $designPaths = [];
                foreach ($request->file('design_files') as $file) {
                    $path = $file->store('designs/' . $order->id, 'public');
                    $designPaths[] = $path;
                }
                $order->design_files = implode(',', $designPaths);
                $order->save();
            }

            // Create order items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $item->price * $item->quantity,
                ]);

                // Reduce stock
                $item->product->decrement('stock', $item->quantity);
            }

            // Create Midtrans Snap Token using Service
            try {
                $snapToken = $this->midtrans->createTransaction($order, $cartItems);
                
                $order->update([
                    'snap_token' => $snapToken,
                    'midtrans_order_id' => $orderCode,
                ]);
            } catch (\Exception $e) {
                throw new \Exception('Gagal membuat token pembayaran: ' . $e->getMessage());
            }

            // Clear cart
            $cart->items()->delete();

            DB::commit();

            return redirect()->route('orders.payment', $order->id)
                ->with('success', 'Pesanan berhasil dibuat! Silakan lanjutkan pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Checkout Error: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function getCartCount()
    {
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->first();
        } else {
            $cart = Cart::where('session_id', session()->getId())->first();
        }

        return response()->json([
            'count' => $cart ? $cart->total_items : 0
        ]);
    }
}