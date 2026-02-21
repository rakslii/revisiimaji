<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use SoftDeletes;

    // Konstanta untuk validasi ENUM
    const CATEGORY_TYPES = ['instan', 'non-instan'];

    protected $fillable = [
        'name', 'description', 'short_description', 'price', 'base_discount_percent',
        'calculated_discount_percent', 'discount_override_percent', 'discount_calculation_type',
        'category', 'category_type', 'is_active', 'image', 'category_id', 'stock', 'sales_count',
        'rating', 'min_order', 'specifications', 'active_product_promotion_id',
        'image_2', 'image_3', 'image_4', 'image_5', 'additional_images',
        'thumbnail', 'main_image', 'gallery_images'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'specifications' => 'array',
        'additional_images' => 'array',
        'gallery_images' => 'array',
        'price' => 'decimal:2',
        'rating' => 'decimal:1',
        'base_discount_percent' => 'integer',
        'calculated_discount_percent' => 'decimal:2',
        'discount_override_percent' => 'integer',
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
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
        'discount_percent',
        'active_product_promotion',
        'product_promotion_discount',
        'has_active_product_promotion',
        'best_product_promotion',
        'final_price_with_product_promotion',
        'total_discount_amount',
        'best_discount_info',
        'is_discount_auto',
        'discount_source'
    ];

    // ============ RELATIONSHIPS ============

// Di app/Models/Product.php, cari method category()
public function productCategory()
{
    return $this->belongsTo(ProductCategory::class, 'category_id');
}

    public function productPromotions()
    {
        return $this->hasMany(ProductPromotion::class);
    }

    public function activeProductPromotion()
    {
        return $this->belongsTo(ProductPromotion::class, 'active_product_promotion_id');
    }

    public function activePromotion()
    {
        return $this->activeProductPromotion();
    }

    public function activePromotions()
    {
        return $this->hasMany(ProductPromotion::class)
            ->where('is_active', true)
            ->where('valid_from', '<=', now())
            ->where('valid_until', '>=', now())
            ->where(function($query) {
                $query->whereNull('quota')
                    ->orWhereRaw('used_count < quota');
            });
    }

    // ============ MUTATORS UNTUK ENUM ============

    public function setCategoryAttribute($value)
    {
        // Pastikan nilai sesuai ENUM
        if (!in_array($value, self::CATEGORY_TYPES)) {
            $value = 'instan';
        }
        $this->attributes['category'] = $value;
    }

    public function setCategoryTypeAttribute($value)
    {
        // Pastikan nilai sesuai ENUM
        if (!in_array($value, self::CATEGORY_TYPES)) {
            $value = 'instan';
        }
        $this->attributes['category_type'] = $value;
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

    public function getDiscountPercentAttribute()
    {
        return (int) round($this->calculated_discount_percent);
    }

    public function getFinalPriceAttribute()
    {
        if ($this->calculated_discount_percent > 0) {
            $discounted = $this->price * (1 - ($this->calculated_discount_percent / 100));
            return round($discounted, 2);
        }
        return $this->price;
    }

    public function getHasDiscountAttribute()
    {
        return $this->calculated_discount_percent > 0;
    }

    public function getDiscountAmountAttribute()
    {
        if ($this->calculated_discount_percent > 0) {
            return $this->price * ($this->calculated_discount_percent / 100);
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

    // ============ ACCESSORS UNTUK PRODUCT PROMOTIONS ============

    public function getActiveProductPromotionAttribute()
    {
        if ($this->relationLoaded('activeProductPromotion') && $this->activeProductPromotion) {
            return $this->activeProductPromotion;
        }
        
        return $this->getBestActiveProductPromotion();
    }

    public function getProductPromotionDiscountAttribute()
    {
        $bestPromotion = $this->active_product_promotion;
        
        if (!$bestPromotion) {
            return 0;
        }

        return $bestPromotion->getDiscountAmount($this->price, 1);
    }

    public function getHasActiveProductPromotionAttribute()
    {
        return $this->activePromotions()->exists();
    }

    public function getBestProductPromotionAttribute()
    {
        return $this->active_product_promotion;
    }

    public function getFinalPriceWithProductPromotionAttribute()
    {
        $productDiscount = $this->discount_amount;
        $promotionDiscount = $this->product_promotion_discount;
        $totalDiscount = $productDiscount + $promotionDiscount;
        
        return max(0, $this->price - $totalDiscount);
    }

    public function getTotalDiscountAmountAttribute()
    {
        return $this->discount_amount + $this->product_promotion_discount;
    }

    public function getBestDiscountInfoAttribute()
    {
        $bestPromotion = $this->active_product_promotion;
        
        $discountInfo = [
            'type' => $this->discount_calculation_type,
            'name' => 'Diskon Produk',
            'discount_amount' => $this->discount_amount,
            'discount_percent' => $this->discount_percent,
            'final_price' => $this->final_price,
            'source' => $this->discount_calculation_type === 'manual' ? 'manual_override' : 'base_discount',
            'has_promotion' => false,
            'is_active' => true
        ];

        if ($bestPromotion && $this->discount_calculation_type === 'auto') {
            $promotionDiscount = $bestPromotion->getDiscountAmount($this->price, 1);
            
            $discountInfo = [
                'type' => 'product_promotion',
                'name' => $bestPromotion->name ?? 'Diskon Promo',
                'discount_amount' => $promotionDiscount,
                'discount_percent' => $bestPromotion->type === 'percentage' ? $bestPromotion->value : ($promotionDiscount / $this->price) * 100,
                'final_price' => max(0, $this->price - $promotionDiscount),
                'promotion' => [
                    'id' => $bestPromotion->id,
                    'name' => $bestPromotion->name,
                    'type' => $bestPromotion->type,
                    'value' => $bestPromotion->value
                ],
                'source' => 'product_promotion',
                'has_promotion' => true,
                'is_active' => $bestPromotion->is_active && $bestPromotion->is_valid
            ];
        }

        return $discountInfo;
    }

    public function getIsDiscountAutoAttribute()
    {
        return $this->discount_calculation_type === 'auto';
    }

    public function getDiscountSourceAttribute()
    {
        if ($this->discount_calculation_type === 'manual') {
            return 'manual_override';
        }
        
        if ($this->active_product_promotion_id) {
            return 'product_promotion';
        }
        
        return 'base_discount';
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

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = is_numeric($value) ? round($value, 2) : 0;
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
        return $query->where('calculated_discount_percent', '>', 0);
    }

    public function scopeWithActiveProductPromotion($query)
    {
        return $query->whereHas('productPromotions', function($q) {
            $q->where('is_active', true)
              ->where('valid_from', '<=', now())
              ->where('valid_until', '>=', now());
        });
    }

    public function scopeWithAutoDiscount($query)
    {
        return $query->where('discount_calculation_type', 'auto');
    }

    public function scopeWithManualDiscount($query)
    {
        return $query->where('discount_calculation_type', 'manual');
    }

    public function scopeWithBestDiscount($query)
    {
        return $query->orderBy('calculated_discount_percent', 'desc');
    }

    // ============ BOOT METHOD ============

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($product) {
            // Set category and category_type from category relationship
            if ($product->category_id) {
                $category = ProductCategory::find($product->category_id);
                if ($category) {
                    // Pastikan nilai sesuai ENUM
                    $type = $category->type;
                    
                    // Validasi nilai ENUM
                    if (!in_array($type, self::CATEGORY_TYPES)) {
                        $type = 'instan'; // default jika tidak valid
                    }
                    
                    $product->category = $type;
                    $product->category_type = $type;
                    
                    \Log::info('Product saving - Setting category fields:', [
                        'category_id' => $product->category_id,
                        'category_type_from_db' => $category->type,
                        'category_field' => $product->category,
                        'category_type_field' => $product->category_type
                    ]);
                }
            }

            // Inisialisasi nilai default
            if (is_null($product->discount_calculation_type)) {
                $product->discount_calculation_type = 'auto';
            }
            
            if (is_null($product->calculated_discount_percent)) {
                $product->calculated_discount_percent = $product->base_discount_percent ?? 0;
            }
            
            // Set default untuk required fields
            if (empty($product->description)) {
                $product->description = 'Deskripsi produk';
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
            if (is_null($product->base_discount_percent)) {
                $product->base_discount_percent = 0;
            }
            if (is_null($product->calculated_discount_percent)) {
                $product->calculated_discount_percent = 0;
            }
            if (is_null($product->rating)) {
                $product->rating = 0;
            }
            if (is_null($product->is_active)) {
                $product->is_active = true;
            }
            
            // Set default untuk category fields jika masih kosong
            if (empty($product->category)) {
                $product->category = 'instan';
            }
            if (empty($product->category_type)) {
                $product->category_type = 'instan';
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

    // ============ METHODS UNTUK DISCOUNT & PROMOTION ============

    public function refreshCalculatedDiscount()
    {
        if ($this->discount_calculation_type === 'manual') {
            return;
        }

        $bestPromotion = $this->getBestActiveProductPromotion();
        
        if ($bestPromotion) {
            $calculatedPercent = $bestPromotion->type === 'percentage' 
                ? $bestPromotion->value 
                : ($bestPromotion->value / $this->price) * 100;
            
            $this->calculated_discount_percent = round($calculatedPercent, 2);
            $this->active_product_promotion_id = $bestPromotion->id;
        } else {
            $this->calculated_discount_percent = $this->base_discount_percent;
            $this->active_product_promotion_id = null;
        }
        
        $this->save();
    }

    public function getBestActiveProductPromotion()
    {
        return $this->activePromotions()
            ->orderBy('priority', 'desc')
            ->orderByRaw("
                CASE 
                    WHEN type = 'percentage' THEN value
                    ELSE (value / ?) * 100 
                END DESC
            ", [$this->price])
            ->first();
    }

    public function setManualDiscount($percent)
    {
        $this->discount_calculation_type = 'manual';
        $this->discount_override_percent = min(100, max(0, (int) $percent));
        $this->calculated_discount_percent = $this->discount_override_percent;
        $this->active_product_promotion_id = null;
        $this->save();
    }

    public function setAutoDiscount()
    {
        $this->discount_calculation_type = 'auto';
        $this->discount_override_percent = null;
        $this->refreshCalculatedDiscount();
    }

    public function getActiveProductPromotionsWithDetails()
    {
        return $this->activePromotions()
            ->orderBy('priority', 'desc')
            ->get()
            ->map(function($promotion) {
                $discountAmount = $promotion->getDiscountAmount($this->price, 1);
                $discountPercent = $promotion->type === 'percentage' 
                    ? $promotion->value 
                    : ($discountAmount / $this->price) * 100;
                
                return [
                    'id' => $promotion->id,
                    'name' => $promotion->name,
                    'type' => $promotion->type,
                    'value' => $promotion->value,
                    'formatted_value' => $promotion->formatted_value,
                    'discount_amount' => $discountAmount,
                    'discount_percent' => $discountPercent,
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
                    'status' => $promotion->status,
                    'is_valid' => $promotion->is_valid
                ];
            });
    }

    public function getMaxPromotionDiscount($quantity = 1)
    {
        $bestPromotion = $this->getBestActiveProductPromotion();
        
        if (!$bestPromotion) {
            return 0;
        }

        return $bestPromotion->getDiscountAmount($this->price, $quantity);
    }

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
                'discount_percent' => $bestPromotion->type === 'percentage' ? $bestPromotion->value : ($bestPromotion->value / $this->price) * 100,
                'valid_until' => $bestPromotion->valid_until->format('d M Y H:i'),
                'remaining_days' => $bestPromotion->remaining_days,
                'is_active' => $bestPromotion->is_active,
                'is_valid' => $bestPromotion->is_valid
            ] : null,
            'product_promotions' => $productPromotions,
            'discount_calculation_type' => $this->discount_calculation_type,
            'base_discount_percent' => $this->base_discount_percent,
            'calculated_discount_percent' => $this->calculated_discount_percent,
            'discount_override_percent' => $this->discount_override_percent,
            'total_discount_amount' => $this->total_discount_amount,
            'final_price_with_promotions' => $this->final_price_with_product_promotion,
            'best_discount_info' => $this->best_discount_info
        ];
    }

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

    // ============ METHODS UNTUK IMAGES ============

    public function getTotalImagesCount()
    {
        $count = 0;
        
        $individualFields = ['image', 'main_image', 'thumbnail', 'image_2', 'image_3', 'image_4', 'image_5'];
        foreach ($individualFields as $field) {
            if (!empty($this->$field)) {
                $count++;
            }
        }
        
        if ($this->additional_images && is_array($this->additional_images)) {
            $count += count(array_filter($this->additional_images));
        }
        
        if ($this->gallery_images && is_array($this->gallery_images)) {
            $count += count(array_filter($this->gallery_images));
        }
        
        return $count;
    }

    public function getAllImagePaths()
    {
        $paths = [];
        
        $individualFields = [
            'image' => 'image',
            'main_image' => 'main_image',
            'thumbnail' => 'thumbnail',
            'image_2' => 'image_2',
            'image_3' => 'image_3',
            'image_4' => 'image_4',
            'image_5' => 'image_5'
        ];
        
        foreach ($individualFields as $field => $type) {
            if (!empty($this->$field)) {
                $paths[] = [
                    'path' => $this->$field,
                    'type' => $type,
                    'url' => $this->getImageUrl($this->$field)
                ];
            }
        }
        
        if ($this->additional_images && is_array($this->additional_images)) {
            foreach (array_filter($this->additional_images) as $path) {
                $paths[] = [
                    'path' => $path,
                    'type' => 'additional',
                    'url' => $this->getImageUrl($path)
                ];
            }
        }
        
        if ($this->gallery_images && is_array($this->gallery_images)) {
            foreach (array_filter($this->gallery_images) as $path) {
                $paths[] = [
                    'path' => $path,
                    'type' => 'gallery',
                    'url' => $this->getImageUrl($path)
                ];
            }
        }
        
        return $paths;
    }
}