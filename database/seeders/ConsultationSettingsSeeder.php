<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConsultationSettingsSeeder extends Seeder
{
    public function run()
    {
        // General Consultation
        DB::table('consultation_general')->insert([
            'phone_number' => '6281234567890',
            'display_text' => 'Chat WhatsApp',
            'message_template' => 'Halo, saya ingin konsultasi. Bisa dibantu?',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Product Consultation
        DB::table('consultation_products')->insert([
            'phone_number' => '6281234567890',
            'display_text' => 'Konsultasi via WhatsApp',
            'message_template' => 'Halo, saya tertarik dengan produk *[PRODUCT_NAME]*. Bisa info lebih lanjut?',
            'include_product_url' => true,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Custom Product Consultation
        DB::table('consultation_custom_products')->insert([
            'phone_number' => '6281234567890',
            'display_text' => 'Konsultasi Produk Custom',
            'message_template' => 'Halo, saya ingin konsultasi tentang produk custom *[PRODUCT_NAME]*. Bisa dibantu?',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}