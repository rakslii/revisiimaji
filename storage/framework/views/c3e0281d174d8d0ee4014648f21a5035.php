

<?php $__env->startSection('title', 'Create Banner'); ?>
<?php $__env->startSection('page-title', 'Create Banner'); ?>
<?php $__env->startSection('page-description', 'Add a new banner to your website'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-6">
    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="text-gray-700 hover:text-blue-600">
                    <i class="fas fa-home mr-2"></i>Dashboard
                </a>
            </li>
            <li class="inline-flex items-center">
                <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                <a href="<?php echo e(route('admin.settings.banners.index')); ?>" class="text-gray-700 hover:text-blue-600">
                    Banners
                </a>
            </li>
            <li aria-current="page" class="inline-flex items-center">
                <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                <span class="text-blue-600 font-medium">Create <?php echo e(ucfirst(str_replace('_', ' ', $type))); ?></span>
            </li>
        </ol>
    </nav>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <form action="<?php echo e(route('admin.settings.banners.store')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="type" value="<?php echo e($type); ?>">

            <!-- Form Header -->
            <div class="px-6 py-4 bg-gray-50 border-b">
                <h3 class="text-lg font-medium text-gray-900">Banner Information</h3>
                <p class="text-sm text-gray-600 mt-1">Fill in the details for your new banner</p>
            </div>

            <!-- Form Body -->
            <div class="p-6">
                <?php if($errors->any()): ?>
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc list-inside">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
                <?php endif; ?>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div>
                        <h4 class="font-medium text-gray-900 mb-4">Basic Information</h4>
                        
                        <!-- Title -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Title <span class="text-gray-400">(Optional)</span>
                            </label>
                            <input type="text" 
                                   name="title" 
                                   value="<?php echo e(old('title')); ?>"
                                   class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                   placeholder="e.g. Summer Sale 2024">
                            <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Subtitle -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Subtitle <span class="text-gray-400">(Optional)</span>
                            </label>
                            <input type="text" 
                                   name="subtitle" 
                                   value="<?php echo e(old('subtitle')); ?>"
                                   class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                   placeholder="e.g. Up to 50% off">
                            <?php $__errorArgs = ['subtitle'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Description <span class="text-gray-400">(Optional)</span>
                            </label>
                            <textarea name="description" 
                                      rows="4"
                                      class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                      placeholder="Brief description of the promotion..."><?php echo e(old('description')); ?></textarea>
                            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Link -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Link URL <span class="text-gray-400">(Optional)</span>
                            </label>
                            <input type="url" 
                                   name="link" 
                                   value="<?php echo e(old('link')); ?>"
                                   placeholder="https://example.com/promo"
                                   class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            <p class="text-xs text-gray-500 mt-1">Leave empty if no link</p>
                            <?php $__errorArgs = ['link'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Button Text -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Button Text
                            </label>
                            <input type="text" 
                                   name="button_text" 
                                   value="<?php echo e(old('button_text', 'Lihat Promo')); ?>"
                                   class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            <?php $__errorArgs = ['button_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div>
                        <h4 class="font-medium text-gray-900 mb-4">Images & Settings</h4>
                        
                        <!-- Main Image Upload -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Banner Image <span class="text-red-500">*</span>
                            </label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center relative hover:border-blue-400 transition-colors">
                                <div id="image-preview" class="mb-3 hidden">
                                    <img src="" class="max-h-40 mx-auto rounded-lg shadow">
                                </div>
                                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                                <p class="text-sm text-gray-600">Click to upload or drag and drop</p>
                                <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF, WEBP up to 2MB</p>
                                <p class="text-xs text-gray-500">Recommended size: 1200 x 600 pixels</p>
                                <input type="file" 
                                       name="image" 
                                       id="image-input"
                                       accept="image/*"
                                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                            </div>
                            <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Mobile Image Upload (Optional) -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Mobile Image <span class="text-gray-400">(Optional)</span>
                            </label>
                            <input type="file" 
                                   name="mobile_image" 
                                   accept="image/*"
                                   class="w-full rounded-lg border-gray-300">
                            <p class="text-xs text-gray-500 mt-1">If not provided, main image will be used for mobile</p>
                            <p class="text-xs text-gray-500">Recommended size: 600 x 600 pixels</p>
                            <?php $__errorArgs = ['mobile_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Display Order -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Display Order
                            </label>
                            <input type="number" 
                                   name="display_order" 
                                   value="<?php echo e(old('display_order', 0)); ?>"
                                   min="0"
                                   class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            <p class="text-xs text-gray-500 mt-1">Lower numbers appear first</p>
                        </div>

                        <!-- Active Status -->
                        <div class="mb-4">
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       name="is_active" 
                                       value="1"
                                       <?php echo e(old('is_active', true) ? 'checked' : ''); ?>

                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Active</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Popup Settings (Only for popup type) -->
                <?php if($type == 'popup'): ?>
                <div class="mt-8 pt-6 border-t">
                    <h4 class="font-medium text-gray-900 mb-4">Popup Settings</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Position -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Position</label>
                            <select name="position" class="w-full rounded-lg border-gray-300">
                                <option value="center" <?php echo e(old('position') == 'center' ? 'selected' : ''); ?>>Center</option>
                                <option value="top" <?php echo e(old('position') == 'top' ? 'selected' : ''); ?>>Top</option>
                                <option value="bottom" <?php echo e(old('position') == 'bottom' ? 'selected' : ''); ?>>Bottom</option>
                                <option value="left" <?php echo e(old('position') == 'left' ? 'selected' : ''); ?>>Left</option>
                                <option value="right" <?php echo e(old('position') == 'right' ? 'selected' : ''); ?>>Right</option>
                            </select>
                        </div>

                        <!-- Size -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Size</label>
                            <select name="size" class="w-full rounded-lg border-gray-300">
                                <option value="small" <?php echo e(old('size') == 'small' ? 'selected' : ''); ?>>Small</option>
                                <option value="medium" <?php echo e(old('size') == 'medium' ? 'selected' : ''); ?>>Medium</option>
                                <option value="large" <?php echo e(old('size') == 'large' ? 'selected' : ''); ?>>Large</option>
                                <option value="full" <?php echo e(old('size') == 'full' ? 'selected' : ''); ?>>Full Screen</option>
                            </select>
                        </div>

                        <!-- Delay -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Delay (seconds)</label>
                            <input type="number" 
                                   name="delay_seconds" 
                                   value="<?php echo e(old('delay_seconds', 3)); ?>"
                                   min="0"
                                   max="60"
                                   class="w-full rounded-lg border-gray-300">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="show_close_button" value="1" <?php echo e(old('show_close_button', true) ? 'checked' : ''); ?> class="rounded">
                            <span class="ml-2 text-sm text-gray-700">Show close button</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="show_once_per_session" value="1" <?php echo e(old('show_once_per_session', true) ? 'checked' : ''); ?> class="rounded">
                            <span class="ml-2 text-sm text-gray-700">Show once per session</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="show_on_mobile" value="1" <?php echo e(old('show_on_mobile', true) ? 'checked' : ''); ?> class="rounded">
                            <span class="ml-2 text-sm text-gray-700">Show on mobile</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="show_on_desktop" value="1" <?php echo e(old('show_on_desktop', true) ? 'checked' : ''); ?> class="rounded">
                            <span class="ml-2 text-sm text-gray-700">Show on desktop</span>
                        </label>
                    </div>
                </div>

                <!-- Background Settings -->
                <div class="mt-6 pt-6 border-t">
                    <h4 class="font-medium text-gray-900 mb-4">Background Settings</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Background Color</label>
                            <div class="flex items-center">
                                <input type="color" 
                                       name="background_color" 
                                       value="<?php echo e(old('background_color', '#ffffff')); ?>"
                                       class="w-12 h-10 rounded border-gray-300 mr-2">
                                <input type="text" 
                                       value="<?php echo e(old('background_color', '#ffffff')); ?>"
                                       class="flex-1 rounded-lg border-gray-300"
                                       id="background_color_text">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Background Opacity (%)</label>
                            <input type="number" 
                                   name="background_opacity" 
                                   value="<?php echo e(old('background_opacity', 100)); ?>"
                                   min="0"
                                   max="100"
                                   class="w-full rounded-lg border-gray-300">
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Date Settings -->
                <div class="mt-6 pt-6 border-t">
                    <h4 class="font-medium text-gray-900 mb-4">Schedule (Optional)</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                            <input type="datetime-local" 
                                   name="start_date" 
                                   value="<?php echo e(old('start_date')); ?>"
                                   class="w-full rounded-lg border-gray-300">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                            <input type="datetime-local" 
                                   name="end_date" 
                                   value="<?php echo e(old('end_date')); ?>"
                                   class="w-full rounded-lg border-gray-300">
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Leave empty for no time limit</p>
                </div>
            </div>

            <!-- Form Footer -->
            <div class="px-6 py-4 bg-gray-50 border-t flex justify-end space-x-3">
                <a href="<?php echo e(route('admin.settings.banners.index')); ?>" 
                   class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                    <i class="fas fa-save mr-2"></i>
                    Create Banner
                </button>
            </div>
        </form>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.getElementById('image-input')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('image-preview');
            const img = preview.querySelector('img');
            img.src = e.target.result;
            preview.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
});

// Sync color input with text input
const colorInput = document.querySelector('input[name="background_color"]');
const colorText = document.getElementById('background_color_text');
if (colorInput && colorText) {
    colorInput.addEventListener('input', function() {
        colorText.value = this.value;
    });
    colorText.addEventListener('input', function() {
        colorInput.value = this.value;
    });
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('pages.admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\revisiimaji\resources\views/pages/admin/settings/banners/create.blade.php ENDPATH**/ ?>