<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            // Instant Products
            [
                'name' => 'Brosur & Flyer',
                'slug' => 'brosur-flyer',
                'type' => 'instan',
                'description' => 'Cetak brosur dan flyer untuk promosi usaha',
                'icon' => 'fas fa-newspaper',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Kartu Nama',
                'slug' => 'kartu-nama',
                'type' => 'instan',
                'description' => 'Kartu nama profesional untuk bisnis',
                'icon' => 'fas fa-address-card',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Stiker & Label',
                'slug' => 'stiker-label',
                'type' => 'instan',
                'description' => 'Stiker dan label produk custom',
                'icon' => 'fas fa-tag',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Undangan',
                'slug' => 'undangan',
                'type' => 'instan',
                'description' => 'Cetak undangan pernikahan, ulang tahun, dll',
                'icon' => 'fas fa-envelope',
                'order' => 4,
                'is_active' => true,
            ],

            // Custom Products
            [
                'name' => 'Banner & Spanduk',
                'slug' => 'banner-spanduk',
                'type' => 'non-instan',
                'description' => 'Banner dan spanduk ukuran besar untuk event',
                'icon' => 'fas fa-flag',
                'order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Kemasan Produk',
                'slug' => 'kemasan-produk',
                'type' => 'non-instan',
                'description' => 'Desain dan cetak kemasan produk custom',
                'icon' => 'fas fa-box',
                'order' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'Merchandise',
                'slug' => 'merchandise',
                'type' => 'non-instan',
                'description' => 'Merchandise custom (kaos, mug, tot bag, dll)',
                'icon' => 'fas fa-tshirt',
                'order' => 7,
                'is_active' => true,
            ],
            [
                'name' => 'Company Profile',
                'slug' => 'company-profile',
                'type' => 'non-instan',
                'description' => 'Buku company profile dan annual report',
                'icon' => 'fas fa-book',
                'order' => 8,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            DB::table('product_categories')->updateOrInsert(
                ['slug' => $category['slug']],
                $category
            );
        }

        $this->command->info('✅ Product categories seeded successfully!');
    }
}
