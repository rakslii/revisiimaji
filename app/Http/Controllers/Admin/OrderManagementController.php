<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderManagementController extends Controller
{
    public function __construct()
{
    // ⚡ HAPUS INI: $this->middleware('auth');
    // Karena ini yang bikin redirect ke /login
    
    // Cek role admin saja
    $this->middleware(function ($request, $next) {
        if (!auth()->check()) {
            // Manual redirect ke admin.login
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
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }
    
    public function show($id)
    {
        $order = Order::with(['user', 'items.product'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }
    
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);
        
        $order->update($validated);
        
        // Log activity
        activity()
            ->performedOn($order)
            ->causedBy(auth()->user())
            ->log("Order status changed to {$request->status}");
            
        return response()->json([
            'success' => true,
            'message' => 'Order status updated'
        ]);
    }
    
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        
        // Soft delete jika ada, atau langsung delete
        $order->delete();
        
        return back()->with('success', 'Order deleted successfully');
    }

}