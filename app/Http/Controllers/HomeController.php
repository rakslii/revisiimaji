<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
// Tambahkan use di atas class
use App\Models\Banner;

class HomeController extends Controller
{
  public function index()
{
    try {
        // Get featured products for homepage (8 terbaru)
        $products = Product::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        // Get active categories with proper ordering
        $categories = ProductCategory::where('is_active', true)
            ->orderBy('order')
            ->orderBy('name')
            ->take(8)
            ->get();

        // Get instant products (produk instan)
        $instantProducts = Product::where('is_active', true)
            ->where('category', 'instan')
            ->orWhere('category_type', 'instan')
            ->take(4)
            ->get();

        // Get custom products (produk non-instan)
        $customProducts = Product::where('is_active', true)
            ->where('category', 'non-instan')
            ->orWhere('category_type', 'non-instan')
            ->take(4)
            ->get();

        // ===== TAMBAHKAN INI UNTUK BANNER =====
        // Get active banners for homepage
        $homeBanners = Banner::homeBanners()
            ->valid()
            ->ordered()
            ->get();

        // Get active popup
        $popup = Banner::popups()
            ->valid()
            ->ordered()
            ->first();
        // ===== SELESAI TAMBAHAN =====

        // DEBUG LOG untuk troubleshooting
        \Log::info('HomeController: Found ' . $categories->count() . ' active categories');
        \Log::info('HomeController: Found ' . $products->count() . ' featured products');
        \Log::info('HomeController: Found ' . $instantProducts->count() . ' instant products');
        \Log::info('HomeController: Found ' . $customProducts->count() . ' custom products');
        \Log::info('HomeController: Found ' . $homeBanners->count() . ' home banners');
        \Log::info('HomeController: Found popup: ' . ($popup ? 'Yes' : 'No'));

        // Tambahkan accessor untuk kategori jika belum ada
        foreach ($categories as $category) {
            if (!isset($category->featured_image_urls)) {
                $category->featured_image_urls = $category->getFeaturedImageUrlsAttribute();
            }
        }

    } catch (\Exception $e) {
        // Jika tabel belum ada atau error, set empty collection
        \Log::error('HomeController error: ' . $e->getMessage());
        \Log::error('HomeController stack trace: ' . $e->getTraceAsString());

        $products = collect();
        $categories = collect();
        $instantProducts = collect();
        $customProducts = collect();
        $homeBanners = collect(); // TAMBAHKAN
        $popup = null; // TAMBAHKAN
    }

    // Jika tidak ada kategori, coba buat data dummy untuk testing
    if ($categories->count() == 0) {
        \Log::warning('HomeController: No categories found, using dummy data');
        $categories = $this->getDummyCategories();
    }

    return view('pages.home.index', [
        'products' => $products,
        'instantProducts' => $instantProducts,
        'customProducts' => $customProducts,
        'categories' => $categories,
        'homeBanners' => $homeBanners, // TAMBAHKAN
        'popup' => $popup // TAMBAHKAN
    ]);
}
  
    /**
     * Method untuk memberikan data dummy kategori jika database kosong
     */
    private function getDummyCategories()
    {
        return collect([
            (object) [
                'id' => 1,
                'name' => 'Packaging Design',
                'description' => 'Desain kemasan produk yang menarik dan profesional',
                'icon' => 'fa-box-open',
                'featured_image_1' => null,
                'featured_image_2' => null,
                'featured_image_3' => null,
                'featured_image_4' => null,
                'featured_image_urls' => [],
                'getFeaturedImageUrlsAttribute' => function() {
                    return [];
                }
            ],
            (object) [
                'id' => 2,
                'name' => 'Brand Identity',
                'description' => 'Identitas visual untuk memperkuat brand Anda',
                'icon' => 'fa-trademark',
                'featured_image_1' => null,
                'featured_image_2' => null,
                'featured_image_3' => null,
                'featured_image_4' => null,
                'featured_image_urls' => [],
                'getFeaturedImageUrlsAttribute' => function() {
                    return [];
                }
            ],
            (object) [
                'id' => 3,
                'name' => 'Web & App Design',
                'description' => 'Desain website dan aplikasi yang responsif',
                'icon' => 'fa-laptop-code',
                'featured_image_1' => null,
                'featured_image_2' => null,
                'featured_image_3' => null,
                'featured_image_4' => null,
                'featured_image_urls' => [],
                'getFeaturedImageUrlsAttribute' => function() {
                    return [];
                }
            ],
            (object) [
                'id' => 4,
                'name' => 'Social Media',
                'description' => 'Konten kreatif untuk media sosial',
                'icon' => 'fa-hashtag',
                'featured_image_1' => null,
                'featured_image_2' => null,
                'featured_image_3' => null,
                'featured_image_4' => null,
                'featured_image_urls' => [],
                'getFeaturedImageUrlsAttribute' => function() {
                    return [];
                }
            ]
        ]);
    }
    
    /**
     * Fallback jika ada route yang tidak ditemukan
     */
    public function fallback()
    {
        return $this->index();
    }
}