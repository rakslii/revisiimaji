<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory; // Ganti dari Category ke ProductCategory
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
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
public function index(Request $request)
{
    $query = Product::with('category');
    
    // Search by name or description
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
    
    $products = $query->latest()->paginate(10);
    $categories = ProductCategory::active()->get();
    
    return view('pages.admin.products.index', compact('products', 'categories'));
}

    public function create()
    {
        $categories = ProductCategory::active()->get();
        return view('pages.admin.products.create', compact('categories'));
    }

    public function store(Request $request) // Ubah dari storeProduct() ke store()
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
            'image' => 'nullable|image|max:2048',
            'specifications' => 'nullable|array',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        // Set default values
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;
        $validated['category'] = ProductCategory::find($validated['category_id'])->type;

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully');
    }

    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return view('pages.admin.products.show', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = ProductCategory::active()->get();
        return view('pages.admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id) // Ubah dari updateProduct() ke update()
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
            'image' => 'nullable|image|max:2048',
            'specifications' => 'nullable|array',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image jika ada
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;
        $validated['category'] = ProductCategory::find($validated['category_id'])->type;

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully');
    }

    public function destroy($id) // Ubah dari deleteProduct() ke destroy()
    {
        $product = Product::findOrFail($id);

        // Delete image jika ada
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully');
    }
}
