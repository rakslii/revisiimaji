<?php

namespace Database\Seeders;

use App\Models\OnlineStore;
use Illuminate\Database\Seeder;

class OnlineStoreSeeder extends Seeder
{
    public function run()
    {
        $stores = [
            [
                'name' => 'Shopee',
                'slug' => 'shopee',
                'platform' => 'ecommerce',
                'description' => 'Toko online kami di platform Shopee',
                'url' => 'https://shopee.co.id/ciptaimaji',
                'icon_class' => 'fab fa-shopify',
                'color' => '#ff5722',
                'gradient_from' => '#ff5722',
                'gradient_to' => '#ff8a65',
                'store_username' => 'ciptaimaji',
                'store_id' => 'ciptaimaji',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => 'Tokopedia',
                'slug' => 'tokopedia',
                'platform' => 'ecommerce',
                'description' => 'Toko online kami di platform Tokopedia',
                'url' => 'https://tokopedia.com/ciptaimaji',
                'icon_class' => 'fas fa-store',
                'color' => '#43b549',
                'gradient_from' => '#43b549',
                'gradient_to' => '#6fcf97',
                'store_username' => 'ciptaimaji',
                'store_id' => 'ciptaimaji',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'name' => 'Instagram',
                'slug' => 'instagram',
                'platform' => 'social_media',
                'description' => 'Akun Instagram kami untuk pemesanan dan informasi',
                'url' => 'https://instagram.com/ciptaimaji',
                'icon_class' => 'fab fa-instagram',
                'color' => '#e1306c',
                'gradient_from' => '#e1306c',
                'gradient_to' => '#fd1d1d',
                'store_username' => 'ciptaimaji',
                'store_id' => 'ciptaimaji',
                'is_active' => true,
                'order' => 3,
            ],
            [
                'name' => 'Bukalapak',
                'slug' => 'bukalapak',
                'platform' => 'ecommerce',
                'description' => 'Toko online kami di platform Bukalapak',
                'url' => 'https://bukalapak.com/ciptaimaji',
                'icon_class' => 'fas fa-shopping-bag',
                'color' => '#e31f27',
                'gradient_from' => '#e31f27',
                'gradient_to' => '#ff6b6b',
                'store_username' => 'ciptaimaji',
                'store_id' => 'ciptaimaji',
                'is_active' => true,
                'order' => 4,
            ],
            [
                'name' => 'Lazada',
                'slug' => 'lazada',
                'platform' => 'ecommerce',
                'description' => 'Toko online kami di platform Lazada',
                'url' => 'https://lazada.co.id/ciptaimaji',
                'icon_class' => 'fab fa-shopping-bag',
                'color' => '#0f146d',
                'gradient_from' => '#0f146d',
                'gradient_to' => '#3a42ff',
                'store_username' => 'ciptaimaji',
                'store_id' => 'ciptaimaji',
                'is_active' => true,
                'order' => 5,
            ],
            [
                'name' => 'TikTok Shop',
                'slug' => 'tiktok-shop',
                'platform' => 'social_media',
                'description' => 'Toko online kami di TikTok Shop',
                'url' => 'https://tiktok.com/@ciptaimaji',
                'icon_class' => 'fab fa-tiktok',
                'color' => '#000000',
                'gradient_from' => '#000000',
                'gradient_to' => '#333333',
                'store_username' => 'ciptaimaji',
                'store_id' => 'ciptaimaji',
                'is_active' => true,
                'order' => 6,
            ],
        ];

        foreach ($stores as $store) {
            OnlineStore::create($store);
        }
    }
}