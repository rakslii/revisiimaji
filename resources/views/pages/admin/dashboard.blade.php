<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap');
        
        * {
            font-family: 'Poppins', sans-serif;
        }
        
        .gradient-sidebar {
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
        }
        
        .gradient-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .nav-item {
            position: relative;
            overflow: hidden;
        }
        
        .nav-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: linear-gradient(180deg, #3b82f6 0%, #8b5cf6 100%);
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }
        
        .nav-item.active::before,
        .nav-item:hover::before {
            transform: translateX(0);
        }
        
        .stat-card {
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100" x-data="adminPanel()">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div :class="sidebarOpen ? 'w-64' : 'w-20'" 
             class="gradient-sidebar text-white transition-all duration-300 flex flex-col shadow-2xl">
            
            <!-- Logo -->
            <div class="p-4 flex items-center justify-between border-b border-gray-700">
                <template x-if="sidebarOpen">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                            <span class="text-xl">🎨</span>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold">Admin Panel</h2>
                            <p class="text-xs text-gray-400">Cipta Imaji</p>
                        </div>
                    </div>
                </template>
                <button @click="sidebarOpen = !sidebarOpen" class="p-2 hover:bg-gray-700 rounded-lg transition-colors">
                    <i x-show="sidebarOpen" class="fas fa-times"></i>
                    <i x-show="!sidebarOpen" class="fas fa-bars"></i>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-4 space-y-2">
                <template x-for="item in [
                    {id: 'dashboard', label: 'Dashboard', icon: 'fas fa-tachometer-alt'},
                    {id: 'orders', label: 'Orders', icon: 'fas fa-shopping-cart'},
                    {id: 'products', label: 'Products', icon: 'fas fa-box'},
                    {id: 'promos', label: 'Promo Codes', icon: 'fas fa-tag'},
                    {id: 'locations', label: 'Locations', icon: 'fas fa-map-marker-alt'}
                ]" :key="item.id">
                    <button @click="currentPage = item.id"
                           :class="currentPage === item.id ? 'active bg-gradient-to-r from-blue-600 to-purple-600 shadow-lg' : 'hover:bg-gray-700/50'"
                           class="nav-item w-full flex items-center gap-3 p-3 rounded-xl transition-all duration-300">
                        <i :class="item.icon" class="w-5 min-w-[20px]"></i>
                        <template x-if="sidebarOpen">
                            <span class="font-medium" x-text="item.label"></span>
                        </template>
                    </button>
                </template>
            </nav>

            <!-- User Profile & Logout -->
            <div class="p-4 border-t border-gray-700">
                <template x-if="sidebarOpen">
                    <div class="mb-3 p-3 bg-gray-800/50 rounded-xl">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold shadow-lg">
                                A
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold truncate">Admin</p>
                                <p class="text-xs text-gray-400 truncate">admin@example.com</p>
                            </div>
                        </div>
                    </div>
                </template>
                
                <button class="w-full flex items-center gap-3 p-3 rounded-xl hover:bg-red-600/20 hover:text-red-400 transition-all duration-300">
                    <i class="fas fa-sign-out-alt w-5 min-w-[20px]"></i>
                    <template x-if="sidebarOpen">
                        <span class="font-medium">Logout</span>
                    </template>
                </button>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <!-- Header -->
            <div class="gradient-header shadow-lg">
                <div class="px-8 py-6">
                    <div class="flex items-center justify-between">
                        <div class="text-white">
                            <h1 class="text-3xl font-bold mb-1">Welcome Back! 👋</h1>
                            <p class="text-purple-100">Admin • Thursday, January 01, 2026</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <!-- Notifications -->
                            <button class="relative p-3 glass-effect text-white rounded-xl hover:bg-white/20 transition-all">
                                <i class="fas fa-bell"></i>
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold">5</span>
                            </button>
                            
                            <!-- Settings -->
                            <button class="p-3 glass-effect text-white rounded-xl hover:bg-white/20 transition-all">
                                <i class="fas fa-cog"></i>
                            </button>
                            
                            <!-- User Avatar -->
                            <div class="flex items-center gap-3 glass-effect px-4 py-2 rounded-xl">
                                <div class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center text-white font-bold shadow-lg">
                                    A
                                </div>
                                <div class="text-white">
                                    <p class="text-sm font-semibold">Admin</p>
                                    <p class="text-xs text-purple-100">Online</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dynamic Content -->
            <div class="p-8">
                <!-- Dashboard -->
                <template x-if="currentPage === 'dashboard'">
                    <div>
                        <!-- Stats Cards -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
                            <!-- Total Orders -->
                            <div class="stat-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-shopping-cart text-white text-xl"></i>
                                    </div>
                                    <span class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-xs font-semibold">Total</span>
                                </div>
                                <h3 class="text-gray-500 text-sm font-medium mb-1">Total Orders</h3>
                                <p class="text-3xl font-bold text-gray-800" x-text="dashboardStats.totalOrders"></p>
                            </div>
                            
                            <!-- Paid Orders -->
                            <div class="stat-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-check-circle text-white text-xl"></i>
                                    </div>
                                    <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-xs font-semibold">Paid</span>
                                </div>
                                <h3 class="text-gray-500 text-sm font-medium mb-1">Paid Orders</h3>
                                <p class="text-3xl font-bold text-gray-800" x-text="dashboardStats.paidOrders"></p>
                            </div>
                            
                            <!-- Unpaid Orders -->
                            <div class="stat-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-times-circle text-white text-xl"></i>
                                    </div>
                                    <span class="px-3 py-1 bg-red-100 text-red-600 rounded-full text-xs font-semibold">Unpaid</span>
                                </div>
                                <h3 class="text-gray-500 text-sm font-medium mb-1">Unpaid Orders</h3>
                                <p class="text-3xl font-bold text-gray-800" x-text="dashboardStats.unpaidOrders"></p>
                            </div>
                            
                            <!-- Instant Products -->
                            <div class="stat-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-bolt text-white text-xl"></i>
                                    </div>
                                    <span class="px-3 py-1 bg-purple-100 text-purple-600 rounded-full text-xs font-semibold">Instant</span>
                                </div>
                                <h3 class="text-gray-500 text-sm font-medium mb-1">Instant Products</h3>
                                <p class="text-3xl font-bold text-gray-800" x-text="dashboardStats.instantProducts"></p>
                            </div>
                            
                            <!-- Non-Instant Products -->
                            <div class="stat-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-box text-white text-xl"></i>
                                    </div>
                                    <span class="px-3 py-1 bg-pink-100 text-pink-600 rounded-full text-xs font-semibold">Custom</span>
                                </div>
                                <h3 class="text-gray-500 text-sm font-medium mb-1">Non-Instant</h3>
                                <p class="text-3xl font-bold text-gray-800" x-text="dashboardStats.nonInstantProducts"></p>
                            </div>
                        </div>

                        <!-- Recent Orders -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="p-6 border-b border-gray-100">
                                <h3 class="text-xl font-bold text-gray-800">Recent Orders</h3>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Order ID</th>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Customer</th>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Product</th>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Amount</th>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        <template x-for="order in recentOrders" :key="order.id">
                                            <tr class="hover:bg-gray-50 transition-colors">
                                                <td class="px-6 py-4">
                                                    <span class="font-semibold text-gray-800" x-text="order.id"></span>
                                                </td>
                                                <td class="px-6 py-4 text-gray-600" x-text="order.user"></td>
                                                <td class="px-6 py-4 text-gray-600" x-text="order.product"></td>
                                                <td class="px-6 py-4">
                                                    <span class="font-semibold text-gray-800">Rp <span x-text="formatCurrency(order.amount)"></span></span>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full" 
                                                          :class="getStatusColor(order.status)"
                                                          x-text="order.status"></span>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <button @click="selectedOrder = order" 
                                                            class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                                        View Details
                                                    </button>
                                                </td>
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
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">All Orders</h2>
                        <p class="text-gray-600">Orders management page</p>
                    </div>
                </template>

                <!-- Products -->
                <template x-if="currentPage === 'products'">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Products</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <template x-for="product in products" :key="product.id">
                                <div class="border border-gray-200 rounded-xl p-4 hover:shadow-md transition-shadow">
                                    <h3 class="font-bold text-lg mb-2" x-text="product.name"></h3>
                                    <p class="text-gray-600 text-sm mb-2" x-text="product.category"></p>
                                    <p class="text-blue-600 font-bold text-xl mb-3">Rp <span x-text="formatCurrency(product.price)"></span></p>
                                    <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full"
                                          :class="product.status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'"
                                          x-text="product.status"></span>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>

                <!-- Promo Codes -->
                <template x-if="currentPage === 'promos'">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Promo Codes</h2>
                        <div class="space-y-4">
                            <template x-for="promo in promoCodes" :key="promo.id">
                                <div class="border border-gray-200 rounded-xl p-4 flex items-center justify-between hover:shadow-md transition-shadow">
                                    <div>
                                        <h3 class="font-bold text-lg" x-text="promo.code"></h3>
                                        <p class="text-gray-600 text-sm">
                                            <span x-text="promo.type === 'percentage' ? promo.value + '%' : 'Rp ' + formatCurrency(promo.value)"></span> discount
                                        </p>
                                        <p class="text-xs text-gray-500 mt-1">Used: <span x-text="promo.used"></span> / <span x-text="promo.quota"></span></p>
                                    </div>
                                    <span class="px-4 py-2 text-sm font-semibold rounded-full"
                                          :class="promo.status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'"
                                          x-text="promo.status"></span>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>

                <!-- Locations -->
                <template x-if="currentPage === 'locations'">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Delivery Locations</h2>
                        <div class="space-y-4">
                            <template x-for="location in locations" :key="location.id">
                                <div class="border border-gray-200 rounded-xl p-4 hover:shadow-md transition-shadow">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <h3 class="font-bold text-lg mb-1">Order: <span x-text="location.orderId"></span></h3>
                                            <p class="text-gray-600 mb-1" x-text="location.user"></p>
                                            <p class="text-sm text-gray-500" x-text="location.address"></p>
                                        </div>
                                        <button @click="openGoogleMaps(location.lat, location.lng)"
                                                class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                            <i class="fas fa-map-marker-alt mr-2"></i>View Map
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- Order Detail Modal -->
    <template x-if="selectedOrder">
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" @click.self="selectedOrder = null">
            <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4 shadow-2xl">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-800">Order Details</h3>
                    <button @click="selectedOrder = null" class="text-gray-500 hover:text-gray-700 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div class="space-y-4">
                    <div class="p-4 bg-gray-50 rounded-xl">
                        <p class="text-xs text-gray-500 mb-1">Order ID</p>
                        <p class="font-bold text-lg text-gray-800" x-text="selectedOrder.id"></p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-xl">
                        <p class="text-xs text-gray-500 mb-1">Customer</p>
                        <p class="font-semibold text-gray-800" x-text="selectedOrder.user"></p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-xl">
                        <p class="text-xs text-gray-500 mb-1">Product</p>
                        <p class="font-semibold text-gray-800" x-text="selectedOrder.product"></p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-xl">
                        <p class="text-xs text-gray-500 mb-1">Amount</p>
                        <p class="font-bold text-xl text-blue-600">Rp <span x-text="formatCurrency(selectedOrder.amount)"></span></p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-xl">
                        <p class="text-xs text-gray-500 mb-2">Status</p>
                        <span class="inline-block px-4 py-2 text-sm font-semibold rounded-full" 
                              :class="getStatusColor(selectedOrder.status)"
                              x-text="selectedOrder.status"></span>
                    </div>
                </div>
                <div class="mt-6 flex gap-3">
                    <button class="flex-1 bg-gradient-to-r from-green-500 to-green-600 text-white py-3 rounded-xl hover:from-green-600 hover:to-green-700 transition-all flex items-center justify-center gap-2 font-semibold shadow-lg"
                            @click="openWhatsApp(selectedOrder.phone)">
                        <i class="fas fa-comment-alt"></i>
                        Contact
                    </button>
                    <button class="flex-1 bg-gradient-to-r from-blue-500 to-blue-600 text-white py-3 rounded-xl hover:from-blue-600 hover:to-blue-700 transition-all font-semibold shadow-lg">
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