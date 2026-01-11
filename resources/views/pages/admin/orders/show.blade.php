@extends('pages.admin.layouts.app')

@section('title', 'Order Details #' . $order->order_code)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Order Details</h1>
            <p class="text-gray-600 mt-1">Order #{{ $order->order_code }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.orders.edit', $order->id) }}" 
               class="px-4 py-2 bg-yellow-100 text-yellow-700 border border-yellow-300 rounded-lg hover:bg-yellow-200">
                <i class="fas fa-edit mr-2"></i>Edit Order
            </a>
            <a href="{{ route('admin.orders') }}" 
               class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">
                <i class="fas fa-arrow-left mr-2"></i>Back to Orders
            </a>
        </div>
    </div>

    <!-- Order Information -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Order Summary -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Summary Card -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Order Summary</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Order Code</p>
                            <p class="font-medium text-gray-900">{{ $order->order_code }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Date</p>
                            <p class="font-medium text-gray-900">{{ $order->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Status</p>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($order->status === 'waiting_payment') bg-blue-100 text-blue-800
                                @elseif($order->status === 'paid') bg-green-100 text-green-800
                                @elseif($order->status === 'processing') bg-purple-100 text-purple-800
                                @elseif($order->status === 'completed') bg-green-100 text-green-800
                                @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Payment Status</p>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Order Items</h3>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
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
                                @foreach($order->items as $item)
                                <tr>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center">
                                            <img src="{{ $item->product->image_url ?? '/images/placeholder.jpg' }}" 
                                                 alt="{{ $item->product->name }}"
                                                 class="w-10 h-10 object-cover rounded mr-3">
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $item->product->name }}</p>
                                                <p class="text-sm text-gray-500">{{ $item->product->sku ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900">
                                        Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900">
                                        {{ $item->quantity }}
                                    </td>
                                    <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                        Rp {{ number_format($item->total, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <td colspan="3" class="px-4 py-3 text-right text-sm font-medium text-gray-700">Subtotal</td>
                                    <td class="px-4 py-3 text-sm font-bold text-gray-900">
                                        Rp {{ number_format($order->total, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @if($order->discount > 0)
                                <tr>
                                    <td colspan="3" class="px-4 py-3 text-right text-sm font-medium text-gray-700">Discount</td>
                                    <td class="px-4 py-3 text-sm font-bold text-red-600">
                                        - Rp {{ number_format($order->discount, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td colspan="3" class="px-4 py-3 text-right text-sm font-medium text-gray-700">Total</td>
                                    <td class="px-4 py-3 text-sm font-bold text-gray-900">
                                        Rp {{ number_format($order->total - $order->discount, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Shipping Information -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Shipping Information</h3>
                </div>
                <div class="p-6">
                    @if($order->shipping_address)
                    <p class="text-sm text-gray-500">Shipping Address</p>
                    <p class="mt-1 text-gray-900">{{ $order->shipping_address }}</p>
                    @else
                    <p class="text-gray-500">No shipping address provided</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Customer & Actions Sidebar -->
        <div class="space-y-6">
            <!-- Customer Information -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Customer Information</h3>
                </div>
                <div class="p-6">
                    @if($order->customer)
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-user text-blue-600"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">{{ $order->customer->name }}</p>
                            <p class="text-sm text-gray-500">{{ $order->customer->email }}</p>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div>
                            <p class="text-sm text-gray-500">Phone</p>
                            <p class="font-medium text-gray-900">{{ $order->customer->phone ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Total Orders</p>
                            <p class="font-medium text-gray-900">{{ $order->customer->orders_count ?? 0 }}</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('admin.customers.show', $order->customer_id) }}"
                           class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                            View Customer Profile →
                        </a>
                    </div>
                    @else
                    <p class="text-gray-500">Customer information not available</p>
                    @endif
                </div>
            </div>

            <!-- Payment Information -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Payment Information</h3>
                </div>
                <div class="p-6 space-y-3">
                    <div>
                        <p class="text-sm text-gray-500">Payment Method</p>
                        <p class="font-medium text-gray-900">{{ $order->payment_method ? ucfirst(str_replace('_', ' ', $order->payment_method)) : 'Not specified' }}</p>
                    </div>
                    @if($order->payment_status === 'paid' && $order->paid_at)
                    <div>
                        <p class="text-sm text-gray-500">Paid At</p>
                        <p class="font-medium text-gray-900">{{ $order->paid_at->format('d M Y H:i') }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Order Notes -->
            @if($order->notes)
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Order Notes</h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-700">{{ $order->notes }}</p>
                </div>
            </div>
            @endif

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
                </div>
                <div class="p-6 space-y-3">
                    @if($order->payment_status === 'unpaid')
                    <button onclick="showPaymentModal({{ $order->id }})"
                            class="w-full flex items-center justify-between p-3 text-left rounded-lg border border-green-200 hover:bg-green-50">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-600 mr-3"></i>
                            <div>
                                <p class="font-medium text-gray-900">Confirm Payment</p>
                                <p class="text-sm text-gray-500">Mark as paid</p>
                            </div>
                        </div>
                    </button>
                    @endif

                    @if($order->status !== 'processing')
                    <button onclick="updateStatus({{ $order->id }}, 'processing')"
                            class="w-full flex items-center justify-between p-3 text-left rounded-lg border border-purple-200 hover:bg-purple-50">
                        <div class="flex items-center">
                            <i class="fas fa-cog text-purple-600 mr-3"></i>
                            <div>
                                <p class="font-medium text-gray-900">Mark as Processing</p>
                                <p class="text-sm text-gray-500">Start processing order</p>
                            </div>
                        </div>
                    </button>
                    @endif

                    @if($order->status !== 'completed')
                    <button onclick="updateStatus({{ $order->id }}, 'completed')"
                            class="w-full flex items-center justify-between p-3 text-left rounded-lg border border-green-200 hover:bg-green-50">
                        <div class="flex items-center">
                            <i class="fas fa-check-double text-green-600 mr-3"></i>
                            <div>
                                <p class="font-medium text-gray-900">Mark as Completed</p>
                                <p class="text-sm text-gray-500">Order delivered/completed</p>
                            </div>
                        </div>
                    </button>
                    @endif

                    @if($order->status !== 'cancelled')
                    <button onclick="showConfirmCancel({{ $order->id }})"
                            class="w-full flex items-center justify-between p-3 text-left rounded-lg border border-red-200 hover:bg-red-50">
                        <div class="flex items-center">
                            <i class="fas fa-times-circle text-red-600 mr-3"></i>
                            <div>
                                <p class="font-medium text-gray-900">Cancel Order</p>
                                <p class="text-sm text-gray-500">Cancel this order</p>
                            </div>
                        </div>
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div id="paymentModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Confirm Payment</h3>
        </div>
        <form id="paymentForm" method="POST">
            @csrf
            <div class="p-6 space-y-4">
                <div>
                    <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">
                        Payment Method
                    </label>
                    <select name="payment_method" id="payment_method" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Select Method</option>
                        <option value="cash">Cash</option>
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="credit_card">Credit Card</option>
                        <option value="ewallet">E-Wallet</option>
                    </select>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                <button type="button" 
                        onclick="closePaymentModal()"
                        class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Confirm Payment
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Cancel Confirmation Modal -->
<div id="cancelModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Cancel Order</h3>
        </div>
        <div class="p-6">
            <p class="text-gray-700">Are you sure you want to cancel this order? This action will restore product stock.</p>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
            <button type="button" 
                    onclick="closeCancelModal()"
                    class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">
                No, Keep Order
            </button>
            <button type="button" 
                    onclick="confirmCancel()"
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                Yes, Cancel Order
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
let currentOrderId = null;

// Payment Modal
function showPaymentModal(orderId) {
    currentOrderId = orderId;
    const modal = document.getElementById('paymentModal');
    const form = document.getElementById('paymentForm');
    form.action = `/admin/orders/${orderId}/confirm-payment`;
    modal.classList.remove('hidden');
}

function closePaymentModal() {
    document.getElementById('paymentModal').classList.add('hidden');
}

// Cancel Modal
function showConfirmCancel(orderId) {
    currentOrderId = orderId;
    document.getElementById('cancelModal').classList.remove('hidden');
}

function closeCancelModal() {
    document.getElementById('cancelModal').classList.add('hidden');
}

function confirmCancel() {
    if (currentOrderId) {
        updateStatus(currentOrderId, 'cancelled');
        closeCancelModal();
    }
}

// Update Status Function
function updateStatus(orderId, status) {
    if (!confirm(`Are you sure you want to mark this order as "${status}"?`)) {
        return;
    }

    fetch(`/admin/orders/${orderId}/status`, {
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

// Close modals when clicking outside
document.getElementById('paymentModal').addEventListener('click', function(e) {
    if (e.target === this) closePaymentModal();
});

document.getElementById('cancelModal').addEventListener('click', function(e) {
    if (e.target === this) closeCancelModal();
});
</script>
@endpush
@endsection