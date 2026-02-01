<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromoCode;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PromoCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PromoCode::with('products')->latest();
        
        // Search filter
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('code', 'like', "%{$request->search}%")
                  ->orWhere('name', 'like', "%{$request->search}%");
            });
        }
        
        // Status filter
        if ($request->has('status') && $request->status) {
            switch($request->status) {
                case 'active':
                    $query->where('is_active', true)
                          ->where('valid_from', '<=', now())
                          ->where('valid_until', '>=', now())
                          ->whereRaw('used_count < quota');
                    break;
                case 'expired':
                    $query->where('valid_until', '<', now());
                    break;
                case 'inactive':
                    $query->where('is_active', false);
                    break;
                case 'quota_exceeded':
                    $query->whereRaw('used_count >= quota');
                    break;
            }
        }
        
        $promoCodes = $query->paginate(10);
        
        return view('pages.admin.promos.index', compact('promoCodes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::active()->get();
        return view('pages.admin.promos.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'nullable|string|unique:promo_codes,code|max:50',
            'name' => 'required|string|max:255',
            'type' => 'required|in:percentage,nominal',
            'value' => 'required|numeric|min:0',
            'quota' => 'required|integer|min:1',
            'min_purchase' => 'nullable|numeric|min:0',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after:valid_from',
            'is_active' => 'boolean',
            'is_for_all_products' => 'boolean',
            'product_scope' => 'nullable|array',
            'product_ids' => 'nullable|array',
            'product_ids.*' => 'exists:products,id',
            'product_discount_type' => 'nullable|in:percentage,nominal',
            'product_discount_value' => 'nullable|numeric|min:0',
            'max_usage_per_product' => 'nullable|integer|min:1',
        ]);

        // Generate code if not provided
        if (empty($validated['code'])) {
            do {
                $code = strtoupper(Str::random(8));
            } while (PromoCode::where('code', $code)->exists());
            $validated['code'] = $code;
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['is_for_all_products'] = $request->has('is_for_all_products');
        $validated['used_count'] = 0;

        // Create promo code
        $promoCode = PromoCode::create($validated);

        // Sync products jika tidak untuk semua produk
        if (!$promoCode->is_for_all_products && $request->has('product_ids')) {
            $productData = [];
            foreach ($request->product_ids as $productId) {
                $productData[$productId] = [
                    'discount_amount' => $request->product_discount_value ?? null,
                    'discount_type' => $request->product_discount_type ?? null,
                    'max_usage_per_product' => $request->max_usage_per_product ?? null,
                ];
            }
            
            $promoCode->products()->sync($productData);
        }

        return redirect()->route('admin.promos.index')
            ->with('success', 'Promo code created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $promoCode = PromoCode::with(['products' => function($query) {
            $query->with('category');
        }])->findOrFail($id);
        
        return view('pages.admin.promos.show', compact('promoCode'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $promoCode = PromoCode::with('products')->findOrFail($id);
        $products = Product::active()->get();
        
        return view('pages.admin.promos.edit', compact('promoCode', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $promoCode = PromoCode::findOrFail($id);

        $validated = $request->validate([
            'code' => 'required|string|unique:promo_codes,code,' . $id . '|max:50',
            'name' => 'required|string|max:255',
            'type' => 'required|in:percentage,nominal',
            'value' => 'required|numeric|min:0',
            'quota' => 'required|integer|min:' . $promoCode->used_count,
            'min_purchase' => 'nullable|numeric|min:0',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after:valid_from',
            'is_active' => 'boolean',
            'is_for_all_products' => 'boolean',
            'product_scope' => 'nullable|array',
            'product_ids' => 'nullable|array',
            'product_ids.*' => 'exists:products,id',
            'product_discount_type' => 'nullable|in:percentage,nominal',
            'product_discount_value' => 'nullable|numeric|min:0',
            'max_usage_per_product' => 'nullable|integer|min:1',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['is_for_all_products'] = $request->has('is_for_all_products');

        // Update promo code
        $promoCode->update($validated);

        // Sync products jika tidak untuk semua produk
        if (!$promoCode->is_for_all_products && $request->has('product_ids')) {
            $productData = [];
            foreach ($request->product_ids as $productId) {
                $productData[$productId] = [
                    'discount_amount' => $request->product_discount_value ?? null,
                    'discount_type' => $request->product_discount_type ?? null,
                    'max_usage_per_product' => $request->max_usage_per_product ?? null,
                ];
            }
            
            $promoCode->products()->sync($productData);
        } elseif ($promoCode->is_for_all_products) {
            // Jika untuk semua produk, hapus semua relasi produk
            $promoCode->products()->detach();
        }

        return redirect()->route('admin.promos.index')
            ->with('success', 'Promo code updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $promoCode = PromoCode::findOrFail($id);
        
        // Detach all products first
        $promoCode->products()->detach();
        
        // Then delete promo
        $promoCode->delete();

        return redirect()->route('admin.promos.index')
            ->with('success', 'Promo code deleted successfully.');
    }

    /**
     * Toggle active status
     */
    public function toggleStatus($id)
    {
        $promoCode = PromoCode::findOrFail($id);
        $promoCode->update(['is_active' => !$promoCode->is_active]);

        return back()->with('success', 'Status updated successfully.');
    }

    /**
     * Show form to add/remove products from promo
     */
    public function manageProducts($id)
    {
        $promoCode = PromoCode::with('products')->findOrFail($id);
        $products = Product::active()->get();
        
        return view('pages.admin.promos.manage-products', compact('promoCode', 'products'));
    }

    /**
     * Update products for promo
     */
    public function updateProducts(Request $request, $id)
    {
        $promoCode = PromoCode::findOrFail($id);
        
        $request->validate([
            'product_ids' => 'nullable|array',
            'product_ids.*' => 'exists:products,id',
            'discount_type' => 'nullable|in:percentage,nominal',
            'discount_value' => 'nullable|numeric|min:0',
            'max_usage_per_product' => 'nullable|integer|min:1',
        ]);
        
        $productData = [];
        if ($request->has('product_ids')) {
            foreach ($request->product_ids as $productId) {
                $productData[$productId] = [
                    'discount_amount' => $request->discount_value ?? null,
                    'discount_type' => $request->discount_type ?? null,
                    'max_usage_per_product' => $request->max_usage_per_product ?? null,
                ];
            }
        }
        
        $promoCode->products()->sync($productData);
        
        return redirect()->route('admin.promos.edit', $promoCode->id)
            ->with('success', 'Products updated successfully.');
    }

    /**
     * Remove product from promo
     */
    public function removeProduct(Request $request, $id)
    {
        $promoCode = PromoCode::findOrFail($id);
        
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);
        
        $promoCode->products()->detach($request->product_id);
        
        return response()->json([
            'success' => true,
            'message' => 'Product removed from promo'
        ]);
    }

    /**
     * Add product to promo
     */
    public function addProduct(Request $request, $id)
    {
        $promoCode = PromoCode::findOrFail($id);
        
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'discount_type' => 'nullable|in:percentage,nominal',
            'discount_value' => 'nullable|numeric|min:0',
            'max_usage_per_product' => 'nullable|integer|min:1',
        ]);
        
        $promoCode->products()->syncWithoutDetaching([
            $request->product_id => [
                'discount_amount' => $request->discount_value ?? null,
                'discount_type' => $request->discount_type ?? null,
                'max_usage_per_product' => $request->max_usage_per_product ?? null,
            ]
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Product added to promo'
        ]);
    }
}