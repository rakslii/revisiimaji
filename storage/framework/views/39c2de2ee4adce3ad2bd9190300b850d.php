

<?php $__env->startSection('title', 'Edit Product'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
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

    <!-- Active Category Type Menu -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b">
            <h2 class="text-lg font-semibold text-gray-800">Category Type</h2>
        </div>
        <div class="p-6">
            <div class="flex space-x-4">
                <div class="flex-1 p-4 border-2 rounded-lg text-center
                    <?php echo e($product->category == 'instan' ? 'border-blue-500 bg-blue-50' : 'border-gray-200 bg-gray-50 opacity-75'); ?>">
                    <div class="flex flex-col items-center">
                        <div class="w-12 h-12 rounded-full <?php echo e($product->category == 'instan' ? 'bg-blue-200' : 'bg-gray-200'); ?> flex items-center justify-center mb-2">
                            <i class="fas fa-bolt text-xl <?php echo e($product->category == 'instan' ? 'text-blue-700' : 'text-gray-500'); ?>"></i>
                        </div>
                        <span class="font-semibold <?php echo e($product->category == 'instan' ? 'text-blue-700' : 'text-gray-500'); ?>">Instan</span>
                        <span class="text-xs text-gray-500 mt-1">Produk cepat saji</span>
                        <?php if($product->category == 'instan'): ?>
                            <span class="mt-2 text-xs bg-blue-600 text-white px-2 py-1 rounded-full">Active</span>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="flex-1 p-4 border-2 rounded-lg text-center
                    <?php echo e($product->category == 'non-instan' ? 'border-green-500 bg-green-50' : 'border-gray-200 bg-gray-50 opacity-75'); ?>">
                    <div class="flex flex-col items-center">
                        <div class="w-12 h-12 rounded-full <?php echo e($product->category == 'non-instan' ? 'bg-green-200' : 'bg-gray-200'); ?> flex items-center justify-center mb-2">
                            <i class="fas fa-clock text-xl <?php echo e($product->category == 'non-instan' ? 'text-green-700' : 'text-gray-500'); ?>"></i>
                        </div>
                        <span class="font-semibold <?php echo e($product->category == 'non-instan' ? 'text-green-700' : 'text-gray-500'); ?>">Non-Instan</span>
                        <span class="text-xs text-gray-500 mt-1">Produk custom</span>
                        <?php if($product->category == 'non-instan'): ?>
                            <span class="mt-2 text-xs bg-green-600 text-white px-2 py-1 rounded-full">Active</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow p-6">
                <form action="<?php echo e(route('admin.products.update', $product->id)); ?>" method="POST" enctype="multipart/form-data" id="productForm">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <!-- Hidden field untuk category type -->
                    <input type="hidden" name="category_type" value="<?php echo e($product->category); ?>">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div class="space-y-4">
                            <!-- Product Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
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
                                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Price -->
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700 mb-1">
                                    Price *
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                                    <input type="number"
                                           id="price"
                                           name="price"
                                           value="<?php echo e(old('price', $product->price)); ?>"
                                           min="0"
                                           step="1"
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
                                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Discount -->
                            <div>
                                <label for="discount_percent" class="block text-sm font-medium text-gray-700 mb-1">
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
                                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-4">
                            <!-- Category Selection -->
                            <div id="categorySelection">
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Select Category *
                                </label>

                                <!-- Search Box -->
                                <div class="mb-3 relative">
                                    <input type="text"
                                           id="categorySearch"
                                           placeholder="Search categories..."
                                           class="w-full px-3 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    <button type="button"
                                            id="clearSearch"
                                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 hidden">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>

                                <!-- Category Count -->
                                <div class="text-xs text-gray-500 mb-2">
                                    <span id="categoryCount">0</span> categories found
                                </div>

                                <div id="categoryOptions" class="space-y-3 max-h-80 overflow-y-auto p-3 border border-gray-300 rounded-lg bg-gray-50">
                                    <!-- Categories will be loaded here via JavaScript -->
                                    <div class="text-center p-6 text-gray-500">
                                        <i class="fas fa-spinner fa-spin text-xl mb-3"></i>
                                        <p>Loading categories...</p>
                                    </div>
                                </div>

                                <input type="hidden" name="category_id" id="selected_category_id" value="<?php echo e(old('category_id', $product->category_id)); ?>">

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

                                <div id="selectedCategoryInfo" class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded-lg <?php echo e($product->category_id ? '' : 'hidden'); ?>">
                                    <div class="flex items-center">
                                        <i class="fas fa-check-circle text-blue-600 mr-2"></i>
                                        <span id="selectedCategoryName" class="font-medium text-blue-800">
                                            <?php echo e($product->productCategory->name ?? ''); ?>

                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Stock -->
                            <div>
                                <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">
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
                                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Min Order -->
                            <div>
                                <label for="min_order" class="block text-sm font-medium text-gray-700 mb-1">
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
                                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>

                    <!-- Image Management Section -->
                    <div class="mt-6 space-y-6">
                        <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Product Images</h3>

                        <!-- Main Image -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">
                                    Main Product Image
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
                                <p class="mt-1 text-xs text-gray-500">Leave empty to keep current image</p>
                                <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                
                                <?php if($product->image): ?>
                                <div class="mt-3 flex items-center gap-3">
                                    <img src="<?php echo e(asset('storage/' . $product->image)); ?>" 
                                         alt="Current" 
                                         class="w-20 h-20 object-cover rounded-lg border">
                                    <div class="flex items-center">
                                        <input type="checkbox" 
                                               name="remove_image" 
                                               id="remove_image" 
                                               value="1"
                                               class="h-4 w-4 text-red-600 border-gray-300 rounded">
                                        <label for="remove_image" class="ml-2 text-xs text-red-600">
                                            Remove current image
                                        </label>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>

                            <!-- Image Preview -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">New Image Preview</label>
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 h-48 flex items-center justify-center bg-gray-50">
                                    <img id="imagePreview" src="" alt="Preview" class="max-h-full max-w-full rounded-lg hidden">
                                    <div id="noImagePreview" class="text-gray-400 text-center">
                                        <i class="fas fa-image text-3xl mb-2"></i>
                                        <p class="text-sm">New image preview</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Images (image_1 to image_4) -->
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Additional Product Images
                            </label>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                <?php for($i = 1; $i <= 4; $i++): ?>
                                    <?php
                                        $field = "image_{$i}";
                                        $currentImage = $product->$field;
                                    ?>
                                    <div>
                                        <label for="image_<?php echo e($i); ?>" class="block text-sm font-medium text-gray-700 mb-1">
                                            Image <?php echo e($i); ?>

                                        </label>
                                        <input type="file"
                                               id="image_<?php echo e($i); ?>"
                                               name="image_<?php echo e($i); ?>"
                                               accept="image/*"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        
                                        <?php if($currentImage): ?>
                                        <div class="mt-2">
                                            <div class="flex items-center gap-2">
                                                <img src="<?php echo e(asset('storage/' . $currentImage)); ?>" 
                                                     alt="Current" 
                                                     class="w-16 h-16 object-cover rounded-lg border">
                                                <div class="flex items-center">
                                                    <input type="checkbox" 
                                                           name="remove_image_<?php echo e($i); ?>" 
                                                           id="remove_image_<?php echo e($i); ?>" 
                                                           value="1"
                                                           class="h-4 w-4 text-red-600 border-gray-300 rounded">
                                                    <label for="remove_image_<?php echo e($i); ?>" class="ml-2 text-xs text-red-600">
                                                        Remove
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                        
                                        <div class="mt-2 h-16 border border-dashed border-gray-200 rounded-lg flex items-center justify-center bg-gray-50 image-preview-container"
                                             data-preview="preview_<?php echo e($i); ?>">
                                            <img id="preview_<?php echo e($i); ?>" class="hidden max-h-full max-w-full rounded-lg">
                                        </div>
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Description Section -->
                    <div class="mt-6 space-y-4">
                        <!-- Short Description -->
                        <div>
                            <label for="short_description" class="block text-sm font-medium text-gray-700 mb-1">
                                Short Description
                            </label>
                            <input type="text"
                                   id="short_description"
                                   name="short_description"
                                   value="<?php echo e(old('short_description', $product->short_description)); ?>"
                                   maxlength="255"
                                   placeholder="Brief description of the product"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['short_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <p class="mt-1 text-xs text-gray-500">Brief description, max 255 characters.</p>
                            <?php $__errorArgs = ['short_description'];
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

                        <!-- Full Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                                Full Description
                            </label>
                            <textarea id="description"
                                      name="description"
                                      rows="4"
                                      placeholder="Detailed description of the product..."
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
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <!-- Specifications Section -->
                    <div class="mt-6">
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
                            ?>
                            
                            <?php $__currentLoopData = $specifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $spec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="specification-item border border-gray-200 rounded-lg p-4">
                                <div class="flex justify-between items-center mb-3">
                                    <span class="text-sm font-medium text-gray-700">Specification #<?php echo e($loop->iteration); ?></span>
                                    <?php if($loop->iteration > 1 || (!empty($spec['key']) || !empty($spec['value']))): ?>
                                    <button type="button" 
                                            onclick="removeSpecification(this)" 
                                            class="text-red-600 hover:text-red-800 text-sm">
                                        <i class="fas fa-trash"></i> Remove
                                    </button>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Key / Title</label>
                                        <input type="text" 
                                               name="specifications[<?php echo e($index); ?>][key]" 
                                               value="<?php echo e($spec['key'] ?? ''); ?>"
                                               placeholder="e.g., Material, Size, Weight"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Value / Description</label>
                                        <input type="text" 
                                               name="specifications[<?php echo e($index); ?>][value]" 
                                               value="<?php echo e($spec['value'] ?? ''); ?>"
                                               placeholder="e.g., High Quality Paper, A4, 100gr"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>
                                </div>
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

                    <!-- Active Status -->
                    <div class="mt-6 flex items-center p-3 bg-gray-50 rounded-lg">
                        <input type="checkbox"
                               id="is_active"
                               name="is_active"
                               value="1"
                               <?php echo e(old('is_active', $product->is_active) ? 'checked' : ''); ?>

                               class="h-5 w-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="is_active" class="ml-3 text-sm text-gray-700 font-medium">
                            Active Product
                        </label>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="mt-8 flex justify-end gap-3">
                        <a href="<?php echo e(route('admin.products.index')); ?>"
                           class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition">
                            Cancel
                        </a>
                        <button type="submit"
                                class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center gap-2 font-medium transition">
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
                                <i class="fas fa-images text-purple-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Total Images</p>
                                <p class="text-lg font-bold text-gray-800">
                                    <?php
                                        $imageCount = 0;
                                        if ($product->image) $imageCount++;
                                        for ($i = 1; $i <= 4; $i++) {
                                            $field = "image_{$i}";
                                            if ($product->$field) $imageCount++;
                                        }
                                    ?>
                                    <?php echo e($imageCount); ?>

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
                                    <?php if($product->created_at): ?>
                                        <?php echo e($product->created_at->format('d M Y')); ?>

                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
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
                    <?php
                        $allImages = [];
                        
                        if ($product->image) {
                            $allImages[] = $product->image;
                        }
                        
                        for ($i = 1; $i <= 4; $i++) {
                            $field = "image_{$i}";
                            if ($product->$field) {
                                $allImages[] = $product->$field;
                            }
                        }
                    ?>
                    
                    <?php if(count($allImages) > 0): ?>
                        <div class="grid grid-cols-3 gap-3">
                            <?php $__currentLoopData = $allImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <img src="<?php echo e(asset('storage/' . $image)); ?>" 
                                     alt="Product image"
                                     class="w-full h-20 object-cover rounded-lg">
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <p class="text-gray-500 text-center py-4">No images available</p>
                    <?php endif; ?>
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
                        <span class="text-sm font-medium text-gray-800">
                            <?php echo e($product->productCategory->name ?? 'Unknown'); ?>

                        </span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Category Type</span>
                        <span class="text-sm text-gray-800">
                            <?php echo e(ucfirst($product->category)); ?>

                        </span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Last Updated</span>
                        <span class="text-sm text-gray-800">
                            <?php if($product->updated_at): ?>
                                <?php echo e($product->updated_at->format('d M Y H:i')); ?>

                            <?php else: ?>
                                N/A
                            <?php endif; ?>
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
            <p class="text-gray-700">
                Are you sure you want to delete "<strong><?php echo e($product->name); ?></strong>"?<br>
                <small class="text-red-600">This will delete ALL product images as well!</small>
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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Variable global untuk menyimpan categories
let allCategories = <?php echo json_encode($categories, 15, 512) ?>;
let currentType = "<?php echo e($product->category); ?>";
let selectedCategoryId = "<?php echo e($product->category_id); ?>";

// Initialize when page loads
document.addEventListener('DOMContentLoaded', function() {
    console.log('🔄 Edit product form initializing...');
    console.log('📦 Categories loaded:', allCategories.length, 'items');
    console.log('🎯 Current type:', currentType);
    console.log('🎯 Selected category ID:', selectedCategoryId);

    // Get DOM elements
    const categoryOptions = document.getElementById('categoryOptions');
    const selectedCategoryInput = document.getElementById('selected_category_id');
    const selectedCategoryInfo = document.getElementById('selectedCategoryInfo');
    const selectedCategoryName = document.getElementById('selectedCategoryName');
    const productForm = document.getElementById('productForm');

    // Image preview elements
    const mainImageInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');
    const noImagePreview = document.getElementById('noImagePreview');

    // Setup main image preview
    if (mainImageInput && imagePreview && noImagePreview) {
        mainImageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];

            if (file) {
                if (file.size > 5 * 1024 * 1024) {
                    showFormMessage('File size too large. Maximum size is 5MB.', 'error');
                    this.value = '';
                    return;
                }

                const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                if (!validTypes.includes(file.type)) {
                    showFormMessage('Invalid file type. Only JPG, PNG, GIF, and WebP are allowed.', 'error');
                    this.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.classList.remove('hidden');
                    noImagePreview.classList.add('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                imagePreview.src = '';
                imagePreview.classList.add('hidden');
                noImagePreview.classList.remove('hidden');
            }
        });
    }

    // Setup previews for additional images
    for (let i = 1; i <= 4; i++) {
        const input = document.getElementById('image_' + i);
        const preview = document.getElementById('preview_' + i);
        const container = document.querySelector('[data-preview="preview_' + i + '"]');

        if (input && container) {
            input.addEventListener('change', function(e) {
                const file = e.target.files[0];

                if (file) {
                    if (file.size > 5 * 1024 * 1024) {
                        showFormMessage('File size too large. Maximum size is 5MB.', 'error');
                        this.value = '';
                        return;
                    }

                    const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                    if (!validTypes.includes(file.type)) {
                        showFormMessage('Invalid file type. Only JPG, PNG, GIF, and WebP are allowed.', 'error');
                        this.value = '';
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        if (preview) {
                            preview.src = e.target.result;
                            preview.classList.remove('hidden');
                        }
                    };
                    reader.readAsDataURL(file);
                } else {
                    if (preview) {
                        preview.src = '';
                        preview.classList.add('hidden');
                    }
                }
            });
        }
    }

    // Render categories
    renderCategoriesWithFilter(currentType, '');

    // Setup search
    setupCategorySearch();

    // Form validation
    if (productForm) {
        productForm.addEventListener('submit', function(e) {
            const categorySelected = selectedCategoryInput ? selectedCategoryInput.value : '';

            if (!categorySelected) {
                e.preventDefault();
                showFormMessage('Please select a product category', 'error');
                document.getElementById('categorySelection').scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
                return false;
            }

            return true;
        });
    }

    // Add styling
    const style = document.createElement('style');
    style.textContent = `
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .category-card {
            transition: all 0.2s ease;
        }
        .category-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        #categoryOptions::-webkit-scrollbar {
            width: 6px;
        }
        #categoryOptions::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }
        #categoryOptions::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }
        #categoryOptions::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }
    `;
    document.head.appendChild(style);
});

// Fungsi untuk render kategori dengan filter search
function renderCategoriesWithFilter(type, searchTerm = '') {
    const categoryOptions = document.getElementById('categoryOptions');
    const selectedCategoryInput = document.getElementById('selected_category_id');
    const selectedCategoryInfo = document.getElementById('selectedCategoryInfo');
    const selectedCategoryName = document.getElementById('selectedCategoryName');
    
    if (!categoryOptions) return;
    
    // Filter categories by type
    let filteredByType = allCategories.filter(cat => cat.type === type);
    
    // Filter by search term if provided
    if (searchTerm.trim() !== '') {
        const term = searchTerm.toLowerCase();
        filteredByType = filteredByType.filter(cat => 
            cat.name.toLowerCase().includes(term) || 
            (cat.description && cat.description.toLowerCase().includes(term))
        );
    }
    
    // Update category count
    const countElement = document.getElementById('categoryCount');
    if (countElement) {
        countElement.textContent = filteredByType.length;
    }
    
    // Clear previous options
    categoryOptions.innerHTML = '';

    if (filteredByType.length === 0) {
        categoryOptions.innerHTML = `
            <div class="text-center p-6 text-gray-500 bg-gray-100 rounded-lg">
                <i class="fas fa-search text-2xl mb-3"></i>
                <p class="font-medium">No categories found</p>
                <p class="text-sm mt-1">Try a different search term</p>
                ${allCategories.filter(cat => cat.type === type).length > 0 ? 
                    `<button onclick="clearSearch()" class="mt-2 text-blue-600 hover:text-blue-800 text-sm">
                        <i class="fas fa-times mr-1"></i> Clear search
                    </button>` : 
                    `<p class="text-sm mt-2">No categories available for this type</p>`
                }
            </div>
        `;
        return;
    }

    // Create category cards
    filteredByType.forEach(category => {
        const categoryCard = document.createElement('div');
        categoryCard.className = 'category-card p-4 border border-gray-300 rounded-lg bg-white hover:bg-blue-50 hover:border-blue-400 cursor-pointer transition-all duration-200';
        categoryCard.dataset.categoryId = category.id;
        categoryCard.dataset.categoryName = category.name;

        const isSelected = selectedCategoryInput && selectedCategoryInput.value == category.id;
        const selectedClass = isSelected ? 'border-blue-500 bg-blue-100 ring-2 ring-blue-200' : '';
        const checkmarkClass = isSelected ? '' : 'opacity-0';

        categoryCard.className = `category-card p-4 border border-gray-300 rounded-lg bg-white hover:bg-blue-50 hover:border-blue-400 cursor-pointer transition-all duration-200 ${selectedClass}`;

        // Highlight search term if exists
        let displayName = category.name;
        if (searchTerm.trim() !== '') {
            const regex = new RegExp(`(${searchTerm})`, 'gi');
            displayName = category.name.replace(regex, '<span class="bg-yellow-200">$1</span>');
        }

        categoryCard.innerHTML = `
            <div class="flex items-center">
                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-3 flex-shrink-0">
                    <i class="${category.icon || 'fas fa-folder'} text-blue-600"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="font-semibold text-gray-800 truncate">${displayName}</h4>
                    <p class="text-sm text-gray-600 mt-1 line-clamp-2">${category.description || 'No description available'}</p>
                </div>
                <div class="checkmark ml-3 flex-shrink-0">
                    <i class="fas fa-check-circle text-blue-600 text-xl ${checkmarkClass}"></i>
                </div>
            </div>
        `;

        categoryCard.addEventListener('click', function() {
            const categoryId = this.dataset.categoryId;
            const categoryName = this.dataset.categoryName;

            console.log(`🎯 Category selected: ${categoryName} (ID: ${categoryId})`);

            document.querySelectorAll('.category-card').forEach(card => {
                card.classList.remove('border-blue-500', 'bg-blue-100', 'ring-2', 'ring-blue-200');
                card.querySelector('.fa-check-circle').classList.add('opacity-0');
            });

            this.classList.add('border-blue-500', 'bg-blue-100', 'ring-2', 'ring-blue-200');
            this.querySelector('.fa-check-circle').classList.remove('opacity-0');

            if (selectedCategoryInput) {
                selectedCategoryInput.value = categoryId;
            }

            if (selectedCategoryInfo && selectedCategoryName) {
                selectedCategoryName.textContent = `Selected: ${categoryName}`;
                selectedCategoryInfo.classList.remove('hidden');
            }

            this.classList.add('scale-[1.02]');
            setTimeout(() => {
                this.classList.remove('scale-[1.02]');
            }, 300);
        });

        categoryOptions.appendChild(categoryCard);
    });
}

// Fungsi untuk clear search
function clearSearch() {
    const searchInput = document.getElementById('categorySearch');
    const clearButton = document.getElementById('clearSearch');
    if (searchInput) {
        searchInput.value = '';
        clearButton.classList.add('hidden');
        renderCategoriesWithFilter(currentType, '');
    }
}

// Setup search functionality
function setupCategorySearch() {
    const searchInput = document.getElementById('categorySearch');
    const clearButton = document.getElementById('clearSearch');
    
    if (!searchInput) return;
    
    searchInput.addEventListener('input', function(e) {
        const searchTerm = e.target.value;
        
        // Show/hide clear button
        if (clearButton) {
            if (searchTerm.length > 0) {
                clearButton.classList.remove('hidden');
            } else {
                clearButton.classList.add('hidden');
            }
        }
        
        // Debounce search
        clearTimeout(window.searchTimeout);
        window.searchTimeout = setTimeout(() => {
            renderCategoriesWithFilter(currentType, searchTerm);
        }, 300);
    });
    
    if (clearButton) {
        clearButton.addEventListener('click', clearSearch);
    }
}

function showFormMessage(message, type = 'success') {
    const existingMessage = document.getElementById('formMessageContainer');
    if (existingMessage) existingMessage.remove();
    
    const messageContainer = document.createElement('div');
    messageContainer.id = 'formMessageContainer';
    messageContainer.className = `mb-4 p-3 rounded-lg ${
        type === 'success' ? 'bg-green-50 border border-green-200 text-green-700' : 
        'bg-red-50 border border-red-200 text-red-700'
    }`;
    messageContainer.innerHTML = `
        <div class="flex items-center">
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} mr-2"></i>
            <span>${message}</span>
        </div>
    `;
    
    const form = document.getElementById('productForm');
    if (form) {
        form.insertBefore(messageContainer, form.firstChild);
    }
    
    setTimeout(() => {
        if (messageContainer && messageContainer.parentNode) {
            messageContainer.remove();
        }
    }, 3000);
}

// Specifications Management
let specIndex = <?php echo e(count($specifications)); ?>;

function addSpecification() {
    const container = document.getElementById('specifications-container');
    const template = document.getElementById('specification-template').innerHTML;
    
    const newSpec = template.replace(/__INDEX__/g, specIndex);
    
    const div = document.createElement('div');
    div.innerHTML = newSpec;
    container.appendChild(div);
    
    specIndex++;
    updateSpecificationNumbers();
}

function removeSpecification(button) {
    const item = button.closest('.specification-item');
    const allItems = document.querySelectorAll('.specification-item');
    const inputs = item.querySelectorAll('input[type="text"]');
    const isEmpty = Array.from(inputs).every(input => input.value.trim() === '');
    
    if (allItems.length === 1 && isEmpty) {
        inputs.forEach(input => input.value = '');
        return;
    }
    
    item.remove();
    updateSpecificationNumbers();
    specIndex = document.querySelectorAll('.specification-item').length;
}

function updateSpecificationNumbers() {
    const items = document.querySelectorAll('.specification-item');
    
    items.forEach((item, index) => {
        const title = item.querySelector('.text-sm.font-medium');
        if (title) {
            title.textContent = `Specification #${index + 1}`;
        }
        
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

// Delete product modal
function showDeleteModal(productId) {
    const modal = document.getElementById('deleteModal');
    modal.classList.remove('hidden');
}

document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        this.classList.add('hidden');
    }
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    updateSpecificationNumbers();
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('pages.admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\revisiimaji\resources\views/pages/admin/products/edit.blade.php ENDPATH**/ ?>