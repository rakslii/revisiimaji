<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->check()) {
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

  // Di ProductController.php, method index()
public function index(Request $request)
{
    $query = Product::with('category');
    
    // Search
    if ($request->has('search') && $request->search) {
        $query->where(function($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('description', 'like', '%' . $request->search . '%')
              ->orWhere('short_description', 'like', '%' . $request->search . '%');
        });
    }
    
    // Filter by category
    if ($request->has('category') && $request->category) {
        $query->where('category_id', $request->category);
    }
    
    // Filter by status
    if ($request->has('status') && $request->status) {
        $query->where('is_active', $request->status === 'active' ? 1 : 0);
    }
    
    // Filter by stock
    if ($request->has('stock_filter') && $request->stock_filter) {
        switch ($request->stock_filter) {
            case 'out_of_stock':
                $query->where('stock', 0);
                break;
            case 'low_stock':
                $query->where('stock', '>', 0)->where('stock', '<=', 10);
                break;
            case 'in_stock':
                $query->where('stock', '>', 0);
                break;
            case 'high_stock':
                $query->where('stock', '>', 10);
                break;
            case 'custom':
                if ($request->has('min_stock') && $request->min_stock) {
                    $query->where('stock', '>=', $request->min_stock);
                }
                if ($request->has('max_stock') && $request->max_stock) {
                    $query->where('stock', '<=', $request->max_stock);
                }
                break;
        }
    }
    
    // Filter by price range
    if ($request->has('min_price') && $request->min_price) {
        $query->where('price', '>=', $request->min_price);
    }
    if ($request->has('max_price') && $request->max_price) {
        $query->where('price', '<=', $request->max_price);
    }
    
    // Sorting
    if ($request->has('sort_by') && $request->sort_by) {
        switch ($request->sort_by) {
            case 'oldest':
                $query->oldest();
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'stock_high':
                $query->orderBy('stock', 'desc');
                break;
            case 'stock_low':
                $query->orderBy('stock', 'asc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            default: // newest
                $query->latest();
                break;
        }
    } else {
        $query->latest(); // Default sort
    }
    
    $perPage = $request->get('per_page', 15);
    $products = $query->paginate($perPage);
    $categories = ProductCategory::active()->get();
    
    return view('pages.admin.products.index', compact('products', 'categories'));
}

    public function create()
    {
        $categories = ProductCategory::active()->get();
        return view('pages.admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'discount_percent' => 'nullable|integer|min:0|max:100',
            'category_id' => 'required|exists:product_categories,id',
            'stock' => 'required|integer|min:0',
            'min_order' => 'nullable|integer|min:1',
            'is_active' => 'nullable|boolean',
            'image' => 'required|image|max:5120',
        ]);

        // Handle image
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        // Get category type from selected category
        $category = ProductCategory::find($validated['category_id']);
        $validated['category'] = $category->type;

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully');
    }

    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return view('pages.admin.products.show', compact('product'));
    }

    public function edit($id)
    {
        // FIX: PASTIKAN MENGGUNAKAN EAGER LOADING
        $product = Product::with('category')->findOrFail($id);
        $categories = ProductCategory::active()->get();
        return view('pages.admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'discount_percent' => 'nullable|integer|min:0|max:100',
            'category_id' => 'required|exists:product_categories,id',
            'stock' => 'required|integer|min:0',
            'min_order' => 'nullable|integer|min:1',
            'is_active' => 'nullable|boolean',
            'image' => 'nullable|image|max:5120',
            'remove_image' => 'nullable|boolean',
        ]);

        // Handle image removal
        if ($request->has('remove_image') && $request->remove_image) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
                $validated['image'] = null;
            }
        }

        // Handle new image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        // Get category type from selected category
        $category = ProductCategory::find($validated['category_id']);
        $validated['category'] = $category->type;

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Delete image
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully');
    }
}
