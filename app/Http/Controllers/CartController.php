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
                return redirect()->back()->with('error', 'Stok ga cukup buat nambah segitu.');
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
                'message' => 'Produk ga ada.'
            ], 404);
        }

        if ($request->quantity > $product->stock) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tinggal ' . $product->stock
            ], 400);
        }

        $item->update(['quantity' => $request->quantity]);

        // Hitung ulang semua total
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

        // Item total yang diupdate
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

        return redirect()->route('cart.index')->with('success', 'Produk dihapus dari keranjang.');
    }

    public function clear()
    {
        $cart = Cart::getCurrentCart();
        $cart->items()->delete();

        return redirect()->route('cart.index')->with('success', 'Keranjang dikosongkan.');
    }

    public function checkout()
    {
        $cart = Cart::getCurrentCart();
        $cartItems = $cart->items()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        foreach ($cartItems as $item) {
            if (!$item->isAvailable()) {
                return redirect()->route('cart.index')->with('error', 'Ada produk yang ga tersedia.');
            }
        }

        $subtotal = $cartItems->sum(fn($i) => $i->price * $i->quantity);
        $discount = 0;
        $total = $subtotal - $discount;

        return view('pages.cart.checkout', compact('cartItems', 'subtotal', 'discount', 'total'));
    }

    public function processCheckout(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
            'shipping_method' => 'required|in:pickup,delivery,cargo',
            'payment_method' => 'required|in:transfer,cash,ewallet',
            'notes' => 'nullable'
        ]);

        DB::beginTransaction();

        try {
            $cart = Cart::getCurrentCart();
            $items = $cart->items()->with('product')->get();

            if ($items->isEmpty()) {
                throw new \Exception('Keranjang kosong.');
            }

            $shipping = match($data['shipping_method']) {
                'delivery' => 15000,
                'cargo' => 25000,
                default => 0
            };

            $subtotal = 0;
            foreach ($items as $item) {
                if ($item->quantity > $item->product->stock) {
                    throw new \Exception('Stok ' . $item->product->name . ' ga cukup.');
                }
                $subtotal += $item->price * $item->quantity;
            }

            $total = $subtotal + $shipping;

            $order = Order::create([
                'order_code' => $orderCode,
                'user_id' => Auth::id(),
                'customer_name' => $data['name'],
                'customer_phone' => $data['phone'],
                'customer_email' => $data['email'],
                'shipping_address' => $data['address'],
                'shipping_city' => $data['city'],
                'shipping_postal_code' => $data['postal_code'],
                'shipping_method' => $data['shipping_method'],
                'payment_method' => $data['payment_method'],
                'notes' => $data['notes'] ?? null,
                'subtotal' => $subtotal,
                'shipping_cost' => $shipping,
                'discount' => 0,
                'total' => $total,
                'status' => 'pending',
                'payment_status' => 'unpaid',
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $item->price * $item->quantity,
                ]);

                $item->product->decrement('stock', $item->quantity);
            }

            $cart->items()->delete();
            DB::commit();

            return redirect()->route('orders.show', $order->id)->with('success', 'Order berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
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