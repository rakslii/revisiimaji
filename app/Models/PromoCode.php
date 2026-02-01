<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// HAPUS SoftDeletes KARENA TIDAK ADA KOLOM deleted_at
// use Illuminate\Database\Eloquent\SoftDeletes;

class PromoCode extends Model
{
    use HasFactory;
    // HAPUS SoftDeletes
    // use SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'description',
        'type',
        'value',
        'max_discount',
        'min_purchase',
        'quota',
        'used_count',
        'valid_from',
        'valid_until',
        'is_active',
        'is_global',
        'customer_limit',
        'usage_limit_per_user'
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'max_discount' => 'decimal:2',
        'min_purchase' => 'decimal:2',
        'quota' => 'integer',
        'used_count' => 'integer',
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'is_active' => 'boolean',
        'is_global' => 'boolean',
        'customer_limit' => 'integer',
        'usage_limit_per_user' => 'integer'
    ];

    protected $appends = [
        'formatted_value',
        'status',
        'is_valid',
        'remaining_days',
        'remaining_uses'
    ];

    // HAPUS KARENA TIDAK MENGGUNAKAN SoftDeletes
    // protected $dates = ['deleted_at'];

    // ============ RELATIONSHIPS ============

    // Relasi dengan product_promotions
    public function productPromotions()
    {
        return $this->hasMany(ProductPromotion::class);
    }

    // Relasi dengan produk melalui product_promotions
    public function products()
    {
        return $this->hasManyThrough(
            Product::class,
            ProductPromotion::class,
            'promo_code_id', // Foreign key on ProductPromotion table
            'id',            // Foreign key on Product table
            'id',            // Local key on PromoCode table
            'product_id'     // Local key on ProductPromotion table
        );
    }

    // ============ SCOPES ============

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                     ->where('valid_from', '<=', now())
                     ->where('valid_until', '>=', now())
                     ->where(function($q) {
                         $q->whereNull('quota')
                           ->orWhereRaw('used_count < quota');
                     });
    }

    public function scopeExpired($query)
    {
        return $query->where('valid_until', '<', now());
    }

    public function scopeUpcoming($query)
    {
        return $query->where('valid_from', '>', now());
    }

    public function scopeGlobal($query)
    {
        return $query->where('is_global', true);
    }

    public function scopeNonGlobal($query)
    {
        return $query->where('is_global', false);
    }

    public function scopeValid($query)
    {
        return $this->scopeActive($query);
    }

    public function scopeWithStatus($query, $status)
    {
        switch($status) {
            case 'active':
                return $this->scopeActive($query);
            case 'expired':
                return $this->scopeExpired($query);
            case 'upcoming':
                return $this->scopeUpcoming($query);
            case 'inactive':
                return $query->where('is_active', false);
            default:
                return $query;
        }
    }

    // ============ ACCESSORS ============

    public function getFormattedValueAttribute()
    {
        if ($this->type === 'percentage') {
            return number_format($this->value, 0) . '%';
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

    // ============ METHODS ============

    public function getDiscountAmount($price)
    {
        if (!$this->is_valid) {
            return 0;
        }

        if ($this->type === 'percentage') {
            $discount = ($price * $this->value) / 100;
            
            // Apply max discount if set
            if ($this->max_discount && $discount > $this->max_discount) {
                $discount = $this->max_discount;
            }
            
            return $discount;
        }

        return min($this->value, $price);
    }

    public function getFinalPrice($price)
    {
        $discount = $this->getDiscountAmount($price);
        return max(0, $price - $discount);
    }

    public function markAsUsed()
    {
        $this->increment('used_count');
        return $this;
    }

    public function canBeUsed($price = null)
    {
        if (!$this->is_valid) {
            return false;
        }

        // Check minimum purchase
        if ($price && $this->min_purchase && $price < $this->min_purchase) {
            return false;
        }

        return true;
    }

    public function isActive()
    {
        return $this->is_valid;
    }

    public function isExpired()
    {
        return $this->valid_until < now();
    }

    public function isUpcoming()
    {
        return $this->valid_from > now();
    }

    // Method untuk mendapatkan semua produk yang terkait dengan promo code ini
    public function getLinkedProducts()
    {
        return $this->productPromotions()
                    ->with('product')
                    ->get()
                    ->pluck('product')
                    ->filter();
    }

    // Method untuk mengecek apakah promo code ini terkait dengan produk tertentu
    public function hasProduct($productId)
    {
        return $this->productPromotions()
                    ->where('product_id', $productId)
                    ->exists();
    }

    // Method untuk menghitung total diskon yang diberikan oleh promo code ini
    public function getTotalDiscountGiven()
    {
        // Hitung berdasarkan penggunaan promo code
        if ($this->type === 'percentage') {
            // Untuk tipe persentase, kita tidak bisa tahu nominal tanpa data transaksi
            return null;
        }
        
        // Untuk tipe nominal, total = value * used_count
        return $this->value * $this->used_count;
    }

    /**
     * Method untuk mendapatkan semua active product promotions yang terkait
     */
    public function getActiveProductPromotions()
    {
        return $this->productPromotions()
                    ->where('is_active', true)
                    ->where('valid_from', '<=', now())
                    ->where('valid_until', '>=', now())
                    ->with('product')
                    ->get();
    }

    /**
     * Method untuk mendapatkan jumlah penggunaan promo code ini melalui product promotions
     */
    public function getTotalUsedThroughPromotions()
    {
        return $this->productPromotions()->sum('used_count');
    }
}