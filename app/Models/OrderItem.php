<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'total',
        'customization',
        'notes'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price' => 'decimal:2',
        'total' => 'decimal:2',
        'customization' => 'array'
    ];

    // Relationship dengan order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relationship dengan product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Boot method untuk menghitung total
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($item) {
            $item->total = $item->price * $item->quantity;
        });

        static::updating(function ($item) {
            $item->total = $item->price * $item->quantity;
        });
    }
}