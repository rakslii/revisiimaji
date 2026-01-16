<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'full_address',
        'recipient_name',
        'recipient_phone',
        'latitude',
        'longitude',
        'city',
        'province',
        'postal_code',
        'is_primary'
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'is_primary' => 'boolean'
    ];

    // Relationship dengan user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship dengan orders
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Scope untuk lokasi utama
    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    // Method untuk set sebagai primary
    public function setAsPrimary()
    {
        // Unset other primary locations for this user
        $this->user->locations()->update(['is_primary' => false]);
        
        // Set this as primary
        $this->is_primary = true;
        $this->save();
    }

    // Format alamat lengkap
    public function getFormattedAddressAttribute()
    {
        return "{$this->full_address}, {$this->city}, {$this->province} {$this->postal_code}";
    }
}