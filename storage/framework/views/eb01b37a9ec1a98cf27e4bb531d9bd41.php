

<?php $__env->startSection('title', 'Create New Product'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <a href="<?php echo e(route('admin.products.index')); ?>"
           class="flex items-center gap-2 bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
            <i class="fas fa-arrow-left"></i> Back to Products
        </a>
    </div>

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
                <a href="<?php echo e(route('admin.products.create', ['type' => 'instan'])); ?>" 
                   class="flex-1 p-4 border-2 rounded-lg text-center transition-all duration-200
                          <?php echo e($selectedType == 'instan' ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-blue-300 hover:bg-blue-25'); ?>">
                    <div class="flex flex-col items-center">
                        <div class="w-12 h-12 rounded-full <?php echo e($selectedType == 'instan' ? 'bg-blue-200' : 'bg-blue-100'); ?> flex items-center justify-center mb-2">
                            <i class="fas fa-bolt text-xl <?php echo e($selectedType == 'instan' ? 'text-blue-700' : 'text-blue-600'); ?>"></i>
                        </div>
                        <span class="font-semibold <?php echo e($selectedType == 'instan' ? 'text-blue-700' : 'text-gray-700'); ?>">Instan</span>
                        <span class="text-xs text-gray-500 mt-1">Produk cepat saji</span>
                        <?php if($selectedType == 'instan'): ?>
                            <span class="mt-2 text-xs bg-blue-600 text-white px-2 py-1 rounded-full">Active</span>
                        <?php endif; ?>
                    </div>
                </a>
                
                <a href="<?php echo e(route('admin.products.create', ['type' => 'non-instan'])); ?>" 
                   class="flex-1 p-4 border-2 rounded-lg text-center transition-all duration-200
                          <?php echo e($selectedType == 'non-instan' ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-green-300 hover:bg-green-25'); ?>">
                    <div class="flex flex-col items-center">
                        <div class="w-12 h-12 rounded-full <?php echo e($selectedType == 'non-instan' ? 'bg-green-200' : 'bg-green-100'); ?> flex items-center justify-center mb-2">
                            <i class="fas fa-clock text-xl <?php echo e($selectedType == 'non-instan' ? 'text-green-700' : 'text-green-600'); ?>"></i>
                        </div>
                        <span class="font-semibold <?php echo e($selectedType == 'non-instan' ? 'text-green-700' : 'text-gray-700'); ?>">Non-Instan</span>
                        <span class="text-xs text-gray-500 mt-1">Produk custom</span>
                        <?php if($selectedType == 'non-instan'): ?>
                            <span class="mt-2 text-xs bg-green-600 text-white px-2 py-1 rounded-full">Active</span>
                        <?php endif; ?>
                    </div>
                </a>
            </div>
        </div>
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

               

                    <!-- STEP 1: Category Type (Hidden Radio) -->
                    <div class="hidden">
                        <input type="radio" name="category_type" value="instan" id="type_instan" <?php echo e($selectedType == 'instan' ? 'checked' : ''); ?>>
                        <input type="radio" name="category_type" value="non-instan" id="type_non_instan" <?php echo e($selectedType == 'non-instan' ? 'checked' : ''); ?>>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-4">
                    <!-- STEP 2: Category Selection -->
                    <div id="categorySelection" class="<?php echo e($selectedType ? '' : 'hidden'); ?>">
                        <div class="flex justify-between items-center mb-3">
                            <label class="block text-sm font-medium text-gray-700">
                                Select Category *
                            </label>
                            <button type="button"
                                    onclick="openAddCategoryModal()"
                                    class="text-sm bg-green-100 text-green-600 hover:bg-green-200 px-3 py-1 rounded-lg transition">
                                <i class="fas fa-plus mr-1"></i> Add New Category
                            </button>
                        </div>

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

                        <div id="categoryOptions" class="space-y-3 max-h-80 overflow-y-auto p-3 border border-gray-200 rounded-lg bg-gray-50">
                            <!-- Categories will be loaded here via JavaScript -->
                            <div class="text-center p-6 text-gray-500">
                                <i class="fas fa-arrow-up text-xl mb-3"></i>
                                <p>Loading categories...</p>
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

                <!-- Main Image (Primary) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-1">
                            Main Product Image *
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
                        <p class="mt-1 text-xs text-gray-500">Main image for product thumbnail</p>
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

                    <!-- Image Preview -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Image Preview</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 h-48 flex items-center justify-center bg-gray-50">
                            <img id="imagePreview" src="" alt="Preview" class="max-h-full max-w-full rounded-lg hidden">
                            <div id="noImagePreview" class="text-gray-400 text-center">
                                <i class="fas fa-image text-3xl mb-2"></i>
                                <p class="text-sm">No image selected</p>
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

                <!-- Full Description -->
                <div>
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

<!-- Modal for Adding New Category -->
<div id="addCategoryModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
        <div class="px-6 py-4 border-b flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900">Add New Category</h3>
            <button type="button" onclick="closeAddCategoryModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form id="addCategoryForm" onsubmit="saveNewCategory(event)">
            <div class="px-6 py-4 space-y-4">
                <!-- Category Name -->
                <div>
                    <label for="new_category_name" class="block text-sm font-medium text-gray-700 mb-1">
                        Category Name *
                    </label>
                    <input type="text"
                           id="new_category_name"
                           name="name"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           required
                           placeholder="e.g., Banner, Merchandise, etc">
                </div>

                <!-- Category Type (Read-only, from selected product type) -->
                <div>
                    <label for="new_category_type" class="block text-sm font-medium text-gray-700 mb-1">
                        Category Type
                    </label>
                    <input type="text"
                           id="new_category_type"
                           class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-700"
                           readonly>
                    <p class="mt-1 text-xs text-gray-500">Type will follow the product type you selected</p>
                </div>

                <!-- Category Description -->
                <div>
                    <label for="new_category_description" class="block text-sm font-medium text-gray-700 mb-1">
                        Description
                    </label>
                    <textarea id="new_category_description"
                              name="description"
                              rows="2"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Brief description of this category"></textarea>
                </div>

                <!-- Category Icon -->
                <div>
                    <label for="new_category_icon" class="block text-sm font-medium text-gray-700 mb-1">
                        Icon (FontAwesome class)
                    </label>
                    <input type="text"
                           id="new_category_icon"
                           name="icon"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="fas fa-tag"
                           value="fas fa-folder">
                    <p class="mt-1 text-xs text-gray-500">e.g., fas fa-tag, fas fa-box, fas fa-image</p>
                </div>

                <!-- Category Order -->
                <div>
                    <label for="new_category_order" class="block text-sm font-medium text-gray-700 mb-1">
                        Display Order
                    </label>
                    <input type="number"
                           id="new_category_order"
                           name="order"
                           min="0"
                           value="0"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <!-- Hidden field for CSRF -->
                <input type="hidden" id="csrf_token" value="<?php echo e(csrf_token()); ?>">
            </div>

            <div class="px-6 py-4 border-t flex justify-end gap-3">
                <button type="button"
                        onclick="closeAddCategoryModal()"
                        class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 flex items-center gap-2">
                    <i class="fas fa-save"></i> Save Category
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Loading Spinner -->
<div id="loadingSpinner" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white p-5 rounded-lg shadow-xl flex items-center gap-3">
        <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600"></div>
        <span class="text-gray-700">Processing...</span>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Variable global untuk menyimpan categories
let allCategories = <?php echo json_encode($categories, 15, 512) ?>;
let selectedType = "<?php echo e($selectedType); ?>";

// Variable untuk menyimpan semua kategori
let allFilteredCategories = [];
let currentType = '';

// Initialize when page loads
document.addEventListener('DOMContentLoaded', function() {
    console.log('🔄 Product form initializing...');
    console.log('📦 Categories loaded:', allCategories.length, 'items');
    console.log('🎯 Selected type from URL:', selectedType);

    // Get DOM elements
    const typeRadios = document.querySelectorAll('input[name="category_type"]');
    const categorySelection = document.getElementById('categorySelection');
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
                const textElement = container.querySelector('.text-center');

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

        if (!categorySelection || !categoryOptions) return;

        categorySelection.classList.remove('hidden');
        
        // Clear search input
        const searchInput = document.getElementById('categorySearch');
        if (searchInput) {
            searchInput.value = '';
        }
        
        // Hide clear button
        const clearButton = document.getElementById('clearSearch');
        if (clearButton) {
            clearButton.classList.add('hidden');
        }
        
        // Render categories
        renderCategoriesWithFilter(type, '');
    }

    // Trigger based on selected type from URL
    if (selectedType) {
        const radioToCheck = document.querySelector(`input[name="category_type"][value="${selectedType}"]`);
        if (radioToCheck) {
            radioToCheck.checked = true;
            setTimeout(() => {
                showCategoriesByType(selectedType);
            }, 300);
        }
    }

    // Add change event to type radio buttons
    typeRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.checked) {
                showCategoriesByType(this.value);
            }
        });
    });

    // Form validation
    if (productForm) {
        productForm.addEventListener('submit', function(e) {
            const typeSelected = document.querySelector('input[name="category_type"]:checked');
            const categorySelected = selectedCategoryInput ? selectedCategoryInput.value : '';
            const mainImageSelected = mainImageInput ? mainImageInput.files.length > 0 : false;

            let isValid = true;
            let errorMessage = '';

            if (!typeSelected) {
                isValid = false;
                errorMessage = 'Please select product type (Instan or Non-Instan)';
            } else if (!categorySelected) {
                isValid = false;
                errorMessage = 'Please select a product category';
            } else if (!mainImageSelected) {
                isValid = false;
                errorMessage = 'Please upload a main product image';
            }

            if (!isValid) {
                e.preventDefault();
                showFormMessage(errorMessage, 'error');

                if (!typeSelected) {
                    document.querySelector('.bg-white.rounded-lg.shadow.mb-6').scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                } else if (!categorySelected) {
                    categorySelection.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                } else if (!mainImageSelected) {
                    mainImageInput.closest('div').scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }

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

    // Setup category search
    setupCategorySearch();
});

// Fungsi untuk render kategori dengan filter search
function renderCategoriesWithFilter(type, searchTerm = '') {
    const categoryOptions = document.getElementById('categoryOptions');
    const selectedCategoryInput = document.getElementById('selected_category_id');
    const selectedCategoryInfo = document.getElementById('selectedCategoryInfo');
    const selectedCategoryName = document.getElementById('selectedCategoryName');
    
    if (!categoryOptions) return;
    
    currentType = type;
    
    // Filter categories by type
    let filteredByType = allCategories.filter(cat => cat.type === type);
    allFilteredCategories = filteredByType;
    
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
                ${allFilteredCategories.length > 0 ? 
                    `<button onclick="clearSearch()" class="mt-2 text-blue-600 hover:text-blue-800 text-sm">
                        <i class="fas fa-times mr-1"></i> Clear search
                    </button>` : 
                    `<p class="text-sm mt-2">Click "Add New Category" button to create one</p>`
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

    const oldCategoryId = "<?php echo e(old('category_id', '')); ?>";
    if (oldCategoryId && oldCategoryId !== '') {
        setTimeout(() => {
            const cardToSelect = categoryOptions.querySelector(`[data-category-id="${oldCategoryId}"]`);
            if (cardToSelect) {
                cardToSelect.click();
            }
        }, 200);
    }
}

// Fungsi untuk clear search
function clearSearch() {
    const searchInput = document.getElementById('categorySearch');
    const clearButton = document.getElementById('clearSearch');
    if (searchInput) {
        searchInput.value = '';
        clearButton.classList.add('hidden');
        if (currentType) {
            renderCategoriesWithFilter(currentType, '');
        }
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
        
        // Debounce search to avoid too many renders
        clearTimeout(window.searchTimeout);
        window.searchTimeout = setTimeout(() => {
            if (currentType) {
                renderCategoriesWithFilter(currentType, searchTerm);
            }
        }, 300);
    });
    
    if (clearButton) {
        clearButton.addEventListener('click', clearSearch);
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
    
    const newHtml = newSpec.innerHTML.replace(/__INDEX__/g, specIndex);
    newSpec.innerHTML = newHtml;
    
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
        
        const allSpecs = document.querySelectorAll('#specifications-container .specification-item');
        allSpecs.forEach((spec, index) => {
            const label = spec.querySelector('.text-sm.font-medium.text-gray-700');
            if (label) {
                label.textContent = `Specification #${index + 1}`;
            }
        });
    }
}

// Character counter
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
    updateCounter();
}

// Stock validation
const stockInput = document.getElementById('stock');
if (stockInput) {
    stockInput.addEventListener('change', function() {
        let value = parseInt(this.value) || 0;
        if (value < 0) this.value = 0;
    });
}

// Min order validation
const minOrderInput = document.getElementById('min_order');
if (minOrderInput) {
    minOrderInput.addEventListener('change', function() {
        let value = parseInt(this.value) || 1;
        if (value < 1) this.value = 1;
    });
}

// Form submission loading
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


// ============ CATEGORY MODAL FUNCTIONS ============

function openAddCategoryModal() {
    const selectedType = document.querySelector('input[name="category_type"]:checked');

    if (!selectedType) {
        showFormMessage('Please select product type (Instan/Non-Instan) first!', 'error');
        return;
    }

    const typeField = document.getElementById('new_category_type');
    if (typeField) {
        typeField.value = selectedType.value === 'instan' ? 'Instan' : 'Non-Instan';
    }

    const modal = document.getElementById('addCategoryModal');
    if (modal) {
        modal.classList.remove('hidden');
    }
}

function closeAddCategoryModal() {
    const modal = document.getElementById('addCategoryModal');
    if (modal) {
        modal.classList.add('hidden');
    }

    const form = document.getElementById('addCategoryForm');
    if (form) {
        form.reset();
    }
}

function showLoading() {
    const spinner = document.getElementById('loadingSpinner');
    if (spinner) spinner.classList.remove('hidden');
}

function hideLoading() {
    const spinner = document.getElementById('loadingSpinner');
    if (spinner) spinner.classList.add('hidden');
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

function showModalMessage(message, type = 'info') {
    // Cek apakah sudah ada message container
    let messageContainer = document.getElementById('modalMessageContainer');
    
    if (!messageContainer) {
        messageContainer = document.createElement('div');
        messageContainer.id = 'modalMessageContainer';
        messageContainer.className = 'mb-4';
        
        // Insert di dalam modal, sebelum form
        const modalBody = document.querySelector('#addCategoryModal .px-6.py-4');
        if (modalBody) {
            modalBody.insertBefore(messageContainer, modalBody.firstChild);
        }
    }
    
    // Set message dengan style sesuai type
    const bgColor = type === 'success' ? 'bg-green-50 border-green-200 text-green-700' : 
                   (type === 'error' ? 'bg-red-50 border-red-200 text-red-700' : 
                   'bg-blue-50 border-blue-200 text-blue-700');
    
    messageContainer.innerHTML = `
        <div class="${bgColor} border px-4 py-3 rounded-lg flex items-center justify-between">
            <span>${message}</span>
            <button onclick="this.parentElement.remove()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    
    // Auto hide after 3 seconds untuk pesan sukses
    if (type === 'success') {
        setTimeout(() => {
            if (messageContainer && messageContainer.innerHTML) {
                messageContainer.innerHTML = '';
            }
        }, 3000);
    }
}

function saveNewCategory(event) {
    event.preventDefault();

    const selectedType = document.querySelector('input[name="category_type"]:checked');
    if (!selectedType) {
        showFormMessage('Please select product type first!', 'error');
        return;
    }

    console.log('Selected type for new category:', selectedType.value); // Debug

    const name = document.getElementById('new_category_name').value;
    const description = document.getElementById('new_category_description').value;
    const icon = document.getElementById('new_category_icon').value || 'fas fa-folder';
    const order = document.getElementById('new_category_order').value || 0;
    const csrfToken = document.getElementById('csrf_token').value;

    if (!name.trim()) {
        showModalMessage('Category name is required!', 'error');
        return;
    }

    showLoading();

    const formData = new FormData();
    formData.append('name', name);
    formData.append('type', selectedType.value);
    formData.append('description', description);
    formData.append('icon', icon);
    formData.append('order', order);
    formData.append('_token', csrfToken);

    // Debug: cek isi formData
    for (let pair of formData.entries()) {
        console.log(pair[0] + ': ' + pair[1]);
    }

    fetch('<?php echo e(route("admin.products.quick-add-category")); ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        hideLoading();

        if (data.success) {
            closeAddCategoryModal();

            const newCategory = data.category;
            console.log('New category created:', newCategory);

            // Pastikan type tersimpan
            if (!newCategory.type) {
                console.error('Category type is missing!');
                newCategory.type = selectedType.value; // Fallback
            }

            allCategories.push(newCategory);

            const currentType = document.querySelector('input[name="category_type"]:checked').value;
            
            // Trigger refresh
            const radioToRefresh = document.querySelector(`input[name="category_type"][value="${currentType}"]`);
            if (radioToRefresh) {
                radioToRefresh.dispatchEvent(new Event('change'));
            }

            setTimeout(() => {
                const categoryOptions = document.getElementById('categoryOptions');
                const newCard = categoryOptions.querySelector(`[data-category-id="${newCategory.id}"]`);
                if (newCard) {
                    newCard.click();
                    
                    newCard.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                    
                    newCard.classList.add('ring-4', 'ring-green-300');
                    setTimeout(() => {
                        newCard.classList.remove('ring-4', 'ring-green-300');
                    }, 1500);
                } else {
                    // Jika card tidak ditemukan (mungkin karena filter search), refresh dengan search kosong
                    clearSearch();
                    setTimeout(() => {
                        const refreshedCard = document.getElementById('categoryOptions').querySelector(`[data-category-id="${newCategory.id}"]`);
                        if (refreshedCard) {
                            refreshedCard.click();
                        }
                    }, 300);
                }
            }, 300);

            showFormMessage(`Category "${newCategory.name}" added successfully!`, 'success');
        } else {
            showModalMessage('Error: ' + (data.message || 'Failed to add category'), 'error');
        }
    })
    .catch(error => {
        hideLoading();
        console.error('Error:', error);
        showModalMessage('Network error occurred', 'error');
    });
}

// Close modal when clicking outside
document.addEventListener('click', function(e) {
    const modal = document.getElementById('addCategoryModal');
    if (modal && !modal.classList.contains('hidden')) {
        if (e.target === modal) {
            closeAddCategoryModal();
        }
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('pages.admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\revisiimaji\resources\views/pages/admin/products/create.blade.php ENDPATH**/ ?>