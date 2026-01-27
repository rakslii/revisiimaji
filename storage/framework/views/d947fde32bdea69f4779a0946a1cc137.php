<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - <?php echo $__env->yieldContent('title', 'Dashboard'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lucide@latest/dist/umd/lucide.css">
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-100">
    <?php $__env->startSection('sidebar'); ?>
    <!-- Sidebar -->
    <div :class="sidebarOpen ? 'w-64' : 'w-20'" 
         class="bg-gray-900 text-white transition-all duration-300 flex flex-col h-screen fixed left-0 top-0">
        <div class="p-4 flex items-center justify-between border-b border-gray-800">
            <template x-if="sidebarOpen">
                <h2 class="text-xl font-bold">Admin Panel</h2>
            </template>
            <button @click="sidebarOpen = !sidebarOpen" class="p-2 hover:bg-gray-800 rounded">
                <i x-show="sidebarOpen" data-lucide="x" class="w-5 h-5"></i>
                <i x-show="!sidebarOpen" data-lucide="menu" class="w-5 h-5"></i>
            </button>
        </div>

        <nav class="flex-1 p-4">
            <?php $__currentLoopData = [
                ['id' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'layout-dashboard'],
                ['id' => 'orders', 'label' => 'Orders', 'icon' => 'shopping-cart'],
                ['id' => 'products', 'label' => 'Products', 'icon' => 'package'],
                ['id' => 'promos', 'label' => 'Promo Codes', 'icon' => 'tag'],
                ['id' => 'locations', 'label' => 'Locations', 'icon' => 'map-pin']
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('admin.' . $item['id'])); ?>"
                   class="w-full flex items-center gap-3 p-3 rounded-lg mb-2 transition-colors
                          <?php echo e(request()->routeIs('admin.' . $item['id']) ? 'bg-blue-600' : 'hover:bg-gray-800'); ?>">
                    <i data-lucide="<?php echo e($item['icon']); ?>" class="w-5 h-5"></i>
                    <template x-if="sidebarOpen">
                        <span><?php echo e($item['label']); ?></span>
                    </template>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </nav>

        <div class="p-4 border-t border-gray-800">
            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="w-full flex items-center gap-3 p-3 rounded-lg hover:bg-gray-800">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                    <template x-if="sidebarOpen">
                        <span>Logout</span>
                    </template>
                </button>
            </form>
        </div>
    </div>
    <?php echo $__env->yieldSection(); ?>

    <!-- Main Content -->
    <div class="ml-20 lg:ml-64">
        <!-- Header -->
        <div class="bg-white shadow-sm border-b">
            <div class="px-8 py-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-semibold text-gray-800">Welcome, Admin</h2>
                    <div class="flex items-center gap-4">
                        <div class="text-right">
                            <p class="text-sm text-gray-600">Admin Account</p>
                            <p class="text-sm font-medium"><?php echo e(Auth::user()->email ?? 'admin@example.com'); ?></p>
                        </div>
                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-semibold">
                            <?php echo e(strtoupper(substr(Auth::user()->name ?? 'A', 0, 1))); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page Content -->
        <div class="p-8">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('adminPanel', () => ({
                sidebarOpen: true,
                selectedOrder: null,
                
                init() {
                    lucide.createIcons();
                },
                
                getStatusColor(status) {
                    const colors = {
                        'paid': 'bg-green-100 text-green-800',
                        'unpaid': 'bg-red-100 text-red-800',
                        'processed': 'bg-blue-100 text-blue-800',
                        'done': 'bg-purple-100 text-purple-800'
                    };
                    return colors[status] || 'bg-gray-100 text-gray-800';
                },
                
                openWhatsApp(phone) {
                    window.open(`https://wa.me/62${phone.substring(1)}`, '_blank');
                }
            }));
        });
    </script>
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH D:\ciptaimaji\revisiimaji\resources\views\layouts\admin.blade.php ENDPATH**/ ?>