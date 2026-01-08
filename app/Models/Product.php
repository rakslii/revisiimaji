<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'name', 'description', 'short_description', 'price', 'discount_percent',
        'category', 'is_active', 'image', 'category_id', 'stock', 'sales_count',
        'rating', 'min_order', 'specifications'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'specifications' => 'array',
        'price' => 'decimal:2',
        'rating' => 'decimal:1'
    ];

    // ✅ TAMBAHKAN RELATIONSHIP INI
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    // Accessor untuk memastikan specifications selalu array
    public function getSpecificationsAttribute($value)
    {
        if (is_array($value)) {
            return $value;
        }

        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }

        return [];
    }

    // Mutator untuk menyimpan sebagai JSON
    public function setSpecificationsAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['specifications'] = json_encode($value);
        } else {
            $this->attributes['specifications'] = $value;
        }
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInstan($query)
    {
        return $query->where('category', 'instan');
    }

    public function scopeNonInstan($query)
    {
        return $query->where('category', 'non-instan');
    }

    // Helper method untuk mendapatkan nama kategori
    public function getCategoryNameAttribute()
    {
        // Prioritaskan relationship jika ada
        if ($this->category_id && $this->category) {
            return $this->category->name;
        }

        // Fallback ke enum category
        return $this->category === 'instan' ? 'Produk Instan' : 'Produk Custom';
    }

    // Helper untuk mendapatkan harga diskon
    public function getDiscountedPriceAttribute()
    {
        if ($this->discount_percent > 0) {
            return $this->price - ($this->price * $this->discount_percent / 100);
        }
        return $this->price;
    }
}
