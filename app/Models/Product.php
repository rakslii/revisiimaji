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
        'category',
        'is_active',
        'image',
        'category_id',
        'stock',
        'sales_count',
        'rating',
        'min_order',
        'specifications',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'specifications' => 'array',
        'price' => 'decimal:2',
        'rating' => 'decimal:1',
    ];

    /* =========================
     |  SPATIE MEDIA FIX (WAJIB)
     ========================= */
    public function getMediaModel(): string
    {
        return Media::class;
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('images')
            ->singleFile(); // 1 produk = 1 gambar (aman buat cart)
    }

    /* =========================
     |  RELATIONSHIP
     ========================= */
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    /* =========================
     |  ACCESSOR & MUTATOR
     ========================= */
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

    public function setSpecificationsAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['specifications'] = json_encode($value);
        } else {
            $this->attributes['specifications'] = $value;
        }
    }

    /* =========================
     |  SCOPES
     ========================= */
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

    /* =========================
     |  HELPERS
     ========================= */
    public function getCategoryNameAttribute()
    {
        if ($this->category_id && $this->category) {
            return $this->category->name;
        }

        return $this->category === 'instan'
            ? 'Produk Instan'
            : 'Produk Custom';
    }

    public function getDiscountedPriceAttribute()
    {
        if ($this->discount_percent > 0) {
            return $this->price - ($this->price * $this->discount_percent / 100);
        }

        return $this->price;
    }

    /* =========================
     |  SAFE IMAGE (ANTI ERROR)
     ========================= */
    public function getImageUrlAttribute()
    {
        if ($this->hasMedia('images')) {
            return $this->getFirstMediaUrl('images');
        }

        // fallback kalo belum ada foto
        return asset('images/no-image.png');
    }
}
