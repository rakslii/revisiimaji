<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductPromotion extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id',
        'promo_code_id',
        'name',
        'type',
        'value',
        'quota',
        'used_count',
        'valid_from',
        'valid_until',
        'min_purchase',
        'min_quantity',
        'is_active',
        'is_exclusive',
        'priority'
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'quota' => 'integer',
        'used_count' => 'integer',
        'min_purchase' => 'decimal:2',
        'min_quantity' => 'integer',
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'is_active' => 'boolean',
        'is_exclusive' => 'boolean',
        'priority' => 'integer'
    ];

    protected $appends = [
        'formatted_value',
        'status',
        'is_valid',
        'remaining_days',
        'remaining_uses'
    ];

    // ============ RELATIONSHIPS ============
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function promoCode()
    {
        return $this->belongsTo(PromoCode::class);
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

    public function scopeValid($query)
    {
        return $this->scopeActive($query);
    }

    public function scopeForProduct($query, $productId)
    {
        return $query->where('product_id', $productId);
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
    public function getDiscountAmount($price, $quantity = 1)
    {
        if (!$this->is_valid) {
            return 0;
        }

        // Check minimum quantity
        if ($this->min_quantity && $quantity < $this->min_quantity) {
            return 0;
        }

        // Check minimum purchase
        $totalPrice = $price * $quantity;
        if ($this->min_purchase && $totalPrice < $this->min_purchase) {
            return 0;
        }

        if ($this->type === 'percentage') {
            return ($totalPrice * $this->value) / 100;
        }

        return min($this->value, $totalPrice);
    }

    public function getFinalPrice($price, $quantity = 1)
    {
        $discount = $this->getDiscountAmount($price, $quantity);
        return max(0, ($price * $quantity) - $discount);
    }

    public function markAsUsed($quantity = 1)
    {
        if ($this->quota) {
            $this->used_count += $quantity;
            $this->save();
        }
        
        return $this;
    }

    public function canBeUsed($price, $quantity = 1)
    {
        return $this->is_valid &&
               (!$this->min_quantity || $quantity >= $this->min_quantity) &&
               (!$this->min_purchase || ($price * $quantity) >= $this->min_purchase);
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
}