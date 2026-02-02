<?php

namespace App\Observers;

use App\Models\ProductPromotion;
use App\Models\Product;

class ProductPromotionObserver
{
    public function created(ProductPromotion $productPromotion)
    {
        $this->updateProductDiscount($productPromotion->product_id);
    }

    public function updated(ProductPromotion $productPromotion)
    {
        $this->updateProductDiscount($productPromotion->product_id);
    }

    public function deleted(ProductPromotion $productPromotion)
    {
        $this->updateProductDiscount($productPromotion->product_id);
    }

    public function restored(ProductPromotion $productPromotion)
    {
        $this->updateProductDiscount($productPromotion->product_id);
    }

    private function updateProductDiscount($productId)
    {
        $product = Product::find($productId);
        
        if ($product && $product->discount_calculation_type === 'auto') {
            $product->refreshCalculatedDiscount();
        }
    }
}