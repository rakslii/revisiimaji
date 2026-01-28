

<?php $__env->startSection('title', 'Products Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Products Management</h1>
            <p class="text-gray-600 mt-1">Total <?php echo e($products->total()); ?> products</p>
        </div>
        <a href="<?php echo e(route('admin.products.create')); ?>" 
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
                    <p class="text-2xl font-bold text-gray-800"><?php echo e($products->total()); ?></p>
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
                        <?php echo e(App\Models\Product::active()->count()); ?>

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
                    <p class="text-sm text-gray-500">Instan Products</p>
                    <p class="text-2xl font-bold text-purple-600">
                        <?php echo e(App\Models\Product::where('category', 'instan')->count()); ?>

                    </p>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <i class="fas fa-bolt text-purple-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Non-Instan Products</p>
                    <p class="text-2xl font-bold text-orange-600">
                        <?php echo e(App\Models\Product::where('category', 'non-instan')->count()); ?>

                    </p>
                </div>
                <div class="bg-orange-100 p-3 rounded-full">
                    <i class="fas fa-clock text-orange-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">Filters</h3>
            <?php if(request()->anyFilled(['search', 'category_type', 'status', 'stock_filter', 'min_price', 'max_price'])): ?>
            <a href="<?php echo e(route('admin.products.index')); ?>" 
               class="text-sm text-red-600 hover:text-red-800">
                <i class="fas fa-times mr-1"></i> Clear All Filters
            </a>
            <?php endif; ?>
        </div>
        
        <form method="GET" action="<?php echo e(route('admin.products.index')); ?>" class="space-y-4">
            <!-- Search Bar -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Search Products</label>
                <div class="flex gap-2">
                    <input type="text" 
                           name="search" 
                           class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Search by name, description..."
                           value="<?php echo e(request('search')); ?>">
                    <button type="submit" 
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Product Type Filter (Instan/Non-Instan) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Product Type</label>
                    <select name="category_type" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">All Types</option>
                        <option value="instan" <?php echo e(request('category_type') == 'instan' ? 'selected' : ''); ?>>
                            Instan
                        </option>
                        <option value="non-instan" <?php echo e(request('category_type') == 'non-instan' ? 'selected' : ''); ?>>
                            Non-Instan
                        </option>
                    </select>
                </div>

                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">All Status</option>
                        <option value="active" <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>>Active</option>
                        <option value="inactive" <?php echo e(request('status') == 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                    </select>
                </div>

                <!-- Stock Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Stock Filter</label>
                    <select name="stock_filter" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">All Stock</option>
                        <option value="out_of_stock" <?php echo e(request('stock_filter') == 'out_of_stock' ? 'selected' : ''); ?>>Out of Stock</option>
                        <option value="low_stock" <?php echo e(request('stock_filter') == 'low_stock' ? 'selected' : ''); ?>>Low Stock (< 10)</option>
                        <option value="in_stock" <?php echo e(request('stock_filter') == 'in_stock' ? 'selected' : ''); ?>>In Stock</option>
                        <option value="high_stock" <?php echo e(request('stock_filter') == 'high_stock' ? 'selected' : ''); ?>>High Stock (10+)</option>
                        <option value="custom" <?php echo e(request('stock_filter') == 'custom' ? 'selected' : ''); ?>>Custom Range</option>
                    </select>
                </div>

                <!-- Sort By -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                    <select name="sort_by" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="newest" <?php echo e(request('sort_by') == 'newest' ? 'selected' : ''); ?>>Newest First</option>
                        <option value="oldest" <?php echo e(request('sort_by') == 'oldest' ? 'selected' : ''); ?>>Oldest First</option>
                        <option value="price_high" <?php echo e(request('sort_by') == 'price_high' ? 'selected' : ''); ?>>Price: High to Low</option>
                        <option value="price_low" <?php echo e(request('sort_by') == 'price_low' ? 'selected' : ''); ?>>Price: Low to High</option>
                        <option value="stock_high" <?php echo e(request('sort_by') == 'stock_high' ? 'selected' : ''); ?>>Stock: High to Low</option>
                        <option value="stock_low" <?php echo e(request('sort_by') == 'stock_low' ? 'selected' : ''); ?>>Stock: Low to High</option>
                        <option value="name_asc" <?php echo e(request('sort_by') == 'name_asc' ? 'selected' : ''); ?>>Name: A-Z</option>
                        <option value="name_desc" <?php echo e(request('sort_by') == 'name_desc' ? 'selected' : ''); ?>>Name: Z-A</option>
                    </select>
                </div>
            </div>

            <!-- Custom Stock Range (Visible when custom is selected) -->
            <div id="customStockRange" class="grid grid-cols-1 md:grid-cols-2 gap-4" 
                 style="<?php echo e(request('stock_filter') == 'custom' ? '' : 'display: none;'); ?>">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Min Stock</label>
                    <input type="number" 
                           name="min_stock" 
                           min="0"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           value="<?php echo e(request('min_stock')); ?>">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Max Stock</label>
                    <input type="number" 
                           name="max_stock" 
                           min="0"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           value="<?php echo e(request('max_stock')); ?>">
                </div>
            </div>

            <!-- Price Range Filter -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Min Price</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                        <input type="number" 
                               name="min_price" 
                               min="0"
                               class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Min price"
                               value="<?php echo e(request('min_price')); ?>">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Max Price</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                        <input type="number" 
                               name="max_price" 
                               min="0"
                               class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Max price"
                               value="<?php echo e(request('max_price')); ?>">
                    </div>
                </div>
            </div>

            <!-- Active Filters Badges -->
            <?php if(request()->anyFilled(['category_type', 'status', 'stock_filter', 'min_price', 'max_price'])): ?>
            <div class="border-t pt-4">
                <p class="text-sm font-medium text-gray-700 mb-2">Active Filters:</p>
                <div class="flex flex-wrap gap-2">
                    <?php if(request('category_type')): ?>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                        <?php echo e(request('category_type') == 'instan' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800'); ?>">
                        Type: <?php echo e(ucfirst(request('category_type'))); ?>

                        <a href="<?php echo e(request()->fullUrlWithQuery(['category_type' => null])); ?>" 
                           class="ml-1 hover:text-opacity-75">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                    <?php endif; ?>
                    
                    <?php if(request('status')): ?>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                        <?php echo e(request('status') == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                        Status: <?php echo e(ucfirst(request('status'))); ?>

                        <a href="<?php echo e(request()->fullUrlWithQuery(['status' => null])); ?>" 
                           class="ml-1 hover:text-opacity-75">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                    <?php endif; ?>
                    
                    <?php if(request('stock_filter')): ?>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                        Stock: <?php echo e(ucfirst(str_replace('_', ' ', request('stock_filter')))); ?>

                        <a href="<?php echo e(request()->fullUrlWithQuery(['stock_filter' => null])); ?>" 
                           class="ml-1 hover:text-opacity-75">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                    <?php endif; ?>
                    
                    <?php if(request('min_price') || request('max_price')): ?>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                        Price: 
                        <?php echo e(request('min_price') ? 'Rp ' . number_format(request('min_price'), 0, ',', '.') : 'Min'); ?>

                        -
                        <?php echo e(request('max_price') ? 'Rp ' . number_format(request('max_price'), 0, ',', '.') : 'Max'); ?>

                        <a href="<?php echo e(request()->fullUrlWithQuery(['min_price' => null, 'max_price' => null])); ?>" 
                           class="ml-1 hover:text-opacity-75">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-2 pt-2">
                <a href="<?php echo e(route('admin.products.index')); ?>" 
                   class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                    Reset
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center gap-2">
                    <i class="fas fa-filter"></i> Apply Filters
                </button>
            </div>
        </form>
    </div>

    <!-- Products Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <!-- Table Header -->
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-medium text-gray-900">Products List</h3>
                <p class="text-sm text-gray-500 mt-1">
                    Showing <?php echo e($products->firstItem() ?? 0); ?>-<?php echo e($products->lastItem() ?? 0); ?> of <?php echo e($products->total()); ?> products
                </p>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-500">Show:</span>
                <select onchange="window.location.href = '<?php echo e(request()->fullUrlWithQuery(['per_page' => ''])); ?>' + this.value" 
                        class="px-2 py-1 border border-gray-300 rounded text-sm">
                    <option value="10" <?php echo e(request('per_page', 15) == 10 ? 'selected' : ''); ?>>10</option>
                    <option value="15" <?php echo e(request('per_page', 15) == 15 ? 'selected' : ''); ?>>15</option>
                    <option value="25" <?php echo e(request('per_page', 15) == 25 ? 'selected' : ''); ?>>25</option>
                    <option value="50" <?php echo e(request('per_page', 15) == 50 ? 'selected' : ''); ?>>50</option>
                </select>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            #<?php echo e($product->id); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gray-100 rounded-lg mr-3 overflow-hidden flex items-center justify-center">
                                    <?php if($product->image): ?>
                                        <img src="<?php echo e(asset('storage/' . $product->image)); ?>" 
                                             alt="<?php echo e($product->name); ?>" 
                                             class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <i class="fas fa-box text-gray-400"></i>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900"><?php echo e($product->name); ?></p>
                                    <p class="text-xs text-gray-500 truncate max-w-xs">
                                        <?php echo e($product->short_description ?: Str::limit($product->description, 50)); ?>

                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php if($product->category == 'instan'): ?>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    <i class="fas fa-bolt mr-1"></i> Instan
                                </span>
                            <?php else: ?>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    <i class="fas fa-clock mr-1"></i> Non-Instan
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                <?php echo e($product->category_name); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <div class="font-medium">Rp <?php echo e(number_format($product->price, 0, ',', '.')); ?></div>
                            <?php if($product->discount_percent > 0): ?>
                                <small class="text-green-600">
                                    -<?php echo e($product->discount_percent); ?>%
                                </small>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                <?php echo e($product->stock > 10 ? 'bg-green-100 text-green-800' : 
                                   ($product->stock > 0 ? 'bg-yellow-100 text-yellow-800' : 
                                   'bg-red-100 text-red-800')); ?>">
                                <?php echo e($product->stock); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                <?php echo e($product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                <?php echo e($product->is_active ? 'Active' : 'Inactive'); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex gap-2">
                                <a href="<?php echo e(route('admin.products.show', $product->id)); ?>" 
                                   class="text-blue-600 hover:text-blue-900 p-1 rounded hover:bg-blue-50" 
                                   title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?php echo e(route('admin.products.edit', $product->id)); ?>" 
                                   class="text-yellow-600 hover:text-yellow-900 p-1 rounded hover:bg-yellow-50" 
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button onclick="showDeleteModal(<?php echo e($product->id); ?>, '<?php echo e(addslashes($product->name)); ?>')"
                                        class="text-red-600 hover:text-red-900 p-1 rounded hover:bg-red-50" 
                                        title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                            <div class="py-8">
                                <i class="fas fa-box fa-2x text-gray-300 mb-2"></i>
                                <p class="text-gray-500">No products found</p>
                                <?php if(request()->anyFilled(['search', 'category_type', 'status', 'stock_filter', 'min_price', 'max_price'])): ?>
                                    <a href="<?php echo e(route('admin.products.index')); ?>" 
                                       class="inline-block mt-2 text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-times mr-1"></i> Clear filters to see all products
                                    </a>
                                <?php else: ?>
                                    <a href="<?php echo e(route('admin.products.create')); ?>" 
                                       class="inline-block mt-2 text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-plus mr-1"></i> Add your first product
                                    </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <?php if($products->hasPages()): ?>
        <div class="px-6 py-4 border-t">
            <?php echo e($products->withQueryString()->links()); ?>

        </div>
        <?php endif; ?>
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
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" 
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
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

// Show/hide custom stock range
document.querySelector('select[name="stock_filter"]').addEventListener('change', function() {
    const customRange = document.getElementById('customStockRange');
    if (this.value === 'custom') {
        customRange.style.display = 'grid';
    } else {
        customRange.style.display = 'none';
    }
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    const stockFilter = document.querySelector('select[name="stock_filter"]');
    if (stockFilter && stockFilter.value === 'custom') {
        document.getElementById('customStockRange').style.display = 'grid';
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('pages.admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\IMAJI\revisiimaji\resources\views/pages/admin/products/index.blade.php ENDPATH**/ ?>