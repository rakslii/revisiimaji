<div class="p-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-900">Popup Banners</h3>
        <a href="<?php echo e(route('admin.settings.banners.create')); ?>?type=popup" 
           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm flex items-center">
            <i class="fas fa-plus mr-2"></i>Add Popup
        </a>
    </div>

    <?php if($popups->isEmpty()): ?>
    <div class="text-center py-12">
        <div class="inline-block p-6 bg-gray-50 rounded-2xl">
            <i class="fas fa-window-restore text-4xl text-gray-300 mb-4"></i>
            <p class="text-gray-500">No popups yet</p>
            <p class="text-sm text-gray-400 mt-2">Click "Add Popup" to create your first popup banner</p>
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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Position/Size</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Delay</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 banners-list">
                <?php $__currentLoopData = $popups->sortBy('display_order'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $popup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr data-id="<?php echo e($popup->id); ?>" class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <i class="fas fa-grip-vertical text-gray-400 cursor-move handle"></i>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="w-16 h-16 rounded-lg overflow-hidden bg-gray-100">
                            <?php if($popup->image_url): ?>
                                <img src="<?php echo e($popup->image_url); ?>" 
                                     alt="<?php echo e($popup->title); ?>"
                                     class="w-full h-full object-cover">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900"><?php echo e($popup->title ?? '-'); ?></div>
                        <div class="text-sm text-gray-500"><?php echo e(Str::limit($popup->description, 50)); ?></div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded text-xs">
                            <?php echo e(ucfirst($popup->position)); ?> / <?php echo e(ucfirst($popup->size)); ?>

                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-sm text-gray-600"><?php echo e($popup->delay_seconds); ?> seconds</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap status-badge">
                        <?php echo $popup->status_badge; ?>

                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center space-x-3">
                            <button onclick="toggleStatus(<?php echo e($popup->id); ?>, this)" 
                                    class="text-gray-600 hover:text-gray-900" title="Toggle Status">
                                <?php if($popup->is_active): ?>
                                    <i class="fas fa-toggle-on text-green-600 text-xl"></i>
                                <?php else: ?>
                                    <i class="fas fa-toggle-off text-gray-400 text-xl"></i>
                                <?php endif; ?>
                            </button>
                            <a href="<?php echo e(route('admin.settings.banners.edit', $popup->id)); ?>" 
                               class="text-blue-600 hover:text-blue-900" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="deleteBanner(<?php echo e($popup->id); ?>, '<?php echo e(addslashes($popup->title ?? 'Untitled')); ?>')" 
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
</div><?php /**PATH C:\laragon\www\revisiimaji\resources\views/pages/admin/settings/banners/tabs/popup.blade.php ENDPATH**/ ?>