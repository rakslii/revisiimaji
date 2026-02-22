<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Banner extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'subtitle', 'description', 'image', 'mobile_image',
        'link', 'button_text', 'type', 'position', 'size',
        'start_date', 'end_date', 'display_order', 'is_active',
        'show_once_per_session', 'delay_seconds', 'show_close_button',
        'show_on_mobile', 'show_on_tablet', 'show_on_desktop',
        'background_color', 'background_opacity', 'views_count', 'clicks_count'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
        'show_once_per_session' => 'boolean',
        'show_close_button' => 'boolean',
        'show_on_mobile' => 'boolean',
        'show_on_tablet' => 'boolean',
        'show_on_desktop' => 'boolean',
        'views_count' => 'integer',
        'clicks_count' => 'integer'
    ];

    protected $appends = [
        'image_url', 'mobile_image_url', 'is_valid', 'status_badge',
        'formatted_start_date', 'formatted_end_date', 'background_style'
    ];

    // ============ ACCESSORS ============

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return null;
        }
        
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }
        
        return Storage::url($this->image);
    }

    public function getMobileImageUrlAttribute()
    {
        if (!$this->mobile_image) {
            return $this->image_url;
        }
        
        if (filter_var($this->mobile_image, FILTER_VALIDATE_URL)) {
            return $this->mobile_image;
        }
        
        return Storage::url($this->mobile_image);
    }

    public function getIsValidAttribute()
    {
        $now = now();
        
        if (!$this->is_active) {
            return false;
        }
        
        if ($this->start_date && $this->start_date > $now) {
            return false;
        }
        
        if ($this->end_date && $this->end_date < $now) {
            return false;
        }
        
        return true;
    }

    public function getStatusBadgeAttribute()
    {
        if (!$this->is_active) {
            return '<span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs">Nonaktif</span>';
        }
        
        $now = now();
        
        if ($this->start_date && $this->start_date > $now) {
            return '<span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">Jadwal</span>';
        }
        
        if ($this->end_date && $this->end_date < $now) {
            return '<span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Kadaluarsa</span>';
        }
        
        return '<span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Aktif</span>';
    }

    public function getFormattedStartDateAttribute()
    {
        return $this->start_date ? $this->start_date->format('d M Y H:i') : '-';
    }

    public function getFormattedEndDateAttribute()
    {
        return $this->end_date ? $this->end_date->format('d M Y H:i') : '-';
    }

    public function getBackgroundStyleAttribute()
    {
        $style = '';
        
        if ($this->background_color) {
            $opacity = $this->background_opacity ?? 100;
            $rgb = $this->hexToRgb($this->background_color);
            $style .= "background-color: rgba({$rgb['r']}, {$rgb['g']}, {$rgb['b']}, " . ($opacity / 100) . ");";
        }
        
        return $style;
    }

    // ============ SCOPES ============

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeValid($query)
    {
        $now = now();
        return $query->where('is_active', true)
            ->where(function($q) use ($now) {
                $q->whereNull('start_date')
                  ->orWhere('start_date', '<=', $now);
            })
            ->where(function($q) use ($now) {
                $q->whereNull('end_date')
                  ->orWhere('end_date', '>=', $now);
            });
    }

    public function scopeHomeBanners($query)
    {
        return $query->where('type', 'home_banner');
    }

    public function scopePopups($query)
    {
        return $query->where('type', 'popup');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order')->orderBy('created_at', 'desc');
    }

    // ============ METHODS ============

    public function incrementViews()
    {
        $this->increment('views_count');
    }

    public function incrementClicks()
    {
        $this->increment('clicks_count');
    }

    private function hexToRgb($hex)
    {
        $hex = str_replace('#', '', $hex);
        
        if (strlen($hex) == 3) {
            $r = hexdec(str_repeat(substr($hex, 0, 1), 2));
            $g = hexdec(str_repeat(substr($hex, 1, 1), 2));
            $b = hexdec(str_repeat(substr($hex, 2, 1), 2));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        
        return ['r' => $r, 'g' => $g, 'b' => $b];
    }

    // ============ BOOT ============

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($banner) {
            if (empty($banner->display_order)) {
                $maxOrder = static::max('display_order') ?? 0;
                $banner->display_order = $maxOrder + 1;
            }
        });
    }
}