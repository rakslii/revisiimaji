@extends('pages.admin.layouts.app')

@section('title', 'Customer Details - ' . $customer->name)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Customer Details</h1>
            <p class="text-gray-600 mt-1">{{ $customer->email }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.customers.edit', $customer->id) }}" 
               class="px-4 py-2 bg-yellow-100 text-yellow-700 border border-yellow-300 rounded-lg hover:bg-yellow-200">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <a href="{{ route('admin.customers') }}" 
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
                            {{ strtoupper(substr($customer->name, 0, 1)) }}
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">{{ $customer->name }}</h2>
                            <p class="text-gray-600">{{ $customer->email }}</p>
                            <div class="flex items-center mt-2">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $customer->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($customer->status) }}
                                </span>
                                <span class="ml-3 text-sm text-gray-500">
                                    Member since {{ $customer->created_at->format('M Y') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Phone Number</p>
                            <p class="font-medium text-gray-900">{{ $customer->phone ?? 'Not provided' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Email Verified</p>
                            <p class="font-medium text-gray-900">
                                @if($customer->email_verified_at)
                                    <span class="text-green-600">Verified</span>
                                @else
                                    <span class="text-yellow-600">Not Verified</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Total Orders</p>
                            <p class="font-medium text-gray-900">{{ $customer->orders_count }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Last Order</p>
                            <p class="font-medium text-gray-900">
                                @if($customer->orders->count() > 0)
                                    {{ $customer->orders->first()->created_at->format('d M Y') }}
                                @else
                                    Never
                                @endif
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
                    @if($customer->orders->count() > 0)
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
                                @foreach($customer->orders as $order)
                                <tr>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                        #{{ $order->order_number }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                        {{ $order->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'processing' => 'bg-blue-100 text-blue-800',
                                                'shipped' => 'bg-purple-100 text-purple-800',
                                                'completed' => 'bg-green-100 text-green-800',
                                                'cancelled' => 'bg-red-100 text-red-800',
                                            ];
                                        @endphp
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" 
                                           class="text-blue-600 hover:text-blue-900">
                                            View
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-8">
                        <i class="fas fa-shopping-cart fa-3x text-gray-300 mb-3"></i>
                        <p class="text-gray-500">No orders found</p>
                    </div>
                    @endif
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
                            Rp {{ number_format($totalSpent, 0, ',', '.') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Average Order Value</p>
                        <p class="text-xl font-bold text-gray-900">
                            Rp {{ number_format($avgOrderValue, 0, ',', '.') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Order Completion Rate</p>
                        <p class="text-xl font-bold text-gray-900">
                            @if($customer->orders_count > 0)
                                {{ round(($customer->orders->where('status', 'completed')->count() / $customer->orders_count) * 100) }}%
                            @else
                                0%
                            @endif
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
                    @if($customer->locations->count() > 0)
                    <div class="space-y-4">
                        @foreach($customer->locations as $location)
                        <div class="border border-gray-200 rounded-lg p-4 {{ $location->is_primary ? 'border-blue-300 bg-blue-50' : '' }}">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $location->name }}</p>
                                    @if($location->is_primary)
                                    <span class="inline-block px-2 py-1 text-xs font-semibold bg-blue-100 text-blue-800 rounded-full mt-1">
                                        Primary
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 mt-2">{{ $location->recipient_name }}</p>
                            <p class="text-sm text-gray-600">{{ $location->recipient_phone }}</p>
                            <p class="text-sm text-gray-500 mt-2">{{ $location->full_address }}</p>
                            <p class="text-sm text-gray-500">{{ $location->city }}, {{ $location->province }} {{ $location->postal_code }}</p>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-gray-500">No addresses saved</p>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
                </div>
                <div class="p-6 space-y-3">
                    @if($customer->status === 'active')
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
                    @else
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
                    @endif

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
            <form id="deleteForm" method="POST" action="{{ route('admin.customers.destroy', $customer->id) }}">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    Yes, Delete
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function updateStatus(status) {
    if (!confirm(`Are you sure you want to ${status === 'active' ? 'activate' : 'deactivate'} this customer?`)) {
        return;
    }

    fetch(`/admin/customers/{{ $customer->id }}/status`, {
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
@endpush
@endsection