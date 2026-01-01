<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Order Management</h1>
            <p class="text-gray-600 mt-1">Kelola semua pesanan</p>
        </div>
        <div class="flex gap-2">
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5"></i>
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
                    <template x-for="order in recentOrders" :key="order.id">
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900" x-text="order.id"></td>
                            <td class="px-6 py-4 text-sm text-gray-600" x-text="order.user"></td>
                            <td class="px-6 py-4 text-sm text-gray-600" x-text="order.product"></td>
                            <td class="px-6 py-4 text-sm text-gray-900">Rp <span x-text="formatCurrency(order.amount)"></span></td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full" 
                                      :class="getStatusColor(order.status)" x-text="order.status"></span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <template x-if="order.status === 'unpaid'">
                                        <button class="p-2 text-green-600 hover:bg-green-50 rounded" title="Confirm Payment">
                                            <i class="fas fa-check-circle w-5 h-5"></i>
                                        </button>
                                    </template>
                                    <template x-if="order.status === 'paid'">
                                        <button class="p-2 text-blue-600 hover:bg-blue-50 rounded" title="Mark as Processed">
                                            <i class="fas fa-clock w-5 h-5"></i>
                                        </button>
                                    </template>
                                    <button class="p-2 text-purple-600 hover:bg-purple-50 rounded" 
                                            title="View Details"
                                            @click="selectedOrder = order">
                                        <i class="fas fa-eye w-5 h-5"></i>
                                    </button>
                                    <button class="p-2 text-emerald-600 hover:bg-emerald-50 rounded" 
                                            title="Open WhatsApp"
                                            @click="openWhatsApp(order.phone)">
                                        <i class="fas fa-comment-alt w-5 h-5"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</div>