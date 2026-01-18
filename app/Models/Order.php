<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_SHIPPED = 'shipped';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_CANCELLED = 'cancelled';

    // Payment status constants
    const PAYMENT_PENDING = 'pending';
    const PAYMENT_PAID = 'paid';
    const PAYMENT_FAILED = 'failed';
    const PAYMENT_EXPIRED = 'expired';

    protected $fillable = [
        'order_code',
        'user_id',

        // CUSTOMER
        'customer_name',
        'customer_phone',
        'customer_email',

        // SHIPPING
        'shipping_address',
        'shipping_city',
        'shipping_postal_code',
        'shipping_method',

        // PAYMENT
        'payment_method',
        'snap_token',
        'midtrans_order_id',

        // MAP
        'latitude',
        'longitude',

        // PRICE
        'subtotal',
        'shipping_cost',
        'discount',
        'total',

        // STATUS
        'status',
        'payment_status',

        // NOTES
        'notes',
        'design_notes',
        'design_files',
    ];


    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
        'paid_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    protected $appends = [
        'customer_name',
        'customer_phone',
        'formatted_total',
        'items_count',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_code)) {
                $order->order_code = static::generateOrderNumber();
            }
        });
    }

    /**
     * Generate unique order number
     */
    public static function generateOrderNumber()
    {
        $prefix = 'ORD-' . date('Ymd');
        $lastOrder = static::where('order_code', 'like', $prefix . '%')
            ->orderBy('id', 'desc')
            ->first();

        $number = 1;
        if ($lastOrder) {
            $lastNumber = (int) substr($lastOrder->order_code, -4);
            $number = $lastNumber + 1;
        }

        return $prefix . '-' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Get the user that owns the order
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the location for the order - INI YANG PERLU DITAMBAHKAN
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Get the order items
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the payments for the order
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Alias untuk payment() jika ada yang masih panggil singular
     */
    public function payment(): HasMany
    {
        return $this->payments();
    }

    /**
     * Check if order can be cancelled
     */
    public function canBeCancelled(): bool
    {
        return in_array($this->status, [self::STATUS_PENDING, self::STATUS_PROCESSING]);
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeAttribute(): string
    {
        $colors = [
            self::STATUS_PENDING => 'warning',
            self::STATUS_PROCESSING => 'info',
            self::STATUS_SHIPPED => 'primary',
            self::STATUS_DELIVERED => 'success',
            self::STATUS_CANCELLED => 'danger',
        ];

        return $colors[$this->status] ?? 'secondary';
    }

    /**
     * Get payment status badge color
     */
    public function getPaymentStatusBadgeAttribute(): string
    {
        $colors = [
            self::PAYMENT_PENDING => 'warning',
            self::PAYMENT_PAID => 'success',
            self::PAYMENT_FAILED => 'danger',
            self::PAYMENT_EXPIRED => 'secondary',
        ];

        return $colors[$this->payment_status] ?? 'secondary';
    }

    /**
     * Get formatted total
     */
    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total ?? 0, 0, ',', '.');
    }

    /**
     * Get customer name from user relationship
     */
    public function getCustomerNameAttribute()
    {
        return $this->user ? $this->user->name : 'N/A';
    }

    /**
     * Get customer phone from user relationship
     */
    public function getCustomerPhoneAttribute()
    {
        return $this->user ? $this->user->phone : 'No phone';
    }

    /**
     * Get items count
     */
    public function getItemsCountAttribute()
    {
        return $this->items()->count();
    }

    /**
     * Get formatted subtotal
     */
    public function getFormattedSubtotalAttribute(): string
    {
        return 'Rp ' . number_format($this->subtotal ?? 0, 0, ',', '.');
    }

    /**
     * Get formatted shipping cost
     */
    public function getFormattedShippingCostAttribute(): string
    {
        return 'Rp ' . number_format($this->shipping_cost ?? 0, 0, ',', '.');
    }

    /**
     * Get formatted discount
     */
    public function getFormattedDiscountAttribute(): string
    {
        return 'Rp ' . number_format($this->discount ?? 0, 0, ',', '.');
    }

    /**
     * Scope a query to only include orders for authenticated user
     */
    public function scopeForCurrentUser($query)
    {
        return $query->where('user_id', auth()->id());
    }

    /**
     * Scope a query to only include pending orders
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Scope a query to only include paid orders
     */
    public function scopePaid($query)
    {
        return $query->where('payment_status', self::PAYMENT_PAID);
    }
}
