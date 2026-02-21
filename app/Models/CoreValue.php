<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoreValue extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'icon',
        'color_scheme',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer'
    ];

    protected $attributes = [
        'color_scheme' => '#193497,#1e40af', // Default fixed value
        'order' => 0,
        'is_active' => true
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('created_at');
    }

    public function getGradientColorsAttribute()
    {
        // Selalu gunakan default fixed colors, ignore database
        return [
            'from' => '#193497',
            'to' => '#1e40af'
        ];
        
        /* Jika ingin tetap menggunakan dari database, gunakan ini:
        if ($this->color_scheme) {
            $colors = explode(',', $this->color_scheme);
            return [
                'from' => $colors[0] ?? '#193497',
                'to' => $colors[1] ?? '#1e40af'
            ];
        }

        return [
            'from' => '#193497',
            'to' => '#1e40af'
        ];
        */
    }
}