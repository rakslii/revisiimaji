<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
        <p class="text-gray-600 mt-1">Ringkasan data toko Anda</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Orders</p>
                    <p class="text-2xl font-bold text-gray-900" x-text="dashboardStats.totalOrders"></p>
                </div>
                <i class="fas fa-shopping-cart w-10 h-10 text-blue-500"></i>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Paid Orders</p>
                    <p class="text-2xl font-bold text-green-600" x-text="dashboardStats.paidOrders"></p>
                </div>
                <i class="fas fa-check-circle w-10 h-10 text-green-500"></i>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Unpaid Orders</p>
                    <p class="text-2xl font-bold text-red-600" x-text="dashboardStats.unpaidOrders"></p>
                </div>
                <i class="fas fa-clock w-10 h-10 text-red-500"></i>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Instant Products</p>
                    <p class="text-2xl font-bold text-purple-600" x-text="dashboardStats.instantProducts"></p>
                </div>
                <i class="fas fa-box w-10 h-10 text-purple-500"></i>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Non-Instant</p>
                    <p class="text-2xl font-bold text-orange-600" x-text="dashboardStats.nonInstantProducts"></p>
                </div>
                <i class="fas fa-box w-10 h-10 text-orange-500"></i>
            </div>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b">
            <h2 class="text-xl font-semibold">Recent Orders</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <template x-for="order in recentOrders" :key="order.id">
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900" x-text="order.id"></td>
                            <td class="px-6 py-4 text-sm text-gray-600" x-text="order.user"></td>
                            <td class="px-6 py-4 text-sm text-gray-900">Rp <span x-text="formatCurrency(order.amount)"></span></td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full" 
                                      :class="getStatusColor(order.status)" x-text="order.status"></span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600" x-text="order.type"></td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</div>