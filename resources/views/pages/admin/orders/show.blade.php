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
            <a href="{{ route('admin.orders.index') }}" 
               class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">
                <i class="fas fa-arrow-left mr-2"></i>Back to Orders
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
        <p>{{ session('success') }}</p>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
        <p>{{ session('error') }}</p>
    </div>
    @endif

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
                        @if($order->payment_method)
                        <div>
                            <p class="text-sm text-gray-500">Payment Method</p>
                            <p class="font-medium text-gray-900">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>
                        </div>
                        @endif
                        @if($order->paid_at)
                        <div>
                            <p class="text-sm text-gray-500">Paid At</p>
                            <p class="font-medium text-gray-900">{{ $order->paid_at->format('d M Y H:i') }}</p>
                        </div>
                        @endif
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
                                            @if($item->product && $item->product->image_url)
                                            <img src="{{ $item->product->image_url }}" 
                                                 alt="{{ $item->product->name }}"
                                                 class="w-10 h-10 object-cover rounded mr-3">
                                            @else
                                            <div class="w-10 h-10 bg-gray-200 rounded mr-3 flex items-center justify-center">
                                                <i class="fas fa-image text-gray-400"></i>
                                            </div>
                                            @endif
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $item->product->name ?? 'Product deleted' }}</p>
                                                @if($item->product && $item->product->sku)
                                                <p class="text-sm text-gray-500">{{ $item->product->sku }}</p>
                                                @endif
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
                                @if($order->shipping_cost > 0)
                                <tr>
                                    <td colspan="3" class="px-4 py-3 text-right text-sm font-medium text-gray-700">Shipping Cost</td>
                                    <td class="px-4 py-3 text-sm font-bold text-gray-900">
                                        Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td colspan="3" class="px-4 py-3 text-right text-sm font-medium text-gray-700">Grand Total</td>
                                    <td class="px-4 py-3 text-sm font-bold text-gray-900">
                                        Rp {{ number_format($order->grand_total ?? ($order->total - $order->discount + ($order->shipping_cost ?? 0)), 0, ',', '.') }}
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
                    @if($order->location)
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm text-gray-500">Recipient</p>
                                <p class="font-medium text-gray-900">{{ $order->location->recipient_name }}</p>
                                <p class="text-sm text-gray-600">{{ $order->location->recipient_phone }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Address</p>
                                <p class="text-gray-900">{{ $order->location->full_address }}</p>
                                <p class="text-sm text-gray-600">
                                    {{ $order->location->city }}, {{ $order->location->province }} {{ $order->location->postal_code }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Location Type</p>
                                <p class="text-gray-900">{{ $order->location->name }}</p>
                                @if($order->location->is_primary)
                                    <span class="inline-block px-2 py-1 text-xs font-semibold bg-blue-100 text-blue-800 rounded-full mt-1">
                                        Primary Address
                                    </span>
                                @endif
                            </div>
                        </div>
                    @elseif($order->shipping_address)
                        <div>
                            <p class="text-sm text-gray-500">Shipping Address</p>
                            <p class="mt-1 text-gray-900">{{ $order->shipping_address }}</p>
                            @if($order->shipping_note)
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">Notes</p>
                                    <p class="text-gray-900">{{ $order->shipping_note }}</p>
                                </div>
                            @endif
                        </div>
                    @else
                        <p class="text-gray-500">No shipping information provided</p>
                    @endif
                </div>
            </div>

            @if($order->notes)
            <!-- Order Notes -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Order Notes</h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-700 whitespace-pre-line">{{ $order->notes }}</p>
                </div>
            </div>
            @endif
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
                        <div>
                            <p class="text-sm text-gray-500">Member Since</p>
                            <p class="font-medium text-gray-900">{{ $order->customer->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t">
                        <a href="{{ route('admin.customers.show', $order->customer_id) }}"
                           class="inline-flex items-center text-blue-600 hover:text-blue-900 text-sm font-medium">
                            <i class="fas fa-user-circle mr-2"></i>
                            View Customer Profile
                        </a>
                    </div>
                    @else
                    <p class="text-gray-500">Customer information not available</p>
                    @endif
                </div>
            </div>

          
            <!-- Order Timeline -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Order Timeline</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                    <i class="fas fa-shopping-cart text-blue-600 text-sm"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">Order Created</p>
                                <p class="text-sm text-gray-500">{{ $order->created_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                        
                        @if($order->status === 'processing' || $order->status === 'completed')
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center">
                                    <i class="fas fa-cog text-purple-600 text-sm"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">Processing Started</p>
                                <p class="text-sm text-gray-500">Order is being processed</p>
                            </div>
                        </div>
                        @endif

                        @if($order->status === 'completed')
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                    <i class="fas fa-check text-green-600 text-sm"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">Order Completed</p>
                                <p class="text-sm text-gray-500">Order has been delivered/completed</p>
                            </div>
                        </div>
                        @endif

                        @if($order->paid_at)
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                    <i class="fas fa-money-bill-wave text-green-600 text-sm"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">Payment Received</p>
                                <p class="text-sm text-gray-500">{{ $order->paid_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
/**
 * Confirm and submit action
 * @param {string} actionType - payment, processing, completed, cancelled
 */
function confirmAction(actionType) {
    const messages = {
        'payment': 'Are you sure you want to confirm payment for this order?\n\nNote: Order will automatically move to "Processing" status.',
        'processing': 'Are you sure you want to mark this order as processing?',
        'completed': 'Are you sure you want to mark this order as completed?',
        'cancelled': 'Are you sure you want to cancel this order?\n\n⚠️ Warning: This action will restore product stock and cannot be undone.'
    };

    const confirmMessage = messages[actionType];
    
    if (!confirm(confirmMessage)) {
        return;
    }

    // Submit the corresponding form
    const formId = actionType + 'Form';
    const form = document.getElementById(formId);
    
    if (form) {
        // Show loading state on button
        const button = document.querySelector(`[onclick="confirmAction('${actionType}')"]`);
        if (button) {
            const originalHTML = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';
            button.disabled = true;
            
            // Submit form after a short delay to show loading state
            setTimeout(() => {
                form.submit();
            }, 300);
        } else {
            form.submit();
        }
    } else {
        console.error('Form not found:', formId);
        alert('Error: Form not found');
    }
}

// Simple modals close functionality
function closePaymentModal() {
    document.getElementById('paymentModal')?.classList.add('hidden');
}

function closeCancelModal() {
    document.getElementById('cancelModal')?.classList.add('hidden');
}
</script>
@endpush
@endsection