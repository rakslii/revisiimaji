<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
        // Get category IDs
        $brosurId = DB::table('product_categories')->where('slug', 'brosur-flyer')->value('id');
        $kartuNamaId = DB::table('product_categories')->where('slug', 'kartu-nama')->value('id');
        $stikerId = DB::table('product_categories')->where('slug', 'stiker-label')->value('id');
        $undanganId = DB::table('product_categories')->where('slug', 'undangan')->value('id');
        $bannerId = DB::table('product_categories')->where('slug', 'banner-spanduk')->value('id');
        $kemasanId = DB::table('product_categories')->where('slug', 'kemasan-produk')->value('id');

        $products = [
            // INSTANT PRODUCTS
            [
                'name' => 'Brosur A4 Full Color',
                'description' => 'Brosur ukuran A4 dengan cetak full color kedua sisi. Kertas art paper 150gsm. Minimum order 50 pcs.',
                'short_description' => 'Brosur A4 full color dua sisi',
                'price' => 50000,
                'discount_percent' => 10,
                'category' => 'instan',
                'category_id' => $brosurId,
                'is_active' => true,
                'stock' => 1000,
                'sales_count' => 245,
                'rating' => 4.8,
                'min_order' => 50,
                'specifications' => json_encode([
                    'ukuran' => 'A4 (21cm x 29.7cm)',
                    'bahan' => 'Art Paper 150gsm',
                    'cetak' => 'Full Color 2 sisi',
                    'finishing' => 'Laminating glossy',
                    'waktu_produksi' => '24 jam'
                ]),
            ],
            [
                'name' => 'Kartu Nama Premium',
                'description' => 'Kartu nama dengan bahan premium ivory 310gsm, cetak kedua sisi dengan finishing spot UV. Cocok untuk profesional.',
                'short_description' => 'Kartu nama bahan premium ivory',
                'price' => 75000,
                'discount_percent' => 0,
                'category' => 'instan',
                'category_id' => $kartuNamaId,
                'is_active' => true,
                'stock' => 500,
                'sales_count' => 189,
                'rating' => 4.9,
                'min_order' => 100,
                'specifications' => json_encode([
                    'ukuran' => '9cm x 5.5cm',
                    'bahan' => 'Ivory 310gsm',
                    'cetak' => 'Full Color 2 sisi',
                    'finishing' => 'Spot UV, rounded corner',
                    'waktu_produksi' => '24 jam'
                ]),
            ],
            [
                'name' => 'Stiker Vinyl Outdoor',
                'description' => 'Stiker vinyl waterproof untuk penggunaan outdoor. Tahan cuaca dan UV. Cocok untuk kendaraan, signage, dll.',
                'short_description' => 'Stiker vinyl tahan cuaca',
                'price' => 35000,
                'discount_percent' => 15,
                'category' => 'instan',
                'category_id' => $stikerId,
                'is_active' => true,
                'stock' => 800,
                'sales_count' => 156,
                'rating' => 4.7,
                'min_order' => 20,
                'specifications' => json_encode([
                    'bahan' => 'Vinyl outdoor',
                    'ketahanan' => 'Waterproof, UV resistant',
                    'lem' => 'Permanent adhesive',
                    'finishing' => 'Laminating glossy',
                    'waktu_produksi' => '24 jam'
                ]),
            ],
            [
                'name' => 'Undangan Pernikahan',
                'description' => 'Paket undangan pernikahan premium dengan berbagai pilihan desain. Include amplop dan RSVP card.',
                'short_description' => 'Undangan pernikahan premium',
                'price' => 120000,
                'discount_percent' => 20,
                'category' => 'instan',
                'category_id' => $undanganId,
                'is_active' => true,
                'stock' => 300,
                'sales_count' => 98,
                'rating' => 4.8,
                'min_order' => 50,
                'specifications' => json_encode([
                    'ukuran' => '15cm x 15cm',
                    'bahan' => 'Art carton 260gsm',
                    'isi' => 'Undangan + amplop + RSVP card',
                    'finishing' => 'Emboss, ribbon',
                    'waktu_produksi' => '48 jam'
                ]),
            ],

            // CUSTOM PRODUCTS
            [
                'name' => 'Banner Roll Up 80x200cm',
                'description' => 'Banner roll up dengan sistem portable. Stand included. Cocok untuk exhibition, seminar, atau store promotion.',
                'short_description' => 'Banner roll up portable',
                'price' => 450000,
                'discount_percent' => 0,
                'category' => 'non-instan',
                'category_id' => $bannerId,
                'is_active' => true,
                'stock' => 50,
                'sales_count' => 34,
                'rating' => 4.9,
                'min_order' => 1,
                'specifications' => json_encode([
                    'ukuran' => '80cm x 200cm',
                    'bahan' => 'Flexy China 440gsm',
                    'sistem' => 'Roll up portable',
                    'include' => 'Stand aluminium, case',
                    'waktu_produksi' => '3-5 hari'
                ]),
            ],
            [
                'name' => 'Kemasan Makanan Custom',
                'description' => 'Desain dan cetak kemasan makanan custom dengan logo dan brand Anda. Food grade material.',
                'short_description' => 'Kemasan makanan branded',
                'price' => 280000,
                'discount_percent' => 10,
                'category' => 'non-instan',
                'category_id' => $kemasanId,
                'is_active' => true,
                'stock' => 200,
                'sales_count' => 67,
                'rating' => 4.6,
                'min_order' => 100,
                'specifications' => json_encode([
                    'bahan' => 'Food grade paper',
                    'cetak' => 'Full color 1 sisi',
                    'finishing' => 'Laminating doff',
                    'ukuran' => 'Custom sesuai kebutuhan',
                    'waktu_produksi' => '5-7 hari'
                ]),
            ],
            [
                'name' => 'X-Banner 60x160cm',
                'description' => 'X-banner dengan sistem cross base yang stabil. Mudah dibawa dan dipasang. Cocok untuk indoor promotion.',
                'short_description' => 'X-banner indoor promotion',
                'price' => 320000,
                'discount_percent' => 5,
                'category' => 'non-instan',
                'category_id' => $bannerId,
                'is_active' => true,
                'stock' => 40,
                'sales_count' => 42,
                'rating' => 4.7,
                'min_order' => 1,
                'specifications' => json_encode([
                    'ukuran' => '60cm x 160cm',
                    'bahan' => 'PVC banner 510gsm',
                    'sistem' => 'X-base aluminium',
                    'include' => 'Stand, carrying bag',
                    'waktu_produksi' => '3-4 hari'
                ]),
            ],
            [
                'name' => 'Company Profile Hard Cover',
                'description' => 'Buku company profile dengan hard cover dan berbagai pilihan finishing. Desain custom sesuai brand identity.',
                'short_description' => 'Buku company profile hard cover',
                'price' => 850000,
                'discount_percent' => 0,
                'category' => 'non-instan',
                'category_id' => null,
                'is_active' => true,
                'stock' => 25,
                'sales_count' => 18,
                'rating' => 4.9,
                'min_order' => 10,
                'specifications' => json_encode([
                    'ukuran' => 'A4 atau A5',
                    'cover' => 'Hard cover + dust jacket',
                    'halaman' => '20-100 halaman',
                    'finishing' => 'Emboss, spot UV',
                    'waktu_produksi' => '7-10 hari'
                ]),
            ],
        ];

        foreach ($products as $product) {
            DB::table('products')->updateOrInsert(
                ['name' => $product['name']],
                $product
            );
        }

        $this->command->info('✅ Products seeded successfully!');
        $this->command->info('📦 Total products: ' . count($products));
    }
}
