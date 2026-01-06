<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\PromoCode;

class AdminController extends Controller
{
// AdminController.php
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
    
public function dashboard()
{
    // Cek nama kolom yang ada
    // Kemungkinan: 'total', 'amount', 'grand_total', 'price'
    
    $stats = [
        'total_users' => User::count(),
        'total_customers' => User::where('role', 'customer')->count(),
        'total_orders' => Order::count(),
        'total_products' => Product::count(),
        'total_promo_codes' => PromoCode::count(),
        'total_revenue' => Order::where('status', 'paid')->sum('total') ?? 0, // ⚡ GANTI!
    ];

    $recent_orders = Order::with('user')->latest()->take(10)->get();
    $recent_customers = User::where('role', 'customer')->latest()->take(5)->get();
    
    return view('pages.admin.dashboard.index', compact('stats', 'recent_orders', 'recent_customers'));
}
    
    public function customers()
    {
        $customers = User::where('role', 'customer')->latest()->paginate(10);
        return view('pages.admin.customers.index', compact('customers'));
    }
    
    public function customerDetail($id)
    {
        $customer = User::findOrFail($id);
        $orders = Order::where('user_id', $id)->latest()->paginate(10);
        return view('pages.admin.customers.show', compact('customer', 'orders'));
    }
    
    public function settings()
    {
        return view('pages.admin.settings.index');
    }
    
    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_email' => 'required|email',
            'site_phone' => 'required|string',
            'whatsapp_number' => 'required|string',
        ]);
        
        // TODO: Save settings to database or config
        // Example: Settings::updateOrCreate(['key' => 'site_name'], ['value' => $validated['site_name']]);
        
        return back()->with('success', 'Settings updated successfully');
    }
}