<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    return redirect()->route('pages.cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
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
            return redirect()->route('pages.cart.index')->with('error', 'Produk tidak ditemukan.');
        }

        if ($request->quantity > $product->stock) {
            return redirect()->route('pages.cart.index')->with('error', 'Stok hanya tersisa ' . $product->stock . ' item.');
        }

        $item->update(['quantity' => $request->quantity]);

        return redirect()->route('pages.cart.index')->with('success', 'Keranjang berhasil diperbarui.');
    }

    public function remove($itemId)
    {
        $cart = Cart::getCurrentCart();
        $item = $cart->items()->find($itemId);
        
        if ($item) {
            $item->delete();
            return redirect()->route('pages.cart.index')->with('success', 'Produk berhasil dihapus dari keranjang.');
        }

        return redirect()->route('pages.cart.index')->with('error', 'Item tidak ditemukan di keranjang.');
    }

    public function clear()
    {
        $cart = Cart::getCurrentCart();
        $cart->items()->delete();
        
        return redirect()->route('pages.cart.index')->with('success', 'Keranjang berhasil dikosongkan.');
    }

    public function checkout()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login untuk melanjutkan checkout.');
        }

        $cart = Cart::getCurrentCart();
        $items = $cart->items()->with('product')->get();
        
        // Validate all items are available
        $unavailableItems = [];
        foreach ($items as $item) {
            if (!$item->isAvailable()) {
                $unavailableItems[] = $item->product->name . ' - ' . $item->getAvailabilityMessage();
            }
        }
        
        if (!empty($unavailableItems)) {
            return redirect()->route('pages.cart.index')
                ->with('error', 'Beberapa produk tidak tersedia:')
                ->with('unavailable', $unavailableItems);
        }
        
        // Get user addresses
        $user = Auth::user();
        $addresses = $user->locations()->orderBy('is_primary', 'desc')->get();
        
        if ($addresses->isEmpty()) {
            return redirect()->route('pages.profile.index')
                ->with('warning', 'Silakan tambahkan alamat pengiriman terlebih dahulu sebelum checkout.');
        }
        
        $subtotal = $cart->subtotal;
        $shippingCost = 15000; // Default shipping cost
        $total = $subtotal + $shippingCost;
        
        return view('cart.checkout', compact(
            'cart', 'items', 'addresses', 
            'subtotal', 'shippingCost', 'total'
        ));
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