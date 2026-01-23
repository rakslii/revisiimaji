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
                'message' => 'Produk tidak tersedia.'
            ], 400);
        }

        if ($product->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak cukup.'
            ], 400);
        }

        $cart = Cart::getCurrentCart();
        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        if ($cartItem) {
            $newQty = $cartItem->quantity + $request->quantity;
            if ($newQty > $product->stock) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok tidak cukup untuk jumlah ini.'
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

        return response()->json([
            'success' => true,
            'message' => 'Produk masuk keranjang!',
            'cart_count' => $cart->items()->sum('quantity')
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
}
