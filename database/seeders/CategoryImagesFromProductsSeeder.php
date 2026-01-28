<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategoryImagesFromProductsSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua kategori
        $categories = DB::table('product_categories')->get();
        
        // Ambil contoh produk dari setiap kategori untuk diambil gambarnya
        foreach ($categories as $category) {
            // Ambil 6 produk dari kategori ini (atau sebanyak yang ada)
            $products = DB::table('products')
                ->where('category_id', $category->id)
                ->where('is_active', true)
                ->whereNotNull('image')
                ->take(6)
                ->get();
            
            $imagePaths = [];
            
            // Ambil gambar dari produk
            foreach ($products as $index => $product) {
                if ($product->image) {
                    $imagePaths[$index] = $product->image;
                }
            }
            
            // Jika produk tidak cukup, tambahkan placeholder
            while (count($imagePaths) < 6) {
                $imagePaths[] = 'categories/placeholder-' . (count($imagePaths) + 1) . '.jpg';
            }
            
            // Update kategori dengan gambar
            DB::table('product_categories')
                ->where('id', $category->id)
                ->update([
                    'featured_image_1' => $imagePaths[0] ?? null,
                    'featured_image_2' => $imagePaths[1] ?? null,
                    'featured_image_3' => $imagePaths[2] ?? null,
                    'featured_image_4' => $imagePaths[3] ?? null,
                    'featured_image_5' => $imagePaths[4] ?? null,
                    'featured_image_6' => $imagePaths[5] ?? null,
                    'category_color' => $this->getColorForCategory($category->name),
                    'accent_color' => $this->getAccentColorForCategory($category->name),
                ]);
        }

        $this->command->info('✅ Category images populated from products!');
    }

    private function getColorForCategory($categoryName): string
    {
        // Logic yang sama seperti sebelumnya
        $colors = [
            'Brosur' => '#193497',
            'Kartu Nama' => '#720e87',
            'Stiker' => '#f72585',
            'Undangan' => '#ff0f0f',
            'Banner' => '#193497',
            'Kemasan' => '#720e87',
            'Merchandise' => '#f72585',
            'Company Profile' => '#193497',
        ];

        foreach ($colors as $key => $color) {
            if (stripos($categoryName, $key) !== false) {
                return $color;
            }
        }

        return '#193497';
    }

    private function getAccentColorForCategory($categoryName): string
    {
        $colors = [
            'Brosur' => '#c0f820',
            'Kartu Nama' => '#f72585',
            'Stiker' => '#ff0f0f',
            'Undangan' => '#c0f820',
            'Banner' => '#720e87',
            'Kemasan' => '#193497',
            'Merchandise' => '#720e87',
            'Company Profile' => '#f72585',
        ];

        foreach ($colors as $key => $color) {
            if (stripos($categoryName, $key) !== false) {
                return $color;
            }
        }

        return '#c0f820';
    }
}