

<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('page-title', 'Dashboard'); ?>
<?php $__env->startSection('page-description', 'Ringkasan data toko Anda'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <?php echo $__env->make('pages.admin.components.stats-card', [
            'title' => 'Total Orders',
            'value' => $stats['total_orders'] ?? 0,
            'icon' => 'fas fa-shopping-cart',
            'color' => 'blue'
        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        
        <?php echo $__env->make('pages.admin.components.stats-card', [
            'title' => 'Total Customers',
            'value' => $stats['total_customers'] ?? 0,
            'icon' => 'fas fa-users',
            'color' => 'green'
        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        
        <?php echo $__env->make('pages.admin.components.stats-card', [
            'title' => 'Total Products',
            'value' => $stats['total_products'] ?? 0,
            'icon' => 'fas fa-box',
            'color' => 'purple'
        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        
        <?php echo $__env->make('pages.admin.components.stats-card', [
            'title' => 'Promo Codes',
            'value' => $stats['total_promo_codes'] ?? 0,
            'icon' => 'fas fa-tag',
            'color' => 'orange'
        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
    
    <!-- Recent Orders -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold">Recent Orders</h2>
                <a href="<?php echo e(route('admin.orders')); ?>" class="text-blue-600 hover:text-blue-800 text-sm">
                    View All <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <?php echo $__env->make('pages.admin.components.datatable', [
                'headers' => ['Order ID', 'Customer', 'Amount', 'Status', 'Date'],
                'data' => $recent_orders ?? []
            ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('pages.admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\revisiimaji\resources\views\pages\admin\dashboard\index.blade.php ENDPATH**/ ?>