<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-100" x-data="adminPanel()">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div :class="sidebarOpen ? 'w-64' : 'w-20'" 
             class="bg-gray-900 text-white transition-all duration-300 flex flex-col">
            <div class="p-4 flex items-center justify-between border-b border-gray-800">
                <template x-if="sidebarOpen">
                    <h2 class="text-xl font-bold">Admin Panel</h2>
                </template>
                <button @click="sidebarOpen = !sidebarOpen" class="p-2 hover:bg-gray-800 rounded">
                    <i x-show="sidebarOpen" class="fas fa-times w-5 h-5"></i>
                    <i x-show="!sidebarOpen" class="fas fa-bars w-5 h-5"></i>
                </button>
            </div>

            <nav class="flex-1 p-4">
                @foreach([
                    ['id' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'fas fa-tachometer-alt'],
                    ['id' => 'orders', 'label' => 'Orders', 'icon' => 'fas fa-shopping-cart'],
                    ['id' => 'products', 'label' => 'Products', 'icon' => 'fas fa-box'],
                    ['id' => 'promos', 'label' => 'Promo Codes', 'icon' => 'fas fa-tag'],
                    ['id' => 'locations', 'label' => 'Locations', 'icon' => 'fas fa-map-marker-alt']
                ] as $item)
                    <button @click="currentPage = '{{ $item['id'] }}'"
                           :class="currentPage === '{{ $item['id'] }}' ? 'bg-blue-600' : 'hover:bg-gray-800'"
                           class="w-full flex items-center gap-3 p-3 rounded-lg mb-2 transition-colors">
                        <i class="{{ $item['icon'] }} w-5 h-5"></i>
                        <template x-if="sidebarOpen">
                            <span>{{ $item['label'] }}</span>
                        </template>
                    </button>
                @endforeach
            </nav>

            <div class="p-4 border-t border-gray-800">
                <button class="w-full flex items-center gap-3 p-3 rounded-lg hover:bg-gray-800">
                    <i class="fas fa-sign-out-alt w-5 h-5"></i>
                    <template x-if="sidebarOpen">
                        <span>Logout</span>
                    </template>
                </button>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <!-- Header -->
            <div class="bg-white shadow-sm border-b">
                <div class="px-8 py-4">
                    <div class="flex items-center justify-between">
                        <h2 class="text-2xl font-semibold text-gray-800">Welcome, Admin</h2>
                        <div class="flex items-center gap-4">
                            <div class="text-right">
                                <p class="text-sm text-gray-600">Admin Account</p>
                                <p class="text-sm font-medium">admin@example.com</p>
                            </div>
                            <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-semibold">
                                A
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dynamic Content -->
            <div class="p-8">
                <!-- Dashboard -->
                <template x-if="currentPage === 'dashboard'">
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
                </template>

                <!-- Orders -->
                <template x-if="currentPage === 'orders'">
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
                </template>

                <!-- Products -->
                <template x-if="currentPage === 'products'">
                    <div class="space-y-6">
                        <div class="flex justify-between items-center">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900">Product Management</h1>
                                <p class="text-gray-600 mt-1">Kelola produk Anda</p>
                            </div>
                            <button class="flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                                <i class="fas fa-plus w-5 h-5"></i>
                                Add Product
                            </button>
                        </div>

                        <div class="bg-white rounded-lg shadow overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        <template x-for="product in products" :key="product.id">
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-6 py-4 text-sm font-medium text-gray-900" x-text="product.id"></td>
                                                <td class="px-6 py-4 text-sm text-gray-900" x-text="product.name"></td>
                                                <td class="px-6 py-4">
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full" 
                                                          :class="product.category === 'instant' ? 'bg-purple-100 text-purple-800' : 'bg-orange-100 text-orange-800'"
                                                          x-text="product.category"></span>
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-900">Rp <span x-text="formatCurrency(product.price)"></span></td>
                                                <td class="px-6 py-4">
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full" 
                                                          :class="product.status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'"
                                                          x-text="product.status"></span>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="flex gap-2">
                                                        <button class="p-2 text-blue-600 hover:bg-blue-50 rounded" title="Edit">
                                                            <i class="fas fa-edit w-5 h-5"></i>
                                                        </button>
                                                        <button class="p-2 text-red-600 hover:bg-red-50 rounded" title="Delete">
                                                            <i class="fas fa-trash-alt w-5 h-5"></i>
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
                </template>

                <!-- Promo Codes -->
                <template x-if="currentPage === 'promos'">
                    <div class="space-y-6">
                        <div class="flex justify-between items-center">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900">Promo Code Management</h1>
                                <p class="text-gray-600 mt-1">Kelola kode promo</p>
                            </div>
                            <button class="flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                                <i class="fas fa-plus w-5 h-5"></i>
                                Create Promo
                            </button>
                        </div>

                        <div class="bg-white rounded-lg shadow overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Code</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Value</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Usage</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Expiry</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        <template x-for="promo in promoCodes" :key="promo.id">
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-6 py-4 text-sm font-medium text-gray-900" x-text="promo.code"></td>
                                                <td class="px-6 py-4">
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full" 
                                                          :class="promo.type === 'percentage' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800'"
                                                          x-text="promo.type"></span>
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-900">
                                                    <template x-if="promo.type === 'percentage'">
                                                        <span x-text="`${promo.value}%`"></span>
                                                    </template>
                                                    <template x-if="promo.type === 'nominal'">
                                                        <span x-text="`Rp ${formatCurrency(promo.value)}`"></span>
                                                    </template>
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-600" x-text="`${promo.used} / ${promo.quota}`"></td>
                                                <td class="px-6 py-4 text-sm text-gray-600" x-text="promo.expiry"></td>
                                                <td class="px-6 py-4">
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full" 
                                                          :class="promo.status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'"
                                                          x-text="promo.status"></span>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="flex gap-2">
                                                        <button class="p-2 text-blue-600 hover:bg-blue-50 rounded" title="Edit">
                                                            <i class="fas fa-edit w-5 h-5"></i>
                                                        </button>
                                                        <button class="p-2 text-red-600 hover:bg-red-50 rounded" title="Delete">
                                                            <i class="fas fa-trash-alt w-5 h-5"></i>
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
                </template>

                <!-- Locations -->
                <template x-if="currentPage === 'locations'">
                    <div class="space-y-6">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Location Management</h1>
                            <p class="text-gray-600 mt-1">Kelola lokasi pengiriman</p>
                        </div>

                        <div class="bg-white rounded-lg shadow overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order ID</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Address</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Coordinates</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Validated</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        <template x-for="location in locations" :key="location.id">
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-6 py-4 text-sm font-medium text-gray-900" x-text="location.orderId"></td>
                                                <td class="px-6 py-4 text-sm text-gray-600" x-text="location.user"></td>
                                                <td class="px-6 py-4 text-sm text-gray-600" x-text="location.address"></td>
                                                <td class="px-6 py-4 text-sm text-gray-600" x-text="`${location.lat}, ${location.lng}`"></td>
                                                <td class="px-6 py-4">
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full" 
                                                          :class="location.validated ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'"
                                                          x-text="location.validated ? 'Validated' : 'Pending'"></span>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="flex gap-2">
                                                        <button class="p-2 text-blue-600 hover:bg-blue-50 rounded" 
                                                                title="View on Map"
                                                                @click="openGoogleMaps(location.lat, location.lng)">
                                                            <i class="fas fa-map-marker-alt w-5 h-5"></i>
                                                        </button>
                                                        <template x-if="!location.validated">
                                                            <button class="p-2 text-green-600 hover:bg-green-50 rounded" title="Validate">
                                                                <i class="fas fa-check-circle w-5 h-5"></i>
                                                            </button>
                                                        </template>
                                                    </div>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </template>
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
                        <i class="fas fa-times w-6 h-6"></i>
                    </button>
                </div>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-600">Order ID</p>
                        <p class="font-semibold" x-text="selectedOrder.id"></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Customer</p>
                        <p class="font-semibold" x-text="selectedOrder.user"></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Product</p>
                        <p class="font-semibold" x-text="selectedOrder.product"></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Amount</p>
                        <p class="font-semibold">Rp <span x-text="formatCurrency(selectedOrder.amount)"></span></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Status</p>
                        <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full" 
                              :class="getStatusColor(selectedOrder.status)"
                              x-text="selectedOrder.status"></span>
                    </div>
                </div>
                <div class="mt-6 flex gap-2">
                    <button class="flex-1 bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 flex items-center justify-center gap-2"
                            @click="openWhatsApp(selectedOrder.phone)">
                        <i class="fas fa-comment-alt w-4 h-4"></i>
                        Contact Customer
                    </button>
                    <button class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                        Update Status
                    </button>
                </div>
            </div>
        </div>
    </template>

    <script>
        function adminPanel() {
            return {
                currentPage: 'dashboard',
                sidebarOpen: true,
                selectedOrder: null,
                
                // Sample data
                dashboardStats: {
                    totalOrders: 248,
                    paidOrders: 195,
                    unpaidOrders: 53,
                    instantProducts: 142,
                    nonInstantProducts: 106
                },

                recentOrders: [
                    { id: 'ORD-001', user: 'John Doe', product: 'Product A', amount: 250000, status: 'unpaid', type: 'instant', phone: '081234567890' },
                    { id: 'ORD-002', user: 'Jane Smith', product: 'Product B', amount: 500000, status: 'paid', type: 'non-instant', phone: '081234567891' },
                    { id: 'ORD-003', user: 'Bob Wilson', product: 'Product C', amount: 150000, status: 'processed', type: 'instant', phone: '081234567892' }
                ],

                products: [
                    { id: 1, name: 'Product A', category: 'instant', price: 250000, status: 'active' },
                    { id: 2, name: 'Product B', category: 'non-instant', price: 500000, status: 'active' },
                    { id: 3, name: 'Product C', category: 'instant', price: 150000, status: 'inactive' }
                ],

                promoCodes: [
                    { id: 1, code: 'DISCOUNT50', type: 'percentage', value: 50, quota: 100, used: 45, expiry: '2026-12-31', status: 'active' },
                    { id: 2, code: 'NEWYEAR2026', type: 'nominal', value: 100000, quota: 50, used: 50, expiry: '2026-01-31', status: 'inactive' }
                ],

                locations: [
                    { id: 1, orderId: 'ORD-001', user: 'John Doe', address: 'Jl. Sudirman No. 123, Jakarta', lat: -6.2088, lng: 106.8456, validated: true },
                    { id: 2, orderId: 'ORD-002', user: 'Jane Smith', address: 'Jl. Gatot Subroto No. 456, Bandung', lat: -6.9175, lng: 107.6191, validated: false }
                ],

                getStatusColor(status) {
                    const colors = {
                        'paid': 'bg-green-100 text-green-800',
                        'unpaid': 'bg-red-100 text-red-800',
                        'processed': 'bg-blue-100 text-blue-800',
                        'done': 'bg-purple-100 text-purple-800'
                    };
                    return colors[status] || 'bg-gray-100 text-gray-800';
                },

                formatCurrency(amount) {
                    return amount.toLocaleString('id-ID');
                },

                openWhatsApp(phone) {
                    window.open(`https://wa.me/62${phone.substring(1)}`, '_blank');
                },

                openGoogleMaps(lat, lng) {
                    window.open(`https://www.google.com/maps?q=${lat},${lng}`, '_blank');
                }
            }
        }
    </script>
</body>
</html>