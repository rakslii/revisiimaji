@extends('admin.layout')

@section('title', 'Orders')

@section('content')
<div class="space-y-6" x-data="adminPanel">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Order Management</h1>
            <p class="text-gray-600 mt-1">Kelola semua pesanan</p>
        </div>
        <div class="flex gap-2">
            <div class="relative">
                <i data-lucide="search" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5"></i>
                <input type="text" placeholder="Search orders..."
                       class="pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($orders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">ORD-{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $order->user->name ?? 'Unknown' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $order->product->name ?? 'Unknown' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">Rp {{ number_format($order->amount, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full"
                                  :class="getStatusColor('{{ $order->status }}')">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                @if($order->status == 'unpaid')
                                <button class="p-2 text-green-600 hover:bg-green-50 rounded" title="Confirm Payment">
                                    <i data-lucide="check-circle" class="w-5 h-5"></i>
                                </button>
                                @endif
                                @if($order->status == 'paid')
                                <button class="p-2 text-blue-600 hover:bg-blue-50 rounded" title="Mark as Processed">
                                    <i data-lucide="clock" class="w-5 h-5"></i>
                                </button>
                                @endif
                                <button class="p-2 text-purple-600 hover:bg-purple-50 rounded" 
                                        title="View Details"
                                        @click="selectedOrder = {{ json_encode($order) }}">
                                    <i data-lucide="eye" class="w-5 h-5"></i>
                                </button>
                                <button class="p-2 text-emerald-600 hover:bg-emerald-50 rounded" 
                                        title="Open WhatsApp"
                                        @click="openWhatsApp('{{ $order->phone }}')">
                                    <i data-lucide="message-circle" class="w-5 h-5"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Order Detail Modal -->
<template x-if="selectedOrder">
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold">Order Details</h3>
                <button @click="selectedOrder = null" class="text-gray-500 hover:text-gray-700">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
            <div class="space-y-3">
                <div>
                    <p class="text-sm text-gray-600">Order ID</p>
                    <p class="font-semibold" x-text="'ORD-' + selectedOrder.id.toString().padStart(3, '0')"></p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Customer</p>
                    <p class="font-semibold" x-text="selectedOrder.user?.name || 'Unknown'"></p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Product</p>
                    <p class="font-semibold" x-text="selectedOrder.product?.name || 'Unknown'"></p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Amount</p>
                    <p class="font-semibold" x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(selectedOrder.amount)"></p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Status</p>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full"
                          :class="getStatusColor(selectedOrder.status)"
                          x-text="selectedOrder.status"></span>
                </div>
            </div>
            <div class="mt-6 flex gap-2">
                <button class="flex-1 bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 flex items-center justify-center gap-2"
                        @click="openWhatsApp(selectedOrder.phone)">
                    <i data-lucide="message-circle" class="w-4 h-4"></i>
                    Contact Customer
                </button>
                <button class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                    Update Status
                </button>
            </div>
        </div>
    </div>
</template>
@endsection