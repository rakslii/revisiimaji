<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\ProductPromotion;
use App\Observers\ProductPromotionObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register observer for ProductPromotion
        ProductPromotion::observe(ProductPromotionObserver::class);
        
        // Or you can register in the model's boot method
    }
}