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
                    @include('pages.admin.dashboard-content')
                </template>

                <!-- Orders -->
                <template x-if="currentPage === 'orders'">
                    @include('pages.admin.orders')
                </template>

                <!-- Products -->
                <template x-if="currentPage === 'products'">
                    @include('pages.admin.products')
                </template>

                <!-- Promo Codes -->
                <template x-if="currentPage === 'promos'">
                    @include('pages.admin.promos')
                </template>

                <!-- Locations -->
                <template x-if="currentPage === 'locations'">
                    @include('pages.admin.locations')
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