<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->check()) {
                return redirect()->route('admin.login')
                    ->with('error', 'Please login first.');
            }

            if (auth()->user()->role !== 'admin') {
                auth()->logout();
                return redirect()->route('admin.login')
                    ->with('error', 'Admin access only.');
            }

            return $next($request);
        });
    }

    public function index(Request $request)
    {
       $query = Product::with('productCategory');
        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('short_description', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('is_active', $request->status === 'active' ? 1 : 0);
        }

        // Filter by stock
        if ($request->has('stock_filter') && $request->stock_filter) {
            switch ($request->stock_filter) {
                case 'out_of_stock':
                    $query->where('stock', 0);
                    break;
                case 'low_stock':
                    $query->where('stock', '>', 0)->where('stock', '<=', 10);
                    break;
                case 'in_stock':
                    $query->where('stock', '>', 0);
                    break;
                case 'high_stock':
                    $query->where('stock', '>', 10);
                    break;
                case 'custom':
                    if ($request->has('min_stock') && $request->min_stock) {
                        $query->where('stock', '>=', $request->min_stock);
                    }
                    if ($request->has('max_stock') && $request->max_stock) {
                        $query->where('stock', '<=', $request->max_stock);
                    }
                    break;
            }
        }

        // Filter by price range
        if ($request->has('min_price') && $request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price') && $request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sorting
        if ($request->has('sort_by') && $request->sort_by) {
            switch ($request->sort_by) {
                case 'oldest':
                    $query->oldest();
                    break;
                case 'price_high':
                    $query->orderBy('price', 'desc');
                    break;
                case 'price_low':
                    $query->orderBy('price', 'asc');
                    break;
                case 'stock_high':
                    $query->orderBy('stock', 'desc');
                    break;
                case 'stock_low':
                    $query->orderBy('stock', 'asc');
                    break;
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                default: // newest
                    $query->latest();
                    break;
            }
        } else {
            $query->latest();
        }

        $perPage = $request->get('per_page', 15);
        $products = $query->paginate($perPage);
        $categories = ProductCategory::active()->get();

        return view('pages.admin.products.index', compact('products', 'categories'));
    }

    public function create(Request $request)
    {
        $categories = ProductCategory::active()->get();
        $selectedType = $request->get('type', 'instan');
        
        return view('pages.admin.products.create', compact('categories', 'selectedType'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'discount_percent' => 'nullable|integer|min:0|max:100',
            'category_id' => 'required|exists:product_categories,id',
            'stock' => 'required|integer|min:0',
            'min_order' => 'nullable|integer|min:1',
            'is_active' => 'nullable|boolean',

            // Main image
            'image' => 'required|image|max:5120',

            // Additional images (image_1 to image_4)
            'image_1' => 'nullable|image|max:5120',
            'image_2' => 'nullable|image|max:5120',
            'image_3' => 'nullable|image|max:5120',
            'image_4' => 'nullable|image|max:5120',

            // Specifications
            'specifications' => 'nullable|array',
            'specifications.*.key' => 'nullable|string|max:100',
            'specifications.*.value' => 'nullable|string|max:255',
        ]);

        try {
            // Handle main image
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('products', 'public');
                $validated['image'] = $path;
            }

            // Handle additional images (image_1 to image_4)
            for ($i = 1; $i <= 4; $i++) {
                $field = "image_{$i}";
                if ($request->hasFile($field)) {
                    $path = $request->file($field)->store("products/additional", 'public');
                    $validated[$field] = $path;
                }
            }

            // Get category from selected category
            $category = ProductCategory::find($validated['category_id']);
            
            if (!$category) {
                throw new \Exception('Category not found');
            }
            
            // Log category yang dipilih
            \Log::info('Selected category:', [
                'id' => $category->id,
                'name' => $category->name,
                'type' => $category->type
            ]);
            
            // Set required fields dari category yang dipilih
            $categoryType = $category->type;
            
            // Validasi nilai ENUM
            if (!in_array($categoryType, ['instan', 'non-instan'])) {
                \Log::warning('Invalid category type, defaulting to instan', ['type' => $categoryType]);
                $categoryType = 'instan';
            }
            
            $validated['category'] = $categoryType;
            $validated['category_type'] = $categoryType;
            
            // Set required fields yang tidak ada di form
            $validated['discount_calculation_type'] = 'auto';
            $validated['calculated_discount_percent'] = $request->discount_percent ?? 0;
            $validated['base_discount_percent'] = $request->discount_percent ?? 0;
            $validated['sales_count'] = 0;
            $validated['rating'] = 0;

            // Set null untuk field yang tidak digunakan
            $validated['main_image'] = null;
            $validated['thumbnail'] = null;
            $validated['additional_images'] = null;
            $validated['gallery_images'] = null;
            $validated['active_product_promotion_id'] = null;
            $validated['discount_override_percent'] = null;
            $validated['image_5'] = null;

            // Process specifications
            if ($request->has('specifications')) {
                $specifications = [];
                foreach ($request->specifications as $spec) {
                    if (!empty($spec['key']) || !empty($spec['value'])) {
                        $specifications[] = [
                            'key' => $spec['key'] ?? '',
                            'value' => $spec['value'] ?? ''
                        ];
                    }
                }
                $validated['specifications'] = $specifications;
            } else {
                $validated['specifications'] = [];
            }

            $validated['is_active'] = $request->has('is_active') ? 1 : 0;

            // Log final data sebelum create
            \Log::info('Creating product with final data:', [
                'name' => $validated['name'],
                'category_id' => $validated['category_id'],
                'category' => $validated['category'],
                'category_type' => $validated['category_type'],
                'price' => $validated['price'],
                'stock' => $validated['stock']
            ]);

            // Create product
            $product = Product::create($validated);
            
            \Log::info('Product created successfully with ID: ' . $product->id);

            return redirect()->route('admin.products.index')
                ->with('success', 'Product created successfully');

        } catch (\Exception $e) {
            \Log::error('Failed to create product: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            return redirect()->back()
                ->with('error', 'Failed to create product: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show($id)
    {
        // Ubah semua pemanggilan:
$product = Product::with('productCategory')->findOrFail($id);
        return view('pages.admin.products.show', compact('product'));
    }

    public function edit($id)
    {
        // Ubah semua pemanggilan:
$product = Product::with('productCategory')->findOrFail($id);
        $categories = ProductCategory::active()->get();
        return view('pages.admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'discount_percent' => 'nullable|integer|min:0|max:100',
            'category_id' => 'required|exists:product_categories,id',
            'stock' => 'required|integer|min:0',
            'min_order' => 'nullable|integer|min:1',
            'is_active' => 'nullable|boolean',

            // Images
            'image' => 'nullable|image|max:5120',
            'remove_image' => 'nullable|boolean',

            'image_2' => 'nullable|image|max:5120',
            'remove_image_2' => 'nullable|boolean',

            'image_3' => 'nullable|image|max:5120',
            'remove_image_3' => 'nullable|boolean',

            'image_4' => 'nullable|image|max:5120',
            'remove_image_4' => 'nullable|boolean',

            'image_5' => 'nullable|image|max:5120',
            'remove_image_5' => 'nullable|boolean',

            'thumbnail' => 'nullable|image|max:5120',
            'remove_thumbnail' => 'nullable|boolean',

            'main_image' => 'nullable|image|max:5120',
            'remove_main_image' => 'nullable|boolean',

            // Specifications
            'specifications' => 'nullable|array',
            'specifications.*.key' => 'nullable|string|max:100',
            'specifications.*.value' => 'nullable|string|max:255',
        ]);

        try {
            // Handle main image removal
            if ($request->has('remove_image') && $request->remove_image) {
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                    $validated['image'] = null;
                }
            }

            // Handle new main image upload
            if ($request->hasFile('image')) {
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }
                $path = $request->file('image')->store('products', 'public');
                $validated['image'] = $path;
            }

            // Handle main_image field
            if ($request->has('remove_main_image') && $request->remove_main_image) {
                if ($product->main_image) {
                    Storage::disk('public')->delete($product->main_image);
                    $validated['main_image'] = null;
                }
            }
            if ($request->hasFile('main_image')) {
                if ($product->main_image) {
                    Storage::disk('public')->delete($product->main_image);
                }
                $path = $request->file('main_image')->store('products/main', 'public');
                $validated['main_image'] = $path;
            }

            // Handle thumbnail
            if ($request->has('remove_thumbnail') && $request->remove_thumbnail) {
                if ($product->thumbnail) {
                    Storage::disk('public')->delete($product->thumbnail);
                    $validated['thumbnail'] = null;
                }
            }
            if ($request->hasFile('thumbnail')) {
                if ($product->thumbnail) {
                    Storage::disk('public')->delete($product->thumbnail);
                }
                $path = $request->file('thumbnail')->store('products/thumbnails', 'public');
                $validated['thumbnail'] = $path;
            }

            // Handle additional images (image_2 to image_5)
            for ($i = 2; $i <= 5; $i++) {
                $field = "image_{$i}";
                $removeField = "remove_image_{$i}";

                if ($request->has($removeField) && $request->$removeField) {
                    $oldImage = $product->$field;
                    if ($oldImage) {
                        Storage::disk('public')->delete($oldImage);
                    }
                    $validated[$field] = null;
                }

                if ($request->hasFile($field)) {
                    $oldImage = $product->$field;
                    if ($oldImage) {
                        Storage::disk('public')->delete($oldImage);
                    }

                    $path = $request->file($field)->store("products/additional", 'public');
                    $validated[$field] = $path;
                }
            }

            // Get category type from selected category
            $category = ProductCategory::find($validated['category_id']);
            $categoryType = $category->type;
            
            if (!in_array($categoryType, ['instan', 'non-instan'])) {
                $categoryType = 'instan';
            }
            
            $validated['category'] = $categoryType;
            $validated['category_type'] = $categoryType;

            // Process specifications
            if ($request->has('specifications')) {
                $specifications = [];
                foreach ($request->specifications as $spec) {
                    if (!empty($spec['key']) || !empty($spec['value'])) {
                        $specifications[] = [
                            'key' => $spec['key'] ?? '',
                            'value' => $spec['value'] ?? ''
                        ];
                    }
                }
                $validated['specifications'] = $specifications;
            } else {
                $validated['specifications'] = [];
            }

            $validated['is_active'] = $request->has('is_active') ? 1 : 0;

            // Handle additional_images JSON field
            if ($request->has('additional_images_paths')) {
                $additionalPaths = json_decode($request->additional_images_paths, true);
                if (is_array($additionalPaths)) {
                    $validated['additional_images'] = $additionalPaths;
                }
            }

            // Handle gallery_images JSON field
            if ($request->has('gallery_images_paths')) {
                $galleryPaths = json_decode($request->gallery_images_paths, true);
                if (is_array($galleryPaths)) {
                    $validated['gallery_images'] = $galleryPaths;
                }
            }

            $product->update($validated);

            return redirect()->route('admin.products.show', $product->id)
                ->with('success', 'Product updated successfully');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update product: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        try {
            // Delete all images
            $imageFields = ['image', 'thumbnail', 'main_image'];
            for ($i = 2; $i <= 5; $i++) {
                $imageFields[] = "image_{$i}";
            }

            foreach ($imageFields as $field) {
                if ($product->$field) {
                    Storage::disk('public')->delete($product->$field);
                }
            }

            // Delete additional images from JSON fields
            if ($product->additional_images && is_array($product->additional_images)) {
                foreach ($product->additional_images as $imagePath) {
                    if ($imagePath) {
                        Storage::disk('public')->delete($imagePath);
                    }
                }
            }

            if ($product->gallery_images && is_array($product->gallery_images)) {
                foreach ($product->gallery_images as $imagePath) {
                    if ($imagePath) {
                        Storage::disk('public')->delete($imagePath);
                    }
                }
            }

            $product->delete();

            return redirect()->route('admin.products.index')
                ->with('success', 'Product deleted successfully');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete product: ' . $e->getMessage());
        }
    }

    public function deleteImage(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'field' => 'required|string|in:image,thumbnail,main_image,image_2,image_3,image_4,image_5',
            'path' => 'nullable|string'
        ]);

        try {
            $field = $request->field;

            if (in_array($field, ['image', 'thumbnail', 'main_image', 'image_2', 'image_3', 'image_4', 'image_5'])) {
                if ($product->$field) {
                    Storage::disk('public')->delete($product->$field);
                    $product->$field = null;
                }
            } elseif ($request->has('path')) {
                $path = $request->path;

                if ($product->additional_images && is_array($product->additional_images)) {
                    $additional = array_filter($product->additional_images, function($imgPath) use ($path) {
                        return $imgPath !== $path;
                    });
                    $product->additional_images = array_values($additional);
                    Storage::disk('public')->delete($path);
                }

                if ($product->gallery_images && is_array($product->gallery_images)) {
                    $gallery = array_filter($product->gallery_images, function($imgPath) use ($path) {
                        return $imgPath !== $path;
                    });
                    $product->gallery_images = array_values($gallery);
                    Storage::disk('public')->delete($path);
                }
            }

            $product->save();

            return response()->json([
                'success' => true,
                'message' => 'Image deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete image: ' . $e->getMessage()
            ], 500);
        }
    }

    public function uploadImage(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'image' => 'required|image|max:5120',
            'field' => 'required|string|in:additional_images,gallery_images',
        ]);

        try {
            $path = $request->file('image')->store('products/gallery', 'public');

            $field = $request->field;
            $images = $product->$field ?? [];
            $images[] = $path;
            $product->$field = $images;
            $product->save();

            return response()->json([
                'success' => true,
                'path' => $path,
                'url' => asset('storage/' . $path),
                'message' => 'Image uploaded successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload image: ' . $e->getMessage()
            ], 500);
        }
    }

    public function quickAddCategory(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:100',
                'type' => 'required|in:instan,non-instan',
                'description' => 'nullable|string',
                'icon' => 'nullable|string|max:50',
                'order' => 'nullable|integer|min:0'
            ]);

            \Log::info('Quick Add Category - Type received: ' . $request->type);

            // Create slug from name
            $slug = Str::slug($request->name);
            
            // Check if slug exists
            $originalSlug = $slug;
            $count = 1;
            while (ProductCategory::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }

            // Pastikan type tersimpan dengan benar
            $type = $request->type;
            
            // Siapkan data untuk create
            $data = [
                'name' => $request->name,
                'slug' => $slug,
                'type' => $type,
                'description' => $request->description,
                'icon' => $request->icon ?? 'fas fa-folder',
                'order' => $request->order ?? 0,
                'is_active' => true
            ];
            
            // Cek apakah kolom color ada
            $hasColorFields = true;
            try {
                $test = ProductCategory::first();
                if ($test) {
                    $columns = \Schema::getColumnListing('product_categories');
                    if (!in_array('category_color', $columns)) {
                        $hasColorFields = false;
                    }
                }
            } catch (\Exception $e) {
                $hasColorFields = false;
            }
            
            if ($hasColorFields) {
                $data['category_color'] = '#193497';
                $data['accent_color'] = '#c0f820';
            }
            
            \Log::info('Data to create:', $data);

            // Create category
            $category = ProductCategory::create($data);

            \Log::info('Category created successfully. ID: ' . $category->id . ', Type: ' . $category->type);

            return response()->json([
                'success' => true,
                'message' => 'Category added successfully',
                'category' => [
                    'id' => $category->id,
                    'name' => $category->name,
                    'type' => $category->type,
                    'description' => $category->description,
                    'icon' => $category->icon,
                    'slug' => $category->slug
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Error adding category: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}