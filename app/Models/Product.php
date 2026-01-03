<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia; // ✅ Import Interface
use Spatie\MediaLibrary\InteractsWithMedia; // ✅ Import Trait
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia // ✅ Implement Interface
{
    use SoftDeletes, InteractsWithMedia; // ✅ Tambahkan Trait
    

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

    public function getMediaModel(): string
    {
        return Media::class;
    }

    
    // Accessor untuk memastikan specifications selalu array
    public function getSpecificationsAttribute($value)
    {
        // Jika sudah array, return langsung
        if (is_array($value)) {
            return $value;
        }
        
        // Jika string (JSON), decode
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }
        
        // Default empty array
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