

<?php $__env->startSection('title', 'Add Online Store'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-6 max-w-4xl">
    <!-- Header dengan Breadcrumb -->
    <div class="mb-6">
        <nav class="flex mb-3" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="text-gray-700 hover:text-blue-600">
                        <i class="fas fa-home mr-2"></i>Dashboard
                    </a>
                </li>
                <li class="inline-flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <a href="<?php echo e(route('admin.settings.index')); ?>" class="text-gray-700 hover:text-blue-600">
                        Settings
                    </a>
                </li>
                <li class="inline-flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <a href="<?php echo e(route('admin.settings.online-stores.index')); ?>" class="text-gray-700 hover:text-blue-600">
                        Online Stores
                    </a>
                </li>
                <li aria-current="page" class="inline-flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-blue-600 font-medium">Add New Store</span>
                </li>
            </ol>
        </nav>
        
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Add Online Store</h1>
                <p class="text-gray-600 mt-1">Add a new online store link to display on your website</p>
            </div>
            
            <a href="<?php echo e(route('admin.settings.online-stores.index')); ?>" 
               class="text-gray-600 hover:text-gray-900 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>Back to List
            </a>
        </div>
    </div>

    <!-- Main Form -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form Column -->
        <div class="lg:col-span-2">
            <form action="<?php echo e(route('admin.settings.online-stores.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <div class="bg-white rounded-lg shadow mb-6">
                    <div class="p-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Store Information</h2>
                        
                        <div class="space-y-6">
                            <!-- Store Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Store Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="name" 
                                       value="<?php echo e(old('name')); ?>"
                                       required
                                       placeholder="e.g., Shopee Store, Instagram Shop"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <p class="text-xs text-gray-500 mt-1">This will be displayed as the store name</p>
                            </div>

                            <!-- Store URL -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Store URL <span class="text-red-500">*</span>
                                </label>
                                <input type="url" 
                                       name="url" 
                                       value="<?php echo e(old('url')); ?>"
                                       required
                                       placeholder="https://shopee.co.id/your-store"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <?php $__errorArgs = ['url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <p class="text-xs text-gray-500 mt-1">Full URL to your online store</p>
                            </div>

                            <!-- Platform -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Platform Type <span class="text-red-500">*</span>
                                </label>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                    <?php $__currentLoopData = $platforms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50 <?php echo e(old('platform') == $key ? 'border-blue-300 bg-blue-50' : 'border-gray-300'); ?>">
                                            <input type="radio" 
                                                   name="platform" 
                                                   value="<?php echo e($key); ?>" 
                                                   <?php echo e(old('platform') == $key ? 'checked' : (($key == 'ecommerce') ? 'checked' : '')); ?>

                                                   class="mr-3 text-blue-600">
                                            <div>
                                                <div class="font-medium">
                                                    <?php if($key == 'ecommerce'): ?>
                                                        <i class="fas fa-shopping-cart mr-2 text-purple-600"></i>
                                                    <?php elseif($key == 'social_media'): ?>
                                                        <i class="fas fa-hashtag mr-2 text-pink-600"></i>
                                                    <?php else: ?>
                                                        <i class="fas fa-store mr-2 text-green-600"></i>
                                                    <?php endif; ?>
                                                    <?php echo e(ucfirst($key)); ?>

                                                </div>
                                                <div class="text-xs text-gray-500 mt-1"><?php echo e(Str::limit($label, 30)); ?></div>
                                            </div>
                                        </label>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                                <?php $__errorArgs = ['platform'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Description -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <textarea name="description" 
                                          rows="3"
                                          placeholder="Brief description of what you sell or special offers..."
                                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"><?php echo e(old('description')); ?></textarea>
                                <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <p class="text-xs text-gray-500 mt-1">Optional description shown in tooltip</p>
                            </div>

                            <!-- Icon Selection -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Icon <span class="text-red-500">*</span>
                                </label>
                                <select name="icon_class" 
                                        required
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select an icon</option>
                                    <?php $__currentLoopData = $iconOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($value); ?>" <?php echo e(old('icon_class') == $value ? 'selected' : ''); ?>>
                                            <?php echo e($label); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['icon_class'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <p class="text-xs text-gray-500 mt-1">Choose an icon that represents this store</p>
                            </div>

                            <!-- Color Presets -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    Color Scheme <span class="text-red-500">*</span>
                                </label>
                                <p class="text-sm text-gray-600 mb-4">Choose a color scheme or create custom:</p>
                                
                                <!-- Preset Colors -->
                                <div class="grid grid-cols-4 md:grid-cols-8 gap-3 mb-6">
                                    <?php $__currentLoopData = $colorPresets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $preset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <label class="cursor-pointer">
                                            <input type="radio" 
                                                   name="color_preset" 
                                                   value="<?php echo e($index); ?>"
                                                   class="hidden color-preset-radio"
                                                   data-from="<?php echo e($preset[0]); ?>"
                                                   data-to="<?php echo e($preset[1]); ?>"
                                                   data-icon="<?php echo e($preset[2]); ?>"
                                                   data-color="<?php echo e($preset[3]); ?>">
                                            <div class="w-full h-12 rounded-lg overflow-hidden relative border-2 border-transparent hover:border-blue-500 color-preset">
                                                <div class="absolute inset-0" style="background: linear-gradient(135deg, <?php echo e($preset[0]); ?>, <?php echo e($preset[1]); ?>);"></div>
                                                <div class="absolute inset-0 flex items-center justify-center">
                                                    <i class="<?php echo e($preset[2]); ?> text-white text-lg"></i>
                                                </div>
                                            </div>
                                        </label>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>

                                <!-- Custom Colors -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4" id="custom-colors">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Main Color <span class="text-red-500">*</span>
                                        </label>
                                        <div class="flex items-center">
                                            <input type="color" 
                                                   name="color_picker" 
                                                   value="<?php echo e(old('color', '#4ECDC4')); ?>"
                                                   class="w-10 h-10 cursor-pointer mr-3">
                                            <input type="text" 
                                                   name="color" 
                                                   value="<?php echo e(old('color', '#4ECDC4')); ?>"
                                                   required
                                                   placeholder="#4ECDC4"
                                                   class="flex-1 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        <?php $__errorArgs = ['color'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Gradient From <span class="text-red-500">*</span>
                                        </label>
                                        <div class="flex items-center">
                                            <input type="color" 
                                                   name="gradient_from_picker" 
                                                   value="<?php echo e(old('gradient_from', '#4ECDC4')); ?>"
                                                   class="w-10 h-10 cursor-pointer mr-3">
                                            <input type="text" 
                                                   name="gradient_from" 
                                                   value="<?php echo e(old('gradient_from', '#4ECDC4')); ?>"
                                                   required
                                                   placeholder="#4ECDC4"
                                                   class="flex-1 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        <?php $__errorArgs = ['gradient_from'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Gradient To <span class="text-red-500">*</span>
                                        </label>
                                        <div class="flex items-center">
                                            <input type="color" 
                                                   name="gradient_to_picker" 
                                                   value="<?php echo e(old('gradient_to', '#45B7D1')); ?>"
                                                   class="w-10 h-10 cursor-pointer mr-3">
                                            <input type="text" 
                                                   name="gradient_to" 
                                                   value="<?php echo e(old('gradient_to', '#45B7D1')); ?>"
                                                   required
                                                   placeholder="#45B7D1"
                                                   class="flex-1 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        <?php $__errorArgs = ['gradient_to'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <!-- Preview -->
                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Preview</label>
                                    <div class="flex items-center space-x-4">
                                        <div class="w-16 h-16 rounded-xl flex items-center justify-center" 
                                             id="colorPreview" 
                                             style="background: linear-gradient(135deg, <?php echo e(old('gradient_from', '#4ECDC4')); ?>, <?php echo e(old('gradient_to', '#45B7D1')); ?>);">
                                            <i class="<?php echo e(old('icon_class', 'fas fa-store')); ?> text-white text-2xl" id="iconPreview"></i>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900" id="namePreview">Store Preview</div>
                                            <div class="text-sm text-gray-500" id="urlPreview">example.com</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Info -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Store Username</label>
                                    <input type="text" 
                                           name="store_username" 
                                           value="<?php echo e(old('store_username')); ?>"
                                           placeholder="@yourstore or your-store-name"
                                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <?php $__errorArgs = ['store_username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Store ID</label>
                                    <input type="text" 
                                           name="store_id" 
                                           value="<?php echo e(old('store_id')); ?>"
                                           placeholder="Store ID or shop ID"
                                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <?php $__errorArgs = ['store_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <!-- Order & Status -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Display Order</label>
                                    <input type="number" 
                                           name="order" 
                                           value="<?php echo e(old('order', 0)); ?>"
                                           min="0"
                                           step="1"
                                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <?php $__errorArgs = ['order'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <p class="text-xs text-gray-500 mt-1">Lower numbers appear first</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                    <div class="flex space-x-4">
                                        <label class="flex items-center">
                                            <input type="radio" 
                                                   name="is_active" 
                                                   value="1" 
                                                   <?php echo e(old('is_active', 1) == 1 ? 'checked' : ''); ?>

                                                   class="mr-2">
                                            <span class="text-green-600">Active</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="radio" 
                                                   name="is_active" 
                                                   value="0" 
                                                   <?php echo e(old('is_active') == 0 ? 'checked' : ''); ?>

                                                   class="mr-2">
                                            <span class="text-red-600">Inactive</span>
                                        </label>
                                    </div>
                                    <?php $__errorArgs = ['is_active'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Footer -->
                    <div class="px-6 py-4 bg-gray-50 border-t flex justify-between items-center">
                        <div>
                            <span class="text-sm text-gray-500">Fields marked with <span class="text-red-500">*</span> are required</span>
                        </div>
                        <div class="flex space-x-3">
                            <a href="<?php echo e(route('admin.settings.online-stores.index')); ?>" 
                               class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center">
                                <i class="fas fa-plus mr-2"></i>Add Store
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Sidebar Column -->
        <div>
            <!-- Tips Card -->
            <div class="bg-white rounded-lg shadow mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>
                        Tips
                    </h3>
                    
                    <div class="space-y-3">
                        <div class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-0.5 mr-2"></i>
                            <p class="text-sm text-gray-600">Use descriptive names that customers will recognize</p>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-0.5 mr-2"></i>
                            <p class="text-sm text-gray-600">Choose colors that match your brand identity</p>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-0.5 mr-2"></i>
                            <p class="text-sm text-gray-600">Ensure URLs are correct and accessible</p>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-0.5 mr-2"></i>
                            <p class="text-sm text-gray-600">Use order numbers to control display sequence</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Platform Info Card -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Platform Examples</h3>
                    
                    <div class="space-y-4">
                        <div class="border border-gray-200 rounded-lg p-3">
                            <div class="flex items-center mb-2">
                                <div class="w-8 h-8 rounded-lg bg-purple-100 flex items-center justify-center mr-2">
                                    <i class="fas fa-shopping-cart text-purple-600"></i>
                                </div>
                                <span class="font-medium">E-commerce</span>
                            </div>
                            <p class="text-xs text-gray-500">Shopee, Tokopedia, Bukalapak, Lazada</p>
                        </div>
                        
                        <div class="border border-gray-200 rounded-lg p-3">
                            <div class="flex items-center mb-2">
                                <div class="w-8 h-8 rounded-lg bg-pink-100 flex items-center justify-center mr-2">
                                    <i class="fas fa-hashtag text-pink-600"></i>
                                </div>
                                <span class="font-medium">Social Media</span>
                            </div>
                            <p class="text-xs text-gray-500">Instagram, Facebook, TikTok, WhatsApp</p>
                        </div>
                        
                        <div class="border border-gray-200 rounded-lg p-3">
                            <div class="flex items-center mb-2">
                                <div class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center mr-2">
                                    <i class="fas fa-store text-green-600"></i>
                                </div>
                                <span class="font-medium">Marketplace</span>
                            </div>
                            <p class="text-xs text-gray-500">Blibli, JD.id, Bhinneka, Ralali</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Color picker synchronization
    const colorPicker = document.querySelector('input[name="color_picker"]');
    const colorInput = document.querySelector('input[name="color"]');
    const gradientFromPicker = document.querySelector('input[name="gradient_from_picker"]');
    const gradientFromInput = document.querySelector('input[name="gradient_from"]');
    const gradientToPicker = document.querySelector('input[name="gradient_to_picker"]');
    const gradientToInput = document.querySelector('input[name="gradient_to"]');
    
    // Color preset selection
    const colorPresets = document.querySelectorAll('.color-preset-radio');
    
    // Preview elements
    const colorPreview = document.getElementById('colorPreview');
    const iconPreview = document.getElementById('iconPreview');
    const namePreview = document.getElementById('namePreview');
    const urlPreview = document.getElementById('urlPreview');
    
    // Sync color pickers with inputs
    colorPicker.addEventListener('input', function() {
        colorInput.value = this.value;
        updatePreview();
    });
    
    colorInput.addEventListener('input', function() {
        colorPicker.value = this.value;
        updatePreview();
    });
    
    gradientFromPicker.addEventListener('input', function() {
        gradientFromInput.value = this.value;
        updatePreview();
    });
    
    gradientFromInput.addEventListener('input', function() {
        gradientFromPicker.value = this.value;
        updatePreview();
    });
    
    gradientToPicker.addEventListener('input', function() {
        gradientToInput.value = this.value;
        updatePreview();
    });
    
    gradientToInput.addEventListener('input', function() {
        gradientToPicker.value = this.value;
        updatePreview();
    });
    
    // Handle color preset selection
    colorPresets.forEach(preset => {
        preset.addEventListener('change', function() {
            if (this.checked) {
                gradientFromInput.value = this.dataset.from;
                gradientFromPicker.value = this.dataset.from;
                gradientToInput.value = this.dataset.to;
                gradientToPicker.value = this.dataset.to;
                colorInput.value = this.dataset.color;
                colorPicker.value = this.dataset.color;
                
                // Update icon if available
                const iconSelect = document.querySelector('select[name="icon_class"]');
                if (iconSelect) {
                    iconSelect.value = this.dataset.icon;
                    iconPreview.className = this.dataset.icon + ' text-white text-2xl';
                }
                
                updatePreview();
            }
        });
    });
    
    // Update store name preview
    const nameInput = document.querySelector('input[name="name"]');
    const urlInput = document.querySelector('input[name="url"]');
    const iconSelect = document.querySelector('select[name="icon_class"]');
    
    nameInput.addEventListener('input', updatePreview);
    urlInput.addEventListener('input', updatePreview);
    iconSelect.addEventListener('change', function() {
        iconPreview.className = this.value + ' text-white text-2xl';
    });
    
    function updatePreview() {
        // Update gradient preview
        const from = gradientFromInput.value || '#4ECDC4';
        const to = gradientToInput.value || '#45B7D1';
        colorPreview.style.background = `linear-gradient(135deg, ${from}, ${to})`;
        
        // Update name and URL preview
        namePreview.textContent = nameInput.value || 'Store Preview';
        urlPreview.textContent = urlInput.value ? 
            new URL(urlInput.value).hostname : 'example.com';
    }
    
    // Initial preview update
    updatePreview();
});
</script>

<style>
.color-preset input:checked + div {
    border-color: #3b82f6 !important;
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
}
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('pages.admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\revisiimaji\resources\views/pages/admin/settings/online-stores/create.blade.php ENDPATH**/ ?>