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

    // Method untuk cek apakah promo valid
    public function isValid()
    {
        return $this->is_active &&
               $this->valid_from <= now() &&
               $this->valid_until >= now() &&
               $this->used_count < $this->quota;
    }

    // Method untuk apply promo
    public function applyTo($amount)
    {
        if (!$this->isValid() || ($this->min_purchase && $amount < $this->min_purchase)) {
            return 0;
        }

        if ($this->type === self::TYPE_PERCENTAGE) {
            return ($amount * $this->value) / 100;
        }

        return min($this->value, $amount); // Tidak boleh lebih dari total
    }

    // Method untuk increment used count
    public function markAsUsed()
    {
        $this->increment('used_count');
    }
    // Accessor untuk formatted value
public function getFormattedValueAttribute()
{
    if ($this->type === 'percentage') {
        return number_format($this->value, 0) . '%';
    }
    
    return 'Rp ' . number_format($this->value, 0, ',', '.');
}

// Accessor untuk status
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
    
    if ($this->used_count >= $this->quota) {
        return 'quota_exceeded';
    }
    
    return 'active';
}
}