<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Cek apakah tabel products ada
        try {
            // Get active products untuk homepage
            $products = Product::where('is_active', true)
                ->orderBy('created_at', 'desc')
                ->take(8) // Ambil 8 produk untuk homepage
                ->get();
        } catch (\Exception $e) {
            // Jika tabel belum ada atau error, set empty collection
            $products = collect();
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
            'customProducts' => $customProducts
        ]);
    }
}