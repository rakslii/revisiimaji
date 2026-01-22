<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of products (Web Version)
     */
    public function index(Request $request)
    {
        // Hapus with('category') karena tidak ada relationship
        $query = Product::where('is_active', true);

        // Filter by category (string: instan/non-instan)
        if ($request->has('category')) {
            if (in_array($request->category, ['instan', 'non-instan'])) {
                // Filter by category string
                $query->where('category', $request->category);
            } elseif ($request->category) {
                // Filter by category_id (numeric)
                $query->where('category_id', $request->category);
            }
        }

        // Filter by category ID (untuk kategori spesifik)
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Search by name
        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Sort options
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price');
                break;
            case 'price_desc':
                $query->orderByDesc('price');
                break;
            case 'popular':
                $query->orderByDesc('sales_count');
                break;
            case 'discount':
                $query->orderByDesc('discount_percent');
                break;
            default:
                $query->latest();
        }

        $products = $query->paginate($request->get('per_page', 12));

        // Untuk API/Live Search request
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'html' => view('components.partials.products.grid', ['products' => $products])->render(),
                'total' => $products->total(),
                'pagination' => $products->links()->toHtml(),
            ]);
        }

        // Get categories for sidebar - HANYA kategori instan dan non-instan
        $instantCategories = ProductCategory::where('is_active', true)
            ->where('type', 'instan')
            ->orderBy('order')
            ->get();

        $customCategories = ProductCategory::where('is_active', true)
            ->where('type', 'non-instan')
            ->orderBy('order')
            ->get();

        return view('pages.products.index', [
            'products' => $products,
            'instantCategories' => $instantCategories,
            'customCategories' => $customCategories,
            'selectedCategory' => $request->category,
            'selectedSort' => $sort,
            'searchQuery' => $request->search,
        ]);
    }

    /**
     * API Endpoint for Live Search
     */
     public function liveSearch(Request $request)
    {
        $query = Product::where('is_active', true);

        // Filter by category
        if ($request->has('category') && in_array($request->category, ['instan', 'non-instan'])) {
            $query->where('category', $request->category);
        }

        // Search by name or description
        if ($request->has('search') && !empty($request->search)) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Sort options
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price');
                break;
            case 'price_desc':
                $query->orderByDesc('price');
                break;
            case 'popular':
                $query->orderByDesc('sales_count');
                break;
            case 'discount':
                $query->orderByDesc('discount_percent');
                break;
            default:
                $query->latest();
        }

        $products = $query->paginate($request->get('per_page', 12));

        return response()->json([
            'success' => true,
            'html' => view('components.partials.products.grid', ['products' => $products])->render(),
            'total' => $products->total(),
            'pagination' => $products->links()->toHtml(),
        ]);
    }

    /**
     * Display the specified product (Web Version)
     */
    public function show($id)
    {
        $product = Product::where('is_active', true)->findOrFail($id);

        // Get related products berdasarkan category string atau category_id
        $relatedProducts = Product::where('is_active', true)
            ->where('id', '!=', $product->id)
            ->where(function($query) use ($product) {
                $query->where('category', $product->category)
                      ->orWhere('category_id', $product->category_id);
            })
            ->limit(4)
            ->get();

        // Jika ada category_id, ambil data category-nya
        $productCategory = null;
        if ($product->category_id) {
            $productCategory = ProductCategory::find($product->category_id);
        }

        return view('pages.products.show', [
            'product' => $product,
            'productCategory' => $productCategory,
            'relatedProducts' => $relatedProducts,
        ]);
    }

    /**
     * Get product categories (API)
     */
    public function categories()
    {
        $categories = ProductCategory::where('is_active', true)
            ->orderBy('order')
            ->get();

        return response()->json([
            'categories' => $categories,
            'instant_categories' => $categories->where('type', 'instan')->values(),
            'non_instant_categories' => $categories->where('type', 'non-instan')->values(),
        ]);
    }
}