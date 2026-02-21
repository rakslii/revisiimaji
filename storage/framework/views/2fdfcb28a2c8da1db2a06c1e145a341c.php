<!DOCTYPE html>
<html>
<head>
    <title>Customers Export</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #4CAF50; color: white; padding: 10px; text-align: left; }
        td { padding: 8px; border-bottom: 1px solid #ddd; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 20px; }
        .date { color: #666; font-size: 12px; text-align: right; }
        .status-active { color: green; }
        .status-inactive { color: red; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Customers Data Export</h2>
        <p>Total Customers: <?php echo e($customers->count()); ?></p>
        <div class="date">Exported on: <?php echo e(now()->format('d M Y H:i:s')); ?></div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <?php if(\Illuminate\Support\Facades\Schema::hasColumn('users', 'status')): ?>
                <th>Status</th>
                <?php endif; ?>
                <th>Orders</th>
                <th>Total Spent</th>
                <th>Joined Date</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $totalSpent = $customer->orders()->where('status', 'completed')->sum('total');
            ?>
            <tr>
                <td><?php echo e($customer->id); ?></td>
                <td><?php echo e($customer->name); ?></td>
                <td><?php echo e($customer->email); ?></td>
                <td><?php echo e($customer->phone ?? 'N/A'); ?></td>
                
                <?php if(\Illuminate\Support\Facades\Schema::hasColumn('users', 'status')): ?>
                <td class="status-<?php echo e($customer->status ?? 'active'); ?>">
                    <?php echo e(ucfirst($customer->status ?? 'active')); ?>

                </td>
                <?php endif; ?>
                
                <td><?php echo e($customer->orders_count ?? 0); ?></td>
                <td>Rp <?php echo e(number_format($totalSpent, 0, ',', '.')); ?></td>
                <td><?php echo e($customer->created_at ? $customer->created_at->format('d M Y') : 'N/A'); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</body>
</html><?php /**PATH C:\laragon\www\revisiimaji\resources\views/pages/admin/customers/export-pdf.blade.php ENDPATH**/ ?>