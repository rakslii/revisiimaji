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
    // HAPUS constructor middleware karena sudah di handle oleh route middleware

    
    public function dashboard()
    {
        $user = auth()->user();
        
        $stats = [
            'total_users' => User::count(),
            'total_orders' => Order::count(),
            'total_products' => Product::count(),
            'total_promo_codes' => PromoCode::count(),
            'recent_orders' => Order::latest()->take(5)->get(),
            'recent_users' => User::latest()->take(5)->get(),
        ];
        
        return view('pages.admin.dashboard', compact('stats', 'user'));
    }
    
    public function customers()
    {
        $customers = User::where('role', 'customer')->latest()->paginate(10);
        return view('pages.admin.customers', compact('customers'));
    }
    
    public function customerDetail($id)
    {
        $customer = User::findOrFail($id);
        $orders = Order::where('user_id', $id)->latest()->paginate(10);
        return view('pages.admin.customer-detail', compact('customer', 'orders'));
    }
    
    public function settings()
    {
        return view('pages.admin.settings');
    }
    
    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_email' => 'required|email',
            'site_phone' => 'required|string',
            'whatsapp_number' => 'required|string',
        ]);
        
        // TODO: Save settings
        return back()->with('success', 'Settings updated successfully');
    }
    public function __construct()
{
    // Cek login
    $this->middleware('auth');
    
    // Cek role admin
    $this->middleware(function ($request, $next) {
        if (auth()->user()->role !== 'admin') {
            auth()->logout();
            return redirect()->route('admin.login')
                ->with('error', 'Admin access only.');
        }
        return $next($request);
    });
}
}