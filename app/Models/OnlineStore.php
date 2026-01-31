<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OnlineStore extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'platform',
        'description',
        'url',
        'icon_class',
        'color',
        'gradient_from',
        'gradient_to',
        'store_username',
        'store_id',
        'is_active',
        'order',
        'metadata'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
        'metadata' => 'array'
    ];

    protected $appends = [
        'platform_label',
        'display_url'
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

    public function scopeEcommerce($query)
    {
        return $query->where('platform', 'ecommerce');
    }

    public function scopeSocialMedia($query)
    {
        return $query->where('platform', 'social_media');
    }

    // Accessors
    public function getPlatformLabelAttribute()
    {
        return [
            'ecommerce' => 'E-commerce',
            'social_media' => 'Social Media',
            'marketplace' => 'Marketplace'
        ][$this->platform] ?? ucfirst($this->platform);
    }

    public function getDisplayUrlAttribute()
    {
        // Short URL untuk display
        $url = parse_url($this->url);
        return $url['host'] ?? $this->url;
    }

    public function getGradientStyleAttribute()
    {
        return "background: linear-gradient(135deg, {$this->gradient_from}, {$this->gradient_to});";
    }

    // Mutators
    public function setSlugAttribute($value)
    {
        if (empty($value) && !empty($this->name)) {
            $value = \Illuminate\Support\Str::slug($this->name);
        }
        $this->attributes['slug'] = $value;
    }

    // Boot method
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($store) {
            if (empty($store->slug)) {
                $store->slug = \Illuminate\Support\Str::slug($store->name);
            }
        });
    }
}