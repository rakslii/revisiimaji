<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'description', 'short_description', 'price', 'discount_percent',
        'category', 'category_type', 'is_active', 'image', 'category_id', 'stock', 'sales_count',
        'rating', 'min_order', 'specifications',
        // Kolom gambar tambahan
        'image_2', 'image_3', 'image_4', 'image_5', 'additional_images',
        'thumbnail', 'main_image', 'gallery_images'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'specifications' => 'array',
        'additional_images' => 'array',
        'gallery_images' => 'array',
        'price' => 'decimal:2',
        'rating' => 'decimal:1'
    ];

    protected $appends = [
        'image_url',
        'final_price',
        'has_discount',
        'category_name',
        'thumbnail_url',
        'discount_amount',
        'formatted_price',
        'formatted_final_price',
        'formatted_discount_amount',
        'all_images',
        'gallery_urls',
        'additional_images_urls',
        'primary_image_url',
        // Appends untuk promo dari product_promotions
        'active_product_promotion',
        'product_promotion_discount',
        'has_active_product_promotion',
        'best_product_promotion',
        'final_price_with_product_promotion',
        'total_discount_amount',
        'best_discount_info'
    ];

    // ============ RELATIONSHIPS ============

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    // Relasi dengan product_promotions (PROMO LANGSUNG) - INI YANG ANDA PUNYA
    public function productPromotions()
    {
        return $this->hasMany(ProductPromotion::class);
    }

    // Alias untuk backward compatibility
    public function activePromotions()
    {
        return $this->productPromotions()
                    ->where('is_active', true)
                    ->where('valid_from', '<=', now())
                    ->where('valid_until', '>=', now())
                    ->where(function($query) {
                        $query->whereNull('quota')
                              ->orWhereRaw('used_count < quota');
                    });
    }

    

    // ============ ACCESSORS UTAMA ============

    public function getSpecificationsAttribute($value)
    {
        if (is_array($value)) {
            return $value;
        }

        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }

        return [];
    }

    public function getCategoryNameAttribute()
    {
        if (is_object($this->category) && isset($this->category->name)) {
            return $this->category->name;
        }

        if (is_string($this->category) && !empty($this->category)) {
            return $this->category === 'instan' ? 'Produk Instan' : 'Produk Non Instan';
        }

        if ($this->category_id) {
            $category = ProductCategory::find($this->category_id);
            return $category ? $category->name : 'Produk';
        }

        if (isset($this->attributes['category']) && !empty($this->attributes['category'])) {
            return $this->attributes['category'] === 'instan' ? 'Produk Instan' : 'Produk Non Instan';
        }

        return 'Produk';
    }

    public function getFinalPriceAttribute()
    {
        if ($this->discount_percent > 0) {
            $discounted = $this->price * (1 - ($this->discount_percent / 100));
            return round($discounted, 2);
        }
        return $this->price;
    }

    public function getHasDiscountAttribute()
    {
        return $this->discount_percent > 0;
    }

    public function getDiscountAmountAttribute()
    {
        if ($this->discount_percent > 0) {
            return $this->price * ($this->discount_percent / 100);
        }
        return 0;
    }

    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getFormattedFinalPriceAttribute()
    {
        return 'Rp ' . number_format($this->final_price, 0, ',', '.');
    }

    public function getFormattedDiscountAmountAttribute()
    {
        return 'Rp ' . number_format($this->discount_amount, 0, ',', '.');
    }

    // ============ ACCESSORS UNTUK GAMBAR ============

    public function getAllImagesAttribute()
    {
        $images = [];

        if ($this->main_image) {
            $images[] = [
                'url' => $this->getImageUrl($this->main_image),
                'type' => 'main',
                'order' => 1,
                'field' => 'main_image'
            ];
        }

        if ($this->image && $this->getImageUrl($this->image) !== ($this->main_image ? $this->getImageUrl($this->main_image) : '')) {
            $images[] = [
                'url' => $this->getImageUrl($this->image),
                'type' => 'legacy',
                'order' => 2,
                'field' => 'image'
            ];
        }

        for ($i = 2; $i <= 5; $i++) {
            $field = "image_{$i}";
            if ($this->$field) {
                $images[] = [
                    'url' => $this->getImageUrl($this->$field),
                    'type' => 'additional',
                    'order' => $i + 1,
                    'field' => $field
                ];
            }
        }

        if ($this->additional_images && is_array($this->additional_images)) {
            foreach ($this->additional_images as $index => $imagePath) {
                if ($imagePath) {
                    $images[] = [
                        'url' => $this->getImageUrl($imagePath),
                        'type' => 'gallery',
                        'order' => count($images) + 1,
                        'field' => 'additional_images[' . $index . ']'
                    ];
                }
            }
        }

        if ($this->gallery_images && is_array($this->gallery_images)) {
            foreach ($this->gallery_images as $index => $imagePath) {
                if ($imagePath) {
                    $images[] = [
                        'url' => $this->getImageUrl($imagePath),
                        'type' => 'gallery',
                        'order' => count($images) + 1,
                        'field' => 'gallery_images[' . $index . ']'
                    ];
                }
            }
        }

        usort($images, function($a, $b) {
            return $a['order'] <=> $b['order'];
        });

        return $images;
    }

    public function getGalleryUrlsAttribute()
    {
        $gallery = [];

        for ($i = 2; $i <= 5; $i++) {
            $field = "image_{$i}";
            if ($this->$field) {
                $gallery[] = $this->getImageUrl($this->$field);
            }
        }

        if ($this->additional_images && is_array($this->additional_images)) {
            foreach ($this->additional_images as $imagePath) {
                if ($imagePath) {
                    $gallery[] = $this->getImageUrl($imagePath);
                }
            }
        }

        if ($this->gallery_images && is_array($this->gallery_images)) {
            foreach ($this->gallery_images as $imagePath) {
                if ($imagePath) {
                    $gallery[] = $this->getImageUrl($imagePath);
                }
            }
        }

        return $gallery;
    }

    public function getAdditionalImagesUrlsAttribute()
    {
        $urls = [];

        if ($this->additional_images && is_array($this->additional_images)) {
            foreach ($this->additional_images as $imagePath) {
                if ($imagePath) {
                    $urls[] = $this->getImageUrl($imagePath);
                }
            }
        }

        if ($this->gallery_images && is_array($this->gallery_images)) {
            foreach ($this->gallery_images as $imagePath) {
                if ($imagePath) {
                    $urls[] = $this->getImageUrl($imagePath);
                }
            }
        }

        return $urls;
    }

    public function getPrimaryImageUrlAttribute()
    {
        return $this->getMainImageUrl();
    }

    public function getImageUrlAttribute()
    {
        return $this->getMainImageUrl();
    }

    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail) {
            return $this->getImageUrl($this->thumbnail);
        }
        return $this->getMainImageUrl();
    }

    private function getMainImageUrl()
    {
        if ($this->main_image) {
            return $this->getImageUrl($this->main_image);
        }

        if ($this->image) {
            return $this->getImageUrl($this->image);
        }

        return asset('images/default-product.jpg');
    }

    private function getImageUrl($imagePath)
    {
        if (!$imagePath) {
            return asset('images/default-product.jpg');
        }

        if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
            return $imagePath;
        }

        $storagePath = storage_path('app/public/' . $imagePath);
        if (file_exists($storagePath)) {
            return asset('storage/' . $imagePath);
        }

        $publicPath = public_path($imagePath);
        if (file_exists($publicPath)) {
            return asset($imagePath);
        }

        return $imagePath;
    }

    // ============ ACCESSORS UNTUK PRODUCT_PROMOTIONS ============

    /**
     * Accessor untuk mendapatkan promo aktif terbaik dari product_promotions
     */
    public function getActiveProductPromotionAttribute()
    {
        return $this->getBestActiveProductPromotion();
    }

    /**
     * Accessor untuk mendapatkan diskon dari product_promotions
     */
    public function getProductPromotionDiscountAttribute()
    {
        $bestPromotion = $this->getBestActiveProductPromotion();
        
        if (!$bestPromotion) {
            return 0;
        }

        // Hitung diskon untuk 1 produk
        return $bestPromotion->getDiscountAmount($this->price, 1);
    }

    /**
     * Accessor untuk cek apakah ada promo aktif dari product_promotions
     */
    public function getHasActiveProductPromotionAttribute()
    {
        return $this->activePromotions()->exists();
    }

    /**
     * Accessor untuk mendapatkan promo terbaik
     */
    public function getBestProductPromotionAttribute()
    {
        return $this->active_product_promotion;
    }

    /**
     * Accessor untuk harga final dengan promo dari product_promotions
     */
    public function getFinalPriceWithProductPromotionAttribute()
    {
        $productDiscount = $this->discount_amount;
        $promotionDiscount = $this->product_promotion_discount;
        $totalDiscount = $productDiscount + $promotionDiscount;
        
        return max(0, $this->price - $totalDiscount);
    }

    /**
     * Accessor untuk total diskon (produk + product_promotion)
     */
    public function getTotalDiscountAmountAttribute()
    {
        return $this->discount_amount + $this->product_promotion_discount;
    }

    /**
     * Accessor untuk informasi diskon terbaik
     */
    public function getBestDiscountInfoAttribute()
    {
        $bestPromotion = $this->getBestActiveProductPromotion();
        
        $discountInfo = [
            'type' => 'product_discount',
            'name' => 'Diskon Produk',
            'discount_amount' => $this->discount_amount,
            'discount_percent' => $this->discount_percent,
            'final_price' => $this->final_price,
            'has_promotion' => false
        ];

        if ($bestPromotion) {
            $promotionDiscount = $bestPromotion->getDiscountAmount($this->price, 1);
            $totalDiscount = $this->discount_amount + $promotionDiscount;
            
            // Jika diskon dari promo lebih besar
            if ($promotionDiscount > $this->discount_amount) {
                $discountInfo = [
                    'type' => 'product_promotion',
                    'name' => $bestPromotion->name,
                    'discount_amount' => $promotionDiscount,
                    'discount_percent' => $bestPromotion->type === 'percentage' ? $bestPromotion->value : 0,
                    'final_price' => max(0, $this->price - $totalDiscount),
                    'promotion' => $bestPromotion,
                    'has_promotion' => true
                ];
            }
        }

        return $discountInfo;
    }

    // ============ MUTATORS ============

    public function setSpecificationsAttribute($value)
    {
        $this->attributes['specifications'] = is_array($value) ? json_encode($value) : $value;
    }

    public function setAdditionalImagesAttribute($value)
    {
        $this->attributes['additional_images'] = is_array($value) ? json_encode($value) : $value;
    }

    public function setGalleryImagesAttribute($value)
    {
        $this->attributes['gallery_images'] = is_array($value) ? json_encode($value) : $value;
    }

    // ============ SCOPES ============

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInstan($query)
    {
        return $query->where('category', 'instan');
    }

    public function scopeNonInstan($query)
    {
        return $query->where('category', 'non-instan');
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function scopeLowStock($query)
    {
        return $query->where('stock', '>', 0)->where('stock', '<=', 10);
    }

    public function scopeOutOfStock($query)
    {
        return $query->where('stock', '<=', 0);
    }

    public function scopeHasDiscount($query)
    {
        return $query->where('discount_percent', '>', 0);
    }

    public function scopeWithActiveProductPromotion($query)
    {
        return $query->whereHas('productPromotions', function($q) {
            $q->where('is_active', true)
              ->where('valid_from', '<=', now())
              ->where('valid_until', '>=', now());
        });
    }

    // HAPUS SCOPE INI KARENA TIDAK ADA TABEL promo_product
    /*
    public function scopeWithActivePromoProduct($query)
    {
        return $query->whereHas('activePromoProducts');
    }
    */

    // ============ BOOT METHOD ============

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($product) {
            if ($product->category_id) {
                $category = ProductCategory::find($product->category_id);
                if ($category) {
                    $product->category = $category->type;
                }
            }
        });

        static::creating(function ($product) {
            if (is_null($product->stock)) {
                $product->stock = 0;
            }
            if (is_null($product->sales_count)) {
                $product->sales_count = 0;
            }
            if (is_null($product->min_order)) {
                $product->min_order = 1;
            }
            if (is_null($product->discount_percent)) {
                $product->discount_percent = 0;
            }
            if (is_null($product->rating)) {
                $product->rating = 0;
            }
        });
    }

    // ============ METHODS UTAMA ============

    public function isInStock()
    {
        return $this->stock > 0;
    }

    public function isLowStock()
    {
        return $this->stock > 0 && $this->stock <= 10;
    }

    public function isOutOfStock()
    {
        return $this->stock <= 0;
    }

    public function updateStock($quantity)
    {
        $this->stock += $quantity;
        if ($this->stock < 0) {
            $this->stock = 0;
        }
        $this->save();
    }

    // ============ METHODS UNTUK PRODUCT_PROMOTIONS ============

    /**
     * Helper method untuk mendapatkan promo aktif terbaik dari product_promotions
     */
    public function getBestActiveProductPromotion()
    {
        return $this->activePromotions()
                    ->orderBy('priority', 'desc')
                    ->orderByRaw("
                        CASE 
                            WHEN type = 'percentage' THEN (value * price / 100)
                            ELSE value 
                        END DESC
                    ")
                    ->first();
    }

    /**
     * Method untuk mendapatkan semua promo aktif dengan detail
     */
    public function getActiveProductPromotionsWithDetails()
    {
        return $this->activePromotions()
                    ->orderBy('priority', 'desc')
                    ->get()
                    ->map(function($promotion) {
                        return [
                            'id' => $promotion->id,
                            'name' => $promotion->name,
                            'type' => $promotion->type,
                            'value' => $promotion->value,
                            'formatted_value' => $promotion->formatted_value,
                            'discount_amount' => $promotion->getDiscountAmount($this->price, 1),
                            'final_price' => $promotion->getFinalPrice($this->price, 1),
                            'valid_from' => $promotion->valid_from->format('d M Y H:i'),
                            'valid_until' => $promotion->valid_until->format('d M Y H:i'),
                            'remaining_days' => $promotion->remaining_days,
                            'quota' => $promotion->quota,
                            'used_count' => $promotion->used_count,
                            'remaining_uses' => $promotion->remaining_uses,
                            'min_purchase' => $promotion->min_purchase,
                            'min_quantity' => $promotion->min_quantity,
                            'is_exclusive' => $promotion->is_exclusive,
                            'priority' => $promotion->priority,
                            'status' => $promotion->status
                        ];
                    });
    }

    /**
     * Method untuk mendapatkan diskon maksimal untuk quantity tertentu
     */
    public function getMaxPromotionDiscount($quantity = 1, $price = null)
    {
        $price = $price ?? $this->price;
        $bestPromotion = $this->getBestActiveProductPromotion();
        
        if (!$bestPromotion) {
            return 0;
        }

        return $bestPromotion->getDiscountAmount($price, $quantity);
    }

    /**
     * Method untuk mendapatkan harga final dengan semua diskon
     */
    public function getFinalPriceAfterAllDiscounts($quantity = 1)
    {
        $productDiscount = $this->discount_amount * $quantity;
        $promotionDiscount = $this->getMaxPromotionDiscount($quantity);
        
        return max(0, ($this->price * $quantity) - $productDiscount - $promotionDiscount);
    }

    /**
     * Method untuk mengecek apakah produk memiliki promo aktif
     */
    public function hasActivePromotion()
    {
        return $this->has_active_product_promotion;
    }

    /**
     * Method untuk mendapatkan ringkasan semua promosi
     */
    public function getPromotionsSummary()
    {
        $productPromotions = $this->getActiveProductPromotionsWithDetails();
        $bestPromotion = $this->getBestActiveProductPromotion();
        
        return [
            'has_product_promotions' => $productPromotions->isNotEmpty(),
            'has_active_promotion' => $bestPromotion !== null,
            'best_promotion' => $bestPromotion ? [
                'id' => $bestPromotion->id,
                'name' => $bestPromotion->name,
                'type' => $bestPromotion->type,
                'value' => $bestPromotion->value,
                'formatted_value' => $bestPromotion->formatted_value,
                'discount_amount' => $bestPromotion->getDiscountAmount($this->price, 1),
                'valid_until' => $bestPromotion->valid_until->format('d M Y H:i'),
                'remaining_days' => $bestPromotion->remaining_days
            ] : null,
            'product_promotions' => $productPromotions,
            'total_discount_amount' => $this->total_discount_amount,
            'final_price_with_promotions' => $this->final_price_with_product_promotion,
            'best_discount_info' => $this->best_discount_info
        ];
    }

    /**
     * Method untuk menggunakan promo (increment used_count)
     */
    public function usePromotion($promotionId, $quantity = 1)
    {
        $promotion = $this->productPromotions()
                         ->where('id', $promotionId)
                         ->where('is_active', true)
                         ->first();
        
        if (!$promotion) {
            return false;
        }

        if ($promotion->quota && $promotion->used_count + $quantity > $promotion->quota) {
            return false;
        }

        $promotion->used_count += $quantity;
        $promotion->save();
        
        return true;
    }

    /**
     * Method untuk mengecek apakah promo bisa digunakan
     */
    public function canUsePromotion($promotionId, $quantity = 1, $totalPrice = null)
    {
        $promotion = $this->productPromotions()
                         ->where('id', $promotionId)
                         ->first();
        
        if (!$promotion) {
            return false;
        }

        $totalPrice = $totalPrice ?? ($this->price * $quantity);
        
        return $promotion->canBeUsed($this->price, $quantity);
    }

    /**
     * Method untuk mendapatkan semua tipe diskon yang tersedia
     */
    public function getAllAvailableDiscounts()
    {
        $discounts = [];

        // Diskont produk
        if ($this->discount_percent > 0) {
            $discounts[] = [
                'type' => 'product_discount',
                'name' => 'Diskon Produk',
                'discount_amount' => $this->discount_amount,
                'discount_percent' => $this->discount_percent,
                'priority' => 0
            ];
        }

        // Promosi dari product_promotions
        $productPromotions = $this->activePromotions()->get();
        foreach ($productPromotions as $promotion) {
            $discountAmount = $promotion->getDiscountAmount($this->price, 1);
            $discounts[] = [
                'type' => 'product_promotion',
                'id' => $promotion->id,
                'name' => $promotion->name,
                'discount_amount' => $discountAmount,
                'discount_percent' => $promotion->type === 'percentage' ? $promotion->value : 0,
                'promotion' => $promotion,
                'priority' => $promotion->priority
            ];
        }

        // Urutkan berdasarkan priority dan jumlah diskon
        usort($discounts, function($a, $b) {
            if ($a['priority'] != $b['priority']) {
                return $b['priority'] <=> $a['priority'];
            }
            return $b['discount_amount'] <=> $a['discount_amount'];
        });

        return $discounts;
    }
}