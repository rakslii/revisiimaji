<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'avatar',
        'phone',
        'address',
        'city',
        'province',
        'postal_code',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Role constants
    const ROLE_CUSTOMER = 'customer';
    const ROLE_ADMIN = 'admin';

    // ============ RELATIONSHIPS ============
    
    // Orders
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Locations
    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    // Payments
    public function payments()
    {
        return $this->hasManyThrough(Payment::class, Order::class);
    }

    // ============ CART RELATIONSHIPS (TAMBAHKAN INI) ============
    
    // Cart (One-to-One: satu user punya satu cart)
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    // Cart items through cart (untuk akses cepat)
    public function cartItems()
    {
        return $this->hasManyThrough(CartItem::class, Cart::class);
    }

    // Active cart items (yang produknya masih aktif)
    public function activeCartItems()
    {
        return $this->cartItems()
            ->whereHas('product', function ($query) {
                $query->where('is_active', true);
            });
    }

    // ============ METHODS ============

    // Simple admin check
    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    // Get cart total items count
    public function getCartItemsCountAttribute()
    {
        if (!$this->cart) {
            return 0;
        }
        return $this->cart->total_items;
    }

    // Get cart subtotal
    public function getCartSubtotalAttribute()
    {
        if (!$this->cart) {
            return 0;
        }
        return $this->cart->subtotal;
    }

    // Get formatted cart subtotal
    public function getFormattedCartSubtotalAttribute()
    {
        if (!$this->cart) {
            return 'Rp 0';
        }
        return $this->cart->formatted_subtotal;
    }

    // Scope untuk admin
    public function scopeAdmins($query)
    {
        return $query->where('role', self::ROLE_ADMIN);
    }

    // Scope untuk customers
    public function scopeCustomers($query)
    {
        return $query->where('role', self::ROLE_CUSTOMER);
    }

    // Find or create by Google ID
    public static function findByGoogleIdOrCreate($googleUser)
    {
        $user = self::where('google_id', $googleUser->id)
                    ->orWhere('email', $googleUser->email)
                    ->first();

        if (!$user) {
            $user = self::create([
                'google_id' => $googleUser->id,
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'avatar' => $googleUser->avatar,
                'password' => bcrypt(uniqid()),
                'role' => self::ROLE_CUSTOMER,
                'email_verified_at' => now(),
            ]);
        } else {
            // Update if missing google_id
            if (!$user->google_id) {
                $user->google_id = $googleUser->id;
            }
            
            // Update avatar
            $user->avatar = $googleUser->avatar;
            $user->save();
        }

        return $user;
    }
}