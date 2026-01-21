@extends('pages.admin.layouts.app')

@section('title', 'Edit Order #' . $order->order_code)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Edit Order</h1>
            <p class="text-gray-600 mt-1">Order #{{ $order->order_code }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.orders.show', $order->id) }}" 
               class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">
                <i class="fas fa-eye mr-2"></i>View Details
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

    <!-- Form -->
    <div class="bg-white rounded-lg shadow">
        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Edit Order Information</h3>
            </div>
            
            <div class="p-6 space-y-6">
                <!-- Customer Selection -->
                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">Customer *</label>
                    <select name="user_id" id="user_id" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Select Customer</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ $order->user_id == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }} - {{ $customer->phone }} ({{ $customer->email }})
                            </option>
                        @endforeach
                    </select>
                    @if($customers->isEmpty())
                    <p class="mt-2 text-sm text-red-600">No customers found. Please create customers first.</p>
                    @endif
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
                                @foreach($order->items as $item)
                                <tr>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $item->product->name ?? 'Product deleted' }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $item->quantity }}</td>
                                    <td class="px-4 py-3 text-sm font-medium text-gray-900">Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <td colspan="3" class="px-4 py-3 text-right text-sm font-medium text-gray-700">Total</td>
                                    <td class="px-4 py-3 text-sm font-bold text-gray-900">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
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
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('shipping_address', $order->shipping_address) }}</textarea>
                </div>

                <!-- Status and Payment -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Order Status *</label>
                        <select name="status" id="status" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="waiting_payment" {{ $order->status == 'waiting_payment' ? 'selected' : '' }}>Waiting Payment</option>
                            <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <div>
                        <label for="payment_status" class="block text-sm font-medium text-gray-700 mb-2">Payment Status *</label>
                        <select name="payment_status" id="payment_status" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="unpaid" {{ $order->payment_status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                            <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                        </select>
                    </div>
                </div>

               <!-- Payment Method -->
<div>
    <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">Payment Method *</label>
    <select name="payment_method" id="payment_method" required
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        <option value="">Select Payment Method</option>
        <option value="cash" {{ $order->payment_method == 'cash' ? 'selected' : '' }}>Cash</option>
        <option value="bank_transfer" {{ $order->payment_method == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
        <option value="credit_card" {{ $order->payment_method == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
        <option value="ewallet" {{ $order->payment_method == 'ewallet' ? 'selected' : '' }}>E-Wallet</option>
    </select>
    @error('payment_method')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

                <!-- Notes -->
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                    <textarea name="notes" id="notes" rows="2"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Additional notes for this order">{{ old('notes', $order->notes) }}</textarea>
                </div>
            </div>
            
            <!-- Form Actions -->
            <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                <a href="{{ route('admin.orders.show', $order->id) }}" 
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

@push('scripts')
<script>
// Add confirmation for status change to cancelled
document.getElementById('status').addEventListener('change', function() {
    if (this.value === 'cancelled') {
        if (!confirm('Changing status to cancelled will restore product stock. Continue?')) {
            this.value = '{{ $order->status }}';
        }
    }
});

// Add confirmation for payment status change to unpaid
document.getElementById('payment_status').addEventListener('change', function() {
    if (this.value === 'unpaid' && '{{ $order->payment_status }}' === 'paid') {
        if (!confirm('Changing payment status to unpaid will mark the order as not paid. Continue?')) {
            this.value = '{{ $order->payment_status }}';
        }
    }
});
</script>
@endpush
@endsection