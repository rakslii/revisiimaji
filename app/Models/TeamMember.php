<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeamMember extends Model
{
    use SoftDeletes;

    protected $table = 'team_members';
    
    protected $fillable = [
        'name',
        'position',
        'bio',
        'image',
        'initial',
        'color_scheme',
        'social_links',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'social_links' => 'array', // INI PENTING: otomatis decode JSON ke array
        'order' => 'integer'
    ];

    protected $attributes = [
        'color_scheme' => '#193497,#1e40af',
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
        return [
            'from' => '#193497',
            'to' => '#1e40af'
        ];
    }

    public function getAvatarInitialsAttribute()
    {
        if ($this->initial) {
            return $this->initial;
        }

        $names = explode(' ', $this->name);
        $initials = '';
        
        foreach ($names as $name) {
            if (isset($name[0])) {
                $initials .= strtoupper($name[0]);
                if (strlen($initials) >= 2) break;
            }
        }

        return $initials ?: substr(strtoupper($this->name), 0, 2);
    }

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            if (filter_var($this->image, FILTER_VALIDATE_URL)) {
                return $this->image;
            }
            return asset('storage/' . $this->image);
        }
        return null;
    }
    
    // Helper method untuk mendapatkan social links sebagai array
    public function getSocialLinksArrayAttribute()
    {
        if (is_array($this->social_links)) {
            return $this->social_links;
        }
        
        if (is_string($this->social_links)) {
            return json_decode($this->social_links, true) ?? [];
        }
        
        return [];
    }
}