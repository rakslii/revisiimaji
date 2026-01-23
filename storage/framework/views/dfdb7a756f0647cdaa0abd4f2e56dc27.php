<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Admin Panel'); ?> - <?php echo e(config('app.name', 'Cipta Imaji')); ?></title>
    
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="bg-gray-100">
    <!-- Sidebar -->
    <?php echo $__env->make('pages.admin.layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    <div class="ml-64"> <!-- Sesuaikan dengan width sidebar -->
        <!-- Header -->
        <?php echo $__env->make('pages.admin.layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        
        <!-- Main Content -->
        <main class="p-6">
            <!-- Page Header -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800"><?php echo $__env->yieldContent('page-title'); ?></h1>
                <p class="text-gray-600 mt-1"><?php echo $__env->yieldContent('page-description'); ?></p>
            </div>
            
            <!-- Alerts -->
            <?php if(session('success')): ?>
                <?php echo $__env->make('pages.admin.components.alert', ['type' => 'success', 'message' => session('success')], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endif; ?>
            
            <?php if(session('error')): ?>
                <?php echo $__env->make('pages.admin.components.alert', ['type' => 'error', 'message' => session('error')], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endif; ?>
            
            <!-- Page Content -->
            <?php echo $__env->yieldContent('content'); ?>
        </main>
        
        <!-- Footer -->
        <?php echo $__env->make('pages.admin.layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
    
    <?php echo $__env->make('pages.admin.layouts.scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>
</html><?php /**PATH C:\laragon\www\cangcut\revisiimaji\resources\views/pages/admin/layouts/app.blade.php ENDPATH**/ ?>