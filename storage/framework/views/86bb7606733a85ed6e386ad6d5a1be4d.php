

<?php $__env->startSection('title', 'Edit Product'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Edit Product: <?php echo e($product->name); ?></h1>
            <p class="text-gray-600 mt-1">Update product details and information</p>
        </div>
        <div class="flex gap-2">
            <a href="<?php echo e(route('admin.products.index')); ?>" 
               class="flex items-center gap-2 bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
                <i class="fas fa-arrow-left"></i> Back to Products
            </a>
            <a href="<?php echo e(route('admin.products.show', $product->id)); ?>" 
               class="flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                <i class="fas fa-eye"></i> View
            </a>
        </div>
    </div>

    <!-- Error Messages -->
    <?php if($errors->any()): ?>
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
        <ul class="list-disc pl-5">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow p-6">
                <form action="<?php echo e(route('admin.products.update', $product->id)); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <!-- Product Name -->
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Product Name *
                        </label>
                        <input type="text"
                               id="name"
                               name="name"
                               value="<?php echo e(old('name', $product->name)); ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               required>
                        <?php $__errorArgs = ['name'];
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
                                       value="<?php echo e(old('price', $product->price)); ?>"
                                       min="0"
                                       step="1000"
                                       class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       required>
                            </div>
                            <?php $__errorArgs = ['price'];
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

                        <div>
                            <label for="discount_percent" class="block text-sm font-medium text-gray-700 mb-2">
                                Discount (%)
                            </label>
                            <input type="number"
                                   id="discount_percent"
                                   name="discount_percent"
                                   value="<?php echo e(old('discount_percent', $product->discount_percent)); ?>"
                                   min="0"
                                   max="100"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['discount_percent'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <?php $__errorArgs = ['discount_percent'];
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
                    </div>

                    <!-- Category & Stock -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Category *
                            </label>
                            <select id="category_id"
                                    name="category_id"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    required>
                                <option value="">Select Category</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>"
                                            <?php echo e((old('category_id', $product->category_id) == $category->id) ? 'selected' : ''); ?>>
                                        <?php echo e($category->name); ?> (<?php echo e($category->type); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['category_id'];
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

                        <div>
                            <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">
                                Stock *
                            </label>
                            <input type="number"
                                   id="stock"
                                   name="stock"
                                   value="<?php echo e(old('stock', $product->stock)); ?>"
                                   min="0"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['stock'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   required>
                            <?php $__errorArgs = ['stock'];
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
                    </div>

                    <!-- Short Description -->
                    <div class="mb-6">
                        <label for="short_description" class="block text-sm font-medium text-gray-700 mb-2">
                            Short Description
                        </label>
                        <input type="text"
                               id="short_description"
                               name="short_description"
                               value="<?php echo e(old('short_description', $product->short_description)); ?>"
                               maxlength="255"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['short_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <p class="mt-1 text-xs text-gray-500">Max 255 characters</p>
                        <?php $__errorArgs = ['short_description'];
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

                    <!-- Full Description -->
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Full Description
                        </label>
                        <textarea id="description"
                                  name="description"
                                  rows="4"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('description', $product->description)); ?></textarea>
                        <?php $__errorArgs = ['description'];
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
        <?php
            // Decode specifications dari database
            $specifications = old('specifications', $product->specifications ?? []);
            
            // Jika specifications kosong, buat satu field kosong
            if (empty($specifications)) {
                $specifications = [['key' => '', 'value' => '']];
            }
        ?>
        
        <?php $__currentLoopData = $specifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $spec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="specification-item border border-gray-200 rounded-lg p-4">
            <div class="flex justify-between items-center mb-3">
                <span class="text-sm font-medium text-gray-700">Specification #<?php echo e($index + 1); ?></span>
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
                           name="specifications[<?php echo e($index); ?>][key]" 
                           value="<?php echo e(old("specifications.{$index}.key", $spec['key'] ?? '')); ?>"
                           placeholder="e.g., Material, Size, Weight"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Value / Description</label>
                    <input type="text" 
                           name="specifications[<?php echo e($index); ?>][value]" 
                           value="<?php echo e(old("specifications.{$index}.value", $spec['value'] ?? '')); ?>"
                           placeholder="e.g., High Quality Paper, A4, 100gr"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>
            
            <!-- Hidden field untuk menyimpan index asli -->
            <input type="hidden" name="specifications[<?php echo e($index); ?>][id]" value="<?php echo e($spec['id'] ?? ''); ?>">
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                    <!-- Min Order & Image -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="min_order" class="block text-sm font-medium text-gray-700 mb-2">
                                Minimum Order
                            </label>
                            <input type="number"
                                   id="min_order"
                                   name="min_order"
                                   value="<?php echo e(old('min_order', $product->min_order)); ?>"
                                   min="1"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['min_order'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <?php $__errorArgs = ['min_order'];
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

                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                                Product Image
                            </label>
                            <input type="file"
                                   id="image"
                                   name="image"
                                   accept="image/*"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <?php if($product->image): ?>
                                <div class="mt-3">
                                    <p class="text-sm text-gray-500 mb-1">Current Image</p>
                                    <div class="flex items-center gap-3">
                                        <img src="<?php echo e(asset('storage/' . $product->image)); ?>"
                                             alt="<?php echo e($product->name); ?>"
                                             class="w-20 h-20 object-cover rounded-lg border">
                                        <div>
                                            <p class="text-sm text-gray-600"><?php echo e(basename($product->image)); ?></p>
                                            <div class="flex items-center">
                                                <input type="checkbox" 
                                                       name="remove_image" 
                                                       id="remove-image-checkbox"
                                                       value="1"
                                                       class="h-4 w-4 text-red-600 border-gray-300 rounded">
                                                <label for="remove-image-checkbox" class="ml-2 text-xs text-red-600 hover:text-red-800 cursor-pointer">
                                                    <i class="fas fa-trash mr-1"></i> Remove image
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <p class="mt-1 text-xs text-gray-500">Leave empty to keep current image</p>
                            <?php $__errorArgs = ['image'];
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
                    </div>

                    <!-- Active Status -->
                    <div class="mb-8">
                        <div class="flex items-center">
                            <input type="checkbox"
                                   id="is_active"
                                   name="is_active"
                                   value="1"
                                   <?php echo e(old('is_active', $product->is_active) ? 'checked' : ''); ?>

                                   class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <label for="is_active" class="ml-2 text-sm text-gray-700">
                                Active Product
                            </label>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end gap-3">
                        <a href="<?php echo e(route('admin.products.index')); ?>"
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
                                <p class="text-lg font-bold text-gray-800"><?php echo e($product->sales_count ?? 0); ?></p>
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
                                    <?php echo e($product->stock > 10 ? 'text-green-600' : 
                                       ($product->stock > 0 ? 'text-yellow-600' : 'text-red-600')); ?>">
                                    <?php echo e($product->stock); ?> units
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="p-2 bg-purple-100 rounded-lg mr-3">
                                <i class="fas fa-calendar text-purple-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Created</p>
                                <p class="text-lg font-bold text-gray-800"><?php echo e($product->created_at->format('d M Y')); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b">
                    <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <a href="<?php echo e(route('admin.products.show', $product->id)); ?>"
                           class="flex items-center gap-2 text-blue-600 hover:text-blue-800">
                            <i class="fas fa-eye"></i>
                            <span>View Product Details</span>
                        </a>
                        
                        <button type="button"
                                onclick="showDeleteModal(<?php echo e($product->id); ?>)"
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
                <?php echo e($product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                <?php echo e($product->is_active ? 'Active' : 'Inactive'); ?>

            </span>
        </div>
        
        <div class="flex justify-between items-center">
            <span class="text-sm text-gray-600">Category</span>
            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                <!-- Gunakan salah satu dari ini -->
                <?php
                    // Pilihan 1: Jika category adalah string
                    if (is_string($product->category)) {
                        echo ucfirst($product->category);
                    }
                    // Pilihan 2: Jika ada relationship category
                    elseif ($product->categoryRelation && is_object($product->categoryRelation)) {
                        echo $product->categoryRelation->name;
                    }
                    // Pilihan 3: Jika tidak ada kategori
                    else {
                        echo 'No Category';
                    }
                ?>
            </span>
        </div>
        
        <div class="flex justify-between items-center">
            <span class="text-sm text-gray-600">Category Type</span>
            <span class="text-sm text-gray-800">
                <?php echo e(is_string($product->category) ? ucfirst($product->category) : 'Unknown'); ?>

            </span>
        </div>
        
        <div class="flex justify-between items-center">
            <span class="text-sm text-gray-600">Last Updated</span>
            <span class="text-sm text-gray-800"><?php echo e($product->updated_at->format('d M Y H:i')); ?></span>
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
            <p id="deleteModalBody" class="text-gray-700">
                Are you sure you want to delete "<strong><?php echo e($product->name); ?></strong>"? This action cannot be undone.
            </p>
        </div>
        <div class="px-6 py-4 border-t flex justify-end gap-3">
            <button type="button" 
                    onclick="document.getElementById('deleteModal').classList.add('hidden')"
                    class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">
                Cancel
            </button>
            <form id="deleteForm" action="<?php echo e(route('admin.products.destroy', $product->id)); ?>" method="POST" class="inline">
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
// Specifications Management
let specIndex = <?php echo e(count($specifications ?? [])); ?>;

function addSpecification() {
    const container = document.getElementById('specifications-container');
    const template = document.getElementById('specification-template').innerHTML;
    
    // Replace placeholder with current index
    const newSpec = template.replace(/__INDEX__/g, specIndex);
    
    // Create new element
    const div = document.createElement('div');
    div.innerHTML = newSpec;
    container.appendChild(div);
    
    // Update counter
    specIndex++;
}

function removeSpecification(button) {
    const item = button.closest('.specification-item');
    
    // Only remove if there's more than one specification
    const allItems = document.querySelectorAll('.specification-item');
    if (allItems.length > 1) {
        item.remove();
        // Renumber the remaining items
        renumberSpecifications();
    } else {
        // If only one left, just clear the inputs
        const inputs = item.querySelectorAll('input[type="text"]');
        inputs.forEach(input => input.value = '');
        alert('At least one specification field must remain. Fields have been cleared instead.');
    }
}

function renumberSpecifications() {
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

// Add validation for specifications
document.querySelector('form').addEventListener('submit', function(e) {
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
        // Optional: Add warning or prevent submit
        // alert('Please fill in at least one specification or remove all specification fields.');
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('pages.admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\revisiimaji\resources\views\pages\admin\products\edit.blade.php ENDPATH**/ ?>