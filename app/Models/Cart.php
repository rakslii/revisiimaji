<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id'
    ];

    /**
     * Get the user that owns the cart
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the cart items
     */
    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Calculate cart subtotal
     */
    public function getSubtotalAttribute(): float
    {
        return $this->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });
    }

    /**
     * Get formatted subtotal
     */
    public function getFormattedSubtotalAttribute(): string
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }

    /**
     * Get total items in cart
     */
    public function getTotalItemsAttribute(): int
    {
        return $this->items->sum('quantity');
    }

    /**
     * Find or create cart for current user/session
     */
    public static function getCurrentCart()
    {
        if (auth()->check()) {
            // User logged in - get or create user cart
            return static::firstOrCreate(
                ['user_id' => auth()->id()],
                ['session_id' => session()->getId()]
            );
        }
        
        // Guest user - get or create session cart
        return static::firstOrCreate(
            ['session_id' => session()->getId()],
            ['user_id' => null]
        );
    }

    /**
     * Merge session cart with user cart after login
     */
    public static function mergeCarts($user)
    {
        $sessionCart = static::where('session_id', session()->getId())
            ->whereNull('user_id')
            ->first();
            
        $userCart = static::where('user_id', $user->id)->first();
        
        if ($sessionCart && $userCart) {
            // Merge session cart items into user cart
            foreach ($sessionCart->items as $item) {
                $existingItem = $userCart->items()
                    ->where('product_id', $item->product_id)
                    ->first();
                    
                if ($existingItem) {
                    $existingItem->update([
                        'quantity' => $existingItem->quantity + $item->quantity
                    ]);
                } else {
                    $userCart->items()->create([
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'price' => $item->price
                    ]);
                }
            }
            
            // Delete session cart
            $sessionCart->delete();
            
        } elseif ($sessionCart) {
            // Convert session cart to user cart
            $sessionCart->update(['user_id' => $user->id]);
        }
    }
}