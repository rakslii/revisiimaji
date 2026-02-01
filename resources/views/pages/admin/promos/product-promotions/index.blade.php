@extends('pages.admin.layouts.app')

@section('title', 'All Product Promotions')
@section('page-title', 'All Product Promotions')
@section('page-description', 'View and manage all product-specific promotions')

@push('styles')
<style>
    .status-badge {
        @apply px-2 py-1 text-xs font-semibold rounded-full;
    }
    .status-active { @apply bg-green-100 text-green-800; }
    .status-inactive { @apply bg-gray-100 text-gray-800; }
    .status-expired { @apply bg-red-100 text-red-800; }
    .status-upcoming { @apply bg-yellow-100 text-yellow-800; }
    .status-quota_exceeded { @apply bg-orange-100 text-orange-800; }
    
    .type-badge {
        @apply px-2 py-1 text-xs font-semibold rounded-full;
    }
    .type-percentage { @apply bg-blue-100 text-blue-800; }
    .type-nominal { @apply bg-green-100 text-green-800; }
</style>
@endpush

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            {{-- <h1 class="text-2xl font-bold text-gray-800">All Product Promotions</h1>
            <p class="text-gray-600 mt-1">View and manage product-specific promotions</p> --}}
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.product-promotions.select-product') }}" 
               class="flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                <i class="fas fa-plus"></i> Add Promotion
            </a>
            <a href="{{ route('admin.promos.index') }}" 
               class="flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
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
                       placeholder="Product or promotion name..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="upcoming" {{ request('status') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                </select>
            </div>

            <!-- Product -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Product</label>
                <select name="product_id" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">All Products</option>
                    @foreach($products ?? [] as $product)
                        <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                            {{ $product->name }}
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
                <a href="{{ route('admin.product-promotions.index') }}" 
                   class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 text-center">
                    Clear
                </a>
            </div>
        </form>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $promotions->total() }}</h3>
                </div>
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-tags text-blue-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Active</p>
                    <h3 class="text-2xl font-bold text-green-600">{{ \App\Models\ProductPromotion::active()->count() }}</h3>
                </div>
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-bolt text-green-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Expired</p>
                    <h3 class="text-2xl font-bold text-red-600">{{ \App\Models\ProductPromotion::expired()->count() }}</h3>
                </div>
                <div class="p-3 bg-red-100 rounded-lg">
                    <i class="fas fa-clock text-red-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Upcoming</p>
                    <h3 class="text-2xl font-bold text-yellow-600">{{ \App\Models\ProductPromotion::upcoming()->count() }}</h3>
                </div>
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <i class="fas fa-calendar text-yellow-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Promotions Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Promotion</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Discount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Validity</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Usage</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($promotions as $promotion)
                    <tr class="hover:bg-gray-50">
                        <!-- Product -->
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                @if($promotion->product->image_url)
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-md object-cover" 
                                         src="{{ $promotion->product->image_url }}" 
                                         alt="{{ $promotion->product->name }}">
                                </div>
                                @endif
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        <a href="{{ route('admin.products.show', $promotion->product_id) }}" 
                                           class="text-blue-600 hover:text-blue-900">
                                            {{ $promotion->product->name }}
                                        </a>
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        Rp {{ number_format($promotion->product->price, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        
                        <!-- Promotion Info -->
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">
                                {{ $promotion->name ?? 'Product Promotion' }}
                            </div>
                            @if($promotion->promo_code_id)
                            <div class="text-xs text-gray-500">
                                <i class="fas fa-link mr-1"></i>
                                {{ $promotion->promoCode->code ?? 'Linked Promo' }}
                            </div>
                            @endif
                        </td>
                        
                        <!-- Discount -->
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="type-badge {{ $promotion->type == 'percentage' ? 'type-percentage' : 'type-nominal' }}">
                                    {{ $promotion->formatted_value }}
                                </span>
                                @if($promotion->min_quantity > 1)
                                <span class="text-xs text-gray-500 mt-1">
                                    Min {{ $promotion->min_quantity }} pcs
                                </span>
                                @endif
                            </div>
                        </td>
                        
                        <!-- Validity -->
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">
                                {{ $promotion->valid_from->format('d M') }} - {{ $promotion->valid_until->format('d M Y') }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ $promotion->remaining_days }} days left
                            </div>
                        </td>
                        
                        <!-- Usage -->
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="text-sm text-gray-900">
                                    {{ $promotion->used_count }} / {{ $promotion->quota ?? '∞' }}
                                </span>
                                @if($promotion->quota)
                                <div class="w-full bg-gray-200 rounded-full h-1.5 mt-1">
                                    <div class="bg-blue-600 h-1.5 rounded-full" 
                                         style="width: {{ min(100, ($promotion->used_count / $promotion->quota) * 100) }}%"></div>
                                </div>
                                @endif
                            </div>
                        </td>
                        
                        <!-- Status -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $status = $promotion->status;
                                $statusClasses = [
                                    'active' => 'status-active',
                                    'inactive' => 'status-inactive',
                                    'expired' => 'status-expired',
                                    'upcoming' => 'status-upcoming',
                                    'quota_exceeded' => 'status-quota_exceeded'
                                ];
                                $statusLabels = [
                                    'active' => 'Active',
                                    'inactive' => 'Inactive',
                                    'expired' => 'Expired',
                                    'upcoming' => 'Upcoming',
                                    'quota_exceeded' => 'Quota Exceeded'
                                ];
                            @endphp
                            <span class="status-badge {{ $statusClasses[$status] }}">
                                {{ $statusLabels[$status] }}
                            </span>
                        </td>
                        
                        <!-- Actions -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.product-promotions.show', $promotion->id) }}" 
                                   class="text-blue-600 hover:text-blue-900 p-1" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.product-promotions.edit', $promotion->id) }}" 
                                   class="text-green-600 hover:text-green-900 p-1" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.product-promotions.toggle-status', $promotion->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-yellow-600 hover:text-yellow-900 p-1" 
                                            title="{{ $promotion->is_active ? 'Deactivate' : 'Activate' }}">
                                        <i class="fas fa-power-off"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.product-promotions.destroy', $promotion->id) }}" method="POST" class="inline" 
                                      onsubmit="return confirm('Delete this promotion?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 p-1" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center">
                            <div class="text-gray-400">
                                <i class="fas fa-tags text-4xl mb-3"></i>
                                <p class="text-lg">No product promotions found</p>
                                <p class="text-sm mt-1">Create your first product promotion</p>
                                <a href="{{ route('admin.product-promotions.select-product') }}" 
                                   class="inline-block mt-4 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                                    <i class="fas fa-plus mr-1"></i> Add Promotion
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($promotions->hasPages())
        <div class="px-6 py-4 border-t">
            {{ $promotions->links() }}
        </div>
        @endif
    </div>
</div>
@endsection