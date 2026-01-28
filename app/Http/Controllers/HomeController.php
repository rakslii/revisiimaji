<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        try {
            // Get active products untuk homepage
            $products = Product::where('is_active', true)
                ->orderBy('created_at', 'desc')
                ->take(8)
                ->get();
            
            // Get categories - tanpa syarat gambar
            $categories = ProductCategory::where('is_active', true)
                ->orderBy('order')
                ->take(4)
                ->get();
                
            // DEBUG LOG
            \Log::info('HomeController: Found ' . $categories->count() . ' categories');
                
        } catch (\Exception $e) {
            // Jika tabel belum ada atau error, set empty collection
            \Log::error('HomeController error: ' . $e->getMessage());
            $products = collect();
            $categories = collect();
        }
        
        // Get instant products
        $instantProducts = Product::where('is_active', true)
            ->where('category', 'instan')
            ->take(4)
            ->get();
            
        // Get custom products  
        $customProducts = Product::where('is_active', true)
            ->where('category', 'non-instan')
            ->take(4)
            ->get();
        
        return view('pages.home.index', [
            'products' => $products,
            'instantProducts' => $instantProducts,
            'customProducts' => $customProducts,
            'categories' => $categories
        ]);
    }
}