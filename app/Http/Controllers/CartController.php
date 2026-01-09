<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['checkout', 'processCheckout']);
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

        // Check product availability
        if (!$product->is_active) {
            return response()->json(['error' => 'Produk tidak tersedia.'], 400);
        }

        if ($product->stock < $request->quantity) {
            return response()->json(['error' => 'Stok tidak mencukupi. Stok tersisa: ' . $product->stock], 400);
        }

        // Get current cart
        $cart = Cart::getCurrentCart();

        // Check if product already in cart
        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        if ($cartItem) {
            // Update quantity
            $newQuantity = $cartItem->quantity + $request->quantity;

            if ($newQuantity > $product->stock) {
                return response()->json(['error' => 'Stok tidak mencukupi untuk menambah jumlah ini.'], 400);
            }

            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            // Add new item
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->price
            ]);
        }

        // Return JSON response for AJAX
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil ditambahkan ke keranjang.',
                'cart_count' => $cart->fresh()->total_items
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
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
            return redirect()->route('cart.index')->with('error', 'Produk tidak ditemukan.');
        }

        if ($request->quantity > $product->stock) {
            return redirect()->route('cart.index')->with('error', 'Stok hanya tersisa ' . $product->stock . ' item.');
        }

        $item->update(['quantity' => $request->quantity]);

        return redirect()->route('cart.index')->with('success', 'Keranjang berhasil diperbarui.');
    }

    public function remove($itemId)
    {
        $cart = Cart::getCurrentCart();
        $item = $cart->items()->find($itemId);

        if ($item) {
            $item->delete();
            return redirect()->route('cart.index')->with('success', 'Produk berhasil dihapus dari keranjang.');
        }

        return redirect()->route('cart.index')->with('error', 'Item tidak ditemukan di keranjang.');
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

        // Check if cart is empty
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

        $user = Auth::user();

        // Calculate totals
        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item->price * $item->quantity;
        }

        $discount = 0;
        $total = $subtotal - $discount;

        return view('pages.cart.checkout', compact(
            'cartItems',
            'subtotal',
            'discount',
            'total'
        ));
    }

    public function processCheckout(Request $request)
{
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
    }

    // Validation - PERBAIKAN DI SINI
   $validated = $request->validate([
    'name' => 'required|string|max:255',
    'phone' => 'required|string|max:20',
    'email' => 'required|email|max:255',
    'address' => 'required|string',
    'city' => 'required|string|max:100',
    'postal_code' => 'required|string|max:10',
    'shipping_method' => 'required|in:pickup,delivery,cargo',
    'payment_method' => 'required|in:transfer,cash,ewallet',
    'notes' => 'nullable|string|max:500',
        // UBAH VALIDASI INI
        'items' => 'required|array|min:1',
        'items.*.product_id' => 'required|exists:products,id',
        'items.*.quantity' => 'required|integer|min:1',
        'items.*.price' => 'required|numeric|min:0',
    ], [
        // Custom error messages
        'items.required' => 'Keranjang belanja kosong.',
        'items.*.product_id.required' => 'ID produk harus diisi.',
        'items.*.quantity.required' => 'Jumlah produk harus diisi.',
        'items.*.quantity.integer' => 'Jumlah produk harus berupa angka.',
        'items.*.quantity.min' => 'Jumlah produk minimal 1.',
    ]);

    DB::beginTransaction();

    try {
        $cart = Cart::getCurrentCart();
        $cartItems = $cart->items()->with('product')->get();

        // Check if cart is empty
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
            // Check stock availability
            if ($item->quantity > $item->product->stock) {
                throw new \Exception("Stok {$item->product->name} tidak mencukupi.");
            }
            $subtotal += $item->price * $item->quantity;
        }

        $discount = 0;
        $total = $subtotal + $shippingCost - $discount;

        // Create order
        $order = Order::create([
            'order_code' => 'CI-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6)),
            'user_id' => Auth::id(),
            'customer_name' => $validated['name'],
            'customer_phone' => $validated['phone'],
            'customer_email' => $validated['email'],
            'shipping_address' => $validated['address'],
            'shipping_city' => $validated['city'],
            'shipping_postal_code' => $validated['postal_code'],
            'shipping_method' => $validated['shipping_method'],
            'payment_method' => $validated['payment_method'],
            'notes' => $validated['notes'] ?? null,
            'subtotal' => $subtotal,
            'shipping_cost' => $shippingCost,
            'discount' => $discount,
            'total' => $total,
            'status' => 'pending',
            'payment_status' => 'unpaid',
        ]);

        // Create order items and reduce stock
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'product_name' => $item->product->name,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'subtotal' => $item->price * $item->quantity,
            ]);

            // Reduce product stock
            $item->product->decrement('stock', $item->quantity);
        }

        // Clear cart
        $cart->items()->delete();

        DB::commit();

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Pesanan berhasil dibuat! Kode pesanan: ' . $order->order_code);
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

        $count = $cart ? $cart->total_items : 0;

        return response()->json(['count' => $count]);
    }
}
