<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalRevenue = Order::where('status', 'completed')->sum('total_price');
        
        $recentOrders = Order::with('user')->latest()->take(5)->get();
        $recentUsers = User::latest()->take(5)->get();
        
        return view('admin.dashboard.index', compact(
            'totalUsers', 
            'totalOrders', 
            'totalProducts', 
            'totalRevenue',
            'recentOrders',
            'recentUsers'
        ));
    }

}