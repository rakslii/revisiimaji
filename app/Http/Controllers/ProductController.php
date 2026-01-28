<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of products (Web Version)
     */
    public function index(Request $request)
    {
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

        // HANYA untuk request NON-AJAX (tampilan awal)
        if (!$request->ajax() && !$request->wantsJson()) {
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
        
        // Untuk AJAX request, biarkan method liveSearch() yang menangani
        // Jangan return apa-apa di sini untuk AJAX
    }

    /**
     * API Endpoint for Live Search (AJAX)
     */
    public function liveSearch(Request $request)
    {
        Log::info('📱 Live Search Request:', $request->all());
        
        try {
            $query = Product::where('is_active', true);

            // Filter by category string (instan/non-instan)
            if ($request->filled('category') && in_array($request->category, ['instan', 'non-instan'])) {
                $query->where('category', $request->category);
                Log::info('🔍 Filtering by category:', ['category' => $request->category]);
            }

            // Filter by category_id (jika numeric)
            if ($request->filled('category_id') && is_numeric($request->category_id)) {
                $query->where('category_id', $request->category_id);
                Log::info('🔍 Filtering by category_id:', ['category_id' => $request->category_id]);
            }

            // Search by name or description
            if ($request->filled('search') && !empty(trim($request->search))) {
                $searchTerm = trim($request->search);
                $query->where(function($q) use ($searchTerm) {
                    $q->where('name', 'like', '%' . $searchTerm . '%')
                      ->orWhere('description', 'like', '%' . $searchTerm . '%');
                });
                Log::info('🔍 Searching for:', ['search' => $searchTerm]);
            }

            // Sort options
            $sort = $request->get('sort', 'latest');
            Log::info('🔍 Sorting by:', ['sort' => $sort]);
            
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
            
            Log::info('✅ Products found:', [
                'total' => $products->total(),
                'count' => $products->count(),
                'category' => $request->category,
                'search' => $request->search
            ]);

            // Render the grid component
            $html = view('components.partials.products.grid', [
                'products' => $products
            ])->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'total' => $products->total(),
                'count' => $products->count(),
                'pagination' => $products->hasPages() ? $products->links()->toHtml() : '',
                'message' => 'OK'
            ]);

        } catch (\Exception $e) {
            Log::error('❌ Live search error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'html' => '<div class="col-span-full text-center py-12">
                    <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Terjadi Kesalahan</h3>
                    <p class="text-gray-500 mb-6">Gagal memuat produk. Silakan coba lagi.</p>
                </div>',
                'total' => 0,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
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