<div class="p-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-900">Home Page Banners</h3>
        <a href="<?php echo e(route('admin.settings.banners.create')); ?>?type=home_banner" 
           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm flex items-center">
            <i class="fas fa-plus mr-2"></i>Add Home Banner
        </a>
    </div>

    <?php if($homeBanners->isEmpty()): ?>
    <div class="text-center py-12">
        <div class="inline-block p-6 bg-gray-50 rounded-2xl">
            <i class="fas fa-images text-4xl text-gray-300 mb-4"></i>
            <p class="text-gray-500">No home banners yet</p>
            <p class="text-sm text-gray-400 mt-2">Click "Add Home Banner" to create your first banner</p>
        </div>
    </div>
    <?php else: ?>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="width: 50px">Drag</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="width: 100px">Image</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtitle</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Period</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 banners-list">
                <?php $__currentLoopData = $homeBanners->sortBy('display_order'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr data-id="<?php echo e($banner->id); ?>" class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <i class="fas fa-grip-vertical text-gray-400 cursor-move handle"></i>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="w-16 h-16 rounded-lg overflow-hidden bg-gray-100">
                            <?php if($banner->image_url): ?>
                                <img src="<?php echo e($banner->image_url); ?>" 
                                     alt="<?php echo e($banner->title); ?>"
                                     class="w-full h-full object-cover">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900"><?php echo e($banner->title ?? '-'); ?></div>
                        <div class="text-sm text-gray-500"><?php echo e(Str::limit($banner->description, 50)); ?></div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-sm text-gray-600"><?php echo e($banner->subtitle ?? '-'); ?></span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-600">
                            <?php if($banner->start_date || $banner->end_date): ?>
                                <?php if($banner->start_date): ?>
                                    <div><span class="font-medium">Start:</span> <?php echo e($banner->formatted_start_date); ?></div>
                                <?php endif; ?>
                                <?php if($banner->end_date): ?>
                                    <div><span class="font-medium">End:</span> <?php echo e($banner->formatted_end_date); ?></div>
                                <?php endif; ?>
                            <?php else: ?>
                                <span class="text-gray-400">No time limit</span>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap status-badge">
                        <?php echo $banner->status_badge; ?>

                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center space-x-3">
                            <button onclick="toggleStatus(<?php echo e($banner->id); ?>, this)" 
                                    class="text-gray-600 hover:text-gray-900" title="Toggle Status">
                                <?php if($banner->is_active): ?>
                                    <i class="fas fa-toggle-on text-green-600 text-xl"></i>
                                <?php else: ?>
                                    <i class="fas fa-toggle-off text-gray-400 text-xl"></i>
                                <?php endif; ?>
                            </button>
                            <a href="<?php echo e(route('admin.settings.banners.edit', $banner->id)); ?>" 
                               class="text-blue-600 hover:text-blue-900" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="deleteBanner(<?php echo e($banner->id); ?>, '<?php echo e(addslashes($banner->title ?? 'Untitled')); ?>')" 
                                    class="text-red-600 hover:text-red-900" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div><?php /**PATH C:\laragon\www\revisiimaji\resources\views/pages/admin/settings/banners/tabs/home.blade.php ENDPATH**/ ?>