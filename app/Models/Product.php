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
        'rating', 'min_order', 'specifications',
        // Kolom gambar tambahan
        'image_2', 'image_3', 'image_4', 'image_5', 'additional_images',
        'thumbnail', 'main_image', 'gallery_images'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'specifications' => 'array',
        'additional_images' => 'array', // Cast JSON ke array
        'gallery_images' => 'array',    // Cast JSON ke array
        'price' => 'decimal:2',
        'rating' => 'decimal:1'
    ];

    protected $appends = [
        'image_url',
        'final_price',
        'has_discount',
        'category_name',
        'thumbnail_url',
        'discount_amount',
        'formatted_price',
        'formatted_final_price',
        'formatted_discount_amount',
        // Appends untuk gambar tambahan
        'all_images',
        'gallery_urls',
        'additional_images_urls',
        'primary_image_url'
    ];

    // Relationship dengan ProductCategory
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    // ============ ACCESSORS ============

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

    // Method untuk mendapatkan diskon dalam rupiah
    public function getDiscountAmountAttribute()
    {
        if ($this->discount_percent > 0) {
            return $this->price * ($this->discount_percent / 100);
        }
        return 0;
    }

    // Get formatted price
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    // Get formatted final price
    public function getFormattedFinalPriceAttribute()
    {
        return 'Rp ' . number_format($this->final_price, 0, ',', '.');
    }

    // Get formatted discount amount
    public function getFormattedDiscountAmountAttribute()
    {
        return 'Rp ' . number_format($this->discount_amount, 0, ',', '.');
    }

    // ============ ACCESSORS UNTUK GAMBAR ============

    /**
     * Get all product images as array
     */
    public function getAllImagesAttribute()
    {
        $images = [];

        // Gambar utama
        $mainImage = $this->getMainImageUrl();
        if ($mainImage) {
            $images[] = [
                'url' => $mainImage,
                'type' => 'main',
                'order' => 1,
                'field' => 'main_image'
            ];
        }

        // Gambar dari kolom image (backward compatibility)
        if ($this->image && $this->getImageUrl($this->image) !== $mainImage) {
            $images[] = [
                'url' => $this->getImageUrl($this->image),
                'type' => 'legacy',
                'order' => 2,
                'field' => 'image'
            ];
        }

        // Gambar tambahan (image_2 sampai image_5)
        for ($i = 2; $i <= 5; $i++) {
            $imageField = "image_{$i}";
            if ($this->$imageField) {
                $images[] = [
                    'url' => $this->getImageUrl($this->$imageField),
                    'type' => 'additional',
                    'order' => $i + 1,
                    'field' => $imageField
                ];
            }
        }

        // Additional images dari JSON
        if ($this->additional_images && is_array($this->additional_images)) {
            foreach ($this->additional_images as $index => $imagePath) {
                if ($imagePath) {
                    $images[] = [
                        'url' => $this->getImageUrl($imagePath),
                        'type' => 'gallery',
                        'order' => count($images) + 1,
                        'field' => 'additional_images[' . $index . ']'
                    ];
                }
            }
        }

        // Gallery images dari JSON
        if ($this->gallery_images && is_array($this->gallery_images)) {
            foreach ($this->gallery_images as $index => $imagePath) {
                if ($imagePath) {
                    $images[] = [
                        'url' => $this->getImageUrl($imagePath),
                        'type' => 'gallery',
                        'order' => count($images) + 1,
                        'field' => 'gallery_images[' . $index . ']'
                    ];
                }
            }
        }

        // Urutkan berdasarkan order
        usort($images, function($a, $b) {
            return $a['order'] <=> $b['order'];
        });

        return $images;
    }

    /**
     * Get gallery image URLs only (tanpa gambar utama)
     */
    public function getGalleryUrlsAttribute()
    {
        $gallery = [];

        // Dari kolom image_2 sampai image_5
        for ($i = 2; $i <= 5; $i++) {
            $imageField = "image_{$i}";
            if ($this->$imageField) {
                $gallery[] = $this->getImageUrl($this->$imageField);
            }
        }

        // Dari additional_images JSON
        if ($this->additional_images && is_array($this->additional_images)) {
            foreach ($this->additional_images as $imagePath) {
                if ($imagePath) {
                    $gallery[] = $this->getImageUrl($imagePath);
                }
            }
        }

        // Dari gallery_images JSON
        if ($this->gallery_images && is_array($this->gallery_images)) {
            foreach ($this->gallery_images as $imagePath) {
                if ($imagePath) {
                    $gallery[] = $this->getImageUrl($imagePath);
                }
            }
        }

        return $gallery;
    }

    /**
     * Get additional images URLs (dari JSON fields)
     */
    public function getAdditionalImagesUrlsAttribute()
    {
        $urls = [];

        // Dari additional_images JSON
        if ($this->additional_images && is_array($this->additional_images)) {
            foreach ($this->additional_images as $imagePath) {
                if ($imagePath) {
                    $urls[] = $this->getImageUrl($imagePath);
                }
            }
        }

        // Dari gallery_images JSON
        if ($this->gallery_images && is_array($this->gallery_images)) {
            foreach ($this->gallery_images as $imagePath) {
                if ($imagePath) {
                    $urls[] = $this->getImageUrl($imagePath);
                }
            }
        }

        return $urls;
    }

    /**
     * Get primary/main image URL
     */
    public function getPrimaryImageUrlAttribute()
    {
        return $this->getMainImageUrl();
    }

    /**
     * Accessor untuk image URL - backward compatibility
     */
    public function getImageUrlAttribute()
    {
        return $this->getMainImageUrl();
    }

    /**
     * Accessor untuk thumbnail URL
     */
    public function getThumbnailUrlAttribute()
    {
        // Jika ada thumbnail khusus
        if ($this->thumbnail) {
            return $this->getImageUrl($this->thumbnail);
        }

        // Fallback ke main image
        return $this->getMainImageUrl();
    }

    /**
     * Helper method untuk mendapatkan URL gambar utama
     */
    private function getMainImageUrl()
    {
        // Prioritas 1: main_image
        if ($this->main_image) {
            return $this->getImageUrl($this->main_image);
        }

        // Prioritas 2: image (backward compatibility)
        if ($this->image) {
            return $this->getImageUrl($this->image);
        }

        return asset('images/default-product.jpg');
    }

    /**
     * Helper method untuk mendapatkan URL gambar dari path
     */
    private function getImageUrl($imagePath)
    {
        if (!$imagePath) {
            return asset('images/default-product.jpg');
        }

        if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
            return $imagePath;
        }

        // Cek di storage
        $storagePath = storage_path('app/public/' . $imagePath);
        if (file_exists($storagePath)) {
            return asset('storage/' . $imagePath);
        }

        // Cek di public
        $publicPath = public_path($imagePath);
        if (file_exists($publicPath)) {
            return asset($imagePath);
        }

        // Return path as-is jika tidak ditemukan
        return $imagePath;
    }

    // ============ MUTATORS ============

    // Mutator untuk specifications
    public function setSpecificationsAttribute($value)
    {
        $this->attributes['specifications'] = is_array($value) ? json_encode($value) : $value;
    }

    // Mutator untuk additional_images (JSON)
    public function setAdditionalImagesAttribute($value)
    {
        $this->attributes['additional_images'] = is_array($value) ? json_encode($value) : $value;
    }

    // Mutator untuk gallery_images (JSON)
    public function setGalleryImagesAttribute($value)
    {
        $this->attributes['gallery_images'] = is_array($value) ? json_encode($value) : $value;
    }

    // ============ SCOPES ============

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

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function scopeLowStock($query)
    {
        return $query->where('stock', '>', 0)->where('stock', '<=', 10);
    }

    public function scopeOutOfStock($query)
    {
        return $query->where('stock', '<=', 0);
    }

    public function scopeHasDiscount($query)
    {
        return $query->where('discount_percent', '>', 0);
    }

    // ============ BOOT METHOD ============

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

    // ============ METHODS ============

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
        return $this->stock <= 0;
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

    // ============ METHODS UNTUK GAMBAR ============

    /**
     * Method untuk menambahkan gambar ke gallery
     */
    public function addToGallery($imagePath)
    {
        $gallery = $this->gallery_images ?? [];
        $gallery[] = $imagePath;
        $this->gallery_images = $gallery;
        $this->save();
        return $this;
    }

    /**
     * Method untuk menghapus gambar dari gallery
     */
    public function removeFromGallery($imagePath)
    {
        $gallery = $this->gallery_images ?? [];
        $gallery = array_filter($gallery, function($path) use ($imagePath) {
            return $path !== $imagePath;
        });
        $this->gallery_images = array_values($gallery); // Reset array keys
        $this->save();
        return $this;
    }

    /**
     * Method untuk mengatur gambar utama
     */
    public function setMainImage($imagePath)
    {
        $this->main_image = $imagePath;
        $this->save();
        return $this;
    }

    /**
     * Method untuk mengatur thumbnail
     */
    public function setThumbnail($imagePath)
    {
        $this->thumbnail = $imagePath;
        $this->save();
        return $this;
    }

    /**
     * Method untuk menambahkan gambar ke kolom image_2 sampai image_5
     */
    public function addAdditionalImage($imagePath, $position = 2)
    {
        if ($position >= 2 && $position <= 5) {
            $field = "image_{$position}";
            $this->$field = $imagePath;
            $this->save();
        }
        return $this;
    }

    /**
     * Method untuk menghapus gambar dari kolom image_2 sampai image_5
     */
    public function removeAdditionalImage($position)
    {
        if ($position >= 2 && $position <= 5) {
            $field = "image_{$position}";
            $this->$field = null;
            $this->save();
        }
        return $this;
    }

    /**
     * Method untuk menambahkan gambar ke additional_images JSON
     */
    public function addToAdditionalImages($imagePath)
    {
        $additional = $this->additional_images ?? [];
        $additional[] = $imagePath;
        $this->additional_images = $additional;
        $this->save();
        return $this;
    }

    /**
     * Method untuk menghapus gambar dari additional_images JSON
     */
    public function removeFromAdditionalImages($imagePath)
    {
        $additional = $this->additional_images ?? [];
        $additional = array_filter($additional, function($path) use ($imagePath) {
            return $path !== $imagePath;
        });
        $this->additional_images = array_values($additional);
        $this->save();
        return $this;
    }

    /**
     * Method untuk mendapatkan jumlah total gambar
     */
    public function getTotalImagesCount()
    {
        $count = 0;

        // Hitung dari semua sumber
        if ($this->main_image) $count++;
        if ($this->image) $count++;
        for ($i = 2; $i <= 5; $i++) {
            $field = "image_{$i}";
            if ($this->$field) $count++;
        }
        if ($this->additional_images) $count += count($this->additional_images);
        if ($this->gallery_images) $count += count($this->gallery_images);

        return $count;
    }

    /**
     * Method untuk mendapatkan semua URL gambar sebagai array sederhana
     */
    public function getAllImageUrls()
    {
        $urls = [];

        if ($this->primary_image_url) {
            $urls[] = $this->primary_image_url;
        }

        foreach ($this->gallery_urls as $url) {
            $urls[] = $url;
        }

        return array_unique($urls); // Hindari duplikat
    }
}
