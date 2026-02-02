<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\PromoCode;
use App\Models\ProductPromotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductPromotionController extends Controller
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

    /**
     * Display a listing of product promotions
     */
    public function index(Request $request)
    {
        $query = ProductPromotion::with(['product', 'promoCode'])
            ->latest();
        
        // Search filter
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhereHas('product', function($q) use ($request) {
                      $q->where('name', 'like', "%{$request->search}%");
                  });
            });
        }
        
        // Status filter
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
                case 'upcoming':
                    $query->where('valid_from', '>', now());
                    break;
                case 'inactive':
                    $query->where('is_active', false);
                    break;
            }
        }
        
        $promotions = $query->paginate(20);
        
        return view('pages.admin.promos.product-promotions.index', compact('promotions'));
    }

    /**
     * Show page to select product for creating promotion
     */
    public function selectProduct(Request $request)
    {
        $query = Product::query()->where('is_active', true);
        
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', "%{$request->search}%");
        }
        
        $products = $query->paginate(20);
        
        return view('pages.admin.promos.product-promotions.select-product', compact('products'));
    }

    /**
     * Show the form for creating a new product promotion
     */
    public function create($productId)
    {
        $product = Product::with('productPromotions')->findOrFail($productId);
        
        // PERBAIKAN: Ambil promo codes yang aktif untuk dropdown
        $promoCodes = PromoCode::where('is_active', true)
            ->where('valid_from', '<=', now())
            ->where('valid_until', '>=', now())
            ->where(function($q) {
                $q->whereNull('quota')
                  ->orWhereRaw('used_count < quota');
            })
            ->get(['id', 'code', 'name']);
        
        return view('pages.admin.promos.product-promotions.create', compact('product', 'promoCodes'));
    }

    /**
     * Store a newly created product promotion
     */
    public function store(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'promo_code_id' => 'nullable|exists:promo_codes,id',
            'type' => 'required|in:percentage,nominal',
            'value' => 'required|numeric|min:0',
            'quota' => 'nullable|integer|min:1',
            'used_count' => 'sometimes|integer|min:0',
            'usage_limit_per_user' => 'nullable|integer|min:1',
            'min_purchase' => 'nullable|numeric|min:0',
            'min_quantity' => 'required|integer|min:1',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after:valid_from',
            'is_active' => 'boolean',
            'is_exclusive' => 'boolean',
            'priority' => 'integer|min:0|max:100',
        ]);
        
        // Validasi tambahan berdasarkan tipe diskon
        if ($validated['type'] === 'percentage') {
            $request->validate([
                'value' => 'max:100'
            ]);
        } else {
            // Untuk nominal, pastikan tidak melebihi harga produk
            $maxNominal = $product->price * 0.9; // Maksimal 90% dari harga
            $request->validate([
                'value' => 'max:' . $maxNominal
            ]);
        }
        
        // Set default name jika tidak diisi
        if (empty($validated['name'])) {
            $validated['name'] = "Promo " . $product->name . " - " . 
                ($validated['type'] === 'percentage' ? 
                    $validated['value'] . '%' : 
                    'Rp ' . number_format($validated['value'], 0, ',', '.')
                );
        }
        
        $validated['product_id'] = $productId;
        $validated['is_active'] = $request->has('is_active');
        $validated['is_exclusive'] = $request->has('is_exclusive');
        $validated['used_count'] = $validated['used_count'] ?? 0;
        
        DB::beginTransaction();
        try {
            $promotion = ProductPromotion::create($validated);
            
            // Jika promotion dibuat aktif, refresh calculated discount produk
            if ($promotion->is_active) {
                $product->refreshCalculatedDiscount();
            }
            
            DB::commit();
            
            return redirect()->route('admin.product-promotions.show', $promotion->id)
                ->with('success', 'Product promotion created successfully.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Failed to create promotion: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified product promotion
     */
    public function show($id)
    {
        $promotion = ProductPromotion::with(['product', 'promoCode'])->findOrFail($id);
        
        $summary = [
            'promotion' => [
                'id' => $promotion->id,
                'name' => $promotion->name,
                'type' => $promotion->type,
                'value' => $promotion->value,
                'formatted_value' => $promotion->formatted_value,
                'status' => $promotion->status,
                'is_valid' => $promotion->is_valid,
                'is_exclusive' => $promotion->is_exclusive,
                'priority' => $promotion->priority,
            ],
            'validity' => [
                'valid_from' => $promotion->valid_from->format('d M Y H:i'),
                'valid_until' => $promotion->valid_until->format('d M Y H:i'),
                'remaining_days' => $promotion->remaining_days,
            ],
            'usage' => [
                'used' => $promotion->used_count,
                'quota' => $promotion->quota,
                'remaining' => $promotion->remaining_uses,
                'limit_per_user' => $promotion->usage_limit_per_user,
            ],
            'conditions' => [
                'min_purchase' => $promotion->min_purchase ? 'Rp ' . number_format($promotion->min_purchase, 0, ',', '.') : 'No minimum',
                'min_quantity' => $promotion->min_quantity,
            ],
            'product' => [
                'id' => $promotion->product->id,
                'name' => $promotion->product->name,
                'price' => $promotion->product->formatted_price,
                'final_price_with_promo' => 'Rp ' . number_format($promotion->getFinalPrice($promotion->product->price, 1), 0, ',', '.'),
                'discount_amount' => 'Rp ' . number_format($promotion->getDiscountAmount($promotion->product->price, 1), 0, ',', '.'),
            ],
        ];
        
        if ($promotion->promoCode) {
            $summary['linked_promo_code'] = [
                'id' => $promotion->promoCode->id,
                'code' => $promotion->promoCode->code,
                'name' => $promotion->promoCode->name,
            ];
        }
        
        return view('pages.admin.promos.product-promotions.show', compact('promotion', 'summary'));
    }

    /**
     * Show the form for editing a product promotion
     */
    public function edit($id)
    {
        $promotion = ProductPromotion::with(['product', 'promoCode'])->findOrFail($id);
        
        // PERBAIKAN: Ambil promo codes untuk dropdown
        $promoCodes = PromoCode::where('is_active', true)
            ->where('valid_from', '<=', now())
            ->where('valid_until', '>=', now())
            ->where(function($q) {
                $q->whereNull('quota')
                  ->orWhereRaw('used_count < quota');
            })
            ->get(['id', 'code', 'name']);
        
        return view('pages.admin.promos.product-promotions.edit', compact('promotion', 'promoCodes'));
    }

    /**
     * Update the specified product promotion
     */
    public function update(Request $request, $id)
    {
        $promotion = ProductPromotion::with('product')->findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'promo_code_id' => 'nullable|exists:promo_codes,id',
            'type' => 'required|in:percentage,nominal',
            'value' => 'required|numeric|min:0',
            'quota' => 'nullable|integer|min:' . $promotion->used_count,
            'usage_limit_per_user' => 'nullable|integer|min:1',
            'min_purchase' => 'nullable|numeric|min:0',
            'min_quantity' => 'required|integer|min:1',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after:valid_from',
            'is_active' => 'boolean',
            'is_exclusive' => 'boolean',
            'priority' => 'integer|min:0|max:100',
        ]);
        
        // Validasi tambahan berdasarkan tipe diskon
        if ($validated['type'] === 'percentage') {
            $request->validate([
                'value' => 'max:100'
            ]);
        } else {
            // Untuk nominal, pastikan tidak melebihi harga produk
            $maxNominal = $promotion->product->price * 0.9;
            $request->validate([
                'value' => 'max:' . $maxNominal
            ]);
        }
        
        // Set default name jika tidak diisi
        if (empty($validated['name'])) {
            $validated['name'] = "Promo " . $promotion->product->name . " - " . 
                ($validated['type'] === 'percentage' ? 
                    $validated['value'] . '%' : 
                    'Rp ' . number_format($validated['value'], 0, ',', '.')
                );
        }
        
        $validated['is_active'] = $request->has('is_active');
        $validated['is_exclusive'] = $request->has('is_exclusive');
        
        DB::beginTransaction();
        try {
            $oldStatus = $promotion->is_active;
            
            $promotion->update($validated);
            
            // Jika status aktif berubah, refresh calculated discount produk
            if ($oldStatus != $validated['is_active']) {
                $promotion->product->refreshCalculatedDiscount();
            }
            
            DB::commit();
            
            return redirect()->route('admin.product-promotions.show', $promotion->id)
                ->with('success', 'Product promotion updated successfully.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Failed to update promotion: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified product promotion
     */
    public function destroy($id)
    {
        $promotion = ProductPromotion::with('product')->findOrFail($id);
        $product = $promotion->product;
        
        DB::beginTransaction();
        try {
            $promotion->delete();
            
            // Refresh calculated discount produk setelah promo dihapus
            $product->refreshCalculatedDiscount();
            
            DB::commit();
            
            return redirect()->route('admin.product-promotions.index')
                ->with('success', 'Product promotion deleted successfully.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete promotion: ' . $e->getMessage());
        }
    }

    /**
     * Toggle active status of product promotion
     */
    public function toggleStatus($id)
    {
        $promotion = ProductPromotion::with('product')->findOrFail($id);
        
        DB::beginTransaction();
        try {
            $promotion->update(['is_active' => !$promotion->is_active]);
            
            // Refresh calculated discount produk
            $promotion->product->refreshCalculatedDiscount();
            
            DB::commit();
            
            return back()->with('success', 'Promotion status updated successfully.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update status: ' . $e->getMessage());
        }
    }

    /**
     * Show promotions for specific product
     */
    public function productPromotions($productId)
    {
        $product = Product::with(['productPromotions' => function($query) {
            $query->latest();
        }])->findOrFail($productId);
        
        return view('pages.admin.promos.product-promotions.product-promotions', compact('product'));
    }
}