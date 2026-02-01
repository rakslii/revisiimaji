<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductPromotion;
use App\Models\PromoCode;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductPromotionController extends Controller
{
    /**
     * Display product selection page
     */
    public function selectProduct(Request $request)
    {
        // MUAT SEMUA PROMOTIONS, BUKAN HANYA ACTIVE
        $query = Product::with(['category', 'productPromotions'])->active();
        
        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }
        
        // Filter by category
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }
        
        // Filter by promo status
        if ($request->has('has_promo')) {
            if ($request->has_promo === 'with') {
                $query->whereHas('productPromotions', function($q) {
                    $q->where('is_active', true)
                      ->where('valid_from', '<=', now())
                      ->where('valid_until', '>=', now());
                });
            } elseif ($request->has_promo === 'without') {
                $query->doesntHave('productPromotions', function($q) {
                    $q->where('is_active', true)
                      ->where('valid_from', '<=', now())
                      ->where('valid_until', '>=', now());
                });
            }
        }
        
        $products = $query->latest()->paginate(12);
        
        // Get categories for filter dropdown
        $categories = ProductCategory::orderBy('name')->get();
        
        return view('pages.admin.promos.product-promotions.select-product', 
            compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new promotion for specific product
     */
    public function create($productId)
    {
        // MUAT SEMUA PROMOTIONS
        $product = Product::with(['category', 'productPromotions'])->findOrFail($productId);
        $promoCodes = PromoCode::active()->get();
        
        return view('pages.admin.promos.product-promotions.create', compact('product', 'promoCodes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $productId)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'type' => 'required|in:percentage,nominal',
            'value' => 'required|numeric|min:0',
            'quota' => 'nullable|integer|min:1',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after:valid_from',
            'min_purchase' => 'nullable|numeric|min:0',
            'min_quantity' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
            'is_exclusive' => 'boolean',
            'priority' => 'nullable|integer|min:0|max:100',
            'promo_code_id' => 'nullable|exists:promo_codes,id'
        ]);
        
        $promotion = ProductPromotion::create([
            'product_id' => $productId,
            'name' => $request->name,
            'type' => $request->type,
            'value' => $request->value,
            'quota' => $request->quota,
            'used_count' => 0,
            'valid_from' => $request->valid_from,
            'valid_until' => $request->valid_until,
            'min_purchase' => $request->min_purchase,
            'min_quantity' => $request->min_quantity,
            'is_active' => $request->boolean('is_active'),
            'is_exclusive' => $request->boolean('is_exclusive'),
            'priority' => $request->priority ?? 0,
            'promo_code_id' => $request->promo_code_id
        ]);
        
        return redirect()->route('admin.product-promotions.show', $promotion->id)
            ->with('success', 'Product promotion created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $promotion = ProductPromotion::with(['product', 'promoCode', 'product.category'])->findOrFail($id);
        
        return view('pages.admin.promos.product-promotions.show', compact('promotion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $promotion = ProductPromotion::with(['product', 'promoCode'])->findOrFail($id);
        $promoCodes = PromoCode::active()->get();
        
        return view('pages.admin.promos.product-promotions.edit', compact('promotion', 'promoCodes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $promotion = ProductPromotion::findOrFail($id);
        
        $request->validate([
            'name' => 'nullable|string|max:255',
            'type' => 'required|in:percentage,nominal',
            'value' => 'required|numeric|min:0',
            'quota' => 'nullable|integer|min:' . $promotion->used_count,
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after:valid_from',
            'min_purchase' => 'nullable|numeric|min:0',
            'min_quantity' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
            'is_exclusive' => 'boolean',
            'priority' => 'nullable|integer|min:0|max:100',
            'promo_code_id' => 'nullable|exists:promo_codes,id'
        ]);
        
        $promotion->update([
            'name' => $request->name,
            'type' => $request->type,
            'value' => $request->value,
            'quota' => $request->quota,
            'valid_from' => $request->valid_from,
            'valid_until' => $request->valid_until,
            'min_purchase' => $request->min_purchase,
            'min_quantity' => $request->min_quantity,
            'is_active' => $request->boolean('is_active'),
            'is_exclusive' => $request->boolean('is_exclusive'),
            'priority' => $request->priority ?? 0,
            'promo_code_id' => $request->promo_code_id
        ]);
        
        return redirect()->route('admin.product-promotions.show', $promotion->id)
            ->with('success', 'Product promotion updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $promotion = ProductPromotion::findOrFail($id);
        $promotion->delete();
        
        return redirect()->route('admin.product-promotions.select-product')
            ->with('success', 'Product promotion deleted successfully.');
    }

    /**
     * Toggle active status
     */
    public function toggleStatus($id)
    {
        $promotion = ProductPromotion::findOrFail($id);
        $promotion->update(['is_active' => !$promotion->is_active]);
        
        return back()->with('success', 'Status updated successfully.');
    }

    /**
     * List all product promotions
     */
    public function index(Request $request)
    {
        $query = ProductPromotion::with(['product', 'promoCode']);
        
        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhereHas('product', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  })
                  ->orWhereHas('promoCode', function($q) use ($request) {
                      $q->where('code', 'like', '%' . $request->search . '%')
                        ->orWhere('name', 'like', '%' . $request->search . '%');
                  });
            });
        }
        
        // Filter by status
        if ($request->has('status') && $request->status) {
            switch($request->status) {
                case 'active':
                    $query->where('is_active', true)
                          ->where('valid_from', '<=', now())
                          ->where('valid_until', '>=', now())
                          ->where(function($q) {
                              $q->whereNull('quota')
                                ->orWhereRaw('used_count < quota');
                          });
                    break;
                case 'expired':
                    $query->where('valid_until', '<', now());
                    break;
                case 'inactive':
                    $query->where('is_active', false);
                    break;
                case 'upcoming':
                    $query->where('valid_from', '>', now());
                    break;
            }
        }
        
        // Filter by product
        if ($request->has('product_id') && $request->product_id) {
            $query->where('product_id', $request->product_id);
        }
        
        $promotions = $query->latest()->paginate(15);
        
        return view('pages.admin.promos.product-promotions.index', compact('promotions'));
    }

    /**
     * Show promotions for specific product
     */
    public function productPromotions($productId)
    {
        // MUAT SEMUA PROMOTIONS
        $product = Product::with(['productPromotions' => function($query) {
            $query->with('promoCode')->latest();
        }])->findOrFail($productId);
        
        return view('pages.admin.promos.product-promotions.product-list', compact('product'));
    }

    /**
     * Reset used count for a promotion
     */
    public function resetUsedCount($id)
    {
        $promotion = ProductPromotion::findOrFail($id);
        $promotion->update(['used_count' => 0]);
        
        return back()->with('success', 'Used count has been reset to 0.');
    }

    /**
     * Duplicate a promotion
     */
    public function duplicate($id)
    {
        $original = ProductPromotion::findOrFail($id);
        
        $newPromotion = $original->replicate();
        $newPromotion->name = $original->name . ' (Copy)';
        $newPromotion->used_count = 0;
        $newPromotion->save();
        
        return redirect()->route('admin.product-promotions.edit', $newPromotion->id)
            ->with('success', 'Promotion duplicated successfully. You can now edit the copy.');
    }
}