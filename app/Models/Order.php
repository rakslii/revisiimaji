<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    /* =========================
     | STATUS CONSTANTS (SAMA DENGAN DB)
     ========================= */
    const STATUS_PENDING          = 'pending';
    const STATUS_WAITING_PAYMENT  = 'waiting_payment';
    const STATUS_PAID             = 'paid';
    const STATUS_PROCESSING       = 'processing';
    const STATUS_COMPLETED        = 'completed';
    const STATUS_CANCELLED        = 'cancelled';

    const PAYMENT_UNPAID    = 'unpaid';
    const PAYMENT_PAID      = 'paid';
    const PAYMENT_FAILED    = 'failed';
    const PAYMENT_EXPIRED   = 'expired';
    const PAYMENT_CANCELLED = 'cancelled';

    /* =========================
     | MASS ASSIGNMENT
     ========================= */
    protected $fillable = [
        'order_code',
        'user_id',

        // customer
        'customer_name',
        'customer_phone',
        'customer_email',

        // shipping
        'shipping_address',
        'shipping_city',
        'shipping_postal_code',
        'shipping_method',
        'shipping_note',
        'latitude',
        'longitude',

        // payment
        'payment_method',
        'payment_status',
        'snap_token',
        'midtrans_order_id',

        // price
        'subtotal',
        'shipping_cost',
        'discount',
        'total',

        // status
        'status',
        'notes',
        'paid_at',
        'completed_at',
    ];

    /* =========================
     | CASTS
     ========================= */
    protected $casts = [
        'subtotal'       => 'decimal:2',
        'shipping_cost'  => 'decimal:2',
        'discount'       => 'decimal:2',
        'total'          => 'decimal:2',
        'paid_at'        => 'datetime',
        'completed_at'   => 'datetime',
    ];

    /* =========================
     | APPENDS (YANG AMAN)
     ========================= */
    protected $appends = [
        'formatted_total',
        'items_count',
    ];

    /* =========================
     | BOOT
     ========================= */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_code)) {
                $order->order_code = static::generateOrderNumber();
            }
        });
    }

    /* =========================
     | GENERATE ORDER CODE
     ========================= */
    public static function generateOrderNumber(): string
    {
        $prefix = 'ORD-' . date('Ymd');
        $lastOrder = static::where('order_code', 'like', $prefix . '%')
            ->orderByDesc('id')
            ->first();

        $number = 1;
        if ($lastOrder) {
            $lastNumber = (int) substr($lastOrder->order_code, -4);
            $number = $lastNumber + 1;
        }

        return $prefix . '-' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    /* =========================
     | RELATIONSHIPS
     ========================= */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }


    // 🔥 ALIAS BIAR GA ERROR
    public function payment(): HasMany
    {
        return $this->payments();
    }


    /* =========================
     | ACCESSORS (AMAN)
     ========================= */
    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total ?? 0, 0, ',', '.');
    }

    public function getItemsCountAttribute(): int
    {
        return $this->items()->count();
    }

    /* =========================
     | SCOPES
     ========================= */
    public function scopeForCurrentUser($query)
    {
        return $query->where('user_id', auth()->id());
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopePaid($query)
    {
        return $query->where('payment_status', self::PAYMENT_PAID);
    }

    /* =========================
     | HELPERS
     ========================= */
    public function canBeCancelled(): bool
    {
        return in_array($this->status, [
            self::STATUS_PENDING,
            self::STATUS_WAITING_PAYMENT,
        ]);
    }
}
