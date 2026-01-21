

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

            <!-- Image Upload -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-1">
                        Product Image *
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
                    <p class="mt-1 text-xs text-gray-500">Max 5MB. JPG, PNG, GIF allowed.</p>
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
                    <label class="block text-sm font-medium text-gray-700 mb-1">Preview</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 h-48 flex items-center justify-center bg-gray-50">
                        <img id="imagePreview" src="" alt="Preview" class="max-h-full max-w-full rounded-lg hidden">
                        <div id="noPreview" class="text-gray-400 text-center">
                            <i class="fas fa-image text-4xl mb-3"></i>
                            <p class="text-sm">No image selected</p>
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
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');
    const noPreview = document.getElementById('noPreview');
    
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
            
            console.log('🔍 Form validation check:');
            console.log('  Type selected:', typeSelected ? typeSelected.value : 'None');
            console.log('  Category selected:', categorySelected || 'None');
            
            let isValid = true;
            let errorMessage = '';
            
            if (!typeSelected) {
                isValid = false;
                errorMessage = 'Please select product type (Instan or Non-Instan)';
            } else if (!categorySelected) {
                isValid = false;
                errorMessage = 'Please select a product category';
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
                }
                
                return false;
            }
            
            console.log('✅ Form validation passed');
            return true;
        });
    }
    
    // Image preview functionality
    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
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
                    imagePreview.src = e.target.result;
                    imagePreview.classList.remove('hidden');
                    noPreview.classList.add('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                imagePreview.src = '';
                imagePreview.classList.add('hidden');
                noPreview.classList.remove('hidden');
            }
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
        #categoryOptions::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }
        #categoryOptions::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 3px;
        }
        #categoryOptions::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    `;
    document.head.appendChild(style);
    
    console.log('✅ Product form initialized successfully');
});

// Debug function (can be called from browser console)
function debugForm() {
    console.log('=== DEBUG PRODUCT FORM ===');
    console.log('1. Categories count:', <?php echo json_encode($categories, 15, 512) ?>.length);
    console.log('2. Selected type:', document.querySelector('input[name="category_type"]:checked')?.value || 'None');
    console.log('3. Selected category ID:', document.getElementById('selected_category_id')?.value || 'None');
    console.log('4. Category options visible:', !document.getElementById('categorySelection').classList.contains('hidden'));
    console.log('5. Category cards:', document.querySelectorAll('.category-card').length);
}
// Load categories by type
function loadCategoriesByType(type) {
    const categorySelection = document.getElementById('categorySelection');
    const categoryOptions = document.getElementById('categoryOptions');
    
    // Show category selection
    categorySelection.classList.remove('hidden');
    
    // Filter categories by type
    const filteredCategories = categories.filter(cat => cat.type === type);
    
    // Clear previous options
    categoryOptions.innerHTML = '';
    
    if (filteredCategories.length === 0) {
        categoryOptions.innerHTML = `
            <div class="text-center p-4 text-gray-500">
                <i class="fas fa-exclamation-circle text-xl mb-2"></i>
                <p>Tidak ada kategori untuk tipe ${type === 'instan' ? 'Instan' : 'Non-Instan'}</p>
            </div>
        `;
        return;
    }
    
    // Create category cards
    filteredCategories.forEach(category => {
        const categoryCard = document.createElement('div');
        categoryCard.className = 'p-4 border border-gray-300 rounded-lg mb-3 cursor-pointer hover:bg-blue-50 transition';
        categoryCard.innerHTML = `
            <div class="flex items-center">
                <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center mr-3">
                    <i class="${category.icon || 'fas fa-box'} text-gray-600"></i>
                </div>
                <div class="flex-1">
                    <h4 class="font-medium text-gray-800">${category.name}</h4>
                    <p class="text-sm text-gray-600 mt-1">${category.description || 'Tanpa deskripsi'}</p>
                </div>
                <div class="text-green-600 opacity-0">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        `;
        
        // Click event
        categoryCard.addEventListener('click', function() {
            // Remove selection from all
            categoryOptions.querySelectorAll('div').forEach(item => {
                item.classList.remove('border-blue-500', 'bg-blue-100');
                item.querySelector('.fa-check-circle').classList.add('opacity-0');
            });
            
            // Add selection to clicked
            this.classList.add('border-blue-500', 'bg-blue-100');
            this.querySelector('.fa-check-circle').classList.remove('opacity-0');
            
            // Set hidden input value
            document.getElementById('selected_category_id').value = category.id;
            document.getElementById('selectedCategoryName').textContent = `Selected: ${category.name}`;
            document.getElementById('selectedCategoryInfo').classList.remove('hidden');
        });
        
        categoryOptions.appendChild(categoryCard);
    });
}
// Specifications Management
let specIndex = 1;

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
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('pages.admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\revisiimaji\resources\views\pages\admin\products\create.blade.php ENDPATH**/ ?>