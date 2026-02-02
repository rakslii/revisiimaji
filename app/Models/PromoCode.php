<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PromoCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'type',
        'value',
        'max_discount',
        'quota',
        'used_count',
        'usage_limit_per_user',
        'min_purchase',
        'valid_from',
        'valid_until',
        'is_active',
        'is_exclusive',
        'priority',
        'is_for_all_products',
        'product_assignment_type',
        'category_ids',
        'min_product_price',
        'max_product_price',
        'stock_filter',
        'product_discount_type'
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'max_discount' => 'decimal:2',
        'min_purchase' => 'decimal:2',
        'min_product_price' => 'decimal:2',
        'max_product_price' => 'decimal:2',
        'quota' => 'integer',
        'used_count' => 'integer',
        'usage_limit_per_user' => 'integer',
        'priority' => 'integer',
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'is_active' => 'boolean',
        'is_exclusive' => 'boolean',
        'is_for_all_products' => 'boolean',
        'category_ids' => 'array',
        'product_assignment_type' => 'string',
        'stock_filter' => 'string',
        'product_discount_type' => 'string'
    ];

    protected $appends = [
        'formatted_value',
        'status',
        'is_valid',
        'remaining_days',
        'remaining_uses',
        'product_assignment_summary',
        'eligible_products_count'
    ];

    // ============ RELATIONSHIPS ============

    public function productPromotions()
    {
        return $this->hasMany(ProductPromotion::class);
    }

    // Relasi dengan produk spesifik yang dipilih
    public function specificProducts()
    {
        return $this->belongsToMany(Product::class, 'promo_code_products')
                    ->withPivot(['discount_type', 'discount_value', 'max_usage', 'used_count'])
                    ->withTimestamps();
    }

    // Relasi dengan kategori
    public function categories()
    {
        return $this->belongsToMany(ProductCategory::class, 'promo_code_categories', 'promo_code_id', 'category_id');
    }

    // ============ ACCESSORS ============

    public function getFormattedValueAttribute()
    {
        if ($this->type === 'percentage') {
            $value = number_format($this->value, 0);
            return $this->max_discount ? "{$value}% (max Rp " . number_format($this->max_discount, 0, ',', '.') . ")" : "{$value}%";
        }
        
        return 'Rp ' . number_format($this->value, 0, ',', '.');
    }

    public function getStatusAttribute()
    {
        if (!$this->is_active) {
            return 'inactive';
        }
        
        $now = now();
        if ($this->valid_from > $now) {
            return 'upcoming';
        }
        
        if ($this->valid_until < $now) {
            return 'expired';
        }
        
        if ($this->quota && $this->used_count >= $this->quota) {
            return 'quota_exceeded';
        }
        
        return 'active';
    }

    public function getIsValidAttribute()
    {
        return $this->is_active &&
               $this->valid_from <= now() &&
               $this->valid_until >= now() &&
               (!$this->quota || $this->used_count < $this->quota);
    }

    public function getRemainingDaysAttribute()
    {
        if ($this->valid_until < now()) {
            return 0;
        }
        
        return max(0, now()->diffInDays($this->valid_until));
    }

    public function getRemainingUsesAttribute()
    {
        if (!$this->quota) {
            return null;
        }
        
        return max(0, $this->quota - $this->used_count);
    }

    public function getProductAssignmentSummaryAttribute()
    {
        switch ($this->product_assignment_type) {
            case 'all':
                return 'Semua Produk';
            case 'specific_products':
                $count = $this->specificProducts()->count();
                return "{$count} Produk Spesifik";
            case 'category_based':
                $categories = $this->category_ids ? ProductCategory::whereIn('id', $this->category_ids)->pluck('name')->toArray() : [];
                return "Kategori: " . implode(', ', $categories);
            case 'price_range':
                $min = $this->min_product_price ? 'Rp ' . number_format($this->min_product_price, 0, ',', '.') : 'Tidak ada';
                $max = $this->max_product_price ? 'Rp ' . number_format($this->max_product_price, 0, ',', '.') : 'Tidak ada';
                return "Harga: {$min} - {$max}";
            case 'stock_based':
                return "Stok: " . match($this->stock_filter) {
                    'in_stock' => 'Produk Tersedia',
                    'low_stock' => 'Stok Rendah',
                    'out_of_stock' => 'Stok Habis',
                    default => 'Semua Stok'
                };
            default:
                return 'Tidak ditentukan';
        }
    }

    public function getEligibleProductsCountAttribute()
    {
        return $this->getEligibleProductsQuery()->count();
    }

    // ============ METHODS ============

    /**
     * Dapatkan query untuk produk yang eligible
     */
    public function getEligibleProductsQuery()
    {
        $query = Product::query()->active();

        switch ($this->product_assignment_type) {
            case 'all':
                // Semua produk aktif
                break;

            case 'specific_products':
                // Produk spesifik yang dipilih
                $query->whereIn('id', $this->specificProducts()->pluck('products.id'));
                break;

            case 'category_based':
                // Berdasarkan kategori
                if ($this->category_ids) {
                    $query->whereIn('category_id', $this->category_ids);
                }
                break;

            case 'price_range':
                // Berdasarkan range harga
                if ($this->min_product_price) {
                    $query->where('price', '>=', $this->min_product_price);
                }
                if ($this->max_product_price) {
                    $query->where('price', '<=', $this->max_product_price);
                }
                break;

            case 'stock_based':
                // Berdasarkan stok
                switch ($this->stock_filter) {
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

        return $query;
    }

    /**
     * Dapatkan produk yang eligible
     */
    public function getEligibleProducts()
    {
        return $this->getEligibleProductsQuery()->get();
    }

    /**
     * Hitung diskon untuk produk tertentu
     */
    public function getDiscountForProduct(Product $product, $quantity = 1)
    {
        if (!$this->is_valid || !$this->appliesToProduct($product)) {
            return 0;
        }

        // Cek apakah produk punya diskon custom
        $customDiscount = $this->specificProducts()
            ->where('product_id', $product->id)
            ->first();

        $discountType = $customDiscount?->pivot->discount_type ?? $this->type;
        $discountValue = $customDiscount?->pivot->discount_value ?? $this->value;

        $totalPrice = $product->price * $quantity;

        if ($discountType === 'percentage') {
            $discountAmount = ($totalPrice * $discountValue) / 100;
            
            // Apply max discount if set
            if ($this->max_discount) {
                $discountAmount = min($discountAmount, $this->max_discount);
            }
            
            return $discountAmount;
        }

        return min($discountValue * $quantity, $totalPrice);
    }

    /**
     * Cek apakah promo berlaku untuk produk tertentu
     */
    public function appliesToProduct(Product $product)
    {
        // Cek produk aktif
        if (!$product->is_active) {
            return false;
        }

        // Cek apakah produk termasuk dalam produk yang eligible
        return $this->getEligibleProductsQuery()
            ->where('products.id', $product->id)
            ->exists();
    }

    /**
     * Mark as used untuk produk tertentu
     */
    public function markAsUsedForProduct($productId, $quantity = 1)
    {
        DB::transaction(function () use ($productId, $quantity) {
            // Update global used_count
            $this->increment('used_count', $quantity);
            
            // Update pivot used_count jika ada
            $this->specificProducts()->where('product_id', $productId)
                ->update([
                    'used_count' => DB::raw('used_count + ' . $quantity)
                ]);
        });
    }

    /**
     * Sync produk spesifik dengan diskon custom
     */
    public function syncSpecificProductsWithDiscounts($productsData)
    {
        $syncData = [];
        
        foreach ($productsData as $productId => $data) {
            $syncData[$productId] = [
                'discount_type' => $data['discount_type'] ?? $this->type,
                'discount_value' => $data['discount_value'] ?? $this->value,
                'max_usage' => $data['max_usage'] ?? null,
            ];
        }
        
        $this->specificProducts()->sync($syncData);
        
        return $this;
    }

    /**
     * Dapatkan summary lengkap promo
     */
    public function getFullSummary()
    {
        $eligibleProducts = $this->getEligibleProducts();
        
        return [
            'promo' => $this->only(['id', 'code', 'name', 'type', 'value', 'formatted_value', 'status', 'is_valid']),
            'validity' => [
                'valid_from' => $this->valid_from->format('d M Y H:i'),
                'valid_until' => $this->valid_until->format('d M Y H:i'),
                'remaining_days' => $this->remaining_days,
            ],
            'usage' => [
                'used' => $this->used_count,
                'quota' => $this->quota,
                'remaining' => $this->remaining_uses,
                'limit_per_user' => $this->usage_limit_per_user,
            ],
            'product_assignment' => [
                'type' => $this->product_assignment_type,
                'summary' => $this->product_assignment_summary,
                'eligible_count' => $eligibleProducts->count(),
                'eligible_products' => $eligibleProducts->take(10)->map(function($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->formatted_price,
                        'stock' => $product->stock,
                        'category' => $product->category_name,
                    ];
                }),
            ],
            'discount_details' => [
                'max_discount' => $this->max_discount ? 'Rp ' . number_format($this->max_discount, 0, ',', '.') : null,
                'min_purchase' => $this->min_purchase ? 'Rp ' . number_format($this->min_purchase, 0, ',', '.') : null,
                'product_discount_type' => $this->product_discount_type,
                'is_exclusive' => $this->is_exclusive,
                'priority' => $this->priority,
            ],
        ];
    }
}