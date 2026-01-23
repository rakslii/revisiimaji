<header class="bg-white shadow-sm border-b">
    <div class="px-6 py-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <!-- Mobile menu button (optional) -->
                <button class="lg:hidden text-gray-500">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            
            <div class="flex items-center space-x-4">
                <?php if(auth()->guard()->check()): ?>
                    <div class="text-right">
                        <p class="text-sm text-gray-600">Welcome back,</p>
                        <p class="text-sm font-medium"><?php echo e(auth()->user()->name ?? 'Admin'); ?></p>
                    </div>
                    <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-semibold">
                        <?php echo e(strtoupper(substr(auth()->user()->name ?? 'A', 0, 1))); ?>

                    </div>
                <?php else: ?>
                    <div class="text-right">
                        <p class="text-sm text-gray-600">Welcome</p>
                        <p class="text-sm font-medium">Guest</p>
                    </div>
                    <div class="w-10 h-10 bg-gray-400 rounded-full flex items-center justify-center text-white font-semibold">
                        G
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header><?php /**PATH C:\laragon\www\cangcut\revisiimaji\resources\views/pages/admin/layouts/header.blade.php ENDPATH**/ ?>