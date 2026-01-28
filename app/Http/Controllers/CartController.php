<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
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
        return response()->json([
            'success' => false,
            'title' => 'Produk Tidak Tersedia',
            'message' => 'Produk ini sedang tidak tersedia.',
            'type' => 'error'
        ], 400);
    }

    if ($product->stock < $request->quantity) {
        return response()->json([
            'success' => false,
            'title' => 'Stok Tidak Cukup',
            'message' => 'Stok produk ini tidak mencukupi.',
            'type' => 'warning'
        ], 400);
    }

    $cart = Cart::getCurrentCart();
    $cartItem = $cart->items()->where('product_id', $product->id)->first();

    if ($cartItem) {
        $newQty = $cartItem->quantity + $request->quantity;
        if ($newQty > $product->stock) {
            return response()->json([
                'success' => false,
                'title' => 'Stok Tidak Cukup',
                'message' => 'Stok tidak cukup untuk jumlah ini.',
                'type' => 'warning'
            ], 400);
        }
        $cartItem->update(['quantity' => $newQty]);
    } else {
        $cart->items()->create([
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'price' => $product->price
        ]);
    }

    $totalItems = $cart->items()->sum('quantity');

    return response()->json([
        'success' => true,
        'title' => 'Berhasil Ditambahkan!',
        'message' => $product->name . ' telah ditambahkan ke keranjang.',
        'type' => 'success',
        'cart_count' => $totalItems,
        'product' => [
            'name' => $product->name,
            'price' => 'Rp ' . number_format($product->final_price, 0, ',', '.'),
            'image' => $product->image_url,
            'quantity' => $request->quantity
        ]
    ]);
}
    public function update(Request $request, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = Cart::getCurrentCart();
        $item = $cart->items()->with('product')->findOrFail($itemId);
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
                'message' => 'Stok tinggal ' . $product->stock
            ], 400);
        }

        $item->update(['quantity' => $request->quantity]);

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
            'cart_count' => $cart->items()->sum('quantity')
        ]);
    }

    public function remove($itemId)
    {
        $cart = Cart::getCurrentCart();
        $item = $cart->items()->find($itemId);

        if ($item) {
            $item->delete();
        }

        return redirect()->route('cart.index')->with('success', 'Produk dihapus.');
    }

    public function clear()
    {
        $cart = Cart::getCurrentCart();
        $cart->items()->delete();

        return redirect()->route('cart.index')->with('success', 'Keranjang dikosongkan.');
    }

    public function checkout()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Login dulu.');
        }

        $cart = Cart::getCurrentCart();
        $cartItems = $cart->items()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item->price * $item->quantity;
        }

        $discount = 0;
        $total = $subtotal - $discount;

        $user = Auth::user();
        $userLocation = null;

        return view('pages.cart.checkout', compact('cartItems', 'subtotal', 'discount', 'total', 'user', 'userLocation'));
    }
    public function getCartCount()
    {
        $cart = Cart::getCurrentCart();
        $count = $cart->items()->sum('quantity');

        return response()->json([
            'count' => $count
        ]);
    }
    public function processCheckout(Request $request)
    {
        DB::beginTransaction();

        try {
            // Validasi input
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'address' => 'required|string',
                'city' => 'required|string|max:100',
                'postal_code' => 'required|string|max:10',
                'notes' => 'nullable|string|max:500'
            ]);

            $cart = Cart::getCurrentCart();
            $cartItems = $cart->items()->with('product')->get();

            // Validasi keranjang
            if ($cartItems->isEmpty()) {
                return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
            }

            // Hitung total
            $subtotal = 0;
            foreach ($cartItems as $item) {
                // Cek stok
                if ($item->quantity > $item->product->stock) {
                    return back()->with('error', 'Stok ' . $item->product->name . ' tidak cukup.');
                }
                $subtotal += $item->price * $item->quantity;
            }

            $discount = 0;
            $total = $subtotal - $discount;

            $orderCode = 'ORD-' . now()->format('YmdHis') . rand(100, 999);
            // Buat order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_code' => $orderCode,

                // CUSTOMER
                'customer_name' => $validated['name'],
                'customer_phone' => $validated['phone'],
                'customer_email' => Auth::user()->email,

                // SHIPPING
                'shipping_address' => $validated['address'],
                'shipping_city' => $validated['city'],
                'shipping_postal_code' => $validated['postal_code'],
                'shipping_method' => 'pickup',

                // PRICE
                'subtotal' => $subtotal,
                'discount' => $discount,
                'total' => $total,

                // STATUS
                'status' => Order::STATUS_PENDING,
                'payment_status' => Order::PAYMENT_UNPAID,

                'notes' => $validated['notes'] ?? null,
            ]);


            // Buat order items & kurangi stok
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $item->price * $item->quantity
                ]);

                // Kurangi stok
                $item->product->decrement('stock', $item->quantity);
            }

            $snapToken = $this->midtrans->createTransaction($order);



            $order->update([
                'snap_token' => $snapToken
            ]);

            // Kosongkan keranjang
            $cart->items()->delete();

            DB::commit();
            return redirect()->route('orders.payment', $order->id);
            // Redirect ke halaman payment
            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Order berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membuat order: ' . $e->getMessage());
        }
    }
}
