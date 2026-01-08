@extends('pages.admin.layouts.app')

@section('title', 'Products Management')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Products Management</h1>
            <p class="text-gray-600 mt-1">Total {{ $products->total() }} products</p>
        </div>
        <a href="{{ route('admin.products.create') }}" 
           class="flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            <i class="fas fa-plus"></i> Add New Product
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Products</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $products->total() }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-box text-blue-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Active Products</p>
                    <p class="text-2xl font-bold text-green-600">
                        {{ $products->filter(fn($p) => $p->is_active)->count() }}
                    </p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-check-circle text-green-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Low Stock</p>
                    <p class="text-2xl font-bold text-yellow-600">
                        {{ $products->filter(fn($p) => $p->stock <= 10 && $p->stock > 0)->count() }}
                    </p>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <i class="fas fa-exclamation-triangle text-yellow-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Out of Stock</p>
                    <p class="text-2xl font-bold text-red-600">
                        {{ $products->filter(fn($p) => $p->stock == 0)->count() }}
                    </p>
                </div>
                <div class="bg-red-100 p-3 rounded-full">
                    <i class="fas fa-times-circle text-red-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <!-- Table Header with Filters -->
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900">Products List</h3>
            <form method="GET" action="{{ route('admin.products.index') }}" class="flex gap-2">
                <input type="text" 
                       name="search" 
                       class="px-3 py-1 border rounded-lg text-sm"
                       placeholder="Search products..."
                       value="{{ request('search') }}">
                <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded-lg text-sm">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($products as $product)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            #{{ $product->id }}
                        </td>
                 <td class="px-6 py-4 whitespace-nowrap">
    <div class="flex items-center">
        <div class="w-10 h-10 bg-gray-100 rounded-lg mr-3 overflow-hidden flex items-center justify-center">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" 
                     alt="{{ $product->name }}" 
                     class="w-full h-full object-cover">
            @else
                <i class="fas fa-box text-gray-400"></i>
            @endif
        </div>
        <div>
            <p class="text-sm font-medium text-gray-900">{{ $product->name }}</p>
            <p class="text-xs text-gray-500 truncate max-w-xs">
                {{ $product->short_description ?: Str::limit($product->description, 50) }}
            </p>
        </div>
    </div>
</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $product->category_name }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <div class="font-medium">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                            @if($product->discount_percent > 0)
                                <small class="text-green-600">
                                    -{{ $product->discount_percent }}%
                                </small>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $product->stock > 10 ? 'bg-green-100 text-green-800' : 
                                   ($product->stock > 0 ? 'bg-yellow-100 text-yellow-800' : 
                                   'bg-red-100 text-red-800') }}">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.products.show', $product->id) }}" 
                                   class="text-blue-600 hover:text-blue-900" 
                                   title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.products.edit', $product->id) }}" 
                                   class="text-yellow-600 hover:text-yellow-900" 
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button onclick="showDeleteModal({{ $product->id }}, '{{ addslashes($product->name) }}')"
                                        class="text-red-600 hover:text-red-900" 
                                        title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            <div class="py-8">
                                <i class="fas fa-box fa-2x text-gray-300 mb-2"></i>
                                <p class="text-gray-500">No products found</p>
                                @if(request()->has('search'))
                                    <a href="{{ route('admin.products.index') }}" 
                                       class="inline-block mt-2 text-blue-600 hover:text-blue-800">
                                        Clear search
                                    </a>
                                @else
                                    <a href="{{ route('admin.products.create') }}" 
                                       class="inline-block mt-2 text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-plus mr-1"></i> Add your first product
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($products->hasPages())
        <div class="px-6 py-4 border-t">
            {{ $products->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Delete Modal (Tailwind version) -->
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