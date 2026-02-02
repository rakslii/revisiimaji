<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromoCode;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PromoCodeController extends Controller
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
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PromoCode::query()->withCount('specificProducts')->latest();
        
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
                case 'quota_exceeded':
                    $query->whereRaw('used_count >= quota');
                    break;
            }
        }
        
        // Assignment type filter
        if ($request->has('assignment_type') && $request->assignment_type) {
            $query->where('product_assignment_type', $request->assignment_type);
        }
        
        $promoCodes = $query->paginate(20);
        
        // Statistics
        $stats = [
            'total' => PromoCode::count(),
            'active' => PromoCode::where('is_active', true)
                        ->where('valid_from', '<=', now())
                        ->where('valid_until', '>=', now())
                        ->where(function($q) {
                            $q->whereNull('quota')
                              ->orWhereRaw('used_count < quota');
                        })->count(),
            'expired' => PromoCode::where('valid_until', '<', now())->count(),
            'upcoming' => PromoCode::where('valid_from', '>', now())->count(),
        ];
        
        return view('pages.admin.promos.index', compact('promoCodes', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // PERBAIKAN 1: Gunakan scope dengan benar
        $products = Product::where('is_active', true)->with('category')->get();
        
        $categories = ProductCategory::withCount(['products' => function($query) {
            $query->where('is_active', true);
        }])->get();
        
        return view('pages.admin.promos.create', compact('products', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $this->validatePromoCode($request);

        // Generate code if not provided
        if (empty($validated['code'])) {
            do {
                $code = strtoupper(Str::random(8));
            } while (PromoCode::where('code', $code)->exists());
            $validated['code'] = $code;
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['is_exclusive'] = $request->has('is_exclusive');
        $validated['used_count'] = 0;

        // Handle category_ids
        if ($request->filled('category_ids')) {
            $validated['category_ids'] = $request->category_ids;
        }

        DB::beginTransaction();
        try {
            // Create promo code
            $promoCode = PromoCode::create($validated);

            // Handle specific products if selected
            if ($validated['product_assignment_type'] === 'specific_products' && $request->has('specific_product_ids')) {
                $this->syncSpecificProducts($promoCode, $request);
            }

            DB::commit();
            
            return redirect()->route('admin.promos.show', $promoCode->id)
                ->with('success', 'Promo code created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Failed to create promo code: ' . $e->getMessage());
        }
    }

    /**
     * Validate promo code data
     */
    private function validatePromoCode(Request $request)
    {
        $rules = [
            'code' => 'nullable|string|unique:promo_codes,code|max:50',
            'name' => 'required|string|max:255',
            'type' => 'required|in:percentage,nominal',
            'value' => 'required|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'quota' => 'required|integer|min:1',
            'usage_limit_per_user' => 'nullable|integer|min:1',
            'min_purchase' => 'nullable|numeric|min:0',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after:valid_from',
            'is_active' => 'boolean',
            'is_exclusive' => 'boolean',
            'priority' => 'integer|min:0|max:10',
            'product_assignment_type' => 'required|in:all,specific_products,category_based,price_range,stock_based',
            'product_discount_type' => 'nullable|in:same_as_promo,custom',
            'stock_filter' => 'nullable|in:any,in_stock,low_stock,out_of_stock',
        ];

        // Conditional rules based on assignment type
        switch ($request->product_assignment_type) {
            case 'specific_products':
                $rules['specific_product_ids'] = 'required|array|min:1';
                $rules['specific_product_ids.*'] = 'exists:products,id';
                break;
            case 'category_based':
                $rules['category_ids'] = 'required|array|min:1';
                $rules['category_ids.*'] = 'exists:product_categories,id';
                break;
            case 'price_range':
                $rules['min_product_price'] = 'nullable|numeric|min:0';
                $rules['max_product_price'] = 'nullable|numeric|min:0';
                break;
        }

        return $request->validate($rules);
    }

    /**
     * Sync specific products with custom discounts
     */
    private function syncSpecificProducts(PromoCode $promoCode, Request $request)
    {
        $productData = [];
        $discountType = $request->product_discount_type === 'custom' ? null : $promoCode->type;
        $discountValue = $request->product_discount_type === 'custom' ? null : $promoCode->value;

        foreach ($request->specific_product_ids as $productId) {
            $productData[$productId] = [
                'discount_type' => $discountType,
                'discount_value' => $discountValue,
                'max_usage' => null,
                'used_count' => 0,
            ];
        }

        $promoCode->specificProducts()->sync($productData);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $promoCode = PromoCode::with(['specificProducts' => function($query) {
            $query->with('category');
        }])->findOrFail($id);
        
        // Get eligible products based on assignment type
        $eligibleProducts = $promoCode->getEligibleProducts();
        
        $summary = [
            'promo' => [
                'id' => $promoCode->id,
                'code' => $promoCode->code,
                'name' => $promoCode->name,
                'type' => $promoCode->type,
                'value' => $promoCode->value,
                'formatted_value' => $promoCode->formatted_value,
                'max_discount' => $promoCode->max_discount,
                'min_purchase' => $promoCode->min_purchase,
                'status' => $promoCode->status,
                'is_valid' => $promoCode->is_valid,
                'is_exclusive' => $promoCode->is_exclusive,
                'priority' => $promoCode->priority,
            ],
            'validity' => [
                'valid_from' => $promoCode->valid_from->format('d M Y H:i'),
                'valid_until' => $promoCode->valid_until->format('d M Y H:i'),
                'remaining_days' => $promoCode->remaining_days,
            ],
            'usage' => [
                'used' => $promoCode->used_count,
                'quota' => $promoCode->quota,
                'remaining' => $promoCode->remaining_uses,
                'limit_per_user' => $promoCode->usage_limit_per_user,
            ],
            'product_assignment' => [
                'type' => $promoCode->product_assignment_type,
                'summary' => $promoCode->product_assignment_summary,
                'eligible_count' => $eligibleProducts->count(),
                'eligible_products' => $eligibleProducts->take(10),
            ],
        ];
        
        return view('pages.admin.promos.show', compact('promoCode', 'summary'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $promoCode = PromoCode::with('specificProducts')->findOrFail($id);
        // PERBAIKAN 2: Gunakan where condition langsung
        $products = Product::where('is_active', true)->with('category')->get();
        $categories = ProductCategory::withCount('products')->get();
        
        return view('pages.admin.promos.edit', compact('promoCode', 'products', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $promoCode = PromoCode::findOrFail($id);

        $validated = $this->validatePromoCodeForUpdate($request, $promoCode);

        $validated['is_active'] = $request->has('is_active');
        $validated['is_exclusive'] = $request->has('is_exclusive');

        // Handle category_ids
        if ($request->filled('category_ids')) {
            $validated['category_ids'] = $request->category_ids;
        } else {
            $validated['category_ids'] = null;
        }

        DB::beginTransaction();
        try {
            // Update promo code
            $promoCode->update($validated);

            // Handle specific products
            if ($validated['product_assignment_type'] === 'specific_products' && $request->has('specific_product_ids')) {
                $this->syncSpecificProducts($promoCode, $request);
            } else {
                // Clear specific products if not in this mode
                $promoCode->specificProducts()->detach();
            }

            DB::commit();
            
            return redirect()->route('admin.promos.show', $promoCode->id)
                ->with('success', 'Promo code updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Failed to update promo code: ' . $e->getMessage());
        }
    }

    /**
     * Validate promo code data for update
     */
    private function validatePromoCodeForUpdate(Request $request, PromoCode $promoCode)
    {
        $rules = [
            'code' => 'required|string|unique:promo_codes,code,' . $promoCode->id . '|max:50',
            'name' => 'required|string|max:255',
            'type' => 'required|in:percentage,nominal',
            'value' => 'required|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'quota' => 'required|integer|min:' . $promoCode->used_count,
            'usage_limit_per_user' => 'nullable|integer|min:1',
            'min_purchase' => 'nullable|numeric|min:0',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after:valid_from',
            'is_active' => 'boolean',
            'is_exclusive' => 'boolean',
            'priority' => 'integer|min:0|max:10',
            'product_assignment_type' => 'required|in:all,specific_products,category_based,price_range,stock_based',
            'product_discount_type' => 'nullable|in:same_as_promo,custom',
            'stock_filter' => 'nullable|in:any,in_stock,low_stock,out_of_stock',
        ];

        // Conditional rules
        switch ($request->product_assignment_type) {
            case 'specific_products':
                $rules['specific_product_ids'] = 'required|array|min:1';
                $rules['specific_product_ids.*'] = 'exists:products,id';
                break;
            case 'category_based':
                $rules['category_ids'] = 'required|array|min:1';
                $rules['category_ids.*'] = 'exists:product_categories,id';
                break;
            case 'price_range':
                $rules['min_product_price'] = 'nullable|numeric|min:0';
                $rules['max_product_price'] = 'nullable|numeric|min:0';
                
                // Validate price range
                if ($request->min_product_price && $request->max_product_price) {
                    $rules['max_product_price'] .= '|gte:min_product_price';
                }
                break;
        }

        return $request->validate($rules);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $promoCode = PromoCode::findOrFail($id);
        
        DB::beginTransaction();
        try {
            // Detach specific products
            $promoCode->specificProducts()->detach();
            
            // Delete promo code
            $promoCode->delete();
            
            DB::commit();
            
            return redirect()->route('admin.promos.index')
                ->with('success', 'Promo code deleted successfully.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.promos.index')
                ->with('error', 'Failed to delete promo code: ' . $e->getMessage());
        }
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
     * Get eligible products preview (AJAX)
     */
    public function getEligibleProductsPreview(Request $request)
    {
        $request->validate([
            'assignment_type' => 'required|in:all,specific_products,category_based,price_range,stock_based',
            'category_ids' => 'nullable|array',
            'min_product_price' => 'nullable|numeric',
            'max_product_price' => 'nullable|numeric',
            'stock_filter' => 'nullable|in:any,in_stock,low_stock,out_of_stock',
        ]);

        // PERBAIKAN 3: Gunakan where condition
        $query = Product::query()->where('is_active', true)->with('category');

        switch ($request->assignment_type) {
            case 'category_based':
                if ($request->filled('category_ids')) {
                    $query->whereIn('category_id', $request->category_ids);
                }
                break;
            case 'price_range':
                if ($request->filled('min_product_price')) {
                    $query->where('price', '>=', $request->min_product_price);
                }
                if ($request->filled('max_product_price')) {
                    $query->where('price', '<=', $request->max_product_price);
                }
                break;
            case 'stock_based':
                switch ($request->stock_filter) {
                    case 'in_stock':
                        $query->where('stock', '>', 0);
                        break;
                    case 'low_stock':
                        $query->where('stock', '>', 0)->where('stock', '<=', 10);
                        break;
                    case 'out_of_stock':
                        $query->where('stock', '<=', 0);
                        break;
                }
                break;
        }

        $count = $query->count();
        $products = $query->take(5)->get();

        return response()->json([
            'count' => $count,
            'products' => $products->map(function($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => 'Rp ' . number_format($product->price, 0, ',', '.'),
                    'stock' => $product->stock,
                    'category' => $product->category_name,
                ];
            }),
            'message' => "Found {$count} eligible products"
        ]);
    }
}