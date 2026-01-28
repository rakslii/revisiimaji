

<?php $__env->startSection('title', 'Customer Details - ' . $customer->name); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Customer Details</h1>
            <p class="text-gray-600 mt-1"><?php echo e($customer->email); ?></p>
        </div>
        <div class="flex space-x-3">
            <a href="<?php echo e(route('admin.customers.edit', $customer->id)); ?>" 
               class="px-4 py-2 bg-yellow-100 text-yellow-700 border border-yellow-300 rounded-lg hover:bg-yellow-200">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <a href="<?php echo e(route('admin.customers.index')); ?>" 
               class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">
                <i class="fas fa-arrow-left mr-2"></i>Back
            </a>
        </div>
    </div>

    <!-- Customer Information -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Customer Profile -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Profile Card -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Profile Information</h3>
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-6">
                        <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-2xl font-bold mr-4">
                            <?php echo e(strtoupper(substr($customer->name, 0, 1))); ?>

                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900"><?php echo e($customer->name); ?></h2>
                            <p class="text-gray-600"><?php echo e($customer->email); ?></p>
                            <div class="flex items-center mt-2">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full <?php echo e($customer->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                    <?php echo e(ucfirst($customer->status)); ?>

                                </span>
                                <span class="ml-3 text-sm text-gray-500">
                                    Member since <?php echo e($customer->created_at->format('M Y')); ?>

                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Phone Number</p>
                            <p class="font-medium text-gray-900"><?php echo e($customer->phone ?? 'Not provided'); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Email Verified</p>
                            <p class="font-medium text-gray-900">
                                <?php if($customer->email_verified_at): ?>
                                    <span class="text-green-600">Verified</span>
                                <?php else: ?>
                                    <span class="text-yellow-600">Not Verified</span>
                                <?php endif; ?>
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Total Orders</p>
                            <p class="font-medium text-gray-900"><?php echo e($customer->orders_count); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Last Order</p>
                            <p class="font-medium text-gray-900">
                                <?php if($customer->orders->count() > 0): ?>
                                    <?php echo e($customer->orders->first()->created_at->format('d M Y')); ?>

                                <?php else: ?>
                                    Never
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900">Recent Orders</h3>
                        <a href="#" class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                            View All Orders
                        </a>
                    </div>
                </div>
                <div class="p-6">
                    <?php if($customer->orders->count() > 0): ?>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order ID</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php $__currentLoopData = $customer->orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                        #<?php echo e($order->order_number); ?>

                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo e($order->created_at->format('d M Y')); ?>

                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                        Rp <?php echo e(number_format($order->total_amount, 0, ',', '.')); ?>

                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <?php
                                            $statusColors = [
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'processing' => 'bg-blue-100 text-blue-800',
                                                'shipped' => 'bg-purple-100 text-purple-800',
                                                'completed' => 'bg-green-100 text-green-800',
                                                'cancelled' => 'bg-red-100 text-red-800',
                                            ];
                                        ?>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full <?php echo e($statusColors[$order->status] ?? 'bg-gray-100 text-gray-800'); ?>">
                                            <?php echo e(ucfirst($order->status)); ?>

                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                        <a href="<?php echo e(route('admin.orders.show', $order->id)); ?>" 
                                           class="text-blue-600 hover:text-blue-900">
                                            View
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <div class="text-center py-8">
                        <i class="fas fa-shopping-cart fa-3x text-gray-300 mb-3"></i>
                        <p class="text-gray-500">No orders found</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Statistics -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Statistics</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <p class="text-sm text-gray-500">Total Spent</p>
                        <p class="text-xl font-bold text-gray-900">
                            Rp <?php echo e(number_format($totalSpent, 0, ',', '.')); ?>

                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Average Order Value</p>
                        <p class="text-xl font-bold text-gray-900">
                            Rp <?php echo e(number_format($avgOrderValue, 0, ',', '.')); ?>

                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Order Completion Rate</p>
                        <p class="text-xl font-bold text-gray-900">
                            <?php if($customer->orders_count > 0): ?>
                                <?php echo e(round(($customer->orders->where('status', 'completed')->count() / $customer->orders_count) * 100)); ?>%
                            <?php else: ?>
                                0%
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Address Book -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Address Book</h3>
                </div>
                <div class="p-6">
                    <?php if($customer->locations->count() > 0): ?>
                    <div class="space-y-4">
                        <?php $__currentLoopData = $customer->locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="border border-gray-200 rounded-lg p-4 <?php echo e($location->is_primary ? 'border-blue-300 bg-blue-50' : ''); ?>">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-medium text-gray-900"><?php echo e($location->name); ?></p>
                                    <?php if($location->is_primary): ?>
                                    <span class="inline-block px-2 py-1 text-xs font-semibold bg-blue-100 text-blue-800 rounded-full mt-1">
                                        Primary
                                    </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 mt-2"><?php echo e($location->recipient_name); ?></p>
                            <p class="text-sm text-gray-600"><?php echo e($location->recipient_phone); ?></p>
                            <p class="text-sm text-gray-500 mt-2"><?php echo e($location->full_address); ?></p>
                            <p class="text-sm text-gray-500"><?php echo e($location->city); ?>, <?php echo e($location->province); ?> <?php echo e($location->postal_code); ?></p>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php else: ?>
                    <p class="text-gray-500">No addresses saved</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
                </div>
                <div class="p-6 space-y-3">
                    <?php if($customer->status === 'active'): ?>
                    <button onclick="updateStatus('inactive')"
                            class="w-full flex items-center justify-between p-3 text-left rounded-lg border border-yellow-200 hover:bg-yellow-50">
                        <div class="flex items-center">
                            <i class="fas fa-user-slash text-yellow-600 mr-3"></i>
                            <div>
                                <p class="font-medium text-gray-900">Deactivate Account</p>
                                <p class="text-sm text-gray-500">Temporarily disable this account</p>
                            </div>
                        </div>
                    </button>
                    <?php else: ?>
                    <button onclick="updateStatus('active')"
                            class="w-full flex items-center justify-between p-3 text-left rounded-lg border border-green-200 hover:bg-green-50">
                        <div class="flex items-center">
                            <i class="fas fa-user-check text-green-600 mr-3"></i>
                            <div>
                                <p class="font-medium text-gray-900">Activate Account</p>
                                <p class="text-sm text-gray-500">Reactivate this account</p>
                            </div>
                        </div>
                    </button>
                    <?php endif; ?>

                    <button onclick="resetPassword()"
                            class="w-full flex items-center justify-between p-3 text-left rounded-lg border border-blue-200 hover:bg-blue-50">
                        <div class="flex items-center">
                            <i class="fas fa-key text-blue-600 mr-3"></i>
                            <div>
                                <p class="font-medium text-gray-900">Reset Password</p>
                                <p class="text-sm text-gray-500">Send password reset email</p>
                            </div>
                        </div>
                    </button>

                    <button onclick="deleteCustomer()"
                            class="w-full flex items-center justify-between p-3 text-left rounded-lg border border-red-200 hover:bg-red-50">
                        <div class="flex items-center">
                            <i class="fas fa-trash text-red-600 mr-3"></i>
                            <div>
                                <p class="font-medium text-gray-900">Delete Account</p>
                                <p class="text-sm text-gray-500">Permanently delete this account</p>
                            </div>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Delete Customer</h3>
        </div>
        <div class="p-6">
            <p class="text-gray-700">Are you sure you want to delete this customer? This action cannot be undone.</p>
            <p class="text-sm text-gray-500 mt-2">Note: Customers with existing orders cannot be deleted.</p>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
            <button type="button" 
                    onclick="closeDeleteModal()"
                    class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">
                Cancel
            </button>
            <form id="deleteForm" method="POST" action="<?php echo e(route('admin.customers.destroy', $customer->id)); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" 
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    Yes, Delete
                </button>
            </form>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
function updateStatus(status) {
    if (!confirm(`Are you sure you want to ${status === 'active' ? 'activate' : 'deactivate'} this customer?`)) {
        return;
    }

    fetch(`/admin/customers/<?php echo e($customer->id); ?>/status`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
        },
        body: JSON.stringify({ status: status })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Failed to update status');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to update status');
    });
}

function resetPassword() {
    if (!confirm('Send password reset email to this customer?')) {
        return;
    }

    // TODO: Implement password reset
    alert('Password reset feature coming soon!');
}

function deleteCustomer() {
    const modal = document.getElementById('deleteModal');
    modal.classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('pages.admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\IMAJI\revisiimaji\resources\views\pages\admin\customers\show.blade.php ENDPATH**/ ?>