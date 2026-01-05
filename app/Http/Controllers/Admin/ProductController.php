<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // GET /admin/products
    public function products()
    {
        $products = Product::latest()->get();
        return view('pages.admin.products', compact('products'));
    }

    public function storeProduct(Request $request)
    {
        Product::create($request->all());
        return back()->with('success', 'Product added');
    }

    public function updateProduct(Request $request, $id)
    {
        Product::findOrFail($id)->update($request->all());
        return back()->with('success', 'Product updated');
    }

    public function deleteProduct($id)
    {
        Product::findOrFail($id)->delete();
        return back()->with('success', 'Product deleted');
    }
}
