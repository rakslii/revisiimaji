

<?php $__env->startSection('title', 'Promo Code Details'); ?>
<?php $__env->startSection('page-title', 'Promo Code Details'); ?>
<?php $__env->startSection('page-description', 'View promo code information'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <div>
                <h1 class="text-xl font-bold text-gray-800"><?php echo e($promoCode->name); ?></h1>
                <p class="text-gray-600 mt-1"><?php echo e($promoCode->code); ?></p>
            </div>
            <div class="flex items-center gap-2">
                <?php
                    $status = $promoCode->status;
                    $statusColors = [
                        'active' => 'bg-green-100 text-green-800',
                        'inactive' => 'bg-gray-100 text-gray-800',
                        'expired' => 'bg-red-100 text-red-800',
                        'upcoming' => 'bg-yellow-100 text-yellow-800',
                        'quota_exceeded' => 'bg-orange-100 text-orange-800'
                    ];
                ?>
                <span class="px-3 py-1 rounded-full text-sm font-medium <?php echo e($statusColors[$status]); ?>">
                    <?php echo e(ucfirst($status)); ?>

                </span>
            </div>
        </div>

        <div class="p-6">
            <!-- Basic Info Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Discount Info -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800">Discount Information</h3>
                    <div class="space-y-3">
                        <div>
                            <span class="text-sm text-gray-600">Type</span>
                            <p class="font-medium">
                                <span class="px-2 py-1 rounded text-sm 
                                    <?php echo e($promoCode->type == 'percentage' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800'); ?>">
                                    <?php echo e(ucfirst($promoCode->type)); ?>

                                </span>
                            </p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600">Value</span>
                            <p class="text-2xl font-bold text-gray-800">
                                <?php echo e($promoCode->formatted_value ?? 
                                   ($promoCode->type == 'percentage' ? $promoCode->value . '%' : 'Rp ' . number_format($promoCode->value, 0, ',', '.'))); ?>

                            </p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600">Minimum Purchase</span>
                            <p class="font-medium">
                                <?php if($promoCode->min_purchase): ?>
                                    Rp <?php echo e(number_format($promoCode->min_purchase, 0, ',', '.')); ?>

                                <?php else: ?>
                                    <span class="text-gray-400">No minimum</span>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Usage Info -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800">Usage Information</h3>
                    <div class="space-y-3">
                        <div>
                            <span class="text-sm text-gray-600">Quota</span>
                            <div class="flex items-center gap-3">
                                <div class="flex-1">
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-blue-600 h-2.5 rounded-full" 
                                             style="width: <?php echo e(min(100, ($promoCode->used_count / $promoCode->quota) * 100)); ?>%"></div>
                                    </div>
                                </div>
                                <span class="text-sm font-medium">
                                    <?php echo e($promoCode->used_count); ?> / <?php echo e($promoCode->quota); ?>

                                </span>
                            </div>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600">Remaining Uses</span>
                            <p class="text-xl font-bold text-gray-800">
                                <?php echo e(max(0, $promoCode->quota - $promoCode->used_count)); ?>

                            </p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600">Status</span>
                            <p class="font-medium">
                                <span class="<?php echo e($promoCode->is_active ? 'text-green-600' : 'text-gray-600'); ?>">
                                    <?php echo e($promoCode->is_active ? 'Active' : 'Inactive'); ?>

                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Validity Period -->
            <div class="border-t border-gray-200 pt-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Validity Period</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <span class="text-sm text-gray-600">Valid From</span>
                        <p class="font-medium"><?php echo e($promoCode->valid_from->format('d M Y, H:i')); ?></p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <span class="text-sm text-gray-600">Valid Until</span>
                        <p class="font-medium"><?php echo e($promoCode->valid_until->format('d M Y, H:i')); ?></p>
                    </div>
                </div>
                <div class="mt-4">
                    <?php
                        $now = now();
                        $start = $promoCode->valid_from;
                        $end = $promoCode->valid_until;
                        
                        if ($now < $start) {
                            $days = $start->diffInDays($now);
                            $message = "Starts in $days days";
                            $color = 'bg-yellow-50 text-yellow-800';
                        } elseif ($now > $end) {
                            $days = $now->diffInDays($end);
                            $message = "Expired $days days ago";
                            $color = 'bg-red-50 text-red-800';
                        } else {
                            $days = $end->diffInDays($now);
                            $message = "$days days remaining";
                            $color = 'bg-green-50 text-green-800';
                        }
                    ?>
                    <div class="inline-block px-3 py-1 rounded-full text-sm <?php echo e($color); ?>">
                        <?php echo e($message); ?>

                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="border-t border-gray-200 pt-6 flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-600">Created: <?php echo e($promoCode->created_at->format('d M Y, H:i')); ?></p>
                    <p class="text-sm text-gray-600">Last Updated: <?php echo e($promoCode->updated_at->format('d M Y, H:i')); ?></p>
                </div>
                <div class="flex gap-3">
                    <a href="<?php echo e(route('admin.promos.edit', $promoCode->id)); ?>" 
                       class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Edit
                    </a>
                    <form action="<?php echo e(route('admin.promos.destroy', $promoCode->id)); ?>" method="POST" 
                          onsubmit="return confirm('Are you sure you want to delete this promo code?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" 
                                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Back Button -->
    <div class="mt-6">
        <a href="<?php echo e(route('admin.promos.index')); ?>" 
           class="inline-flex items-center text-blue-600 hover:text-blue-800">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Promo Codes List
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('pages.admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\revisiimaji\resources\views/pages/admin/promos/show.blade.php ENDPATH**/ ?>