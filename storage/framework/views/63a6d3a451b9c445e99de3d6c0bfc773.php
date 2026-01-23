<?php if(empty($data)): ?>
    <div class="p-6 text-center text-gray-500">
        No data available
    </div>
<?php else: ?>
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <?php $__currentLoopData = $headers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $header): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <?php echo e($header); ?>

                    </th>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        #<?php echo e($item['order_code'] ?? $item['id'] ?? 'N/A'); ?>

                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <?php echo e($item['customer_name'] ?? 'N/A'); ?>

                        <?php if(isset($item['customer_email'])): ?>
                            <div class="text-xs text-gray-500"><?php echo e($item['customer_email']); ?></div>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        <?php echo e($item['formatted_total'] ?? 'Rp ' . number_format($item['total'] ?? 0, 0, ',', '.')); ?>

                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <?php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'processing' => 'bg-blue-100 text-blue-800',
                                'shipped' => 'bg-purple-100 text-purple-800',
                                'completed' => 'bg-green-100 text-green-800',
                                'cancelled' => 'bg-red-100 text-red-800',
                            ];
                            $status = $item['status'] ?? 'pending';
                        ?>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full <?php echo e($statusColors[$status] ?? 'bg-gray-100 text-gray-800'); ?>">
                            <?php echo e(ucfirst($status)); ?>

                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <?php echo e($item['created_at'] ?? 'N/A'); ?>

                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
<?php endif; ?><?php /**PATH C:\laragon\www\cangcut\revisiimaji\resources\views/pages/admin/components/datatable.blade.php ENDPATH**/ ?>