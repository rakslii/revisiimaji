<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductManagementController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(15);
        $categories = Category::all();
        
        return view('admin.products.index', compact('products', 'categories'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'image' => 'required|image|max:5120',
            'is_active' => 'boolean',
        ]);
        
        $validated['is_active'] = $request->has('is_active');
        
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }
        
        Product::create($validated);
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully');
    }
    
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:5120',
            'is_active' => 'boolean',
        ]);
        
        $validated['is_active'] = $request->has('is_active');
        
        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                \Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }
        
        $product->update($validated);
        
        return back()->with('success', 'Product updated successfully');
    }
    
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        // Delete image
        if ($product->image) {
            \Storage::disk('public')->delete($product->image);
        }
        
        $product->delete();
        
        return back()->with('success', 'Product deleted successfully');
    }

}