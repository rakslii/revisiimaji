

<?php $__env->startSection('title', 'Settings'); ?>
<?php $__env->startSection('page-title', 'Settings'); ?>
<?php $__env->startSection('page-description', 'Configure your store settings'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- General Settings -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b">
            <h2 class="text-xl font-semibold">General Settings</h2>
            <p class="text-gray-600 text-sm mt-1">Basic store configuration</p>
        </div>
        
        <div class="p-6">
            <form method="POST" action="<?php echo e(route('admin.settings.update')); ?>">
                <?php echo csrf_field(); ?>
                
                <div class="space-y-6">
                    <!-- Site Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Site Name</label>
                        <input type="text" name="site_name" value="<?php echo e(old('site_name')); ?>" 
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <!-- Site Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Site Email</label>
                        <input type="email" name="site_email" value="<?php echo e(old('site_email')); ?>"
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <!-- Site Phone -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Site Phone</label>
                        <input type="text" name="site_phone" value="<?php echo e(old('site_phone')); ?>"
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <!-- WhatsApp Number -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">WhatsApp Number</label>
                        <input type="text" name="whatsapp_number" value="<?php echo e(old('whatsapp_number')); ?>"
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                               placeholder="6281234567890">
                    </div>
                    
                    <!-- Submit -->
                    <div class="pt-4">
                        <button type="submit" 
                                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Save Settings
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Other Settings Sections -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Payment Settings -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b">
                <h3 class="font-semibold">Payment Settings</h3>
            </div>
            <div class="p-6">
                <p class="text-gray-600 text-sm">Configure payment methods</p>
                <!-- Add payment settings here -->
            </div>
        </div>
        
        <!-- Shipping Settings -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b">
                <h3 class="font-semibold">Shipping Settings</h3>
            </div>
            <div class="p-6">
                <p class="text-gray-600 text-sm">Configure shipping options</p>
                <!-- Add shipping settings here -->
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('pages.admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ciptaimaji\revisiimaji\resources\views\pages\admin\settings\index.blade.php ENDPATH**/ ?>