

<?php $__env->startSection('title', 'Edit Order #' . $order->order_code); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Edit Order</h1>
            <p class="text-gray-600 mt-1">Order #<?php echo e($order->order_code); ?></p>
        </div>
        <div class="flex space-x-3">
            <a href="<?php echo e(route('admin.orders.show', $order->id)); ?>" 
               class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">
                <i class="fas fa-eye mr-2"></i>View Details
            </a>
            <a href="<?php echo e(route('admin.orders.index')); ?>" 
               class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">
                <i class="fas fa-arrow-left mr-2"></i>Back to Orders
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    <?php if(session('success')): ?>
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
        <p><?php echo e(session('success')); ?></p>
    </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
        <p><?php echo e(session('error')); ?></p>
    </div>
    <?php endif; ?>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow">
        <form action="<?php echo e(route('admin.orders.update', $order->id)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Edit Order Information</h3>
            </div>
            
            <div class="p-6 space-y-6">
                <!-- Customer Selection -->
<div>
    <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">Customer *</label>
    <select name="user_id" id="user_id" required
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['user_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
        <option value="">Select Customer</option>
        <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($customer->id); ?>" 
                <?php echo e(old('user_id', $order->user_id) == $customer->id ? 'selected' : ''); ?>>
                <?php echo e($customer->name); ?> - <?php echo e($customer->phone); ?> (<?php echo e($customer->email); ?>)
            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    <?php $__errorArgs = ['user_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    <?php if($customers->isEmpty()): ?>
    <p class="mt-2 text-sm text-red-600">No customers found. Please create customers first.</p>
    <?php endif; ?>
</div>

                <!-- Order Items (Readonly) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Order Items</label>
                    <div class="border rounded-lg overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="px-4 py-3 text-sm text-gray-900"><?php echo e($item->product->name ?? 'Product deleted'); ?></td>
                                    <td class="px-4 py-3 text-sm text-gray-900">Rp <?php echo e(number_format($item->price, 0, ',', '.')); ?></td>
                                    <td class="px-4 py-3 text-sm text-gray-900"><?php echo e($item->quantity); ?></td>
                                    <td class="px-4 py-3 text-sm font-medium text-gray-900">Rp <?php echo e(number_format($item->total, 0, ',', '.')); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <td colspan="3" class="px-4 py-3 text-right text-sm font-medium text-gray-700">Total</td>
                                    <td class="px-4 py-3 text-sm font-bold text-gray-900">Rp <?php echo e(number_format($order->total, 0, ',', '.')); ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">Note: Order items cannot be modified after creation.</p>
                </div>

                <!-- Shipping Address -->
                <div>
                    <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-2">Shipping Address</label>
                    <textarea name="shipping_address" id="shipping_address" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"><?php echo e(old('shipping_address', $order->shipping_address)); ?></textarea>
                </div>

                <!-- Status and Payment -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Order Status *</label>
                        <select name="status" id="status" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="pending" <?php echo e($order->status == 'pending' ? 'selected' : ''); ?>>Pending</option>
                            <option value="waiting_payment" <?php echo e($order->status == 'waiting_payment' ? 'selected' : ''); ?>>Waiting Payment</option>
                            <option value="paid" <?php echo e($order->status == 'paid' ? 'selected' : ''); ?>>Paid</option>
                            <option value="processing" <?php echo e($order->status == 'processing' ? 'selected' : ''); ?>>Processing</option>
                            <option value="completed" <?php echo e($order->status == 'completed' ? 'selected' : ''); ?>>Completed</option>
                            <option value="cancelled" <?php echo e($order->status == 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                        </select>
                    </div>

                    <div>
                        <label for="payment_status" class="block text-sm font-medium text-gray-700 mb-2">Payment Status *</label>
                        <select name="payment_status" id="payment_status" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="unpaid" <?php echo e($order->payment_status == 'unpaid' ? 'selected' : ''); ?>>Unpaid</option>
                            <option value="paid" <?php echo e($order->payment_status == 'paid' ? 'selected' : ''); ?>>Paid</option>
                        </select>
                    </div>
                </div>

               <!-- Payment Method -->
<div>
    <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">Payment Method *</label>
    <select name="payment_method" id="payment_method" required
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        <option value="">Select Payment Method</option>
        <option value="cash" <?php echo e($order->payment_method == 'cash' ? 'selected' : ''); ?>>Cash</option>
        <option value="bank_transfer" <?php echo e($order->payment_method == 'bank_transfer' ? 'selected' : ''); ?>>Bank Transfer</option>
        <option value="credit_card" <?php echo e($order->payment_method == 'credit_card' ? 'selected' : ''); ?>>Credit Card</option>
        <option value="ewallet" <?php echo e($order->payment_method == 'ewallet' ? 'selected' : ''); ?>>E-Wallet</option>
    </select>
    <?php $__errorArgs = ['payment_method'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

                <!-- Notes -->
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                    <textarea name="notes" id="notes" rows="2"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Additional notes for this order"><?php echo e(old('notes', $order->notes)); ?></textarea>
                </div>
            </div>
            
            <!-- Form Actions -->
            <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                <a href="<?php echo e(route('admin.orders.show', $order->id)); ?>" 
                   class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Update Order
                </button>
            </div>
        </form>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
// Add confirmation for status change to cancelled
document.getElementById('status').addEventListener('change', function() {
    if (this.value === 'cancelled') {
        if (!confirm('Changing status to cancelled will restore product stock. Continue?')) {
            this.value = '<?php echo e($order->status); ?>';
        }
    }
});

// Add confirmation for payment status change to unpaid
document.getElementById('payment_status').addEventListener('change', function() {
    if (this.value === 'unpaid' && '<?php echo e($order->payment_status); ?>' === 'paid') {
        if (!confirm('Changing payment status to unpaid will mark the order as not paid. Continue?')) {
            this.value = '<?php echo e($order->payment_status); ?>';
        }
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('pages.admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ciptaimaji\revisiimaji\resources\views\pages\admin\orders\edit.blade.php ENDPATH**/ ?>