

<?php $__env->startSection('title', 'Create Promo Code'); ?>
<?php $__env->startSection('page-title', 'Create New Promo Code'); ?>
<?php $__env->startSection('page-description', 'Add a new discount code with detailed product assignment'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6">
            <form action="<?php echo e(route('admin.promos.store')); ?>" method="POST" id="promoForm">
                <?php echo csrf_field(); ?>
                
                <!-- Basic Information -->
                <div class="mb-8 pb-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Code Field -->
                        <div>
                            <label for="code" class="block text-sm font-medium text-gray-700 mb-1">
                                Promo Code <span class="text-gray-400 text-xs">(auto-generate jika kosong)</span>
                            </label>
                            <input type="text" 
                                   name="code" 
                                   id="code"
                                   value="<?php echo e(old('code')); ?>"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="e.g., SUMMER50">
                            <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Name Field -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                Promo Name *
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name"
                                   value="<?php echo e(old('name')); ?>"
                                   required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="e.g., Summer Sale Discount">
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                <!-- Discount Details -->
                <div class="mb-8 pb-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Discount Details</h3>
                    
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Type Field -->
                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700 mb-1">
                                    Discount Type *
                                </label>
                                <select name="type" 
                                        id="type"
                                        required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Type</option>
                                    <option value="percentage" <?php echo e(old('type') == 'percentage' ? 'selected' : ''); ?>>Percentage (%)</option>
                                    <option value="nominal" <?php echo e(old('type') == 'nominal' ? 'selected' : ''); ?>>Nominal (Rp)</option>
                                </select>
                                <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Value Field -->
                            <div>
                                <label for="value" class="block text-sm font-medium text-gray-700 mb-1">
                                    Discount Value *
                                </label>
                                <div class="relative">
                                    <input type="number" 
                                           name="value" 
                                           id="value"
                                           step="0.01"
                                           min="0"
                                           value="<?php echo e(old('value')); ?>"
                                           required
                                           class="w-full pl-12 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="0.00">
                                    <div class="absolute left-0 top-0 h-full flex items-center px-3 border-r border-gray-300 bg-gray-50 rounded-l-lg">
                                        <span id="value-prefix" class="text-gray-500">
                                            <?php echo e(old('type') == 'percentage' ? '%' : 'Rp'); ?>

                                        </span>
                                    </div>
                                </div>
                                <?php $__errorArgs = ['value'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <!-- Max Discount (for percentage type) -->
                        <div id="max-discount-container" class="<?php echo e(old('type') == 'percentage' ? '' : 'hidden'); ?>">
                            <label for="max_discount" class="block text-sm font-medium text-gray-700 mb-1">
                                Maximum Discount (Rp)
                            </label>
                            <input type="number" 
                                   name="max_discount" 
                                   id="max_discount"
                                   step="0.01"
                                   min="0"
                                   value="<?php echo e(old('max_discount')); ?>"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="e.g., 50000">
                            <p class="mt-1 text-xs text-gray-500">Maximum discount amount (for percentage type only)</p>
                            <?php $__errorArgs = ['max_discount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Minimum Purchase -->
                        <div>
                            <label for="min_purchase" class="block text-sm font-medium text-gray-700 mb-1">
                                Minimum Purchase (Rp)
                            </label>
                            <input type="number" 
                                   name="min_purchase" 
                                   id="min_purchase"
                                   step="0.01"
                                   min="0"
                                   value="<?php echo e(old('min_purchase')); ?>"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="0.00">
                            <?php $__errorArgs = ['min_purchase'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                <!-- Product Assignment -->
                <div class="mb-8 pb-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Product Assignment</h3>
                    
                    <!-- Assignment Type -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Select which products this promo applies to *
                        </label>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <?php $__currentLoopData = [
                                'all' => ['icon' => '🛒', 'title' => 'All Products', 'desc' => 'Apply to all active products'],
                                'specific_products' => ['icon' => '🎯', 'title' => 'Specific Products', 'desc' => 'Select specific products'],
                                'category_based' => ['icon' => '📁', 'title' => 'By Category', 'desc' => 'Select by product category'],
                                'price_range' => ['icon' => '💰', 'title' => 'By Price Range', 'desc' => 'Filter by product price'],
                                'stock_based' => ['icon' => '📦', 'title' => 'By Stock Status', 'desc' => 'Filter by stock availability']
                            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <label class="relative flex cursor-pointer">
                                    <input type="radio" 
                                           name="product_assignment_type" 
                                           value="<?php echo e($type); ?>"
                                           <?php echo e(old('product_assignment_type', 'all') == $type ? 'checked' : ''); ?>

                                           class="sr-only peer">
                                    <div class="w-full p-4 border-2 border-gray-200 rounded-lg peer-checked:border-blue-500 peer-checked:bg-blue-50 transition">
                                        <div class="flex items-start">
                                            <div class="text-2xl mr-3"><?php echo e($info['icon']); ?></div>
                                            <div>
                                                <div class="font-medium text-gray-900"><?php echo e($info['title']); ?></div>
                                                <div class="text-sm text-gray-500 mt-1"><?php echo e($info['desc']); ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <?php $__errorArgs = ['product_assignment_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Specific Products Section -->
                    <div id="specific-products-section" class="mt-6 <?php echo e(old('product_assignment_type') == 'specific_products' ? '' : 'hidden'); ?>">
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Select Specific Products
                        </label>
                        
                        <div class="border border-gray-300 rounded-lg overflow-hidden">
                            <div class="max-h-60 overflow-y-auto p-4">
                                <div class="space-y-2">
                                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <label class="flex items-center p-2 hover:bg-gray-50 rounded">
                                            <input type="checkbox"
                                                   name="specific_product_ids[]"
                                                   value="<?php echo e($product->id); ?>"
                                                   <?php echo e(in_array($product->id, old('specific_product_ids', [])) ? 'checked' : ''); ?>

                                                   class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                                            <div class="ml-3">
                                                <span class="text-sm font-medium text-gray-700"><?php echo e($product->name); ?></span>
                                                <div class="text-xs text-gray-500">
                                                    <?php echo e($product->category_name); ?> • Rp <?php echo e(number_format($product->price, 0, ',', '.')); ?>

                                                    <?php if($product->stock > 0): ?>
                                                        • Stock: <?php echo e($product->stock); ?>

                                                    <?php else: ?>
                                                        • <span class="text-red-500">Out of stock</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </label>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Product Discount Type -->
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Discount for Specific Products
                            </label>
                            <div class="flex items-center space-x-4">
                                <label class="flex items-center">
                                    <input type="radio" 
                                           name="product_discount_type" 
                                           value="same_as_promo"
                                           <?php echo e(old('product_discount_type', 'same_as_promo') == 'same_as_promo' ? 'checked' : ''); ?>

                                           class="h-4 w-4 text-blue-600 border-gray-300">
                                    <span class="ml-2 text-sm text-gray-700">Same as promo discount</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" 
                                           name="product_discount_type" 
                                           value="custom"
                                           <?php echo e(old('product_discount_type') == 'custom' ? 'checked' : ''); ?>

                                           class="h-4 w-4 text-blue-600 border-gray-300">
                                    <span class="ml-2 text-sm text-gray-700">Custom discount per product</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Category Based Section -->
                    <div id="category-based-section" class="mt-6 <?php echo e(old('product_assignment_type') == 'category_based' ? '' : 'hidden'); ?>">
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Select Categories
                        </label>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50">
                                    <input type="checkbox"
                                           name="category_ids[]"
                                           value="<?php echo e($category->id); ?>"
                                           <?php echo e(in_array($category->id, old('category_ids', [])) ? 'checked' : ''); ?>

                                           class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                                    <div class="ml-3">
                                        <span class="text-sm font-medium text-gray-700"><?php echo e($category->name); ?></span>
                                        <div class="text-xs text-gray-500"><?php echo e($category->products_count ?? 0); ?> products</div>
                                    </div>
                                </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <!-- Price Range Section -->
                    <div id="price-range-section" class="mt-6 <?php echo e(old('product_assignment_type') == 'price_range' ? '' : 'hidden'); ?>">
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Price Range Filter
                        </label>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="min_product_price" class="block text-sm font-medium text-gray-700 mb-1">
                                    Minimum Price (Rp)
                                </label>
                                <input type="number"
                                       name="min_product_price"
                                       id="min_product_price"
                                       step="0.01"
                                       min="0"
                                       value="<?php echo e(old('min_product_price')); ?>"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg"
                                       placeholder="e.g., 10000">
                            </div>
                            
                            <div>
                                <label for="max_product_price" class="block text-sm font-medium text-gray-700 mb-1">
                                    Maximum Price (Rp)
                                </label>
                                <input type="number"
                                       name="max_product_price"
                                       id="max_product_price"
                                       step="0.01"
                                       min="0"
                                       value="<?php echo e(old('max_product_price')); ?>"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg"
                                       placeholder="e.g., 1000000">
                            </div>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">Leave empty for no limit</p>
                    </div>

                    <!-- Stock Based Section -->
                    <div id="stock-based-section" class="mt-6 <?php echo e(old('product_assignment_type') == 'stock_based' ? '' : 'hidden'); ?>">
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Stock Status Filter
                        </label>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <?php $__currentLoopData = [
                                'any' => ['title' => 'Any Stock', 'desc' => 'All products'],
                                'in_stock' => ['title' => 'In Stock', 'desc' => 'Stock > 0'],
                                'low_stock' => ['title' => 'Low Stock', 'desc' => 'Stock ≤ 10'],
                                'out_of_stock' => ['title' => 'Out of Stock', 'desc' => 'Stock = 0']
                            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <label class="relative flex cursor-pointer">
                                    <input type="radio"
                                           name="stock_filter"
                                           value="<?php echo e($value); ?>"
                                           <?php echo e(old('stock_filter', 'any') == $value ? 'checked' : ''); ?>

                                           class="sr-only peer">
                                    <div class="w-full p-4 border-2 border-gray-200 rounded-lg peer-checked:border-blue-500 peer-checked:bg-blue-50">
                                        <div class="font-medium text-gray-900"><?php echo e($info['title']); ?></div>
                                        <div class="text-xs text-gray-500 mt-1"><?php echo e($info['desc']); ?></div>
                                    </div>
                                </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>

                <!-- Usage & Validity -->
                <div class="mb-8 pb-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Usage & Validity</h3>
                    
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Quota -->
                            <div>
                                <label for="quota" class="block text-sm font-medium text-gray-700 mb-1">
                                    Usage Quota *
                                </label>
                                <input type="number" 
                                       name="quota" 
                                       id="quota"
                                       min="1"
                                       value="<?php echo e(old('quota', 100)); ?>"
                                       required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                <p class="mt-1 text-xs text-gray-500">Maximum total usage</p>
                            </div>

                            <!-- Usage Limit Per User -->
                            <div>
                                <label for="usage_limit_per_user" class="block text-sm font-medium text-gray-700 mb-1">
                                    Limit Per User
                                </label>
                                <input type="number" 
                                       name="usage_limit_per_user" 
                                       id="usage_limit_per_user"
                                       min="1"
                                       value="<?php echo e(old('usage_limit_per_user')); ?>"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg"
                                       placeholder="No limit if empty">
                                <p class="mt-1 text-xs text-gray-500">Max usage per customer</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Valid From -->
                            <div>
                                <label for="valid_from" class="block text-sm font-medium text-gray-700 mb-1">
                                    Valid From *
                                </label>
                                <input type="datetime-local" 
                                       name="valid_from" 
                                       id="valid_from"
                                       value="<?php echo e(old('valid_from')); ?>"
                                       required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            </div>

                            <!-- Valid Until -->
                            <div>
                                <label for="valid_until" class="block text-sm font-medium text-gray-700 mb-1">
                                    Valid Until *
                                </label>
                                <input type="datetime-local" 
                                       name="valid_until" 
                                       id="valid_until"
                                       value="<?php echo e(old('valid_until')); ?>"
                                       required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            </div>
                        </div>

                        <!-- Advanced Options -->
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <input type="checkbox" 
                                       name="is_active" 
                                       id="is_active"
                                       value="1"
                                       <?php echo e(old('is_active', true) ? 'checked' : ''); ?>

                                       class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                                <label for="is_active" class="ml-2 block text-sm text-gray-700">
                                    Activate immediately
                                </label>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" 
                                       name="is_exclusive" 
                                       id="is_exclusive"
                                       value="1"
                                       <?php echo e(old('is_exclusive') ? 'checked' : ''); ?>

                                       class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                                <label for="is_exclusive" class="ml-2 block text-sm text-gray-700">
                                    Exclusive promo (cannot be combined with other promos)
                                </label>
                            </div>

                            <div>
                                <label for="priority" class="block text-sm font-medium text-gray-700 mb-1">
                                    Priority Level
                                </label>
                                <select name="priority" 
                                        id="priority"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                    <?php for($i = 0; $i <= 10; $i++): ?>
                                        <option value="<?php echo e($i); ?>" <?php echo e(old('priority', 0) == $i ? 'selected' : ''); ?>>
                                            <?php echo e($i); ?> <?php echo e($i == 0 ? '(Normal)' : ''); ?>

                                        </option>
                                    <?php endfor; ?>
                                </select>
                                <p class="mt-1 text-xs text-gray-500">Higher priority = applied first when multiple promos available</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-3">
                    <a href="<?php echo e(route('admin.promos.index')); ?>" 
                       class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                        Create Promo Code
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Update value prefix based on type selection
    document.getElementById('type').addEventListener('change', function() {
        const prefix = this.value === 'percentage' ? '%' : 'Rp';
        document.getElementById('value-prefix').textContent = prefix;
        
        // Show/hide max discount field
        const maxDiscountContainer = document.getElementById('max-discount-container');
        if (this.value === 'percentage') {
            maxDiscountContainer.classList.remove('hidden');
        } else {
            maxDiscountContainer.classList.add('hidden');
            document.getElementById('max_discount').value = '';
        }
    });

    // Show/hide product assignment sections
    const assignmentRadios = document.querySelectorAll('input[name="product_assignment_type"]');
    const sections = {
        'specific_products': document.getElementById('specific-products-section'),
        'category_based': document.getElementById('category-based-section'),
        'price_range': document.getElementById('price-range-section'),
        'stock_based': document.getElementById('stock-based-section')
    };

    function showAssignmentSection(type) {
        // Hide all sections first
        Object.values(sections).forEach(section => {
            if (section) section.classList.add('hidden');
        });
        
        // Show selected section
        if (sections[type]) {
            sections[type].classList.remove('hidden');
        }
    }

    // Add event listeners to assignment radios
    assignmentRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            showAssignmentSection(this.value);
        });
    });

    // Set default dates
    document.addEventListener('DOMContentLoaded', function() {
        const now = new Date();
        const thirtyDaysLater = new Date();
        thirtyDaysLater.setDate(thirtyDaysLater.getDate() + 30);
        
        // Format to YYYY-MM-DDTHH:mm
        const formatDate = (date) => {
            return date.toISOString().slice(0, 16);
        };
        
        // Set default dates if not already set
        if (!document.getElementById('valid_from').value) {
            document.getElementById('valid_from').value = formatDate(now);
        }
        
        if (!document.getElementById('valid_until').value) {
            document.getElementById('valid_until').value = formatDate(thirtyDaysLater);
        }

        // Trigger initial type change
        const typeSelect = document.getElementById('type');
        if (typeSelect.value) {
            typeSelect.dispatchEvent(new Event('change'));
        }

        // Show initial assignment section
        const selectedAssignment = document.querySelector('input[name="product_assignment_type"]:checked');
        if (selectedAssignment) {
            showAssignmentSection(selectedAssignment.value);
        }
    });

    // Form validation
    document.getElementById('promoForm').addEventListener('submit', function(e) {
        const minPrice = document.getElementById('min_product_price').value;
        const maxPrice = document.getElementById('max_product_price').value;
        
        if (minPrice && maxPrice && parseFloat(minPrice) > parseFloat(maxPrice)) {
            e.preventDefault();
            alert('Minimum price cannot be greater than maximum price.');
            document.getElementById('min_product_price').focus();
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('pages.admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\revisiimaji\resources\views/pages/admin/promos/create.blade.php ENDPATH**/ ?>