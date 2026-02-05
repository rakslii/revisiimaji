@extends('pages.admin.layouts.app')

@section('title', 'Customers Management')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            {{-- <h1 class="text-2xl font-bold text-gray-800">Customers Management</h1> --}}
            <p class="text-gray-600 mt-1">Total {{ $customers->total() }} customers</p>
        </div>
        <div class="flex gap-2">
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <input type="text" placeholder="Search customers..."
                       class="pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       id="searchInput">
            </div>
            <a href="{{ route('admin.customers.create') }}"
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
                    <p class="text-2xl font-bold text-gray-800">{{ $customers->total() }}</p>
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
                        {{ $customers->where('status', 'active')->count() }}
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
                        {{ $customers->where('status', 'inactive')->count() }}
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
                        {{ $customers->where('created_at', '>=', now()->startOfMonth())->count() }}
                    </p>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <i class="fas fa-user-plus text-purple-600"></i>
                </div>
            </div>
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
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
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
    @forelse($customers as $customer)
    <tr class="hover:bg-gray-50"
        data-customer-id="{{ $customer->id }}"
        data-customer-status="{{ $customer->status ?? 'active' }}"
        data-date="{{ $customer->created_at ? $customer->created_at->format('Y-m-d') : '' }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold">
                                        {{ strtoupper(substr($customer->name, 0, 1)) }}
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $customer->name }}</div>
                                    <div class="text-xs text-gray-500">ID: #{{ $customer->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $customer->email }}</div>
                            <div class="text-xs text-gray-500">{{ $customer->phone ?? 'No phone' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $customer->orders_count }}</div>
                            <div class="text-xs text-gray-500">
                                @if($customer->orders_count > 0)
                                    @php
                                        $lastOrder = \App\Models\Order::where('user_id', $customer->id)
                                            ->latest()
                                            ->first();
                                    @endphp
                                    @if($lastOrder && $lastOrder->created_at)
                                        Last: {{ $lastOrder->created_at->diffForHumans() }}
                                    @else
                                        N/A
                                    @endif
                                @else
                                    No orders yet
                                @endif
                            </div>
                        </td>
                        <!-- Di bagian status badge di view: -->
<td class="px-6 py-4 whitespace-nowrap">
    @php
        // Cek apakah status ada, jika tidak default 'active'
        $status = $customer->status ?? 'active';
        $statusColor = $status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
    @endphp
    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusColor }}">
        {{ ucfirst($status) }}
    </span>
</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if($customer->created_at)
                                {{ $customer->created_at->format('d M Y') }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.customers.show', $customer->id) }}"
                                   class="text-blue-600 hover:text-blue-900"
                                   title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.customers.edit', $customer->id) }}"
                                   class="text-yellow-600 hover:text-yellow-900"
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button onclick="showCustomerActions({{ $customer->id }}, '{{ addslashes($customer->name) }}')"
                                        class="text-gray-600 hover:text-gray-900"
                                        title="Actions">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            <div class="py-8">
                                <i class="fas fa-users fa-2x text-gray-300 mb-2"></i>
                                <p class="text-gray-500">No customers found</p>
                                <a href="{{ route('admin.customers.create') }}"
                                   class="mt-2 inline-block text-blue-600 hover:text-blue-900">
                                    Add your first customer
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($customers->hasPages())
        <div class="px-6 py-4 border-t">
            {{ $customers->links() }}
        </div>
        @endif
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

@push('scripts')

<script>
let currentCustomerId = null;
let currentCustomerName = null;
let currentCustomerStatus = null;

function showCustomerActions(customerId, customerName) {
    currentCustomerId = customerId;
    currentCustomerName = customerName;

    // Get customer status from table row - PERBAIKAN DI SINI
    const row = document.querySelector(`tr[data-customer-id="${customerId}"]`);
    if (row) {
        currentCustomerStatus = row.getAttribute('data-customer-status') || 'active';
    } else {
        currentCustomerStatus = 'active'; // default
    }

    document.getElementById('customerName').textContent = `Actions for ${customerName}`;

    // Set action buttons based on status
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
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
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
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
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

        // Status filter
        const statusMatch = !statusFilter || status === statusFilter;

        // Date filter
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
            dateMatch = false; // Jika ada filter tanggal tapi data date kosong
        }

        // Search filter
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
</script>

@endpush
@endsection
