<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\PromoCode;

class DashboardController extends Controller
{
public function index()
{
    // Statistics
    $stats = [
        'total_orders' => Order::count(),
        'total_customers' => User::where('role', 'customer')->count(),
        'total_products' => Product::where('is_active', true)->count(),
        'total_promo_codes' => PromoCode::count(),
        'total_revenue' => Order::where('status', 'completed')->sum('total') ?? 0,
    ];
    
    // Recent Orders
    $recent_orders = Order::with(['user', 'items'])
        ->latest()
        ->take(10)
        ->get();
    
    return view('pages.admin.dashboard.index', compact('stats', 'recent_orders'));
}
}