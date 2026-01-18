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

    // Relationship dengan ProductCategory
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    // Accessor untuk specifications
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

    // Mutator untuk specifications
    public function setSpecificationsAttribute($value)
    {
        $this->attributes['specifications'] = is_array($value) ? json_encode($value) : $value;
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

    // FIXED: Helper method untuk mendapatkan nama kategori YANG AMAN
    public function getCategoryNameAttribute()
    {
        // Cek apakah $this->category adalah object ProductCategory
        if ($this->category && is_object($this->category) && method_exists($this->category, 'getAttribute')) {
            // Ini adalah Eloquent model object
            return $this->category->name;
        }
        
        // Cek apakah $this->category adalah string (dari kolom ENUM)
        if (is_string($this->category) && !empty($this->category)) {
            // Coba cari category name dari category_id jika ada
            if ($this->category_id) {
                // Hindari N+1 query dengan menggunakan cache atau langsung query
                $categoryName = cache()->remember("category_name_{$this->category_id}", 300, function () {
                    $cat = ProductCategory::find($this->category_id);
                    return $cat ? $cat->name : null;
                });
                
                if ($categoryName) {
                    return $categoryName;
                }
            }
            
            // Jika tidak ada, format string enum
            return ucfirst($this->category);
        }
        
        // Jika category_id ada
        if ($this->category_id) {
            $category = ProductCategory::find($this->category_id);
            return $category ? $category->name : "Category #{$this->category_id}";
        }
        
        return 'No Category';
    }

    // Helper untuk mendapatkan type kategori dari ENUM
    public function getCategoryTypeAttribute()
    {
        if (is_string($this->category)) {
            return ucfirst($this->category);
        }
        
        // Jika ada relationship
        if ($this->category && is_object($this->category)) {
            return $this->category->type ?? 'Unknown';
        }
        
        return 'Unknown';
    }

    // Accessor untuk final price (setelah diskon)
    public function getFinalPriceAttribute()
    {
        if ($this->discount_percent > 0) {
            $discounted = $this->price * (1 - ($this->discount_percent / 100));
            return round($discounted, 2);
        }
        return $this->price;
    }

    // Check if product has discount
    public function getHasDiscountAttribute()
    {
        return $this->discount_percent > 0;
    }

    // Accessor untuk image URL
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('images/default-product.jpg');
        }
        
        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }
        
        return asset('storage/' . $this->image);
    }

    // Method untuk mendapatkan diskon dalam rupiah
    public function getDiscountAmountAttribute()
    {
        if ($this->discount_percent > 0) {
            return $this->price * ($this->discount_percent / 100);
        }
        return 0;
    }

    // Boot method untuk event
    protected static function boot()
    {
        parent::boot();

        // Saat menyimpan product, sync category dengan category_id
        static::saving(function ($product) {
            if ($product->category_id) {
                $category = ProductCategory::find($product->category_id);
                if ($category) {
                    $product->category = $category->type; // Sync enum dengan type
                }
            }
        });

        // Set default untuk beberapa field jika null
        static::creating(function ($product) {
            if (is_null($product->stock)) {
                $product->stock = 0;
            }
            if (is_null($product->sales_count)) {
                $product->sales_count = 0;
            }
            if (is_null($product->min_order)) {
                $product->min_order = 1;
            }
            if (is_null($product->discount_percent)) {
                $product->discount_percent = 0;
            }
        });
    }

    // Method untuk mengecek stok
    public function isInStock()
    {
        return $this->stock > 0;
    }

    public function isLowStock()
    {
        return $this->stock > 0 && $this->stock <= 10;
    }

    public function isOutOfStock()
    {
        return $this->stock === 0;
    }

    // Method untuk update stok
    public function updateStock($quantity)
    {
        $this->stock += $quantity;
        if ($this->stock < 0) {
            $this->stock = 0;
        }
        $this->save();
    }
}