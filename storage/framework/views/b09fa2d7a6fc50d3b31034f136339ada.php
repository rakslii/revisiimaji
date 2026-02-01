

<?php $__env->startSection('title', 'Create Promo Code'); ?>
<?php $__env->startSection('page-title', 'Create New Promo Code'); ?>
<?php $__env->startSection('page-description', 'Add a new discount code with product assignments'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .select2-container--default .select2-selection--multiple {
        min-height: 42px;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
    }
    .select2-container .select2-selection--multiple .select2-selection__rendered {
        padding: 0 8px;
    }
    .select2-container--default.select2-container--focus .select2-selection--multiple {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6">
            <form action="<?php echo e(route('admin.promos.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                
                <div class="space-y-6">
                    <!-- Code & Name -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Code Field -->
                        <div>
                            <label for="code" class="block text-sm font-medium text-gray-700 mb-1">
                                Promo Code <span class="text-xs text-gray-500">(auto-generate if empty)</span>
                            </label>
                            <input type="text" 
                                   name="code" 
                                   id="code"
                                   value="<?php echo e(old('code')); ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                   placeholder="e.g., DISCOUNT50">
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
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
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

                    <!-- Discount Type & Value -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Type Field -->
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 mb-1">
                                Discount Type *
                            </label>
                            <select name="type" 
                                    id="type"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
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
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span id="value-prefix" class="text-gray-500 sm:text-sm">
                                        <?php echo e(old('type') == 'percentage' ? '%' : 'Rp'); ?>

                                    </span>
                                </div>
                                <input type="number" 
                                       name="value" 
                                       id="value"
                                       step="0.01"
                                       min="0"
                                       value="<?php echo e(old('value')); ?>"
                                       required
                                       class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                       placeholder="0.00">
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

                    <!-- Quota & Min Purchase -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Quota Field -->
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
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                   placeholder="e.g., 100">
                            <p class="mt-1 text-xs text-gray-500">Maximum number of uses</p>
                            <?php $__errorArgs = ['quota'];
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
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                   placeholder="0.00">
                            <p class="mt-1 text-xs text-gray-500">Minimum purchase amount (optional)</p>
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

                    <!-- Product Assignment -->
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Product Assignment</h3>
                        </div>
                        
                        <!-- For All Products -->
                        <div class="mb-6">
                            <div class="flex items-center">
                                <input type="checkbox" 
                                       name="is_for_all_products" 
                                       id="is_for_all_products"
                                       value="1"
                                       <?php echo e(old('is_for_all_products') ? 'checked' : ''); ?>

                                       class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <label for="is_for_all_products" class="ml-2 block text-sm text-gray-900 font-medium">
                                    Apply to all products
                                </label>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">If checked, this promo will apply to all products regardless of selection below</p>
                        </div>

                        <!-- Product Selection (hidden if for all products) -->
                        <div id="product-selection-section" class="<?php echo e(old('is_for_all_products') ? 'hidden' : ''); ?>">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Select Specific Products
                            </label>
                            
                            <div class="mb-4">
                                <select name="product_ids[]" 
                                        id="product-select" 
                                        multiple 
                                        class="w-full px-3 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($product->id); ?>" 
                                                <?php echo e(in_array($product->id, old('product_ids', [])) ? 'selected' : ''); ?>>
                                            <?php echo e($product->name); ?> - Rp <?php echo e(number_format($product->price, 0, ',', '.')); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            
                            <!-- Product-specific discount override -->
                            <div id="product-discount-section" class="mt-4 p-4 bg-gray-50 rounded-lg">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Product-specific Discount (Optional)</h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label for="product_discount_type" class="block text-xs font-medium text-gray-600 mb-1">
                                            Override Type
                                        </label>
                                        <select name="product_discount_type" 
                                                id="product_discount_type"
                                                class="w-full px-3 py-2 text-sm border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">Same as promo</option>
                                            <option value="percentage" <?php echo e(old('product_discount_type') == 'percentage' ? 'selected' : ''); ?>>Percentage (%)</option>
                                            <option value="nominal" <?php echo e(old('product_discount_type') == 'nominal' ? 'selected' : ''); ?>>Nominal (Rp)</option>
                                        </select>
                                    </div>
                                    
                                    <div>
                                        <label for="product_discount_value" class="block text-xs font-medium text-gray-600 mb-1">
                                            Override Value
                                        </label>
                                        <input type="number" 
                                               name="product_discount_value" 
                                               id="product_discount_value"
                                               step="0.01"
                                               min="0"
                                               value="<?php echo e(old('product_discount_value')); ?>"
                                               class="w-full px-3 py-2 text-sm border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                               placeholder="Leave empty for promo value">
                                    </div>
                                    
                                    <div>
                                        <label for="max_usage_per_product" class="block text-xs font-medium text-gray-600 mb-1">
                                            Max Usage per Product
                                        </label>
                                        <input type="number" 
                                               name="max_usage_per_product" 
                                               id="max_usage_per_product"
                                               min="1"
                                               value="<?php echo e(old('max_usage_per_product')); ?>"
                                               class="w-full px-3 py-2 text-sm border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                               placeholder="Leave empty for no limit">
                                    </div>
                                </div>
                                <p class="mt-2 text-xs text-gray-500">
                                    These settings will apply to all selected products. Leave empty to use promo default.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Validity Period -->
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
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <?php $__errorArgs = ['valid_from'];
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
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <?php $__errorArgs = ['valid_until'];
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

                    <!-- Active Status -->
                    <div class="flex items-center">
                        <input type="checkbox" 
                               name="is_active" 
                               id="is_active"
                               value="1"
                               <?php echo e(old('is_active', true) ? 'checked' : ''); ?>

                               class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="is_active" class="ml-2 block text-sm text-gray-900">
                            Activate this promo code immediately
                        </label>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end space-x-3">
                    <a href="<?php echo e(route('admin.promos.index')); ?>" 
                       class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Create Promo Code
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    // Initialize Select2
    $(document).ready(function() {
        $('#product-select').select2({
            placeholder: 'Select products...',
            allowClear: true,
            width: '100%'
        });
    });

    // Update value prefix based on type selection
    document.getElementById('type').addEventListener('change', function() {
        const prefix = this.value === 'percentage' ? '%' : 'Rp';
        document.getElementById('value-prefix').textContent = prefix;
    });

    // Toggle product selection section
    document.getElementById('is_for_all_products').addEventListener('change', function() {
        const productSection = document.getElementById('product-selection-section');
        if (this.checked) {
            productSection.classList.add('hidden');
        } else {
            productSection.classList.remove('hidden');
        }
    });

    // Set default dates
    document.addEventListener('DOMContentLoaded', function() {
        const now = new Date();
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 30);
        
        // Format to YYYY-MM-DDTHH:mm
        const formatDate = (date) => {
            return date.toISOString().slice(0, 16);
        };
        
        if (!document.getElementById('valid_from').value) {
            document.getElementById('valid_from').value = formatDate(now);
        }
        
        if (!document.getElementById('valid_until').value) {
            document.getElementById('valid_until').value = formatDate(tomorrow);
        }

        // Trigger initial type change
        const typeSelect = document.getElementById('type');
        if (typeSelect.value) {
            typeSelect.dispatchEvent(new Event('change'));
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('pages.admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\revisiimaji\resources\views/pages/admin/promos/create.blade.php ENDPATH**/ ?>