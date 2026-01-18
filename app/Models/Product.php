<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

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

    protected $appends = [
        'image_url',
        'final_price',
        'has_discount',
        'category_name',
        'thumbnail_url'
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

    // PERBAIKAN: Helper method untuk mendapatkan nama kategori
    public function getCategoryNameAttribute()
    {
        // Prioritas 1: Jika category adalah object (relationship loaded)
        if (is_object($this->category) && isset($this->category->name)) {
            return $this->category->name;
        }
        
        // Prioritas 2: Jika category adalah string (dari kolom ENUM)
        if (is_string($this->category) && !empty($this->category)) {
            return $this->category === 'instan' ? 'Produk Instan' : 'Produk Non Instan';
        }
        
        // Prioritas 3: Jika category_id ada, coba ambil dari database
        if ($this->category_id) {
            // Cek cache dulu untuk menghindari N+1 query
            $cacheKey = 'category_name_' . $this->category_id;
            $categoryName = cache()->remember($cacheKey, 300, function () {
                $category = ProductCategory::find($this->category_id);
                return $category ? $category->name : null;
            });
            
            if ($categoryName) {
                return $categoryName;
            }
        }
        
        // Fallback: Cek kolom enum langsung
        if (isset($this->attributes['category']) && !empty($this->attributes['category'])) {
            return $this->attributes['category'] === 'instan' ? 'Produk Instan' : 'Produk Non Instan';
        }
        
        // Default fallback
        return 'Produk';
    }

    // Helper untuk mendapatkan type kategori
    public function getCategoryTypeAttribute()
    {
        // Jika category adalah object
        if (is_object($this->category) && isset($this->category->type)) {
            return $this->category->type;
        }
        
        // Jika category adalah string
        if (is_string($this->category)) {
            return $this->category;
        }
        
        // Jika ada di attributes
        if (isset($this->attributes['category']) && !empty($this->attributes['category'])) {
            return $this->attributes['category'];
        }
        
        return 'unknown';
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

    // Accessor untuk image URL - SIMPLE VERSION
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('images/default-product.jpg');
        }
        
        // Jika URL external
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }
        
        // Cek apakah file ada di storage
        $filePath = storage_path('app/public/' . $this->image);
        if (file_exists($filePath)) {
            return asset('storage/' . $this->image);
        }
        
        // Coba cek di public folder
        $publicPath = public_path($this->image);
        if (file_exists($publicPath)) {
            return asset($this->image);
        }
        
        // Fallback ke default
        return asset('images/default-product.jpg');
    }

    // Accessor untuk thumbnail URL
    public function getThumbnailUrlAttribute()
    {
        return $this->image_url; // Untuk sekarang sama dengan image_url
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
                    $product->category = $category->type;
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
            if (is_null($product->rating)) {
                $product->rating = 0;
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