<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AboutUsSection extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'subtitle',
        'content',
        'section_type',
        'position',
        'order',
        'is_active',
        'data',
        'background_color',
        'text_color',
        'icon'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'data' => 'array',
        'order' => 'integer'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('section_type', $type);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('created_at');
    }

    public function getSectionLabelAttribute()
    {
        $labels = [
            'hero' => 'Hero Section',
            'story' => 'Our Story',
            'mission' => 'Mission & Vision',
            'values' => 'Core Values',
            'team' => 'Team Members',
            'stats' => 'Achievements',
            'technology' => 'Technology',
            'cta' => 'Call to Action'
        ];

        return $labels[$this->section_type] ?? ucfirst(str_replace('_', ' ', $this->section_type));
    }
}