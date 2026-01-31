<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $fillable = [
        'name', 'slug', 'type', 'description', 'icon', 'order', 'is_active',
        'featured_image_1', 'featured_image_2', 'featured_image_3',
        'featured_image_4', 'featured_image_5', 'featured_image_6',
        'category_color', 'accent_color'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer'
    ];

    protected $appends = [
        'featured_image_urls',
        'main_image_url',
        'thumbnail_urls'
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    // Relationships
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    // Accessors
    public function getFeaturedImageUrlsAttribute()
    {
        $urls = [];
        for ($i = 1; $i <= 6; $i++) {
            $field = "featured_image_{$i}";
            if ($this->$field) {
                $urls[$field] = $this->getImageUrl($this->$field);
            }
        }
        return $urls;
    }

    public function getMainImageUrlAttribute()
    {
        if ($this->featured_image_1) {
            return $this->getImageUrl($this->featured_image_1);
        }
        return null;
    }

    public function getThumbnailUrlsAttribute()
    {
        $thumbnails = [];
        for ($i = 2; $i <= 4; $i++) {
            $field = "featured_image_{$i}";
            if ($this->$field) {
                $thumbnails[] = $this->getImageUrl($this->$field);
            }
        }
        return $thumbnails;
    }

    public function getTotalProductsCountAttribute()
    {
        return $this->products()->count();
    }

    public function getActiveProductsCountAttribute()
    {
        return $this->products()->active()->count();
    }
private function getImageUrl($imagePath)
{
    if (!$imagePath) {
        \Log::debug('Image path is empty');
        return null;
    }

    \Log::debug('Looking for image: ' . $imagePath);

    if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
        \Log::debug('Image is URL: ' . $imagePath);
        return $imagePath;
    }

    // Cek di storage
    $storagePath = storage_path('app/public/' . $imagePath);
    \Log::debug('Storage path: ' . $storagePath);
    
    if (file_exists($storagePath)) {
        \Log::debug('Image found in storage');
        return asset('storage/' . $imagePath);
    }

    // Cek di public
    $publicPath = public_path($imagePath);
    \Log::debug('Public path: ' . $publicPath);
    
    if (file_exists($publicPath)) {
        \Log::debug('Image found in public');
        return asset($imagePath);
    }

    // Coba cek di storage dengan path yang mungkin berbeda
    $alternativePaths = [
        'public/' . $imagePath,
        'storage/app/public/' . $imagePath,
        $imagePath
    ];

    foreach ($alternativePaths as $altPath) {
        $fullPath = storage_path('app/' . $altPath);
        \Log::debug('Checking alternative path: ' . $fullPath);
        
        if (file_exists($fullPath)) {
            \Log::debug('Image found in alternative path');
            return asset('storage/' . ltrim($altPath, 'public/'));
        }
    }

    \Log::warning('Image not found: ' . $imagePath);
    return null; // Kembalikan null jika tidak ditemukan
}    // Mutator untuk slug
    public function setSlugAttribute($value)
    {
        if (empty($value) && !empty($this->name)) {
            $value = \Illuminate\Support\Str::slug($this->name);
        }
        $this->attributes['slug'] = $value;
    }

    // Boot method untuk default values
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            // Generate slug jika kosong
            if (empty($category->slug)) {
                $category->slug = \Illuminate\Support\Str::slug($category->name);
            }
            
            // Set default colors jika kosong
            if (empty($category->category_color)) {
                $category->category_color = '#193497';
            }
            if (empty($category->accent_color)) {
                $category->accent_color = '#c0f820';
            }
            
            // Set default type jika kosong
            if (empty($category->type)) {
                $category->type = 'instan';
            }
            
            // Set default order jika kosong
            if (empty($category->order)) {
                $category->order = 0;
            }
        });

        static::updating(function ($category) {
            // Update slug jika nama berubah
            if ($category->isDirty('name') && empty($category->slug)) {
                $category->slug = \Illuminate\Support\Str::slug($category->name);
            }
        });
    }
}