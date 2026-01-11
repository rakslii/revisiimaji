@extends('pages.admin.layouts.app')

@section('title', 'Orders Management')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Orders Management</h1>
            <p class="text-gray-600 mt-1">Total {{ $orders->total() }} orders</p>
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
                    <p class="text-2xl font-bold text-gray-800">{{ $orders->total() }}</p>
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
                        {{ $orders->where('status', 'pending')->count() }}
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
                        {{ $orders->where('status', 'processing')->count() }}
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
                        {{ $orders->where('status', 'completed')->count() }}
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
                    @forelse($orders as $order)
                    <tr class="hover:bg-gray-50" data-status="{{ $order->status }}" data-payment="{{ $order->payment_status }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-receipt text-blue-600 text-sm"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">#{{ $order->order_code }}</div>
                                    <div class="text-xs text-gray-500">{{ $order->items_count }} items</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $order->customer_name }}</div>
                            <div class="text-xs text-gray-500">{{ $order->customer_phone }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $order->created_at->format('d M Y') }}</div>
                            <div class="text-xs text-gray-500">{{ $order->created_at->format('H:i') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                            Rp {{ number_format($order->total, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'waiting_payment' => 'bg-blue-100 text-blue-800',
                                    'paid' => 'bg-green-100 text-green-800',
                                    'processing' => 'bg-purple-100 text-purple-800',
                                    'completed' => 'bg-green-100 text-green-800',
                                    'cancelled' => 'bg-red-100 text-red-800',
                                ];
                            @endphp
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.orders.show', $order->id) }}" 
                                   class="text-blue-600 hover:text-blue-900" 
                                   title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.orders.edit', $order->id) }}" 
                                   class="text-yellow-600 hover:text-yellow-900" 
                                   title="Edit Order">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button onclick="showOrderActions({{ $order->id }})"
                                        class="text-gray-600 hover:text-gray-900"
                                        title="Quick Actions">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            <div class="py-8">
                                <i class="fas fa-shopping-cart fa-2x text-gray-300 mb-2"></i>
                                <p class="text-gray-500">No orders found</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($orders->hasPages())
        <div class="px-6 py-4 border-t">
            {{ $orders->links() }}
        </div>
        @endif
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
                <button type="button" id="markAsPaidBtn"
                        class="w-full flex items-center justify-between p-3 text-left rounded-lg border border-green-200 hover:bg-green-50">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-600 mr-3"></i>
                        <div>
                            <p class="font-medium text-gray-900">Mark as Paid</p>
                            <p class="text-sm text-gray-500">Confirm payment received</p>
                        </div>
                    </div>
                </button>
                
                <button type="button" id="markProcessingBtn"
                        class="w-full flex items-center justify-between p-3 text-left rounded-lg border border-purple-200 hover:bg-purple-50">
                    <div class="flex items-center">
                        <i class="fas fa-cog text-purple-600 mr-3"></i>
                        <div>
                            <p class="font-medium text-gray-900">Mark as Processing</p>
                            <p class="text-sm text-gray-500">Start processing order</p>
                        </div>
                    </div>
                </button>
                
                <button type="button" id="markCompletedBtn"
                        class="w-full flex items-center justify-between p-3 text-left rounded-lg border border-green-200 hover:bg-green-50">
                    <div class="flex items-center">
                        <i class="fas fa-check-double text-green-600 mr-3"></i>
                        <div>
                            <p class="font-medium text-gray-900">Mark as Completed</p>
                            <p class="text-sm text-gray-500">Order delivered/completed</p>
                        </div>
                    </div>
                </button>
                
                <button type="button" id="cancelOrderBtn"
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

@push('scripts')
<script>
let currentOrderId = null;

function showOrderActions(orderId) {
    currentOrderId = orderId;
    const modal = document.getElementById('actionsModal');
    modal.classList.remove('hidden');
}

// Close modal when clicking outside
document.getElementById('actionsModal').addEventListener('click', function(e) {
    if (e.target === this) {
        this.classList.add('hidden');
    }
});

// Filter functionality
document.getElementById('statusFilter').addEventListener('change', function() {
    filterOrders();
});

document.getElementById('paymentFilter').addEventListener('change', function() {
    filterOrders();
});

document.getElementById('searchInput').addEventListener('input', function() {
    filterOrders();
});

function filterOrders() {
    const statusFilter = document.getElementById('statusFilter').value;
    const paymentFilter = document.getElementById('paymentFilter').value;
    const searchQuery = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('#ordersTable tr');
    
    rows.forEach(row => {
        const status = row.getAttribute('data-status');
        const payment = row.getAttribute('data-payment');
        const rowText = row.textContent.toLowerCase();
        
        const statusMatch = !statusFilter || status === statusFilter;
        const paymentMatch = !paymentFilter || payment === paymentFilter;
        const searchMatch = !searchQuery || rowText.includes(searchQuery);
        
        if (statusMatch && paymentMatch && searchMatch) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
</script>
@endpush
@endsection