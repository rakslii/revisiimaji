

<?php $__env->startSection('title', 'Orders Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Orders Management</h1>
            <p class="text-gray-600 mt-1">Total <?php echo e($orders->total()); ?> orders</p>
        </div>
        <div class="flex gap-2">
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <input type="text" 
                       placeholder="Search orders..." 
                       class="pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       id="searchInput">
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Orders</p>
                    <p class="text-2xl font-bold text-gray-800"><?php echo e($orders->total()); ?></p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-shopping-cart text-blue-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Pending</p>
                    <p class="text-2xl font-bold text-yellow-600">
                        <?php echo e($orders->where('status', 'pending')->count()); ?>

                    </p>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <i class="fas fa-clock text-yellow-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Processing</p>
                    <p class="text-2xl font-bold text-purple-600">
                        <?php echo e($orders->where('status', 'processing')->count()); ?>

                    </p>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <i class="fas fa-cog text-purple-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Completed</p>
                    <p class="text-2xl font-bold text-green-600">
                        <?php echo e($orders->where('status', 'completed')->count()); ?>

                    </p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-check-circle text-green-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">Orders List</h3>
                <div class="flex items-center space-x-4">
                    <select id="statusFilter" class="px-3 py-1 border rounded-lg text-sm">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="waiting_payment">Waiting Payment</option>
                        <option value="paid">Paid</option>
                        <option value="processing">Processing</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                    
                    <select id="paymentFilter" class="px-3 py-1 border rounded-lg text-sm">
                        <option value="">All Payments</option>
                        <option value="paid">Paid</option>
                        <option value="unpaid">Unpaid</option>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Order ID
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Customer
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Total
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Payment
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="ordersTable">
                    <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50" data-status="<?php echo e($order->status); ?>" data-payment="<?php echo e($order->payment_status); ?>">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-receipt text-blue-600 text-sm"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">#<?php echo e($order->order_code); ?></div>
                                    <div class="text-xs text-gray-500"><?php echo e($order->items_count); ?> items</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900"><?php echo e($order->customer_name); ?></div>
                            <div class="text-xs text-gray-500"><?php echo e($order->customer_phone); ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900"><?php echo e($order->created_at->format('d M Y')); ?></div>
                            <div class="text-xs text-gray-500"><?php echo e($order->created_at->format('H:i')); ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                            Rp <?php echo e(number_format($order->total, 0, ',', '.')); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'waiting_payment' => 'bg-blue-100 text-blue-800',
                                    'paid' => 'bg-green-100 text-green-800',
                                    'processing' => 'bg-purple-100 text-purple-800',
                                    'completed' => 'bg-green-100 text-green-800',
                                    'cancelled' => 'bg-red-100 text-red-800',
                                ];
                            ?>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full <?php echo e($statusColors[$order->status] ?? 'bg-gray-100 text-gray-800'); ?>">
                                <?php echo e(ucfirst(str_replace('_', ' ', $order->status))); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full <?php echo e($order->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                <?php echo e(ucfirst($order->payment_status)); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <a href="<?php echo e(route('admin.orders.show', $order->id)); ?>" 
                                   class="text-blue-600 hover:text-blue-900" 
                                   title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?php echo e(route('admin.orders.edit', $order->id)); ?>" 
                                   class="text-yellow-600 hover:text-yellow-900" 
                                   title="Edit Order">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button onclick="showOrderActions(<?php echo e($order->id); ?>)"
                                        class="text-gray-600 hover:text-gray-900"
                                        title="Quick Actions">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            <div class="py-8">
                                <i class="fas fa-shopping-cart fa-2x text-gray-300 mb-2"></i>
                                <p class="text-gray-500">No orders found</p>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <?php if($orders->hasPages()): ?>
        <div class="px-6 py-4 border-t">
            <?php echo e($orders->links()); ?>

        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Quick Actions Modal -->
<div id="actionsModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-sm w-full mx-4">
        <div class="px-6 py-4 border-b">
            <h3 class="text-lg font-medium text-gray-900">Order Actions</h3>
        </div>
        <div class="p-6">
            <div class="space-y-3">
                <!-- Hidden Forms -->
                <form id="markPaidForm" method="POST" style="display: none;">
                    <?php echo csrf_field(); ?>
                </form>
                
                <form id="markProcessingForm" method="POST" style="display: none;">
                    <?php echo csrf_field(); ?>
                </form>
                
                <form id="markCompletedForm" method="POST" style="display: none;">
                    <?php echo csrf_field(); ?>
                </form>
                
                <!-- Update status form untuk cancelled -->
                <form id="updateStatusForm" method="POST" style="display: none;">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="status" value="cancelled">
                </form>
                
                <!-- Buttons dengan onclick handler -->
                <button type="button" onclick="submitAction('paid')"
                        class="w-full flex items-center justify-between p-3 text-left rounded-lg border border-green-200 hover:bg-green-50">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-600 mr-3"></i>
                        <div>
                            <p class="font-medium text-gray-900">Mark as Paid</p>
                            <p class="text-sm text-gray-500">Confirm payment received</p>
                        </div>
                    </div>
                </button>
                
                <button type="button" onclick="submitAction('processing')"
                        class="w-full flex items-center justify-between p-3 text-left rounded-lg border border-purple-200 hover:bg-purple-50">
                    <div class="flex items-center">
                        <i class="fas fa-cog text-purple-600 mr-3"></i>
                        <div>
                            <p class="font-medium text-gray-900">Mark as Processing</p>
                            <p class="text-sm text-gray-500">Start processing order</p>
                        </div>
                    </div>
                </button>
                
                <button type="button" onclick="submitAction('completed')"
                        class="w-full flex items-center justify-between p-3 text-left rounded-lg border border-green-200 hover:bg-green-50">
                    <div class="flex items-center">
                        <i class="fas fa-check-double text-green-600 mr-3"></i>
                        <div>
                            <p class="font-medium text-gray-900">Mark as Completed</p>
                            <p class="text-sm text-gray-500">Order delivered/completed</p>
                        </div>
                    </div>
                </button>
                
                <button type="button" onclick="submitAction('cancelled')"
                        class="w-full flex items-center justify-between p-3 text-left rounded-lg border border-red-200 hover:bg-red-50">
                    <div class="flex items-center">
                        <i class="fas fa-times-circle text-red-600 mr-3"></i>
                        <div>
                            <p class="font-medium text-gray-900">Cancel Order</p>
                            <p class="text-sm text-gray-500">Cancel this order</p>
                        </div>
                    </div>
                </button>
            </div>
        </div>
        <div class="px-6 py-4 border-t flex justify-end">
            <button type="button" 
                    onclick="document.getElementById('actionsModal').classList.add('hidden')"
                    class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">
                Close
            </button>
        </div>
    </div>
</div>
<?php $__env->startPush('scripts'); ?>
<script>
// Global variable untuk menyimpan order ID yang sedang diproses
let currentOrderId = null;

/**
 * Menampilkan modal actions untuk order tertentu
 * @param {number} orderId - ID order yang akan diproses
 */
function showOrderActions(orderId) {
    currentOrderId = orderId;
    const modal = document.getElementById('actionsModal');
    modal.classList.remove('hidden');
    
    // Update semua form actions dengan currentOrderId
    updateFormActions(orderId);
}

/**
 * Update action URL untuk semua form berdasarkan order ID
 * @param {number} orderId - ID order
 */
function updateFormActions(orderId) {
    const forms = {
        'markPaidForm': `/admin/orders/${orderId}/confirm-payment`,
        'markProcessingForm': `/admin/orders/${orderId}/mark-processing`,
        'markCompletedForm': `/admin/orders/${orderId}/mark-completed`,
        'updateStatusForm': `/admin/orders/${orderId}/update-status`
    };
    
    Object.entries(forms).forEach(([formId, actionUrl]) => {
        const form = document.getElementById(formId);
        if (form) {
            form.action = actionUrl;
        }
    });
    
    // Set status value untuk cancelled form
    const statusInput = document.querySelector('#updateStatusForm input[name="status"]');
    if (statusInput) {
        statusInput.value = 'cancelled';
    }
}

/**
 * Handle action button click (menggunakan form submit)
 * @param {string} actionType - Jenis action: 'paid', 'processing', 'completed', 'cancelled'
 */
function submitAction(actionType) {
    if (!currentOrderId) {
        alert('No order selected');
        return;
    }
    
    // Konfirmasi pesan berdasarkan action type
    const confirmMessages = {
        'paid': 'Are you sure you want to mark this order as paid?\n\nNote: Order will automatically move to "Processing" status.',
        'processing': 'Are you sure you want to mark this order as processing?',
        'completed': 'Are you sure you want to mark this order as completed?',
        'cancelled': 'Are you sure you want to cancel this order?\n\nNote: This action will restore product stock.'
    };
    
    const confirmMessage = confirmMessages[actionType] || `Are you sure you want to ${actionType} this order?`;
    
    if (!confirm(confirmMessage)) {
        return;
    }
    
    // Tentukan form yang akan disubmit
    const formMap = {
        'paid': 'markPaidForm',
        'processing': 'markProcessingForm',
        'completed': 'markCompletedForm',
        'cancelled': 'updateStatusForm'
    };
    
    const formId = formMap[actionType];
    if (!formId) {
        console.error('No form found for action:', actionType);
        return;
    }
    
    const form = document.getElementById(formId);
    if (form) {
        // Tutup modal
        document.getElementById('actionsModal').classList.add('hidden');
        // Submit form (akan langsung redirect ke controller)
        form.submit();
    } else {
        console.error('Form not found:', formId);
        alert('Error: Form not found');
    }
}

/**
 * Filter orders berdasarkan status, payment status, dan search query
 */
function filterOrders() {
    const statusFilter = document.getElementById('statusFilter')?.value || '';
    const paymentFilter = document.getElementById('paymentFilter')?.value || '';
    const searchQuery = document.getElementById('searchInput')?.value.toLowerCase() || '';
    
    const rows = document.querySelectorAll('#ordersTable tr[data-status]');
    
    rows.forEach(row => {
        const status = row.getAttribute('data-status') || '';
        const payment = row.getAttribute('data-payment') || '';
        const rowText = row.textContent.toLowerCase();
        
        const statusMatch = !statusFilter || status === statusFilter;
        const paymentMatch = !paymentFilter || payment === paymentFilter;
        const searchMatch = !searchQuery || rowText.includes(searchQuery);
        
        row.style.display = (statusMatch && paymentMatch && searchMatch) ? '' : 'none';
    });
}

/**
 * Initialize semua event listeners saat halaman dimuat
 */
function initializePage() {
    // Setup filter event listeners
    const statusFilter = document.getElementById('statusFilter');
    const paymentFilter = document.getElementById('paymentFilter');
    const searchInput = document.getElementById('searchInput');
    
    if (statusFilter) {
        statusFilter.addEventListener('change', filterOrders);
    }
    
    if (paymentFilter) {
        paymentFilter.addEventListener('change', filterOrders);
    }
    
    if (searchInput) {
        searchInput.addEventListener('input', filterOrders);
    }
    
    // Setup modal close event
    const modal = document.getElementById('actionsModal');
    if (modal) {
        // Close modal when clicking outside
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
            }
        });
        
        // Close button event
        const closeBtn = modal.querySelector('[onclick*="actionsModal"]');
        if (closeBtn) {
            closeBtn.onclick = function() {
                modal.classList.add('hidden');
            };
        }
    }
    
    // Setup ellipsis buttons in table
    const actionButtons = document.querySelectorAll('button[onclick^="showOrderActions"]');
    actionButtons.forEach(button => {
        const originalOnclick = button.getAttribute('onclick');
        const orderId = originalOnclick?.match(/\d+/)?.[0];
        
        if (orderId) {
            button.addEventListener('click', function(e) {
                e.stopPropagation();
                showOrderActions(orderId);
            });
        }
    });
}

// Initialize saat halaman dimuat
document.addEventListener('DOMContentLoaded', initializePage);

// Export functions ke global scope
window.showOrderActions = showOrderActions;
window.submitAction = submitAction;
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('pages.admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\cangcut\revisiimaji\resources\views\pages\admin\orders\index.blade.php ENDPATH**/ ?>