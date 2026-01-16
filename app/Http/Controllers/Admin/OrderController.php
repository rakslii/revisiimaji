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
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->check()) {
                return redirect()->route('admin.login')
                    ->with('error', 'Please login first.');
            }
            
            if (auth()->user()->role !== 'admin') {
                auth()->logout();
                return redirect()->route('admin.login')
                    ->with('error', 'Admin access only.');
            }
            
            return $next($request);
        });
    }

    public function orders()
    {
        $orders = Order::with(['user' => function($query) {
            $query->select('id', 'name', 'email', 'phone');
        }])
        ->select('orders.*')
        ->addSelect([
            'items_count' => \App\Models\OrderItem::whereColumn('order_id', 'orders.id')
                ->selectRaw('COUNT(*)')
        ])
        ->latest()
        ->paginate(10);

        return view('pages.admin.orders.index', compact('orders'));
    }
    
    public function orderDetail($id)
    {
        $order = Order::with([
            'user',
            'location',
            'items.product',
            'payments'
        ])->findOrFail($id);
        
        return view('pages.admin.orders.show', compact('order'));
    }

    public function create()
    {
        // Cek role yang benar: 'customer' atau 'user'
        $customers = User::whereIn('role', ['customer', 'user'])->orderBy('name')->get();
        $products = Product::active()->orderBy('name')->get();
        
        return view('pages.admin.orders.create', compact('customers', 'products'));
    }

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

            // Generate order code
            $orderCode = 'ORD-' . date('Ymd') . '-' . strtoupper(uniqid());

            // Create order
            $order = Order::create([
                'order_code' => $orderCode,
                'user_id' => $validated['user_id'],
                'total' => $total,
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

            return redirect()->route('admin.orders.show', $order->id)
                ->with('success', 'Order created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to create order: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        try {
            $order = Order::with(['user', 'items.product'])
                ->findOrFail($id);
            
            // Cek role yang benar: 'customer' atau 'user'
            $customers = User::whereIn('role', ['customer', 'user'])->orderBy('name')->get();
            
            return view('pages.admin.orders.edit', compact('order', 'customers'));
            
        } catch (\Exception $e) {
            \Log::error('Error loading order edit page: ' . $e->getMessage());
            
            return redirect()->route('admin.orders')
                ->with('error', 'Order not found or error loading page.');
        }
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:pending,waiting_payment,paid,processing,completed,cancelled',
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

            return redirect()->route('admin.orders.show', $order->id)
                ->with('success', 'Order updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to update order: ' . $e->getMessage())
                ->withInput();
        }
    }

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
    
    public function updateOrderStatus(Request $request, $id)
    {
        try {
            $order = Order::findOrFail($id);
            
            $request->validate([
                'status' => 'required|in:pending,waiting_payment,paid,processing,completed,cancelled'
            ]);

            $oldStatus = $order->status;
            $newStatus = $request->status;
            
            // Update order
            $order->update(['status' => $newStatus]);

            // Handle stock adjustments khusus untuk cancelled
            if ($newStatus === 'cancelled' && $oldStatus !== 'cancelled') {
                foreach ($order->items as $item) {
                    $product = Product::find($item->product_id);
                    if ($product) {
                        $product->increment('stock', $item->quantity);
                    }
                }
            } elseif ($oldStatus === 'cancelled' && $newStatus !== 'cancelled') {
                foreach ($order->items as $item) {
                    $product = Product::find($item->product_id);
                    if ($product) {
                        $product->decrement('stock', $item->quantity);
                    }
                }
            }
            
            return redirect()->back()
                ->with('success', 'Order status updated successfully');
            
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update order status: ' . $e->getMessage());
        }
    }
    
    public function confirmPayment(Request $request, $id)
    {
        try {
            $order = Order::findOrFail($id);
            
            $order->update([
                'payment_status' => 'paid',
                'status' => 'processing',
                'paid_at' => now()
            ]);
            
            return redirect()->back()
                ->with('success', 'Payment confirmed successfully');
            
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to confirm payment: ' . $e->getMessage());
        }
    }
    
    public function markAsProcessing(Request $request, $id)
    {
        try {
            $order = Order::findOrFail($id);
            
            // Cek jika order sudah dibayar
            if ($order->payment_status !== 'paid') {
                return redirect()->back()
                    ->with('error', 'Cannot process unpaid order');
            }
            
            $order->update(['status' => 'processing']);
            
            return redirect()->back()
                ->with('success', 'Order marked as processing successfully');
            
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update order: ' . $e->getMessage());
        }
    }

    public function markAsCompleted(Request $request, $id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->update(['status' => 'completed']);
            
            return redirect()->back()
                ->with('success', 'Order marked as completed successfully');
            
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update order: ' . $e->getMessage());
        }
    }
    
}