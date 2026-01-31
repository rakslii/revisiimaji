<aside class="fixed left-0 top-0 h-screen w-64 bg-gray-900 text-white shadow-lg">
    <!-- Logo -->
    <div class="p-6 border-b border-gray-800">
        <h2 class="text-xl font-bold">Admin Panel</h2>
        <p class="text-gray-400 text-sm mt-1">{{ config('app.name', 'Cipta Imaji') }}</p>
    </div>
    
    <!-- Navigation -->
    <nav class="p-4 space-y-2">
        @foreach([
            ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'fas fa-tachometer-alt'],
            ['route' => 'admin.orders.index', 'label' => 'Orders', 'icon' => 'fas fa-shopping-cart'],
            ['route' => 'admin.products.index', 'label' => 'Products', 'icon' => 'fas fa-box'],
            ['route' => 'admin.customers.index', 'label' => 'Customers', 'icon' => 'fas fa-users'],
            ['route' => 'admin.promos.index', 'label' => 'Promo Codes', 'icon' => 'fas fa-tag'],
            ['route' => 'admin.settings', 'label' => 'Settings', 'icon' => 'fas fa-cog'],
        ] as $item)
            <a href="{{ route($item['route']) }}" 
               class="flex items-center gap-3 p-3 rounded-lg transition-colors 
                      {{ request()->routeIs($item['route'] . '*') || 
                         (strpos($item['route'], '.index') !== false && 
                          request()->routeIs(str_replace('.index', '', $item['route']) . '.*')) ? 'bg-blue-600' : 'hover:bg-gray-800' }}">
                <i class="{{ $item['icon'] }} w-5 h-5"></i>
                <span>{{ $item['label'] }}</span>
            </a>
        @endforeach
    </nav>
    
    <!-- Logout -->
    <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-800">
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 p-3 rounded-lg hover:bg-gray-800">
                <i class="fas fa-sign-out-alt w-5 h-5"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>