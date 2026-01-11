<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function orders()
    {
        $orders = Order::with(['user', 'items.product'])
            ->latest()
            ->paginate(10);

        return view('pages.admin.orders.index', compact('orders'));
    }
    
    /**
     * Display order details.
     */
    public function orderDetail($id)
    {
        $order = Order::with(['user', 'items.product', 'payment', 'location'])
            ->findOrFail($id);
        
        return view('pages.admin.orders.show', compact('order'));
    }

    /**
     * Show create order form.
     */
    public function create()
    {
        $customers = User::where('role', 'user')->orderBy('name')->get();
        $products = Product::active()->orderBy('name')->get();
        
        return view('pages.admin.orders.create', compact('customers', 'products'));
    }

    /**
     * Store a new order.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'products' => 'required|array|min:1',
            'shipping_address' => 'nullable|string',
            'status' => 'required|in:pending,processing,shipped,completed,cancelled',
            'payment_status' => 'required|in:paid,unpaid',
            'payment_method' => 'nullable|in:cash,bank_transfer,credit_card,ewallet',
            'notes' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Parse products JSON
            $products = json_decode($validated['products'], true);
            
            // Calculate total
            $total = 0;
            foreach ($products as $product) {
                $total += $product['price'] * $product['quantity'];
            }

            // Generate order number
            $orderNumber = 'ORD-' . date('Ymd') . '-' . str_pad(Order::count() + 1, 5, '0', STR_PAD_LEFT);

            // Create order
            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => $validated['user_id'],
                'total_amount' => $total,
                'status' => $validated['status'],
                'payment_status' => $validated['payment_status'],
                'payment_method' => $validated['payment_method'],
                'shipping_address' => $validated['shipping_address'],
                'notes' => $validated['notes'],
            ]);

            // Create order items
            foreach ($products as $productData) {
                $order->items()->create([
                    'product_id' => $productData['id'],
                    'quantity' => $productData['quantity'],
                    'price' => $productData['price'],
                    'total' => $productData['price'] * $productData['quantity'],
                ]);

                // Update product stock
                $product = Product::find($productData['id']);
                if ($product && $validated['status'] !== 'cancelled') {
                    $product->decrement('stock', $productData['quantity']);
                }
            }

            DB::commit();

            return redirect()->route('admin.orders.orderDetail', $order->id)
                ->with('success', 'Order created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to create order: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show edit order form.
     */
    public function edit($id)
    {
        $order = Order::with(['user', 'items.product'])
            ->findOrFail($id);
        $customers = User::where('role', 'user')->orderBy('name')->get();
        
        return view('pages.admin.orders.edit', compact('order', 'customers'));
    }

    /**
     * Update order.
     */
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:pending,processing,shipped,completed,cancelled',
            'payment_status' => 'required|in:paid,unpaid',
            'payment_method' => 'nullable|in:cash,bank_transfer,credit_card,ewallet',
            'shipping_address' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Handle stock adjustments for status changes
            if ($validated['status'] === 'cancelled' && $order->status !== 'cancelled') {
                // Restore stock
                foreach ($order->items as $item) {
                    $product = Product::find($item->product_id);
                    if ($product) {
                        $product->increment('stock', $item->quantity);
                    }
                }
            } elseif ($order->status === 'cancelled' && $validated['status'] !== 'cancelled') {
                // Reduce stock again
                foreach ($order->items as $item) {
                    $product = Product::find($item->product_id);
                    if ($product) {
                        $product->decrement('stock', $item->quantity);
                    }
                }
            }

            // Update order
            $order->update($validated);

            DB::commit();

            return redirect()->route('admin.orders.orderDetail', $order->id)
                ->with('success', 'Order updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to update order: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Delete order.
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        
        // Only allow delete if order is cancelled
        if ($order->status !== 'cancelled') {
            return redirect()->back()
                ->with('error', 'Only cancelled orders can be deleted.');
        }

        try {
            DB::beginTransaction();

            // Delete order items
            $order->items()->delete();
            
            // Delete order
            $order->delete();

            DB::commit();

            return redirect()->route('admin.orders')
                ->with('success', 'Order deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to delete order: ' . $e->getMessage());
        }
    }
    
    /**
     * Update order status via AJAX.
     */
    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,completed,cancelled'
        ]);

        $oldStatus = $order->status;
        $order->update(['status' => $request->status]);

        // Handle stock adjustments
        if ($request->status === 'cancelled' && $oldStatus !== 'cancelled') {
            foreach ($order->items as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->increment('stock', $item->quantity);
                }
            }
        } elseif ($oldStatus === 'cancelled' && $request->status !== 'cancelled') {
            foreach ($order->items as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->decrement('stock', $item->quantity);
                }
            }
        }
        
        return back()->with('success', 'Order status updated successfully');
    }
    
    /**
     * Confirm payment for order.
     */
    public function confirmPayment($id)
    {
        $order = Order::findOrFail($id);
        $order->update([
            'payment_status' => 'paid',
            'status' => 'processing'
        ]);
        
        return back()->with('success', 'Payment confirmed successfully');
    }
}