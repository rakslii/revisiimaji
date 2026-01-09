<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'name',
        'description',
        'short_description',
        'price',
        'discount_percent',
        'category', // STRING (instan / non-instan)
        'category_id', // RELASI
        'is_active',
        'image',
        'stock',
        'sales_count',
        'rating',
        'min_order',
        'specifications'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'specifications' => 'array',
        'price' => 'decimal:2',
        'rating' => 'decimal:1'
    ];

    // ================= RELATION =================

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    // ================= MEDIA =================

    public function getMediaModel(): string
    {
        return Media::class;
    }

    // ================= SPECIFICATIONS =================

    public function getSpecificationsAttribute($value)
    {
        if (is_array($value)) return $value;

        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }

        return [];
    }

    public function setSpecificationsAttribute($value)
    {
        $this->attributes['specifications'] = is_array($value)
            ? json_encode($value)
            : $value;
    }

    // ================= SCOPES =================

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

    // ================= ACCESSOR (FIX ERROR) =================

    public function getCategoryNameAttribute()
    {
        // PRIORITAS RELASI
        if ($this->relationLoaded('category') || $this->category_id) {
            if ($this->category instanceof \App\Models\ProductCategory) {
                return $this->category->name;
            }
        }

        // FALLBACK STRING
        if (is_string($this->category)) {
            return ucfirst($this->category);
        }

        return 'No Category';
    }
}
