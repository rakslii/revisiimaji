@extends('pages.admin.layouts.app')

@section('title', 'Select Product for Promotion')
@section('page-title', 'Select Product')
@section('page-description', 'Choose a product to create or manage promotions')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <!-- HAPUS H1 DI SINI KARENA SUDAH ADA DI LAYOUT -->
            <!-- <h1 class="text-2xl font-bold text-gray-800">Select Product</h1> -->
            {{-- <p class="text-gray-600">Choose a product to create or manage promotions</p> --}}
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.product-promotions.index') }}" 
               class="flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                <i class="fas fa-list"></i> View All Promotions
            </a>
            <a href="{{ route('admin.promos.index') }}" 
               class="flex items-center gap-2 px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200">
                <i class="fas fa-ticket-alt"></i> Promo Codes
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-4">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Product name..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>

            <!-- Has Promotion -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Promotion Status</label>
                <select name="has_promo" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">All Products</option>
                    <option value="with" {{ request('has_promo') == 'with' ? 'selected' : '' }}>With Active Promotion</option>
                    <option value="without" {{ request('has_promo') == 'without' ? 'selected' : '' }}>Without Promotion</option>
                </select>
            </div>

            <!-- Category -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <select name="category_id" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">All Categories</option>
                    @foreach($categories ?? [] as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Actions -->
            <div class="flex items-end gap-2">
                <button type="submit" 
                        class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-search mr-1"></i> Filter
                </button>
                <a href="{{ route('admin.product-promotions.select-product') }}" 
                   class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 text-center">
                    Clear
                </a>
            </div>
        </form>
    </div>

    <!-- Product Grid -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if($products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 p-6">
            @foreach($products as $product)
            <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-shadow">
                <!-- Product Image -->
                <div class="h-48 bg-gray-100 overflow-hidden">
                    <img src="{{ $product->image_url }}" 
                         alt="{{ $product->name }}"
                         class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                </div>
                
                <!-- Product Info -->
                <div class="p-4">
                    <h3 class="font-medium text-gray-900 truncate">{{ $product->name }}</h3>
                    <div class="mt-2 flex items-center justify-between">
                        <span class="text-lg font-bold text-blue-600">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </span>
                        @if($product->has_discount)
                        <span class="text-sm line-through text-gray-400">
                            Rp {{ number_format($product->final_price, 0, ',', '.') }}
                        </span>
                        @endif
                    </div>
                    
                    <div class="mt-3 text-sm text-gray-600">
                        <div class="flex items-center gap-1">
                            <i class="fas fa-box text-gray-400"></i>
                            <span>Stock: {{ $product->stock }}</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <i class="fas fa-tag text-gray-400"></i>
                            <span>{{ $product->category_name }}</span>
                        </div>
                    </div>
                    
                   <!-- Promotion Status -->
<div class="mt-4">
    @php
        // Gunakan productPromotions yang sudah dimuat di controller
        $activePromotions = $product->productPromotions->filter(function($promo) {
            return $promo->is_active && 
                   $promo->valid_from <= now() && 
                   $promo->valid_until >= now() &&
                   (!$promo->quota || $promo->used_count < $promo->quota);
        });
    @endphp
    
    @if($activePromotions->count() > 0)
    <div class="mb-2">
        <div class="flex items-center justify-between">
            <span class="text-sm font-medium text-green-600">
                <i class="fas fa-ticket-alt mr-1"></i>
                {{ $activePromotions->count() }} Active Promotion(s)
            </span>
            <a href="{{ route('admin.product-promotions.product-promotions', $product->id) }}" 
               class="text-xs text-blue-600 hover:text-blue-800">
                View
            </a>
        </div>
        @foreach($activePromotions->take(2) as $promo)
        <div class="mt-1 text-xs bg-green-50 text-green-700 px-2 py-1 rounded">
            {{ $promo->formatted_value ?? $promo->name }} • 
            {{ \Carbon\Carbon::parse($promo->valid_until)->diffInDays(now()) }} days left
        </div>
        @endforeach
    </div>
    @else
    <div class="text-sm text-gray-500 bg-gray-50 px-3 py-2 rounded">
        <i class="fas fa-info-circle mr-1"></i>
        No active promotions
    </div>
    @endif
</div> 
                    <!-- Action Buttons -->
                    <div class="mt-4 flex gap-2">
                        <a href="{{ route('admin.product-promotions.create', $product->id) }}" 
                           class="flex-1 px-3 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 text-center">
                            <i class="fas fa-plus mr-1"></i> Add Promotion
                        </a>
                        <a href="{{ route('admin.products.show', $product->id) }}" 
                           class="px-3 py-2 bg-gray-100 text-gray-700 text-sm rounded-md hover:bg-gray-200">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        @if($products->hasPages())
        <div class="px-6 py-4 border-t">
            {{ $products->links() }}
        </div>
        @endif
        
        @else
        <div class="p-12 text-center">
            <i class="fas fa-box-open text-4xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 text-lg">No products found</p>
            <p class="text-gray-400 mt-1">Try adjusting your search filters</p>
        </div>
        @endif
    </div>
</div>
@endsection