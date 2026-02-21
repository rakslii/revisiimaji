

<?php $__env->startSection('title', 'Customers Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            
            <p class="text-gray-600 mt-1">Total <?php echo e($customers->total()); ?> customers</p>
        </div>
        <div class="flex gap-2">
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <input type="text" placeholder="Search customers..."
                       class="pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       id="searchInput">
            </div>
            
            <!-- Export Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open"
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 flex items-center">
                    <i class="fas fa-download mr-2"></i>
                    Export
                    <i class="fas fa-chevron-down ml-2 text-xs"></i>
                </button>
                
                <div x-show="open" 
                     @click.away="open = false"
                     class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-10">
                    <a href="<?php echo e(route('admin.customers.export.csv')); ?>" 
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 first:rounded-t-lg">
                        <i class="fas fa-file-csv mr-2 text-green-600"></i>
                        Export as CSV
                    </a>
                    <a href="<?php echo e(route('admin.customers.export.excel')); ?>" 
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-file-excel mr-2 text-green-600"></i>
                        Export as Excel
                    </a>
                    <a href="<?php echo e(route('admin.customers.export.pdf')); ?>" 
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 last:rounded-b-lg">
                        <i class="fas fa-file-pdf mr-2 text-red-600"></i>
                        Export as PDF
                    </a>
                </div>
            </div>

            <a href="<?php echo e(route('admin.customers.create')); ?>"
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <i class="fas fa-plus mr-2"></i>Add Customer
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Customers</p>
                    <p class="text-2xl font-bold text-gray-800"><?php echo e($customers->total()); ?></p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-users text-blue-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Active</p>
                    <p class="text-2xl font-bold text-green-600">
                        <?php echo e($customers->where('status', 'active')->count()); ?>

                    </p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-user-check text-green-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Inactive</p>
                    <p class="text-2xl font-bold text-yellow-600">
                        <?php echo e($customers->where('status', 'inactive')->count()); ?>

                    </p>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <i class="fas fa-user-slash text-yellow-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">New This Month</p>
                    <p class="text-2xl font-bold text-purple-600">
                        <?php echo e($customers->where('created_at', '>=', now()->startOfMonth())->count()); ?>

                    </p>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <i class="fas fa-user-plus text-purple-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Export Options Bar (Optional - for quick export) -->
    <div class="bg-white rounded-lg shadow p-4 flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <span class="text-sm font-medium text-gray-700">Quick Export:</span>
            <a href="<?php echo e(route('admin.customers.export.csv', ['status' => 'active'])); ?>" 
               class="text-sm text-green-600 hover:text-green-800">
                <i class="fas fa-check-circle mr-1"></i>Active Customers
            </a>
            <a href="<?php echo e(route('admin.customers.export.csv', ['status' => 'inactive'])); ?>" 
               class="text-sm text-yellow-600 hover:text-yellow-800">
                <i class="fas fa-times-circle mr-1"></i>Inactive Customers
            </a>
            <a href="<?php echo e(route('admin.customers.export.csv', ['period' => 'this_month'])); ?>" 
               class="text-sm text-purple-600 hover:text-purple-800">
                <i class="fas fa-calendar mr-1"></i>This Month
            </a>
        </div>
        <div class="flex items-center space-x-2">
            <i class="fas fa-info-circle text-gray-400"></i>
            <span class="text-xs text-gray-500">Export data berdasarkan filter yang aktif</span>
        </div>
    </div>

    <!-- Customers Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">Customers List</h3>
                <div class="flex items-center space-x-4">
                    <select id="statusFilter" class="px-3 py-1 border rounded-lg text-sm">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>

                    <select id="dateFilter" class="px-3 py-1 border rounded-lg text-sm">
                        <option value="">All Time</option>
                        <option value="today">Today</option>
                        <option value="week">This Week</option>
                        <option value="month">This Month</option>
                    </select>

                    <!-- Export Selected Button -->
                    <button onclick="exportSelectedCustomers()"
                            class="px-3 py-1 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 text-sm flex items-center"
                            id="exportSelectedBtn"
                            style="display: none;">
                        <i class="fas fa-download mr-1"></i>
                        Export Selected (<span id="selectedCount">0</span>)
                    </button>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <input type="checkbox" 
                                   id="selectAll" 
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Customer
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Contact
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Orders
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Joined
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
               <tbody class="bg-white divide-y divide-gray-200" id="customersTable">
    <?php $__empty_1 = true; $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <tr class="hover:bg-gray-50"
        data-customer-id="<?php echo e($customer->id); ?>"
        data-customer-status="<?php echo e($customer->status ?? 'active'); ?>"
        data-date="<?php echo e($customer->created_at ? $customer->created_at->format('Y-m-d') : ''); ?>">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="checkbox" 
                                   class="customer-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                   value="<?php echo e($customer->id); ?>">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold">
                                        <?php echo e(strtoupper(substr($customer->name, 0, 1))); ?>

                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900"><?php echo e($customer->name); ?></div>
                                    <div class="text-xs text-gray-500">ID: #<?php echo e($customer->id); ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900"><?php echo e($customer->email); ?></div>
                            <div class="text-xs text-gray-500"><?php echo e($customer->phone ?? 'No phone'); ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900"><?php echo e($customer->orders_count); ?></div>
                            <div class="text-xs text-gray-500">
                                <?php if($customer->orders_count > 0): ?>
                                    <?php
                                        $lastOrder = \App\Models\Order::where('user_id', $customer->id)
                                            ->latest()
                                            ->first();
                                    ?>
                                    <?php if($lastOrder && $lastOrder->created_at): ?>
                                        Last: <?php echo e($lastOrder->created_at->diffForHumans()); ?>

                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                <?php else: ?>
                                    No orders yet
                                <?php endif; ?>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php
                                $status = $customer->status ?? 'active';
                                $statusColor = $status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
                            ?>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full <?php echo e($statusColor); ?>">
                                <?php echo e(ucfirst($status)); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php if($customer->created_at): ?>
                                <?php echo e($customer->created_at->format('d M Y')); ?>

                            <?php else: ?>
                                N/A
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <a href="<?php echo e(route('admin.customers.show', $customer->id)); ?>"
                                   class="text-blue-600 hover:text-blue-900"
                                   title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?php echo e(route('admin.customers.edit', $customer->id)); ?>"
                                   class="text-yellow-600 hover:text-yellow-900"
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button onclick="showCustomerActions(<?php echo e($customer->id); ?>, '<?php echo e(addslashes($customer->name)); ?>')"
                                        class="text-gray-600 hover:text-gray-900"
                                        title="Actions">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            <div class="py-8">
                                <i class="fas fa-users fa-2x text-gray-300 mb-2"></i>
                                <p class="text-gray-500">No customers found</p>
                                <a href="<?php echo e(route('admin.customers.create')); ?>"
                                   class="mt-2 inline-block text-blue-600 hover:text-blue-900">
                                    Add your first customer
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if($customers->hasPages()): ?>
        <div class="px-6 py-4 border-t">
            <?php echo e($customers->links()); ?>

        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Quick Actions Modal -->
<div id="actionsModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-sm w-full mx-4">
        <div class="px-6 py-4 border-b">
            <h3 class="text-lg font-medium text-gray-900" id="customerName">Customer Actions</h3>
        </div>
        <div class="p-6">
            <div class="space-y-3" id="actionButtons">
                <!-- Actions will be loaded dynamically -->
            </div>
        </div>
        <div class="px-6 py-4 border-t flex justify-end">
            <button type="button"
                    onclick="closeActionsModal()"
                    class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">
                Close
            </button>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<!-- Include Alpine.js for dropdown -->
<script src="//unpkg.com/alpinejs" defer></script>

<script>
let currentCustomerId = null;
let currentCustomerName = null;
let currentCustomerStatus = null;

// Select All functionality
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.customer-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
    updateSelectedCount();
});

// Individual checkbox changes
document.querySelectorAll('.customer-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        updateSelectedCount();
        
        // Update select all checkbox
        const totalCheckboxes = document.querySelectorAll('.customer-checkbox').length;
        const checkedCheckboxes = document.querySelectorAll('.customer-checkbox:checked').length;
        const selectAll = document.getElementById('selectAll');
        
        if (checkedCheckboxes === 0) {
            selectAll.checked = false;
            selectAll.indeterminate = false;
        } else if (checkedCheckboxes === totalCheckboxes) {
            selectAll.checked = true;
            selectAll.indeterminate = false;
        } else {
            selectAll.indeterminate = true;
        }
    });
});

function updateSelectedCount() {
    const selectedCount = document.querySelectorAll('.customer-checkbox:checked').length;
    const exportBtn = document.getElementById('exportSelectedBtn');
    
    if (selectedCount > 0) {
        exportBtn.style.display = 'flex';
        document.getElementById('selectedCount').textContent = selectedCount;
    } else {
        exportBtn.style.display = 'none';
    }
}

function exportSelectedCustomers() {
    const selectedIds = [];
    document.querySelectorAll('.customer-checkbox:checked').forEach(checkbox => {
        selectedIds.push(checkbox.value);
    });
    
    if (selectedIds.length === 0) {
        alert('Please select at least one customer to export');
        return;
    }
    
    // Create form and submit
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '<?php echo e(route("admin.customers.export.selected")); ?>';
    form.style.display = 'none';
    
    // Add CSRF token
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = '<?php echo e(csrf_token()); ?>';
    form.appendChild(csrfInput);
    
    // Add selected IDs
    selectedIds.forEach(id => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'selected_ids[]';
        input.value = id;
        form.appendChild(input);
    });
    
    document.body.appendChild(form);
    form.submit();
}

function showCustomerActions(customerId, customerName) {
    currentCustomerId = customerId;
    currentCustomerName = customerName;

    const row = document.querySelector(`tr[data-customer-id="${customerId}"]`);
    if (row) {
        currentCustomerStatus = row.getAttribute('data-customer-status') || 'active';
    } else {
        currentCustomerStatus = 'active';
    }

    document.getElementById('customerName').textContent = `Actions for ${customerName}`;

    const actionButtons = document.getElementById('actionButtons');

    let buttonsHTML = '';

    if (currentCustomerStatus === 'active') {
        buttonsHTML = `
            <button type="button" onclick="updateCustomerStatus('inactive')"
                    class="w-full flex items-center justify-between p-3 text-left rounded-lg border border-yellow-200 hover:bg-yellow-50">
                <div class="flex items-center">
                    <i class="fas fa-user-slash text-yellow-600 mr-3"></i>
                    <div>
                        <p class="font-medium text-gray-900">Deactivate Account</p>
                        <p class="text-sm text-gray-500">Temporarily disable this account</p>
                    </div>
                </div>
            </button>
        `;
    } else {
        buttonsHTML = `
            <button type="button" onclick="updateCustomerStatus('active')"
                    class="w-full flex items-center justify-between p-3 text-left rounded-lg border border-green-200 hover:bg-green-50">
                <div class="flex items-center">
                    <i class="fas fa-user-check text-green-600 mr-3"></i>
                    <div>
                        <p class="font-medium text-gray-900">Activate Account</p>
                        <p class="text-sm text-gray-500">Reactivate this account</p>
                    </div>
                </div>
            </button>
        `;
    }

    buttonsHTML += `
    <button type="button" onclick="resetCustomerPassword()"
            class="w-full flex items-center justify-between p-3 text-left rounded-lg border border-blue-200 hover:bg-blue-50">
        <div class="flex items-center">
            <i class="fas fa-key text-blue-600 mr-3"></i>
            <div>
                <p class="font-medium text-gray-900">Reset Password</p>
                <p class="text-sm text-gray-500">Send password reset email</p>
            </div>
        </div>
    </button>

    <a href="/admin/customers/${currentCustomerId}/edit"
       class="block w-full text-left">
        <div class="flex items-center justify-between p-3 rounded-lg border border-purple-200 hover:bg-purple-50">
            <div class="flex items-center">
                <i class="fas fa-edit text-purple-600 mr-3"></i>
                <div>
                    <p class="font-medium text-gray-900">Edit Profile</p>
                    <p class="text-sm text-gray-500">Update customer information</p>
                </div>
            </div>
        </div>
    </a>

    <button type="button" onclick="deleteCustomer()"
            class="w-full flex items-center justify-between p-3 text-left rounded-lg border border-red-200 hover:bg-red-50">
        <div class="flex items-center">
            <i class="fas fa-trash text-red-600 mr-3"></i>
            <div>
                <p class="font-medium text-gray-900">Delete Account</p>
                <p class="text-sm text-gray-500">Permanently delete this account</p>
            </div>
        </div>
    </button>
`;

    actionButtons.innerHTML = buttonsHTML;

    const modal = document.getElementById('actionsModal');
    modal.classList.remove('hidden');
}

function closeActionsModal() {
    document.getElementById('actionsModal').classList.add('hidden');
}

function updateCustomerStatus(status) {
    console.log('Updating status for customer:', currentCustomerId, 'to:', status);
    console.log('CSRF Token:', document.querySelector('meta[name="csrf-token"]')?.content);

    if (!confirm(`Are you sure you want to ${status === 'active' ? 'activate' : 'deactivate'} ${currentCustomerName}?`)) {
        return;
    }

    fetch(`/admin/customers/${currentCustomerId}/status`, {
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

function resetCustomerPassword() {
    if (!confirm(`Send password reset email to ${currentCustomerName}?`)) {
        return;
    }

    alert('Password reset feature coming soon!');
    closeActionsModal();
}

function deleteCustomer() {
    if (!confirm(`Are you sure you want to delete ${currentCustomerName}? This action cannot be undone.`)) {
        return;
    }

    fetch(`/admin/customers/${currentCustomerId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
        }
    })
    .then(response => {
        if (response.ok) {
            location.reload();
        } else {
            alert('Failed to delete customer');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to delete customer');
    });
}

// Filter functionality
document.getElementById('statusFilter').addEventListener('change', function() {
    filterCustomers();
});

document.getElementById('dateFilter').addEventListener('change', function() {
    filterCustomers();
});

document.getElementById('searchInput').addEventListener('input', function() {
    filterCustomers();
});

function filterCustomers() {
    const statusFilter = document.getElementById('statusFilter').value;
    const dateFilter = document.getElementById('dateFilter').value;
    const searchQuery = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('#customersTable tr');

    rows.forEach(row => {
        const status = row.getAttribute('data-customer-status') || '';
        const dateStr = row.getAttribute('data-date');
        const rowText = row.textContent.toLowerCase();

        const statusMatch = !statusFilter || status === statusFilter;

        let dateMatch = true;
        if (dateFilter && dateStr) {
            const date = new Date(dateStr);
            const today = new Date();

            if (dateFilter === 'today') {
                dateMatch = date.toDateString() === today.toDateString();
            } else if (dateFilter === 'week') {
                const startOfWeek = new Date(today.setDate(today.getDate() - today.getDay()));
                dateMatch = date >= startOfWeek;
            } else if (dateFilter === 'month') {
                const startOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
                dateMatch = date >= startOfMonth;
            }
        } else if (dateFilter && !dateStr) {
            dateMatch = false;
        }

        const searchMatch = !searchQuery || rowText.includes(searchQuery);

        if (statusMatch && dateMatch && searchMatch) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

// Close modal when clicking outside
document.getElementById('actionsModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeActionsModal();
    }
});

// Initialize selected count on page load
document.addEventListener('DOMContentLoaded', function() {
    updateSelectedCount();
});
</script>

<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('pages.admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\revisiimaji\resources\views/pages/admin/customers/index.blade.php ENDPATH**/ ?>