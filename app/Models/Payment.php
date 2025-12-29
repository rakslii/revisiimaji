<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'payment_method',
        'qr_code',
        'qr_url',
        'external_id',
        'amount',
        'status',
        'expired_at',
        'payment_data',
        'bank',
        'va_number'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'expired_at' => 'datetime',
        'payment_data' => 'array'
    ];

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_PAID = 'paid';
    const STATUS_EXPIRED = 'expired';
    const STATUS_FAILED = 'failed';

    // Relationship dengan order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Scope untuk status tertentu
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Method untuk cek apakah payment expired
    public function isExpired()
    {
        return $this->status === self::STATUS_EXPIRED || 
               ($this->expired_at && $this->expired_at->isPast());
    }

    // Accessor untuk status label
    public function getStatusLabelAttribute()
    {
        $labels = [
            self::STATUS_PENDING => 'Menunggu',
            self::STATUS_PROCESSING => 'Diproses',
            self::STATUS_PAID => 'Dibayar',
            self::STATUS_EXPIRED => 'Kadaluarsa',
            self::STATUS_FAILED => 'Gagal'
        ];
        
        return $labels[$this->status] ?? $this->status;
    }
}