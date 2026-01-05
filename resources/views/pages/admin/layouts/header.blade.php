<header class="bg-white shadow-sm border-b">
    <div class="px-6 py-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <!-- Mobile menu button (optional) -->
                <button class="lg:hidden text-gray-500">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            
            <div class="flex items-center space-x-4">
                <div class="text-right">
                    <p class="text-sm text-gray-600">Welcome back,</p>
                    <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
                </div>
                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-semibold">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            </div>
        </div>
    </div>
</header>