<?php

namespace Database\Seeders;

use App\Models\OnlineStore;
use Illuminate\Database\Seeder;

class OnlineStoreSeeder extends Seeder
{
    public function run()
    {
        // Hapus data lama jika ada
        OnlineStore::truncate();

        $stores = [
            [
                'name' => 'Shopee',
                'slug' => 'shopee',
                'platform' => 'ecommerce',
                'description' => 'Toko online kami di platform Shopee',
                'url' => 'https://shopee.co.id/ciptaimaji',
                'icon_class' => 'fas fa-shopping-cart', // Shopee tidak ada di FontAwesome
                'color' => '#FF5722',
                'gradient_from' => '#FF5722',
                'gradient_to' => '#FF8A65',
                'store_username' => '@ciptaimaji',
                'store_id' => 'ciptaimaji_shopee',
                'is_active' => true,
                'order' => 1,
                'metadata' => [
                    'platform_icon' => 'shopee',
                    'verified' => true,
                    'follower_count' => 1500
                ],
            ],
            [
                'name' => 'Tokopedia',
                'slug' => 'tokopedia',
                'platform' => 'ecommerce',
                'description' => 'Toko online kami di platform Tokopedia',
                'url' => 'https://tokopedia.com/ciptaimaji',
                'icon_class' => 'fas fa-store',
                'color' => '#43B549',
                'gradient_from' => '#43B549',
                'gradient_to' => '#6FCF97',
                'store_username' => 'ciptaimaji',
                'store_id' => 'ciptaimaji_tokped',
                'is_active' => true,
                'order' => 2,
                'metadata' => [
                    'platform_icon' => 'tokopedia',
                    'verified' => true,
                    'rating' => 4.8
                ],
            ],
            [
                'name' => 'Instagram Shop',
                'slug' => 'instagram-shop',
                'platform' => 'social_media',
                'description' => 'Pesan via Instagram untuk konsultasi dan pemesanan',
                'url' => 'https://instagram.com/ciptaimaji',
                'icon_class' => 'fab fa-instagram',
                'color' => '#E1306C',
                'gradient_from' => '#E1306C',
                'gradient_to' => '#FD1D1D',
                'store_username' => '@ciptaimaji',
                'store_id' => 'ciptaimaji_ig',
                'is_active' => true,
                'order' => 3,
                'metadata' => [
                    'follower_count' => 3200,
                    'is_shop_active' => true,
                    'highlight_reel' => true
                ],
            ],
            [
                'name' => 'WhatsApp Business',
                'slug' => 'whatsapp-business',
                'platform' => 'social_media',
                'description' => 'Hubungi kami via WhatsApp untuk konsultasi & order',
                'url' => 'https://wa.me/6281234567890',
                'icon_class' => 'fab fa-whatsapp',
                'color' => '#25D366',
                'gradient_from' => '#25D366',
                'gradient_to' => '#128C7E',
                'store_username' => '+62 812-3456-7890',
                'store_id' => '6281234567890',
                'is_active' => true,
                'order' => 4,
                'metadata' => [
                    'phone_number' => '+6281234567890',
                    'business_hours' => '08:00-17:00',
                    'response_time' => 'kurang dari 15 menit'
                ],
            ],
            [
                'name' => 'Facebook Marketplace',
                'slug' => 'facebook-marketplace',
                'platform' => 'social_media',
                'description' => 'Temukan produk kami di Facebook Marketplace',
                'url' => 'https://facebook.com/ciptaimaji',
                'icon_class' => 'fab fa-facebook',
                'color' => '#1877F2',
                'gradient_from' => '#1877F2',
                'gradient_to' => '#0099FF',
                'store_username' => 'Cipta Imaji',
                'store_id' => 'ciptaimaji_fb',
                'is_active' => true,
                'order' => 5,
                'metadata' => [
                    'page_likes' => 1200,
                    'marketplace_rating' => 4.9
                ],
            ],
            [
                'name' => 'Bukalapak',
                'slug' => 'bukalapak',
                'platform' => 'ecommerce',
                'description' => 'Toko online resmi di Bukalapak',
                'url' => 'https://bukalapak.com/u/ciptaimaji',
                'icon_class' => 'fas fa-shopping-bag',
                'color' => '#E31F27',
                'gradient_from' => '#E31F27',
                'gradient_to' => '#FF6B6B',
                'store_username' => 'ciptaimaji',
                'store_id' => 'ciptaimaji_bukalapak',
                'is_active' => true,
                'order' => 6,
                'metadata' => [
                    'power_merchant' => true,
                    'trusted_store' => true
                ],
            ],
            [
                'name' => 'Lazada',
                'slug' => 'lazada',
                'platform' => 'ecommerce',
                'description' => 'Official store di Lazada Indonesia',
                'url' => 'https://lazada.co.id/shop/ciptaimaji',
                'icon_class' => 'fas fa-box',
                'color' => '#0F146D',
                'gradient_from' => '#0F146D',
                'gradient_to' => '#3A42FF',
                'store_username' => 'CiptaImajiOfficial',
                'store_id' => 'ciptaimaji_lazada',
                'is_active' => true,
                'order' => 7,
                'metadata' => [
                    'lazmall' => true,
                    'fulfilled_by_lazada' => true
                ],
            ],
            [
                'name' => 'TikTok Shop',
                'slug' => 'tiktok-shop',
                'platform' => 'social_media',
                'description' => 'Live shopping & produk eksklusif di TikTok Shop',
                'url' => 'https://tiktok.com/@ciptaimaji',
                'icon_class' => 'fab fa-tiktok',
                'color' => '#000000',
                'gradient_from' => '#000000',
                'gradient_to' => '#333333',
                'store_username' => '@ciptaimaji',
                'store_id' => 'ciptaimaji_tiktok',
                'is_active' => true,
                'order' => 8,
                'metadata' => [
                    'live_shopping' => true,
                    'video_count' => 45,
                    'follower_count' => 8900
                ],
            ],
        ];

        foreach ($stores as $store) {
            OnlineStore::create($store);
        }
        
        $this->command->info('✅ Online stores seeded successfully!');
        $this->command->info('📱 ' . count($stores) . ' online stores created');
    }
}