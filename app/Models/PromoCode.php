<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'type',
        'value',
        'quota',
        'used_count',
        'min_purchase',
        'valid_from',
        'valid_until',
        'is_active'
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'quota' => 'integer',
        'used_count' => 'integer',
        'min_purchase' => 'decimal:2',
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'is_active' => 'boolean'
    ];

    // Type constants
    const TYPE_PERCENTAGE = 'percentage';
    const TYPE_NOMINAL = 'nominal';

    // Scope untuk promo aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                     ->where('valid_from', '<=', now())
                     ->where('valid_until', '>=', now())
                     ->whereRaw('used_count < quota');
    }

    // Scope untuk search
    public function scopeSearch($query, $search)
    {
        return $query->where('code', 'like', "%{$search}%")
                     ->orWhere('name', 'like', "%{$search}%");
    }

    // Method untuk cek apakah promo valid
    public function isValid()
    {
        return $this->is_active &&
               $this->valid_from <= now() &&
               $this->valid_until >= now() &&
               $this->used_count < $this->quota;
    }

    // Method untuk cek status
    public function getStatusAttribute()
    {
        if (!$this->is_active) return 'inactive';
        if (now() < $this->valid_from) return 'upcoming';
        if (now() > $this->valid_until) return 'expired';
        if ($this->used_count >= $this->quota) return 'quota_exceeded';
        return 'active';
    }

    // Method untuk apply promo
    public function calculateDiscount($amount)
    {
        if (!$this->isValid() || ($this->min_purchase && $amount < $this->min_purchase)) {
            return 0;
        }

        if ($this->type === self::TYPE_PERCENTAGE) {
            $discount = ($amount * $this->value) / 100;
            return $discount;
        }

        return $this->value;
    }

    // Method untuk increment used count
    public function markAsUsed()
    {
        $this->increment('used_count');
    }

    // Format value untuk display
    public function getFormattedValueAttribute()
    {
        if ($this->type === self::TYPE_PERCENTAGE) {
            return $this->value . '%';
        }
        return 'Rp ' . number_format($this->value, 0, ',', '.');
    }
}
