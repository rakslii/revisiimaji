

<?php $__env->startSection('title', 'Settings'); ?>
<?php $__env->startSection('page-title', 'Settings'); ?>
<?php $__env->startSection('page-description', 'Configure your store settings'); ?>

<?php $__env->startSection('content'); ?>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Admin Users -->
    <a href="<?php echo e(route('admin.settings.admin-users.index')); ?>" 
       class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow duration-300">
        <div class="flex items-center space-x-4">
            <div class="p-3 bg-blue-100 text-blue-600 rounded-lg">
                <i class="fas fa-users text-xl"></i>
            </div>
            <div>
                <h3 class="font-semibold text-lg">Admin Users</h3>
                <p class="text-gray-600 text-sm mt-1">Manage administrator accounts</p>
            </div>
        </div>
    </a>

    <!-- Online Stores -->
    <a href="<?php echo e(route('admin.settings.online-stores.index')); ?>" 
       class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow duration-300">
        <div class="flex items-center space-x-4">
            <div class="p-3 bg-green-100 text-green-600 rounded-lg">
                <i class="fas fa-store text-xl"></i>
            </div>
            <div>
                <h3 class="font-semibold text-lg">Online Stores</h3>
                <p class="text-gray-600 text-sm mt-1">Manage online store platforms</p>
            </div>
        </div>
    </a>

    <!-- General Settings -->
    <a href="<?php echo e(route('admin.settings.general.index')); ?>" 
       class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow duration-300">
        <div class="flex items-center space-x-4">
            <div class="p-3 bg-purple-100 text-purple-600 rounded-lg">
                <i class="fas fa-cog text-xl"></i>
            </div>
            <div>
                <h3 class="font-semibold text-lg">General Settings</h3>
                <p class="text-gray-600 text-sm mt-1">Basic store configuration</p>
            </div>
        </div>
    </a>

    <!-- About Us -->
    <a href="<?php echo e(route('admin.settings.about-us.index')); ?>" 
       class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow duration-300">
        <div class="flex items-center space-x-4">
            <div class="p-3 bg-yellow-100 text-yellow-600 rounded-lg">
                <i class="fas fa-info-circle text-xl"></i>
            </div>
            <div>
                <h3 class="font-semibold text-lg">About Us</h3>
                <p class="text-gray-600 text-sm mt-1">Manage about us page content</p>
            </div>
        </div>
    </a>

    <!-- Banners -->
    <a href="<?php echo e(route('admin.settings.banners.index')); ?>" 
       class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow duration-300">
        <div class="flex items-center space-x-4">
            <div class="p-3 bg-red-100 text-red-600 rounded-lg">
                <i class="fas fa-image text-xl"></i>
            </div>
            <div>
                <h3 class="font-semibold text-lg">Banners</h3>
                <p class="text-gray-600 text-sm mt-1">Manage website banners</p>
            </div>
        </div>
    </a>

    <!-- Consultations -->
    <a href="<?php echo e(route('admin.settings.consultations.index')); ?>" 
       class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow duration-300">
        <div class="flex items-center space-x-4">
            <div class="p-3 bg-teal-100 text-teal-600 rounded-lg">
                <i class="fas fa-comments text-xl"></i>
            </div>
            <div>
                <h3 class="font-semibold text-lg">Consultations</h3>
                <p class="text-gray-600 text-sm mt-1">Manage consultation settings</p>
            </div>
        </div>
    </a>

    <!-- Payment Settings -->
    <a href="<?php echo e(route('admin.settings.payments.index')); ?>" 
       class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow duration-300">
        <div class="flex items-center space-x-4">
            <div class="p-3 bg-indigo-100 text-indigo-600 rounded-lg">
                <i class="fas fa-credit-card text-xl"></i>
            </div>
            <div>
                <h3 class="font-semibold text-lg">Payment Settings</h3>
                <p class="text-gray-600 text-sm mt-1">Configure payment methods</p>
            </div>
        </div>
    </a>

    <!-- Shipping Settings -->
    <a href="<?php echo e(route('admin.settings.shippings.index')); ?>" 
       class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow duration-300">
        <div class="flex items-center space-x-4">
            <div class="p-3 bg-pink-100 text-pink-600 rounded-lg">
                <i class="fas fa-shipping-fast text-xl"></i>
            </div>
            <div>
                <h3 class="font-semibold text-lg">Shipping Settings</h3>
                <p class="text-gray-600 text-sm mt-1">Configure shipping options</p>
            </div>
        </div>
    </a>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .hover\:shadow-lg:hover {
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('pages.admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\revisiimaji\resources\views/pages/admin/settings/index.blade.php ENDPATH**/ ?>