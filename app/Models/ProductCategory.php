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

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    // Relationships - PERBAIKAN INI
    public function products()
    {
        // Gunakan 'category_id' bukan 'product_category_id'
        return $this->hasMany(Product::class, 'category_id');
    }
}