<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function orders()
    {
        $orders = Order::with('user')->latest()->paginate(10);
        return view('pages.admin.orders.index', compact('orders'));
    }
    
    public function orderDetail($id)
    {
        $order = Order::with(['user', 'items.product'])->findOrFail($id);
        return view('pages.admin.orders.detail', compact('order'));
    }
    
    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,completed,cancelled'
        ]);
        
        $order->update(['status' => $request->status]);
        
        // TODO: Send notification to user
        
        return back()->with('success', 'Order status updated successfully');
    }
    
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