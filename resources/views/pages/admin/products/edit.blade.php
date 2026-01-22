@extends('pages.admin.layouts.app')

@section('title', 'Edit Product')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Edit Product: {{ $product->name }}</h1>
            <p class="text-gray-600 mt-1">Update product details and information</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.products.index') }}" 
               class="flex items-center gap-2 bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
                <i class="fas fa-arrow-left"></i> Back to Products
            </a>
            <a href="{{ route('admin.products.show', $product->id) }}" 
               class="flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                <i class="fas fa-eye"></i> View
            </a>
        </div>
    </div>

    <!-- Error Messages -->
    @if ($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow p-6">
                <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" id="productForm">
                    @csrf
                    @method('PUT')

                    <!-- Product Name -->
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Product Name *
                        </label>
                        <input type="text"
                               id="name"
                               name="name"
                               value="{{ old('name', $product->name) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                               required>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Price & Discount -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                                Price *
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                                <input type="number"
                                       id="price"
                                       name="price"
                                       value="{{ old('price', $product->price) }}"
                                       min="0"
                                       step="1"
                                       class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('price') border-red-500 @enderror"
                                       required>
                            </div>
                            @error('price')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="discount_percent" class="block text-sm font-medium text-gray-700 mb-2">
                                Discount (%)
                            </label>
                            <input type="number"
                                   id="discount_percent"
                                   name="discount_percent"
                                   value="{{ old('discount_percent', $product->discount_percent) }}"
                                   min="0"
                                   max="100"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('discount_percent') border-red-500 @enderror">
                            @error('discount_percent')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Category & Stock -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Category *
                            </label>
                            <select id="category_id"
                                    name="category_id"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('category_id') border-red-500 @enderror"
                                    required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                            {{ (old('category_id', $product->category_id) == $category->id) ? 'selected' : '' }}>
                                        {{ $category->name }} ({{ $category->type }})
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">
                                Stock *
                            </label>
                            <input type="number"
                                   id="stock"
                                   name="stock"
                                   value="{{ old('stock', $product->stock) }}"
                                   min="0"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('stock') border-red-500 @enderror"
                                   required>
                            @error('stock')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Short Description -->
                    <div class="mb-6">
                        <label for="short_description" class="block text-sm font-medium text-gray-700 mb-2">
                            Short Description
                        </label>
                        <input type="text"
                               id="short_description"
                               name="short_description"
                               value="{{ old('short_description', $product->short_description) }}"
                               maxlength="255"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('short_description') border-red-500 @enderror">
                        <p class="mt-1 text-xs text-gray-500">Max 255 characters</p>
                        @error('short_description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Full Description -->
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Full Description
                        </label>
                        <textarea id="description"
                                  name="description"
                                  rows="4"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Specifications Section -->
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Product Specifications</h3>
                            <button type="button" 
                                    onclick="addSpecification()" 
                                    class="text-sm bg-blue-100 text-blue-600 hover:bg-blue-200 px-3 py-1 rounded-lg">
                                <i class="fas fa-plus mr-1"></i> Add Specification
                            </button>
                        </div>
                        
                        <div id="specifications-container" class="space-y-4">
                            @php
                                $specifications = [];
                                
                                if (old('specifications')) {
                                    $specifications = old('specifications');
                                } else {
                                    $dbSpecs = $product->specifications;
                                    
                                    if (is_string($dbSpecs)) {
                                        $decoded = json_decode($dbSpecs, true);
                                        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                            $specifications = $decoded;
                                        }
                                    } elseif (is_array($dbSpecs)) {
                                        $specifications = $dbSpecs;
                                    }
                                }
                                
                                $specifications = array_filter($specifications, function($spec) {
                                    return !empty($spec['key']) || !empty($spec['value']);
                                });
                                
                                if (empty($specifications)) {
                                    $specifications = [['key' => '', 'value' => '']];
                                }
                            @endphp
                            
                            @foreach($specifications as $index => $spec)
                            <div class="specification-item border border-gray-200 rounded-lg p-4">
                                <div class="flex justify-between items-center mb-3">
                                    <span class="text-sm font-medium text-gray-700">Specification #{{ $loop->iteration }}</span>
                                    @if($loop->iteration > 1 || (!empty($spec['key']) || !empty($spec['value'])))
                                    <button type="button" 
                                            onclick="removeSpecification(this)" 
                                            class="text-red-600 hover:text-red-800 text-sm">
                                        <i class="fas fa-trash"></i> Remove
                                    </button>
                                    @endif
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Key / Title</label>
                                        <input type="text" 
                                               name="specifications[{{ $index }}][key]" 
                                               value="{{ $spec['key'] ?? '' }}"
                                               placeholder="e.g., Material, Size, Weight"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Value / Description</label>
                                        <input type="text" 
                                               name="specifications[{{ $index }}][value]" 
                                               value="{{ $spec['value'] ?? '' }}"
                                               placeholder="e.g., High Quality Paper, A4, 100gr"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        <!-- Empty template untuk JavaScript -->
                        <div id="specification-template" class="hidden">
                            <div class="specification-item border border-gray-200 rounded-lg p-4">
                                <div class="flex justify-between items-center mb-3">
                                    <span class="text-sm font-medium text-gray-700">New Specification</span>
                                    <button type="button" 
                                            onclick="removeSpecification(this)" 
                                            class="text-red-600 hover:text-red-800 text-sm">
                                        <i class="fas fa-trash"></i> Remove
                                    </button>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Key / Title</label>
                                        <input type="text" 
                                               name="specifications[__INDEX__][key]" 
                                               placeholder="e.g., Material, Size, Weight"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Value / Description</label>
                                        <input type="text" 
                                               name="specifications[__INDEX__][value]" 
                                               placeholder="e.g., High Quality Paper, A4, 100gr"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Image Management Section -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Product Images</h3>
                        
                        <!-- Main Image -->
                        <div class="mb-6 p-4 border border-gray-200 rounded-lg">
                            <div class="flex justify-between items-center mb-3">
                                <h4 class="font-medium text-gray-700">Main Product Image</h4>
                            </div>
                            
                            <!-- main_image field -->
                            <div class="mb-4">
                                <label for="main_image" class="block text-sm font-medium text-gray-700 mb-2">
                                    Primary Image (Override)
                                </label>
                                <input type="file"
                                       id="main_image"
                                       name="main_image"
                                       accept="image/*"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @if($product->main_image)
                                    <div class="mt-3">
                                        <p class="text-sm text-gray-500 mb-1">Current Primary Image</p>
                                        <div class="flex items-center gap-3">
                                            @php
                                                $mainImageUrl = $product->main_image ? 
                                                    (filter_var($product->main_image, FILTER_VALIDATE_URL) ? 
                                                     $product->main_image : 
                                                     asset('storage/' . $product->main_image)) : 
                                                    asset('images/default-product.jpg');
                                            @endphp
                                            <img src="{{ $mainImageUrl }}"
                                                 alt="Primary Image"
                                                 class="w-20 h-20 object-cover rounded-lg border">
                                            <div>
                                                <p class="text-sm text-gray-600">{{ basename($product->main_image) }}</p>
                                                <div class="flex items-center">
                                                    <input type="checkbox" 
                                                           name="remove_main_image" 
                                                           id="remove-main-image-checkbox"
                                                           value="1"
                                                           class="h-4 w-4 text-red-600 border-gray-300 rounded">
                                                    <label for="remove-main-image-checkbox" class="ml-2 text-xs text-red-600 hover:text-red-800 cursor-pointer">
                                                        <i class="fas fa-trash mr-1"></i> Remove this image
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Legacy image field (backward compatibility) -->
                            <div>
                                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                                    Legacy Main Image
                                </label>
                                <input type="file"
                                       id="image"
                                       name="image"
                                       accept="image/*"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @if($product->image)
                                    <div class="mt-3">
                                        <p class="text-sm text-gray-500 mb-1">Current Legacy Image</p>
                                        <div class="flex items-center gap-3">
                                            @php
                                                $legacyImageUrl = $product->image ? 
                                                    (filter_var($product->image, FILTER_VALIDATE_URL) ? 
                                                     $product->image : 
                                                     asset('storage/' . $product->image)) : 
                                                    asset('images/default-product.jpg');
                                            @endphp
                                            <img src="{{ $legacyImageUrl }}"
                                                 alt="{{ $product->name }}"
                                                 class="w-20 h-20 object-cover rounded-lg border">
                                            <div>
                                                <p class="text-sm text-gray-600">{{ basename($product->image) }}</p>
                                                <div class="flex items-center">
                                                    <input type="checkbox" 
                                                           name="remove_image" 
                                                           id="remove-image-checkbox"
                                                           value="1"
                                                           class="h-4 w-4 text-red-600 border-gray-300 rounded">
                                                    <label for="remove-image-checkbox" class="ml-2 text-xs text-red-600 hover:text-red-800 cursor-pointer">
                                                        <i class="fas fa-trash mr-1"></i> Remove this image
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Additional Images (image_2 to image_5) -->
                        <div class="mb-6 p-4 border border-gray-200 rounded-lg">
                            <h4 class="font-medium text-gray-700 mb-4">Additional Product Images</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @for($i = 2; $i <= 5; $i++)
                                    @php
                                        $field = "image_{$i}";
                                        $removeField = "remove_image_{$i}";
                                        $currentImage = $product->$field;
                                    @endphp
                                    <div>
                                        <label for="{{ $field }}" class="block text-sm font-medium text-gray-700 mb-2">
                                            Image {{ $i }}
                                        </label>
                                        <input type="file"
                                               id="{{ $field }}"
                                               name="{{ $field }}"
                                               accept="image/*"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        
                                        @if($currentImage)
                                            <div class="mt-3">
                                                <div class="flex items-center gap-3">
                                                    @php
                                                        $additionalImageUrl = $currentImage ? 
                                                            (filter_var($currentImage, FILTER_VALIDATE_URL) ? 
                                                             $currentImage : 
                                                             asset('storage/' . $currentImage)) : 
                                                            asset('images/default-product.jpg');
                                                    @endphp
                                                    <img src="{{ $additionalImageUrl }}"
                                                         alt="Image {{ $i }}"
                                                         class="w-16 h-16 object-cover rounded-lg border">
                                                    <div>
                                                        <p class="text-xs text-gray-600">{{ basename($currentImage) }}</p>
                                                        <div class="flex items-center">
                                                            <input type="checkbox" 
                                                                   name="{{ $removeField }}" 
                                                                   id="remove-{{ $field }}-checkbox"
                                                                   value="1"
                                                                   class="h-4 w-4 text-red-600 border-gray-300 rounded">
                                                            <label for="remove-{{ $field }}-checkbox" class="ml-2 text-xs text-red-600 hover:text-red-800 cursor-pointer">
                                                                <i class="fas fa-trash mr-1"></i> Remove
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endfor
                            </div>
                        </div>

                        <!-- Thumbnail Image -->
                        <div class="mb-6 p-4 border border-gray-200 rounded-lg">
                            <h4 class="font-medium text-gray-700 mb-3">Thumbnail Image</h4>
                            <input type="file"
                                   id="thumbnail"
                                   name="thumbnail"
                                   accept="image/*"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @if($product->thumbnail)
                                <div class="mt-3">
                                    <p class="text-sm text-gray-500 mb-1">Current Thumbnail</p>
                                    <div class="flex items-center gap-3">
                                        @php
                                            $thumbnailUrl = $product->thumbnail ? 
                                                (filter_var($product->thumbnail, FILTER_VALIDATE_URL) ? 
                                                 $product->thumbnail : 
                                                 asset('storage/' . $product->thumbnail)) : 
                                                asset('images/default-product.jpg');
                                        @endphp
                                        <img src="{{ $thumbnailUrl }}"
                                             alt="Thumbnail"
                                             class="w-20 h-20 object-cover rounded-lg border">
                                        <div>
                                            <p class="text-sm text-gray-600">{{ basename($product->thumbnail) }}</p>
                                            <div class="flex items-center">
                                                <input type="checkbox" 
                                                       name="remove_thumbnail" 
                                                       id="remove-thumbnail-checkbox"
                                                       value="1"
                                                       class="h-4 w-4 text-red-600 border-gray-300 rounded">
                                                <label for="remove-thumbnail-checkbox" class="ml-2 text-xs text-red-600 hover:text-red-800 cursor-pointer">
                                                    <i class="fas fa-trash mr-1"></i> Remove thumbnail
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- JSON Images Fields (additional_images, gallery_images) -->
                        <div class="mb-6 p-4 border border-gray-200 rounded-lg">
                            <h4 class="font-medium text-gray-700 mb-4">Gallery Images (JSON Fields)</h4>
                            
                            <!-- Current Gallery Images -->
                            @php
                                $allGalleryImages = array_merge(
                                    $product->additional_images ?? [],
                                    $product->gallery_images ?? []
                                );
                            @endphp
                            
                            @if(count($allGalleryImages) > 0)
                                <div class="mb-4">
                                    <p class="text-sm text-gray-600 mb-2">Current Gallery Images:</p>
                                    <div class="grid grid-cols-4 gap-3">
                                        @foreach($allGalleryImages as $index => $imagePath)
                                            <div class="relative group">
                                                @php
                                                    $galleryImageUrl = $imagePath ? 
                                                        (filter_var($imagePath, FILTER_VALIDATE_URL) ? 
                                                         $imagePath : 
                                                         asset('storage/' . $imagePath)) : 
                                                        asset('images/default-product.jpg');
                                                @endphp
                                                <img src="{{ $galleryImageUrl }}"
                                                     alt="Gallery Image {{ $index + 1 }}"
                                                     class="w-full h-20 object-cover rounded-lg">
                                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100">
                                                    <button type="button"
                                                            onclick="removeGalleryImage('{{ $imagePath }}')"
                                                            class="p-1 bg-white rounded-full text-red-600 hover:bg-red-50">
                                                        <i class="fas fa-trash text-xs"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Upload new gallery images -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Upload New Gallery Images
                                </label>
                                <div id="gallery-upload-container" class="space-y-3">
                                    <div class="flex items-center gap-3">
                                        <input type="file"
                                               name="gallery_images[]"
                                               accept="image/*"
                                               class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <button type="button" 
                                                onclick="addGalleryUploadField()"
                                                class="px-3 py-2 bg-green-100 text-green-600 rounded-lg hover:bg-green-200">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <p class="mt-2 text-xs text-gray-500">You can upload multiple gallery images</p>
                            </div>
                        </div>
                    </div>

                    <!-- Min Order -->
                    <div class="mb-6">
                        <label for="min_order" class="block text-sm font-medium text-gray-700 mb-2">
                            Minimum Order
                        </label>
                        <input type="number"
                               id="min_order"
                               name="min_order"
                               value="{{ old('min_order', $product->min_order) }}"
                               min="1"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('min_order') border-red-500 @enderror">
                        @error('min_order')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Active Status -->
                    <div class="mb-8">
                        <div class="flex items-center">
                            <input type="checkbox"
                                   id="is_active"
                                   name="is_active"
                                   value="1"
                                   {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <label for="is_active" class="ml-2 text-sm text-gray-700">
                                Active Product
                            </label>
                        </div>
                    </div>

                    <!-- Hidden fields untuk JSON images -->
                    <input type="hidden" name="additional_images_paths" id="additional_images_paths" value="{{ json_encode($product->additional_images ?? []) }}">
                    <input type="hidden" name="gallery_images_paths" id="gallery_images_paths" value="{{ json_encode($product->gallery_images ?? []) }}">

                    <!-- Submit Buttons -->
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('admin.products.index') }}"
                           class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="reset"
                                class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                            Reset
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center gap-2">
                            <i class="fas fa-save"></i> Update Product
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Product Stats -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Product Stats</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="p-2 bg-blue-100 rounded-lg mr-3">
                                <i class="fas fa-chart-line text-blue-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Sales Count</p>
                                <p class="text-lg font-bold text-gray-800">{{ $product->sales_count ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="p-2 bg-green-100 rounded-lg mr-3">
                                <i class="fas fa-box text-green-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Stock Status</p>
                                <p class="text-lg font-bold 
                                    {{ $product->stock > 10 ? 'text-green-600' : 
                                       ($product->stock > 0 ? 'text-yellow-600' : 'text-red-600') }}">
                                    {{ $product->stock }} units
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="p-2 bg-purple-100 rounded-lg mr-3">
                                <i class="fas fa-images text-purple-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Total Images</p>
                                <p class="text-lg font-bold text-gray-800">
                                    @php
                                        $imageCount = 0;
                                        if ($product->main_image) $imageCount++;
                                        if ($product->image) $imageCount++;
                                        for ($i = 2; $i <= 5; $i++) {
                                            $field = "image_{$i}";
                                            if ($product->$field) $imageCount++;
                                        }
                                        if ($product->additional_images) $imageCount += count($product->additional_images);
                                        if ($product->gallery_images) $imageCount += count($product->gallery_images);
                                    @endphp
                                    {{ $imageCount }}
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="p-2 bg-yellow-100 rounded-lg mr-3">
                                <i class="fas fa-calendar text-yellow-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Created</p>
                                <p class="text-lg font-bold text-gray-800">
                                    @if($product->created_at)
                                        {{ $product->created_at->format('d M Y') }}
                                    @else
                                        N/A
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Current Images Preview -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b">
                    <h3 class="text-lg font-medium text-gray-900">Current Images Preview</h3>
                </div>
                <div class="p-4">
                    @php
                        $allImages = [];
                        
                        // Main images
                        if ($product->main_image) {
                            $allImages[] = [
                                'url' => $product->main_image ? 
                                    (filter_var($product->main_image, FILTER_VALIDATE_URL) ? 
                                     $product->main_image : 
                                     asset('storage/' . $product->main_image)) : 
                                    asset('images/default-product.jpg'),
                                'type' => 'main'
                            ];
                        }
                        
                        if ($product->image && $product->image !== $product->main_image) {
                            $allImages[] = [
                                'url' => $product->image ? 
                                    (filter_var($product->image, FILTER_VALIDATE_URL) ? 
                                     $product->image : 
                                     asset('storage/' . $product->image)) : 
                                    asset('images/default-product.jpg'),
                                'type' => 'legacy'
                            ];
                        }
                        
                        // Additional images
                        for ($i = 2; $i <= 5; $i++) {
                            $field = "image_{$i}";
                            if ($product->$field) {
                                $allImages[] = [
                                    'url' => $product->$field ? 
                                        (filter_var($product->$field, FILTER_VALIDATE_URL) ? 
                                         $product->$field : 
                                         asset('storage/' . $product->$field)) : 
                                        asset('images/default-product.jpg'),
                                    'type' => 'additional'
                                ];
                            }
                        }
                        
                        // JSON images
                        if ($product->additional_images && is_array($product->additional_images)) {
                            foreach ($product->additional_images as $imagePath) {
                                if ($imagePath) {
                                    $allImages[] = [
                                        'url' => filter_var($imagePath, FILTER_VALIDATE_URL) ? 
                                            $imagePath : 
                                            asset('storage/' . $imagePath),
                                        'type' => 'gallery'
                                    ];
                                }
                            }
                        }
                        
                        if ($product->gallery_images && is_array($product->gallery_images)) {
                            foreach ($product->gallery_images as $imagePath) {
                                if ($imagePath) {
                                    $allImages[] = [
                                        'url' => filter_var($imagePath, FILTER_VALIDATE_URL) ? 
                                            $imagePath : 
                                            asset('storage/' . $imagePath),
                                        'type' => 'gallery'
                                    ];
                                }
                            }
                        }
                    @endphp
                    
                    @if(count($allImages) > 0)
                        <div class="grid grid-cols-3 gap-3">
                            @foreach($allImages as $index => $image)
                                <div class="relative">
                                    <img src="{{ $image['url'] }}" 
                                         alt="Image {{ $index + 1 }}"
                                         class="w-full h-20 object-cover rounded-lg">
                                    <span class="absolute top-1 left-1 px-1 py-0.5 text-xs bg-black bg-opacity-70 text-white rounded">
                                        {{ $image['type'] === 'main' ? 'M' : 
                                           ($image['type'] === 'legacy' ? 'L' : 
                                           ($image['type'] === 'additional' ? 'A' : 'G')) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                        <p class="mt-3 text-sm text-gray-600 text-center">{{ count($allImages) }} images total</p>
                    @else
                        <p class="text-gray-500 text-center py-4">No images available</p>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b">
                    <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <a href="{{ route('admin.products.show', $product->id) }}"
                           class="flex items-center gap-2 text-blue-600 hover:text-blue-800">
                            <i class="fas fa-eye"></i>
                            <span>View Product Details</span>
                        </a>
                        
                        <button type="button"
                                onclick="showDeleteModal({{ $product->id }})"
                                class="flex items-center gap-2 text-red-600 hover:text-red-800 w-full text-left">
                            <i class="fas fa-trash"></i>
                            <span>Delete This Product</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Current Status -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Current Status</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Product Status</span>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full 
                            {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Category</span>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                            @if($product->category)
                                {{ ucfirst($product->category) }}
                            @elseif($product->category_id && $product->categoryRelation)
                                {{ $product->categoryRelation->name }}
                            @else
                                Unknown
                            @endif
                        </span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Category Type</span>
                        <span class="text-sm text-gray-800">
                            @if(is_string($product->category))
                                {{ ucfirst($product->category) }}
                            @elseif($product->categoryRelation)
                                {{ $product->categoryRelation->type }}
                            @else
                                Unknown
                            @endif
                        </span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Last Updated</span>
                        <span class="text-sm text-gray-800">
                            @if($product->updated_at)
                                {{ $product->updated_at->format('d M Y H:i') }}
                            @else
                                N/A
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
        <div class="px-6 py-4 border-b">
            <h3 class="text-lg font-medium text-gray-900">Confirm Delete</h3>
        </div>
        <div class="px-6 py-4">
            <p id="deleteModalBody" class="text-gray-700">
                Are you sure you want to delete "<strong>{{ $product->name }}</strong>"?<br>
                <small class="text-red-600">This will delete ALL product images as well!</small>
            </p>
        </div>
        <div class="px-6 py-4 border-t flex justify-end gap-3">
            <button type="button" 
                    onclick="document.getElementById('deleteModal').classList.add('hidden')"
                    class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">
                Cancel
            </button>
            <form id="deleteForm" action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Specifications Management
let specIndex = {{ count($specifications) }};

function addSpecification() {
    const container = document.getElementById('specifications-container');
    const template = document.getElementById('specification-template').innerHTML;
    
    const newSpec = template.replace(/__INDEX__/g, specIndex);
    
    const div = document.createElement('div');
    div.innerHTML = newSpec;
    container.appendChild(div);
    
    specIndex++;
    
    // Update nomor urut
    updateSpecificationNumbers();
}

function removeSpecification(button) {
    const item = button.closest('.specification-item');
    
    // Dapatkan semua item specifications
    const allItems = document.querySelectorAll('.specification-item');
    
    // Jika hanya ada 1 item dan kosong, jangan hapus
    const inputs = item.querySelectorAll('input[type="text"]');
    const isEmpty = Array.from(inputs).every(input => input.value.trim() === '');
    
    if (allItems.length === 1 && isEmpty) {
        // Kosongkan input
        inputs.forEach(input => input.value = '');
        return;
    }
    
    // Hapus item
    item.remove();
    
    // Update nomor urut
    updateSpecificationNumbers();
    
    // Update specIndex
    specIndex = document.querySelectorAll('.specification-item').length;
}

function updateSpecificationNumbers() {
    const items = document.querySelectorAll('.specification-item');
    
    items.forEach((item, index) => {
        const title = item.querySelector('.text-sm.font-medium');
        if (title) {
            title.textContent = `Specification #${index + 1}`;
        }
        
        // Update input names
        const keyInput = item.querySelector('input[name*="[key]"]');
        const valueInput = item.querySelector('input[name*="[value]"]');
        
        if (keyInput) {
            keyInput.name = `specifications[${index}][key]`;
        }
        if (valueInput) {
            valueInput.name = `specifications[${index}][value]`;
        }
    });
}

// Gallery Images Management
function addGalleryUploadField() {
    const container = document.getElementById('gallery-upload-container');
    const newField = document.createElement('div');
    newField.className = 'flex items-center gap-3';
    newField.innerHTML = `
        <input type="file"
               name="gallery_images[]"
               accept="image/*"
               class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        <button type="button" 
                onclick="removeGalleryUploadField(this)"
                class="px-3 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200">
            <i class="fas fa-minus"></i>
        </button>
    `;
    container.appendChild(newField);
}

function removeGalleryUploadField(button) {
    const fieldDiv = button.closest('.flex.items-center');
    if (document.querySelectorAll('#gallery-upload-container .flex.items-center').length > 1) {
        fieldDiv.remove();
    } else {
        // If only one field left, just clear it
        const input = fieldDiv.querySelector('input[type="file"]');
        input.value = '';
    }
}

function removeGalleryImage(imagePath) {
    if (confirm('Remove this gallery image?')) {
        // Remove from additional_images JSON
        let additionalImages = JSON.parse(document.getElementById('additional_images_paths').value || '[]');
        additionalImages = additionalImages.filter(img => img !== imagePath);
        document.getElementById('additional_images_paths').value = JSON.stringify(additionalImages);
        
        // Remove from gallery_images JSON
        let galleryImages = JSON.parse(document.getElementById('gallery_images_paths').value || '[]');
        galleryImages = galleryImages.filter(img => img !== imagePath);
        document.getElementById('gallery_images_paths').value = JSON.stringify(galleryImages);
        
        // Reload page to show updated images
        window.location.reload();
    }
}

// Delete product modal
function showDeleteModal(productId) {
    const modal = document.getElementById('deleteModal');
    modal.classList.remove('hidden');
}

// Close modal when clicking outside
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        this.classList.add('hidden');
    }
});

// Form validation
document.getElementById('productForm').addEventListener('submit', function(e) {
    let isValid = true;
    
    // Validate specifications
    const specItems = document.querySelectorAll('.specification-item');
    let hasValidSpec = false;
    
    specItems.forEach(item => {
        const keyInput = item.querySelector('input[name*="[key]"]');
        const valueInput = item.querySelector('input[name*="[value]"]');
        
        if ((keyInput && keyInput.value.trim() !== '') || 
            (valueInput && valueInput.value.trim() !== '')) {
            hasValidSpec = true;
        }
    });
    
    if (!hasValidSpec) {
        if (!confirm('No specifications entered. Continue without specifications?')) {
            isValid = false;
        }
    }
    
    if (!isValid) {
        e.preventDefault();
    }
});

// Price calculation preview
const priceInput = document.getElementById('price');
const discountInput = document.getElementById('discount_percent');

function calculateFinalPrice() {
    const price = parseFloat(priceInput.value) || 0;
    const discount = parseFloat(discountInput.value) || 0;
    
    if (discount > 0) {
        const discountedPrice = price * (1 - discount / 100);
        // You can show this in a preview element if needed
        console.log('Final price:', discountedPrice);
    }
}

priceInput.addEventListener('input', calculateFinalPrice);
discountInput.addEventListener('input', calculateFinalPrice);

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Update specification numbers on page load
    updateSpecificationNumbers();
});
</script>
@endpush
@endsection