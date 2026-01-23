

<?php $__env->startSection('title', 'Create New Product'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Create New Product</h1>
            <p class="text-gray-600 mt-1">Add a new product to your store</p>
        </div>
        <a href="<?php echo e(route('admin.products.index')); ?>"
           class="flex items-center gap-2 bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
            <i class="fas fa-arrow-left"></i> Back to Products
        </a>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="<?php echo e(route('admin.products.store')); ?>" method="POST" enctype="multipart/form-data" id="productForm">
            <?php echo csrf_field(); ?>

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
                               value="<?php echo e(old('name')); ?>"
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
                                   value="<?php echo e(old('price')); ?>"
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
                                   required
                                   placeholder="0">
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

                    <!-- STEP 1: Category Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Product Type *
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Instan Option -->
                            <label class="relative cursor-pointer group">
                                <input type="radio"
                                       name="category_type"
                                       value="instan"
                                       class="sr-only peer"
                                       <?php echo e(old('category_type') == 'instan' ? 'checked' : ''); ?>

                                       id="type_instan">
                                <div class="p-5 border-2 border-gray-300 rounded-xl text-center transition-all duration-300
                                            peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:ring-2 peer-checked:ring-blue-200
                                            group-hover:border-blue-300 group-hover:bg-blue-25">
                                    <div class="flex flex-col items-center">
                                        <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center mb-3
                                                    group-hover:bg-blue-200 peer-checked:bg-blue-200">
                                            <i class="fas fa-bolt text-xl text-blue-600"></i>
                                        </div>
                                        <h3 class="font-bold text-gray-800 text-lg">Instan</h3>
                                        <p class="text-sm text-gray-600 mt-2">Produk cepat saji</p>
                                        <div class="mt-3 text-blue-600 opacity-0 peer-checked:opacity-100 transition-opacity">
                                            <i class="fas fa-check-circle"></i> Dipilih
                                        </div>
                                    </div>
                                </div>
                            </label>

                            <!-- Non-Instan Option -->
                            <label class="relative cursor-pointer group">
                                <input type="radio"
                                       name="category_type"
                                       value="non-instan"
                                       class="sr-only peer"
                                       <?php echo e(old('category_type') == 'non-instan' ? 'checked' : ''); ?>

                                       id="type_non_instan">
                                <div class="p-5 border-2 border-gray-300 rounded-xl text-center transition-all duration-300
                                            peer-checked:border-green-500 peer-checked:bg-green-50 peer-checked:ring-2 peer-checked:ring-green-200
                                            group-hover:border-green-300 group-hover:bg-green-25">
                                    <div class="flex flex-col items-center">
                                        <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center mb-3
                                                    group-hover:bg-green-200 peer-checked:bg-green-200">
                                            <i class="fas fa-clock text-xl text-green-600"></i>
                                        </div>
                                        <h3 class="font-bold text-gray-800 text-lg">Non-Instan</h3>
                                        <p class="text-sm text-gray-600 mt-2">Produk custom</p>
                                        <div class="mt-3 text-green-600 opacity-0 peer-checked:opacity-100 transition-opacity">
                                            <i class="fas fa-check-circle"></i> Dipilih
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                        <?php $__errorArgs = ['category_type'];
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

                <!-- Right Column -->
                <div class="space-y-4">
                    <!-- STEP 2: Category Selection (Initially Hidden) -->
                    <div id="categorySelection" class="hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Select Category *
                        </label>
                        <div id="categoryOptions" class="space-y-3 max-h-80 overflow-y-auto p-3 border border-gray-200 rounded-lg bg-gray-50">
                            <!-- Categories will be loaded here via JavaScript -->
                            <div class="text-center p-6 text-gray-500">
                                <i class="fas fa-arrow-up text-xl mb-3"></i>
                                <p>Please select product type first</p>
                            </div>
                        </div>
                        <input type="hidden" name="category_id" id="selected_category_id" value="<?php echo e(old('category_id')); ?>">
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
                        <div id="selectedCategoryInfo" class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded-lg hidden">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-blue-600 mr-2"></i>
                                <span id="selectedCategoryName" class="font-medium text-blue-800"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Discount -->
                    <div>
                        <label for="discount_percent" class="block text-sm font-medium text-gray-700 mb-1">
                            Discount (%)
                        </label>
                        <input type="number"
                               id="discount_percent"
                               name="discount_percent"
                               value="<?php echo e(old('discount_percent', 0)); ?>"
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

                    <!-- Stock -->
                    <div>
                        <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">
                            Stock *
                        </label>
                        <input type="number"
                               id="stock"
                               name="stock"
                               value="<?php echo e(old('stock', 0)); ?>"
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
                               value="<?php echo e(old('min_order', 1)); ?>"
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

                <!-- Main Images -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Main Image (Primary) -->
                    <div>
                        <label for="main_image" class="block text-sm font-medium text-gray-700 mb-1">
                            Primary Image (Recommended)
                        </label>
                        <input type="file"
                               id="main_image"
                               name="main_image"
                               accept="image/*"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['main_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <p class="mt-1 text-xs text-gray-500">Will be used as the main display image</p>
                        <?php $__errorArgs = ['main_image'];
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

                    <!-- Legacy Main Image (Backward Compatibility) -->
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-1">
                            Legacy Main Image *
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
unset($__errorArgs, $__bag); ?>"
                               required>
                        <p class="mt-1 text-xs text-gray-500">Required for backward compatibility</p>
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
                    </div>
                </div>

                <!-- Image Preview -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Primary Image Preview</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 h-48 flex items-center justify-center bg-gray-50">
                            <img id="mainImagePreview" src="" alt="Primary Preview" class="max-h-full max-w-full rounded-lg hidden">
                            <div id="noMainPreview" class="text-gray-400 text-center">
                                <i class="fas fa-image text-3xl mb-2"></i>
                                <p class="text-sm">No primary image selected</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Legacy Image Preview</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 h-48 flex items-center justify-center bg-gray-50">
                            <img id="legacyImagePreview" src="" alt="Legacy Preview" class="max-h-full max-w-full rounded-lg hidden">
                            <div id="noLegacyPreview" class="text-gray-400 text-center">
                                <i class="fas fa-image text-3xl mb-2"></i>
                                <p class="text-sm">No legacy image selected</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Images (image_2 to image_5) -->
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Additional Product Images
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <?php for($i = 2; $i <= 5; $i++): ?>
                            <div>
                                <label for="image_<?php echo e($i); ?>" class="block text-sm font-medium text-gray-700 mb-1">
                                    Image <?php echo e($i); ?>

                                </label>
                                <input type="file"
                                       id="image_<?php echo e($i); ?>"
                                       name="image_<?php echo e($i); ?>"
                                       accept="image/*"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <div class="mt-2 h-24 border-2 border-dashed border-gray-200 rounded-lg flex items-center justify-center bg-gray-50 image-preview-container"
                                     data-preview="preview_<?php echo e($i); ?>">
                                    <div class="text-center text-gray-400">
                                        <i class="fas fa-plus text-sm mb-1"></i>
                                        <p class="text-xs">Optional</p>
                                    </div>
                                    <img id="preview_<?php echo e($i); ?>" class="hidden max-h-full max-w-full rounded-lg">
                                </div>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>

                <!-- Thumbnail Image -->
                <div class="mt-6">
                    <label for="thumbnail" class="block text-sm font-medium text-gray-700 mb-1">
                        Thumbnail Image (Optional)
                    </label>
                    <input type="file"
                           id="thumbnail"
                           name="thumbnail"
                           accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <div class="mt-2 w-32 h-32 border-2 border-dashed border-gray-200 rounded-lg flex items-center justify-center bg-gray-50">
                        <img id="thumbnailPreview" src="" alt="Thumbnail Preview" class="max-h-full max-w-full rounded-lg hidden">
                        <div id="noThumbnailPreview" class="text-gray-400 text-center">
                            <i class="fas fa-image text-xl mb-1"></i>
                            <p class="text-xs">Thumbnail</p>
                        </div>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Smaller version for product listings (optional)</p>
                </div>

                <!-- Gallery Images (Multiple upload) -->
                <div class="mt-6">
                    <div class="flex justify-between items-center mb-3">
                        <label class="block text-sm font-medium text-gray-700">
                            Gallery Images (Multiple)
                        </label>
                        <button type="button"
                                onclick="addGalleryField()"
                                class="text-xs bg-blue-100 text-blue-600 hover:bg-blue-200 px-2 py-1 rounded">
                            <i class="fas fa-plus mr-1"></i> Add More
                        </button>
                    </div>

                    <div id="galleryFields" class="space-y-3">
                        <div class="flex items-center gap-3">
                            <input type="file"
                                   name="gallery_images[]"
                                   accept="image/*"
                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <button type="button"
                                    onclick="removeGalleryField(this)"
                                    class="px-3 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 invisible">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>

                    <p class="mt-1 text-xs text-gray-500">Upload multiple images for product gallery</p>
                </div>
            </div>

            <!-- Active Status -->
            <div class="mt-6 flex items-center p-3 bg-gray-50 rounded-lg">
                <input type="checkbox"
                       id="is_active"
                       name="is_active"
                       value="1"
                       <?php echo e(old('is_active', true) ? 'checked' : ''); ?>

                       class="h-5 w-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <label for="is_active" class="ml-3 text-sm text-gray-700 font-medium">
                    Active Product
                </label>
            </div>

            <!-- Description -->
            <div class="mt-6">
                <label for="short_description" class="block text-sm font-medium text-gray-700 mb-1">
                    Short Description
                </label>
                <input type="text"
                       id="short_description"
                       name="short_description"
                       value="<?php echo e(old('short_description')); ?>"
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

            <div class="mt-4">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                    Full Description *
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
unset($__errorArgs, $__bag); ?>"
                          required><?php echo e(old('description')); ?></textarea>
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
                    <!-- Default satu field kosong -->
                    <div class="specification-item border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-sm font-medium text-gray-700">Specification #1</span>
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
                                       name="specifications[0][key]"
                                       placeholder="e.g., Material, Size, Weight"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Value / Description</label>
                                <input type="text"
                                       name="specifications[0][value]"
                                       placeholder="e.g., High Quality Paper, A4, 100gr"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                        </div>
                    </div>
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

            <!-- Submit Button -->
            <div class="mt-8 flex justify-end gap-3">
                <a href="<?php echo e(route('admin.products.index')); ?>"
                   class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition">
                    Cancel
                </a>
                <button type="submit"
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center gap-2 font-medium transition">
                    <i class="fas fa-save"></i> Create Product
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Initialize when page loads
document.addEventListener('DOMContentLoaded', function() {
    console.log('🔄 Product form initializing...');

    // Get categories from Laravel
    const categories = <?php echo json_encode($categories, 15, 512) ?>;
    console.log('📦 Categories loaded:', categories.length, 'items');

    // Get DOM elements
    const typeRadios = document.querySelectorAll('input[name="category_type"]');
    const categorySelection = document.getElementById('categorySelection');
    const categoryOptions = document.getElementById('categoryOptions');
    const selectedCategoryInput = document.getElementById('selected_category_id');
    const selectedCategoryInfo = document.getElementById('selectedCategoryInfo');
    const selectedCategoryName = document.getElementById('selectedCategoryName');
    const productForm = document.getElementById('productForm');

    // Image preview elements
    const mainImageInput = document.getElementById('main_image');
    const legacyImageInput = document.getElementById('image');
    const thumbnailInput = document.getElementById('thumbnail');

    // Function to setup image preview
    function setupImagePreview(inputElement, previewElement, noPreviewElement) {
        if (inputElement && previewElement && noPreviewElement) {
            inputElement.addEventListener('change', function(e) {
                const file = e.target.files[0];

                if (file) {
                    // Check file size (max 5MB)
                    if (file.size > 5 * 1024 * 1024) {
                        alert('File size too large. Maximum size is 5MB.');
                        this.value = '';
                        return;
                    }

                    // Check file type
                    const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                    if (!validTypes.includes(file.type)) {
                        alert('Invalid file type. Only JPG, PNG, GIF, and WebP are allowed.');
                        this.value = '';
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewElement.src = e.target.result;
                        previewElement.classList.remove('hidden');
                        noPreviewElement.classList.add('hidden');
                    };
                    reader.readAsDataURL(file);
                } else {
                    previewElement.src = '';
                    previewElement.classList.add('hidden');
                    noPreviewElement.classList.remove('hidden');
                }
            });
        }
    }

    // Setup all image previews
    setupImagePreview(mainImageInput, document.getElementById('mainImagePreview'), document.getElementById('noMainPreview'));
    setupImagePreview(legacyImageInput, document.getElementById('legacyImagePreview'), document.getElementById('noLegacyPreview'));
    setupImagePreview(thumbnailInput, document.getElementById('thumbnailPreview'), document.getElementById('noThumbnailPreview'));

    // Setup previews for additional images (image_2 to image_5)
    for (let i = 2; i <= 5; i++) {
        const input = document.getElementById('image_' + i);
        const preview = document.getElementById('preview_' + i);
        const container = document.querySelector('[data-preview="preview_' + i + '"]');

        if (input && container) {
            input.addEventListener('change', function(e) {
                const file = e.target.files[0];
                const textElement = container.querySelector('.text-center');

                if (file) {
                    // Check file size (max 5MB)
                    if (file.size > 5 * 1024 * 1024) {
                        alert('File size too large. Maximum size is 5MB.');
                        this.value = '';
                        return;
                    }

                    // Check file type
                    const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                    if (!validTypes.includes(file.type)) {
                        alert('Invalid file type. Only JPG, PNG, GIF, and WebP are allowed.');
                        this.value = '';
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        if (preview) {
                            preview.src = e.target.result;
                            preview.classList.remove('hidden');
                        }
                        if (textElement) {
                            textElement.classList.add('hidden');
                        }
                    };
                    reader.readAsDataURL(file);
                } else {
                    if (preview) {
                        preview.src = '';
                        preview.classList.add('hidden');
                    }
                    if (textElement) {
                        textElement.classList.remove('hidden');
                    }
                }
            });
        }
    }

    // Function to show categories based on selected type
    function showCategoriesByType(type) {
        console.log(`📡 Showing categories for type: ${type}`);

        // Show category selection section
        categorySelection.classList.remove('hidden');

        // Filter categories by type
        const filteredCategories = categories.filter(cat => cat.type === type);
        console.log(`📊 Found ${filteredCategories.length} categories for ${type}`);

        // Clear previous options
        categoryOptions.innerHTML = '';

        if (filteredCategories.length === 0) {
            categoryOptions.innerHTML = `
                <div class="text-center p-6 text-gray-500 bg-gray-100 rounded-lg">
                    <i class="fas fa-exclamation-triangle text-2xl mb-3"></i>
                    <p class="font-medium">No categories available</p>
                    <p class="text-sm mt-1">Please add categories for ${type} type in admin panel</p>
                </div>
            `;
            return;
        }

        // Create category cards
        filteredCategories.forEach(category => {
            const categoryCard = document.createElement('div');
            categoryCard.className = 'category-card p-4 border border-gray-300 rounded-lg bg-white hover:bg-blue-50 hover:border-blue-400 cursor-pointer transition-all duration-200';
            categoryCard.dataset.categoryId = category.id;
            categoryCard.dataset.categoryName = category.name;

            categoryCard.innerHTML = `
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-3 flex-shrink-0">
                        <i class="${category.icon || 'fas fa-folder'} text-blue-600"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="font-semibold text-gray-800 truncate">${category.name}</h4>
                        <p class="text-sm text-gray-600 mt-1 line-clamp-2">${category.description || 'No description available'}</p>
                    </div>
                    <div class="checkmark ml-3 flex-shrink-0">
                        <i class="fas fa-check-circle text-blue-600 text-xl opacity-0"></i>
                    </div>
                </div>
            `;

            // Click event for category card
            categoryCard.addEventListener('click', function() {
                const categoryId = this.dataset.categoryId;
                const categoryName = this.dataset.categoryName;

                console.log(`🎯 Category selected: ${categoryName} (ID: ${categoryId})`);

                // Remove selection from all cards
                document.querySelectorAll('.category-card').forEach(card => {
                    card.classList.remove('border-blue-500', 'bg-blue-100', 'ring-2', 'ring-blue-200');
                    card.querySelector('.fa-check-circle').classList.add('opacity-0');
                });

                // Add selection to clicked card
                this.classList.add('border-blue-500', 'bg-blue-100', 'ring-2', 'ring-blue-200');
                this.querySelector('.fa-check-circle').classList.remove('opacity-0');

                // Update hidden input
                if (selectedCategoryInput) {
                    selectedCategoryInput.value = categoryId;
                    console.log(`✅ Hidden input updated: ${selectedCategoryInput.value}`);
                }

                // Show selected category info
                if (selectedCategoryInfo && selectedCategoryName) {
                    selectedCategoryName.textContent = `Selected: ${categoryName}`;
                    selectedCategoryInfo.classList.remove('hidden');
                }

                // Add animation feedback
                this.classList.add('scale-[1.02]');
                setTimeout(() => {
                    this.classList.remove('scale-[1.02]');
                }, 300);
            });

            categoryOptions.appendChild(categoryCard);
        });

        // Auto-select if there's old value
        const oldCategoryId = "<?php echo e(old('category_id', '')); ?>";
        if (oldCategoryId && oldCategoryId !== '') {
            setTimeout(() => {
                const cardToSelect = categoryOptions.querySelector(`[data-category-id="${oldCategoryId}"]`);
                if (cardToSelect) {
                    cardToSelect.click();
                    console.log(`🔄 Auto-selected old category: ${oldCategoryId}`);
                }
            }, 200);
        }
    }

    // Add change event to type radio buttons
    typeRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.checked) {
                console.log(`📻 Type changed to: ${this.value}`);
                showCategoriesByType(this.value);
            }
        });
    });

    // Auto-trigger if there's old type
    const oldType = "<?php echo e(old('category_type', '')); ?>";
    if (oldType) {
        console.log(`🔄 Found old type: ${oldType}`);
        const radioToCheck = document.querySelector(`input[name="category_type"][value="${oldType}"]`);
        if (radioToCheck) {
            radioToCheck.checked = true;
            // Trigger after a delay to ensure DOM is ready
            setTimeout(() => {
                showCategoriesByType(oldType);
            }, 300);
        }
    }

    // Form validation before submit
    if (productForm) {
        productForm.addEventListener('submit', function(e) {
            const typeSelected = document.querySelector('input[name="category_type"]:checked');
            const categorySelected = selectedCategoryInput ? selectedCategoryInput.value : '';
            const legacyImageSelected = legacyImageInput ? legacyImageInput.files.length > 0 : false;

            console.log('🔍 Form validation check:');
            console.log('  Type selected:', typeSelected ? typeSelected.value : 'None');
            console.log('  Category selected:', categorySelected || 'None');
            console.log('  Legacy image:', legacyImageSelected ? 'Selected' : 'Missing');

            let isValid = true;
            let errorMessage = '';

            if (!typeSelected) {
                isValid = false;
                errorMessage = 'Please select product type (Instan or Non-Instan)';
            } else if (!categorySelected) {
                isValid = false;
                errorMessage = 'Please select a product category';
            } else if (!legacyImageSelected) {
                isValid = false;
                errorMessage = 'Please upload a product image';
            }

            if (!isValid) {
                e.preventDefault();

                // Show error alert
                const alertDiv = document.createElement('div');
                alertDiv.className = 'fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-lg z-50';
                alertDiv.innerHTML = `
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <span class="font-medium">${errorMessage}</span>
                    </div>
                `;
                document.body.appendChild(alertDiv);

                // Remove alert after 5 seconds
                setTimeout(() => {
                    alertDiv.remove();
                }, 5000);

                // Scroll to error
                if (!typeSelected) {
                    document.querySelector('input[name="category_type"]').closest('div').scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                } else if (!categorySelected) {
                    categorySelection.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                } else if (!legacyImageSelected) {
                    legacyImageInput.closest('div').scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }

                return false;
            }

            console.log('✅ Form validation passed');
            return true;
        });
    }

    // Add some styling to category cards
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
        #categoryOptions::-webkit
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

    console.log('✅ Product form initialization complete');
});

// Gallery Images Management
let galleryFieldCount = 1;

function addGalleryField() {
    const galleryFields = document.getElementById('galleryFields');
    const newField = document.createElement('div');
    newField.className = 'flex items-center gap-3';
    newField.innerHTML = `
        <input type="file"
               name="gallery_images[]"
               accept="image/*"
               class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        <button type="button"
                onclick="removeGalleryField(this)"
                class="px-3 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition">
            <i class="fas fa-minus"></i>
        </button>
    `;
    galleryFields.appendChild(newField);
    galleryFieldCount++;

    // Show remove buttons on all fields if there's more than 1
    updateGalleryRemoveButtons();
}

function removeGalleryField(button) {
    const field = button.closest('.flex.items-center.gap-3');
    if (field) {
        field.remove();
        galleryFieldCount--;
        updateGalleryRemoveButtons();
    }
}

function updateGalleryRemoveButtons() {
    const fields = document.querySelectorAll('#galleryFields > div');
    const removeButtons = document.querySelectorAll('#galleryFields button[onclick="removeGalleryField(this)"]');
    
    if (fields.length > 1) {
        removeButtons.forEach(button => button.classList.remove('invisible'));
    } else {
        removeButtons.forEach(button => button.classList.add('invisible'));
    }
}

// Specifications Management
let specIndex = 1;

function addSpecification() {
    const container = document.getElementById('specifications-container');
    const template = document.getElementById('specification-template');
    
    if (!container || !template) return;

    const newSpec = template.cloneNode(true);
    newSpec.classList.remove('hidden');
    newSpec.classList.add('specification-item', 'border', 'border-gray-200', 'rounded-lg', 'p-4');
    
    // Update the index in the name attribute
    const newHtml = newSpec.innerHTML.replace(/__INDEX__/g, specIndex);
    newSpec.innerHTML = newHtml;
    
    // Update the label
    const label = newSpec.querySelector('.text-sm.font-medium.text-gray-700');
    if (label) {
        label.textContent = `Specification #${specIndex + 1}`;
    }

    container.appendChild(newSpec);
    specIndex++;
}

function removeSpecification(button) {
    const specItem = button.closest('.specification-item');
    if (specItem) {
        specItem.remove();
        
        // Update remaining specification numbers
        const allSpecs = document.querySelectorAll('#specifications-container .specification-item');
        allSpecs.forEach((spec, index) => {
            const label = spec.querySelector('.text-sm.font-medium.text-gray-700');
            if (label) {
                label.textContent = `Specification #${index + 1}`;
            }
        });
    }
}

// Real-time price formatting
const priceInput = document.getElementById('price');
if (priceInput) {
    priceInput.addEventListener('input', function(e) {
        // Remove non-numeric characters
        let value = this.value.replace(/[^\d]/g, '');
        
        // Format with thousand separators
        if (value.length > 0) {
            const formatted = new Intl.NumberFormat('id-ID').format(parseInt(value));
            
            // Create a temporary element to display formatted value
            const displaySpan = document.createElement('span');
            displaySpan.textContent = `Rp ${formatted}`;
            displaySpan.className = 'text-gray-500 absolute right-3 top-1/2 transform -translate-y-1/2';
            
            // Remove existing display if any
            const existingDisplay = this.parentElement.querySelector('.price-display');
            if (existingDisplay) {
                existingDisplay.remove();
            }
            
            displaySpan.classList.add('price-display');
            this.parentElement.appendChild(displaySpan);
        } else {
            // Remove display if value is empty
            const existingDisplay = this.parentElement.querySelector('.price-display');
            if (existingDisplay) {
                existingDisplay.remove();
            }
        }
    });

    // Also format on page load if there's an old value
    if (priceInput.value) {
        priceInput.dispatchEvent(new Event('input'));
    }
}

// Character counter for short description
const shortDescriptionInput = document.getElementById('short_description');
if (shortDescriptionInput) {
    const counterDiv = document.createElement('div');
    counterDiv.className = 'mt-1 text-xs text-gray-500 text-right';
    counterDiv.id = 'shortDescriptionCounter';
    
    shortDescriptionInput.parentElement.appendChild(counterDiv);
    
    function updateCounter() {
        const count = shortDescriptionInput.value.length;
        const max = shortDescriptionInput.maxLength || 255;
        counterDiv.textContent = `${count}/${max} characters`;
        
        if (count > max * 0.8) {
            counterDiv.classList.remove('text-gray-500');
            counterDiv.classList.add('text-yellow-600');
        } else {
            counterDiv.classList.remove('text-yellow-600');
            counterDiv.classList.add('text-gray-500');
        }
        
        if (count >= max) {
            counterDiv.classList.remove('text-yellow-600');
            counterDiv.classList.add('text-red-600', 'font-medium');
        }
    }
    
    shortDescriptionInput.addEventListener('input', updateCounter);
    
    // Initialize counter
    updateCounter();
}

// Discount validation
const discountInput = document.getElementById('discount_percent');
if (discountInput) {
    discountInput.addEventListener('change', function() {
        let value = parseInt(this.value) || 0;
        
        if (value < 0) {
            this.value = 0;
        } else if (value > 100) {
            this.value = 100;
        }
    });
}

// Stock validation
const stockInput = document.getElementById('stock');
if (stockInput) {
    stockInput.addEventListener('change', function() {
        let value = parseInt(this.value) || 0;
        
        if (value < 0) {
            this.value = 0;
        }
    });
}

// Minimum order validation
const minOrderInput = document.getElementById('min_order');
if (minOrderInput) {
    minOrderInput.addEventListener('change', function() {
        let value = parseInt(this.value) || 1;
        
        if (value < 1) {
            this.value = 1;
        }
    });
}

// Form submission loading state
const form = document.getElementById('productForm');
if (form) {
    form.addEventListener('submit', function() {
        const submitButton = this.querySelector('button[type="submit"]');
        if (submitButton) {
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Creating Product...';
            submitButton.classList.add('opacity-75', 'cursor-not-allowed');
        }
    });
}

// Handle browser back button - warn about unsaved changes
let formChanged = false;
const formInputs = document.querySelectorAll('#productForm input, #productForm textarea, #productForm select');
formInputs.forEach(input => {
    input.addEventListener('change', () => {
        formChanged = true;
    });
    
    input.addEventListener('input', () => {
        formChanged = true;
    });
});

window.addEventListener('beforeunload', function(e) {
    if (formChanged) {
        e.preventDefault();
        e.returnValue = 'You have unsaved changes. Are you sure you want to leave?';
        return e.returnValue;
    }
});

// Handle image file validation globally
document.querySelectorAll('input[type="file"][accept="image/*"]').forEach(input => {
    input.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;

        // Validate file size (5MB max)
        const maxSize = 5 * 1024 * 1024; // 5MB
        if (file.size > maxSize) {
            alert(`File ${file.name} is too large. Maximum size is 5MB.`);
            this.value = '';
            return;
        }

        // Validate file type
        const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!validTypes.includes(file.type)) {
            alert(`File ${file.name} is not a valid image type. Please upload JPG, PNG, GIF, or WebP.`);
            this.value = '';
            return;
        }
    });
});

// Auto-focus on first input field with error
document.addEventListener('DOMContentLoaded', function() {
    const firstErrorField = document.querySelector('.border-red-500');
    if (firstErrorField) {
        firstErrorField.focus();
        firstErrorField.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('pages.admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\cangcut\revisiimaji\resources\views/pages/admin/products/create.blade.php ENDPATH**/ ?>