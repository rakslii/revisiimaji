<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General Settings
            [
                'key' => 'site_name',
                'value' => 'Cipta Imaji',
                'type' => 'string',
                'group' => 'general',
                'description' => 'Nama website/toko'
            ],
            [
                'key' => 'site_email',
                'value' => 'info@ciptaimaji.com',
                'type' => 'string',
                'group' => 'general',
                'description' => 'Email utama website'
            ],
            [
                'key' => 'site_phone',
                'value' => '+6281234567890',
                'type' => 'string',
                'group' => 'general',
                'description' => 'Nomor telepon customer service'
            ],
            [
                'key' => 'site_address',
                'value' => 'Jl. Contoh No. 123, Jakarta Selatan',
                'type' => 'text',
                'group' => 'general',
                'description' => 'Alamat toko fisik'
            ],

            // WhatsApp Settings
            [
                'key' => 'whatsapp_number',
                'value' => '6281234567890',
                'type' => 'string',
                'group' => 'whatsapp',
                'description' => 'Nomor WhatsApp untuk chat'
            ],
            [
                'key' => 'whatsapp_message',
                'value' => 'Halo Cipta Imaji, saya ingin konsultasi tentang produk digital printing',
                'type' => 'text',
                'group' => 'whatsapp',
                'description' => 'Pesan default WhatsApp'
            ],

            // Shipping Settings
            [
                'key' => 'shipping_cost_jabodetabek',
                'value' => '15000',
                'type' => 'number',
                'group' => 'shipping',
                'description' => 'Biaya pengiriman Jabodetabek'
            ],
            [
                'key' => 'free_shipping_minimum',
                'value' => '500000',
                'type' => 'number',
                'group' => 'shipping',
                'description' => 'Minimum belanja untuk gratis ongkir'
            ],

            // Payment Settings
            [
                'key' => 'payment_qris_enabled',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'payment',
                'description' => 'Aktifkan pembayaran QRIS'
            ],
            [
                'key' => 'payment_bank_transfer_enabled',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'payment',
                'description' => 'Aktifkan transfer bank'
            ],

            // Product Settings
            [
                'key' => 'instant_product_processing_time',
                'value' => '24',
                'type' => 'number',
                'group' => 'products',
                'description' => 'Waktu proses produk instan (jam)'
            ],
            [
                'key' => 'custom_product_processing_time',
                'value' => '72',
                'type' => 'number',
                'group' => 'products',
                'description' => 'Waktu proses produk custom (jam)'
            ],
        ];

        foreach ($settings as $setting) {
            DB::table('admin_settings')->updateOrInsert(
                ['key' => $setting['key']],
                $setting
            );
        }

        $this->command->info('✅ Admin settings seeded successfully!');
    }
}
