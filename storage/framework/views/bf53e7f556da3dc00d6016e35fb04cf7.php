

<?php $__env->startSection('title', 'Online Stores'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-6">
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
                <li aria-current="page" class="inline-flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-blue-600 font-medium">Online Stores</span>
                </li>
            </ol>
        </nav>
        
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Online Stores</h1>
                <p class="text-gray-600 mt-1">Manage your online store links for the website</p>
            </div>
            
            <a href="<?php echo e(route('admin.settings.online-stores.create')); ?>" 
               class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center">
                <i class="fas fa-plus mr-2"></i>Add Store
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    <?php if(session('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <?php echo e(session('success')); ?>

            </div>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <?php echo e(session('error')); ?>

            </div>
        </div>
    <?php endif; ?>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <div class="flex flex-wrap gap-4 items-center">
            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <div class="flex space-x-2">
                    <a href="<?php echo e(route('admin.settings.online-stores.index', array_merge(request()->except(['status', 'page']), ['status' => '']))); ?>" 
                       class="px-3 py-1 rounded-lg <?php echo e(!request()->has('status') ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'); ?>">
                        All
                    </a>
                    <a href="<?php echo e(route('admin.settings.online-stores.index', array_merge(request()->except(['status', 'page']), ['status' => 'active']))); ?>" 
                       class="px-3 py-1 rounded-lg <?php echo e(request('status') == 'active' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'); ?>">
                        Active
                    </a>
                    <a href="<?php echo e(route('admin.settings.online-stores.index', array_merge(request()->except(['status', 'page']), ['status' => 'inactive']))); ?>" 
                       class="px-3 py-1 rounded-lg <?php echo e(request('status') == 'inactive' ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'); ?>">
                        Inactive
                    </a>
                </div>
            </div>

            <!-- Platform Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Platform</label>
                <select onchange="window.location.href = this.value" 
                        class="border border-gray-300 rounded-lg px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="<?php echo e(route('admin.settings.online-stores.index', request()->except(['platform', 'page']))); ?>">All Platforms</option>
                    <?php $__currentLoopData = $platformOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e(route('admin.settings.online-stores.index', array_merge(request()->except(['platform', 'page']), ['platform' => $key]))); ?>"
                                <?php echo e(request('platform') == $key ? 'selected' : ''); ?>>
                            <?php echo e($label); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <!-- Search -->
            <div class="flex-1 min-w-[200px]">
                <form method="GET" action="<?php echo e(route('admin.settings.online-stores.index')); ?>">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <div class="flex">
                        <input type="text" 
                               name="search" 
                               value="<?php echo e(request('search')); ?>"
                               placeholder="Search stores..."
                               class="flex-1 border border-gray-300 rounded-l-lg px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <button type="submit" 
                                class="bg-blue-600 text-white px-4 rounded-r-lg hover:bg-blue-700">
                            <i class="fas fa-search"></i>
                        </button>
                        <?php if(request()->has('search')): ?>
                            <a href="<?php echo e(route('admin.settings.online-stores.index', request()->except(['search', 'page']))); ?>" 
                               class="ml-2 bg-gray-300 text-gray-700 px-3 rounded-lg hover:bg-gray-400 flex items-center">
                                <i class="fas fa-times"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>

   <!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="rounded-lg bg-blue-100 p-3 mr-4">
                <i class="fas fa-store text-blue-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Total Stores</p>
                <p class="text-2xl font-bold text-gray-900"><?php echo e($stats['total'] ?? 0); ?></p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="rounded-lg bg-green-100 p-3 mr-4">
                <i class="fas fa-check-circle text-green-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Active Stores</p>
                <p class="text-2xl font-bold text-gray-900"><?php echo e($stats['active'] ?? 0); ?></p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="rounded-lg bg-red-100 p-3 mr-4">
                <i class="fas fa-times-circle text-red-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Inactive Stores</p>
                <p class="text-2xl font-bold text-gray-900"><?php echo e($stats['inactive'] ?? 0); ?></p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="rounded-lg bg-purple-100 p-3 mr-4">
                <i class="fas fa-layer-group text-purple-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Platforms</p>
                <p class="text-2xl font-bold text-gray-900"><?php echo e(count($platformOptions)); ?></p>
            </div>
        </div>
    </div>
</div>
    <!-- Stores Grid -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <?php if($stores->count() > 0): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                <?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        <!-- Store Header with Gradient -->
                        <div class="h-32 relative" style="background: linear-gradient(135deg, <?php echo e($store->gradient_from); ?>, <?php echo e($store->gradient_to); ?>);">
                            <div class="absolute top-3 right-3">
                                <span class="px-2 py-1 text-xs rounded-full <?php echo e($store->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                    <?php echo e($store->is_active ? 'Active' : 'Inactive'); ?>

                                </span>
                            </div>
                            <div class="absolute top-3 left-3">
                                <span class="px-2 py-1 text-xs rounded-full bg-white/20 text-white backdrop-blur-sm">
                                    <?php echo e($store->platform_label); ?>

                                </span>
                            </div>
                            <div class="absolute bottom-3 left-3">
                                <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center">
                                    <i class="<?php echo e($store->icon_class); ?> text-white text-2xl"></i>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Store Body -->
                        <div class="p-4">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h3 class="font-bold text-gray-900 text-lg"><?php echo e($store->name); ?></h3>
                                    <p class="text-sm text-gray-500 mt-1"><?php echo e($store->display_url); ?></p>
                                </div>
                                <span class="text-xs text-gray-400">#<?php echo e($store->order); ?></span>
                            </div>
                            
                            <?php if($store->description): ?>
                                <p class="text-sm text-gray-600 mb-4 line-clamp-2"><?php echo e($store->description); ?></p>
                            <?php endif; ?>
                            
                            <!-- Store Info -->
                            <div class="space-y-2 text-sm mb-4">
                                <?php if($store->store_username): ?>
                                    <div class="flex items-center text-gray-600">
                                        <i class="fas fa-user mr-2 text-gray-400"></i>
                                        <span><?php echo e($store->store_username); ?></span>
                                    </div>
                                <?php endif; ?>
                                <?php if($store->store_id): ?>
                                    <div class="flex items-center text-gray-600">
                                        <i class="fas fa-id-card mr-2 text-gray-400"></i>
                                        <span>ID: <?php echo e($store->store_id); ?></span>
                                    </div>
                                <?php endif; ?>
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-calendar mr-2 text-gray-400"></i>
                                    <span>Created: <?php echo e($store->created_at->format('d/m/Y')); ?></span>
                                </div>
                            </div>
                            
                            <!-- Actions -->
                            <div class="flex justify-between items-center pt-4 border-t">
                                <div class="flex space-x-2">
                                    <a href="<?php echo e($store->url); ?>" 
                                       target="_blank"
                                       class="text-blue-600 hover:text-blue-800 transition-colors"
                                       title="Visit Store">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                    <a href="<?php echo e(route('admin.settings.online-stores.edit', $store->id)); ?>" 
                                       class="text-green-600 hover:text-green-800 transition-colors"
                                       title="Edit Store">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <!-- Reorder Buttons -->
                                    <div class="flex space-x-1">
                                        <form action="<?php echo e(route('admin.settings.online-stores.reorder', $store->id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('POST'); ?>
                                            <input type="hidden" name="direction" value="up">
                                            <button type="submit" 
                                                    class="text-gray-600 hover:text-gray-800 transition-colors <?php echo e($loop->first ? 'opacity-30 cursor-not-allowed' : ''); ?>"
                                                    title="Move Up"
                                                    <?php echo e($loop->first ? 'disabled' : ''); ?>>
                                                <i class="fas fa-arrow-up"></i>
                                            </button>
                                        </form>
                                        <form action="<?php echo e(route('admin.settings.online-stores.reorder', $store->id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('POST'); ?>
                                            <input type="hidden" name="direction" value="down">
                                            <button type="submit" 
                                                    class="text-gray-600 hover:text-gray-800 transition-colors <?php echo e($loop->last ? 'opacity-30 cursor-not-allowed' : ''); ?>"
                                                    title="Move Down"
                                                    <?php echo e($loop->last ? 'disabled' : ''); ?>>
                                                <i class="fas fa-arrow-down"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                
                                <div class="flex space-x-2">
                                    <!-- Toggle Status -->
                                    <form action="<?php echo e(route('admin.settings.online-stores.toggle-status', $store->id)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('POST'); ?>
                                        <button type="submit" 
                                                class="text-<?php echo e($store->is_active ? 'red' : 'green'); ?>-600 hover:text-<?php echo e($store->is_active ? 'red' : 'green'); ?>-800 transition-colors"
                                                title="<?php echo e($store->is_active ? 'Deactivate' : 'Activate'); ?>">
                                            <i class="fas fa-power-off"></i>
                                        </button>
                                    </form>
                                    
                                    <!-- Delete -->
                                    <form action="<?php echo e(route('admin.settings.online-stores.destroy', $store->id)); ?>" 
                                          method="POST"
                                          onsubmit="return confirm('Delete <?php echo e($store->name); ?>?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-800 transition-colors"
                                                title="Delete Store">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            
            <!-- Pagination -->
            <?php if($stores->hasPages()): ?>
                <div class="px-6 py-4 border-t bg-gray-50">
                    <?php echo e($stores->links()); ?>

                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="p-12 text-center">
                <div class="inline-block p-4 bg-gray-100 rounded-full mb-4">
                    <i class="fas fa-store text-gray-400 text-4xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Online Stores Found</h3>
                <p class="text-gray-500 mb-6">Get started by adding your first online store</p>
                <a href="<?php echo e(route('admin.settings.online-stores.create')); ?>" 
                   class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 inline-flex items-center">
                    <i class="fas fa-plus mr-2"></i>Add Your First Store
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('pages.admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\revisiimaji\resources\views/pages/admin/settings/online-stores/index.blade.php ENDPATH**/ ?>