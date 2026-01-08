@extends('pages.admin.layouts.app')

@section('title', $product->name)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">{{ $product->name }}</h1>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                            <i class="fas fa-home mr-2"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400"></i>
                            <a href="{{ route('admin.products.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600">Products</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500">{{ $product->name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.products.edit', $product->id) }}" 
               class="flex items-center gap-2 bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('admin.products.index') }}" 
               class="flex items-center gap-2 bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Product Image & Basic Info -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Product Image Card -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-center">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-64 object-cover rounded-lg mb-4 mx-auto">
                    @else
                        <div class="w-full h-64 bg-gray-100 rounded-lg flex items-center justify-center mb-4">
                            <i class="fas fa-image fa-4x text-gray-300"></i>
                        </div>
                    @endif
                    
                    <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $product->name }}</h3>
                    
                    <div class="flex justify-center gap-2 mb-4">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full 
                            {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                        </span>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                            {{ $product->category_name }}
                        </span>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 mt-6">
                        <div class="text-center">
                            <p class="text-sm text-gray-500">Product ID</p>
                            <p class="text-lg font-bold text-gray-800">#{{ $product->id }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-sm text-gray-500">Stock</p>
                            <p class="text-lg font-bold 
                                {{ $product->stock > 10 ? 'text-green-600' : 
                                   ($product->stock > 0 ? 'text-yellow-600' : 'text-red-600') }}">
                                {{ $product->stock }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Card -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b">
                    <h3 class="text-lg font-medium text-gray-900">Product Stats</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="p-2 bg-blue-100 rounded-lg mr-3">
                                <i class="fas fa-shopping-cart text-blue-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Sales Count</p>
                                <p class="text-lg font-bold text-gray-800">{{ $product->sales_count }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="p-2 bg-yellow-100 rounded-lg mr-3">
                                <i class="fas fa-star text-yellow-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Rating</p>
                                <p class="text-lg font-bold text-gray-800">{{ $product->rating ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="p-2 bg-indigo-100 rounded-lg mr-3">
                                <i class="fas fa-box text-indigo-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Minimum Order</p>
                                <p class="text-lg font-bold text-gray-800">{{ $product->min_order }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Product Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Product Details Card -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b">
                    <h3 class="text-lg font-medium text-gray-900">Product Details</h3>
                </div>
                <div class="p-6">
                    <!-- Price & Category -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Price</p>
                            <div class="flex items-baseline">
                                <span class="text-2xl font-bold text-gray-800">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                                @if($product->discount_percent > 0)
                                    <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        -{{ $product->discount_percent }}%
                                    </span>
                                @endif
                            </div>
                            @if($product->discount_percent > 0)
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">Discounted Price</p>
                                    <p class="text-xl font-bold text-green-600">
                                        Rp {{ number_format($product->discounted_price, 0, ',', '.') }}
                                    </p>
                                </div>
                            @endif
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Category</p>
                            <div class="flex items-center">
                                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $product->category_name }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Short Description -->
                    @if($product->short_description)
                    <div class="mb-6">
                        <p class="text-sm text-gray-500 mb-2">Short Description</p>
                        <p class="text-gray-700">{{ $product->short_description }}</p>
                    </div>
                    @endif

                    <!-- Full Description -->
                    <div class="mb-6">
                        <p class="text-sm text-gray-500 mb-2">Description</p>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-gray-700 whitespace-pre-line">{{ $product->description }}</p>
                        </div>
                    </div>

                    <!-- Specifications -->
                    @if($product->specifications && count($product->specifications) > 0)
                    <div class="mb-6">
                        <p class="text-sm text-gray-500 mb-3">Specifications</p>
                        <div class="bg-gray-50 rounded-lg overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200">
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($product->specifications as $key => $value)
                                    <tr class="hover:bg-gray-100">
                                        <td class="px-4 py-3 text-sm font-medium text-gray-700">
                                            {{ ucfirst(str_replace('_', ' ', $key)) }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-600">
                                            {{ $value }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                    <!-- Timestamps -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Created At</p>
                            <p class="text-gray-700">{{ $product->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Last Updated</p>
                            <p class="text-gray-700">{{ $product->updated_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions Card -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Product Actions</h3>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full 
                        {{ $product->stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                    </span>
                </div>
                <div class="p-6">
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('admin.products.edit', $product->id) }}" 
                           class="flex items-center gap-2 bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700">
                            <i class="fas fa-edit"></i> Edit Product
                        </a>
                        <button type="button" 
                                onclick="showDeleteModal({{ $product->id }}, '{{ addslashes($product->name) }}')"
                                class="flex items-center gap-2 bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                            <i class="fas fa-trash"></i> Delete Product
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
        <div class="px-6 py-4 border-b">
            <h3 class="text-lg font-medium text-gray-900">Confirm Delete</h3>
        </div>
        <div class="px-6 py-4">
            <p id="deleteModalBody" class="text-gray-700"></p>
        </div>
        <div class="px-6 py-4 border-t flex justify-end gap-3">
            <button type="button" 
                    onclick="document.getElementById('deleteModal').classList.add('hidden')"
                    class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">
                Cancel
            </button>
            <form id="deleteForm" method="POST" class="inline">
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
function showDeleteModal(id, productName) {
    const form = document.getElementById('deleteForm');
    form.action = `/admin/products/${id}`;
    
    document.getElementById('deleteModalBody').innerHTML = 
        `Are you sure you want to delete <strong>"${productName}"</strong>? This action cannot be undone.`;
    
    document.getElementById('deleteModal').classList.remove('hidden');
}

// Close modal when clicking outside
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        this.classList.add('hidden');
    }
});
</script>
@endpush

@endsection