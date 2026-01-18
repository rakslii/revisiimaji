<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
        'price'
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    /**
     * Get the cart that owns the item
     */
    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    

    /**
     * Get the product
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Calculate item total
     */
    public function getTotalAttribute(): float
    {
        return $this->price * $this->quantity;
    }

    /**
     * Get formatted total
     */
    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total, 0, ',', '.');
    }

    /**
     * Get formatted price
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Check if product is still available
     */
    public function isAvailable(): bool
    {
        return $this->product && 
               $this->product->is_active && 
               $this->product->stock >= $this->quantity;
    }

    /**
     * Get availability message
     */
    public function getAvailabilityMessage(): string
    {
        if (!$this->product) return 'Produk tidak ditemukan';
        if (!$this->product->is_active) return 'Produk tidak aktif';
        if ($this->product->stock < $this->quantity) {
            return 'Stok hanya tersisa ' . $this->product->stock . ' item';
        }
        return 'Tersedia';
    }
}