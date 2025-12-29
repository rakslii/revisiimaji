<nav class="bg-white shadow-lg sticky top-0 z-50">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center space-x-2">
                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                    <i class="fas fa-print text-white text-lg"></i>
                </div>
                <span class="text-xl font-bold text-gray-800">Cipta Imaji</span>
            </a>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600 font-medium {{ request()->routeIs('home') ? 'text-blue-600' : '' }}">
                    Beranda
                </a>
                <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-blue-600 font-medium {{ request()->routeIs('products.*') ? 'text-blue-600' : '' }}">
                    Produk
                </a>
                <a href="{{ route('whatsapp.chat') }}" target="_blank" class="text-gray-700 hover:text-blue-600 font-medium">
                    <i class="fab fa-whatsapp mr-1"></i> Chat
                </a>

                @auth
                    <div class="flex items-center space-x-4">
                    <!-- Di layout navbar Anda -->
{{-- Cart icon with counter --}}
{{-- Cart icon with counter --}}
<a href="{{ route('cart.index') }}" class="relative">
    <i class="fas fa-shopping-cart text-xl text-gray-700 hover:text-blue-600"></i>
    @auth
        @php
            // Gunakan accessor baru
            $cartCount = auth()->user()->cart_items_count;
        @endphp
        @if($cartCount > 0)
            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center cart-counter">
                {{ $cartCount }}
            </span>
        @else
            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center cart-counter hidden">
                0
            </span>
        @endif
    @endauth
</a>

                        <div class="relative group">
                            <button class="flex items-center space-x-2 focus:outline-none">
                                @if(auth()->user()->avatar)
                                    <img src="{{ auth()->user()->avatar }}" alt="Avatar" class="w-8 h-8 rounded-full">
                                @else
                                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                @endif
                                <span class="text-gray-700">{{ auth()->user()->name }}</span>
                                <i class="fas fa-chevron-down text-gray-500 text-sm"></i>
                            </button>

                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 hidden group-hover:block">
                                <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-box mr-2"></i> Pesanan Saya
                                </a>
                                <a href="{{ route('profile.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user mr-2"></i> Profil
                                </a>
                                @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 border-t">
                                    <i class="fas fa-cog mr-2"></i> Admin Panel
                                </a>
                                @endif
                                <form method="POST" action="{{ route('logout') }}" class="border-t">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('google.login') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 font-medium">
                        <i class="fab fa-google mr-2"></i> Login dengan Google
                    </a>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <button id="mobile-menu-button" class="md:hidden text-gray-700">
                <i class="fas fa-bars text-2xl"></i>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden hidden py-4 border-t">
            <div class="flex flex-col space-y-4">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600 font-medium">
                    Beranda
                </a>
                <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-blue-600 font-medium">
                    Produk
                </a>
                <a href="{{ route('whatsapp.chat') }}" target="_blank" class="text-gray-700 hover:text-blue-600 font-medium">
                    <i class="fab fa-whatsapp mr-2"></i> Chat WhatsApp
                </a>

                @auth
                    <a href="{{ route('cart.index') }}" class="text-gray-700 hover:text-blue-600 font-medium">
                        <i class="fas fa-shopping-cart mr-2"></i> Keranjang
                    </a>
                    <a href="{{ route('orders.index') }}" class="text-gray-700 hover:text-blue-600 font-medium">
                        <i class="fas fa-box mr-2"></i> Pesanan Saya
                    </a>
                    <a href="{{ route('profile.index') }}" class="text-gray-700 hover:text-blue-600 font-medium">
                        <i class="fas fa-user mr-2"></i> Profil
                    </a>
                    @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-blue-600 font-medium">
                        <i class="fas fa-cog mr-2"></i> Admin Panel
                    </a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left text-red-600 hover:text-red-800 font-medium">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('google.login') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 font-medium text-center">
                        <i class="fab fa-google mr-2"></i> Login dengan Google
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<script>
document.getElementById('mobile-menu-button').addEventListener('click', function() {
    const menu = document.getElementById('mobile-menu');
    menu.classList.toggle('hidden');
});

// Function to add product to cart
function addToCart(event, productId, productName) {
    event.preventDefault();

    const form = event.target.closest('form');
    const button = event.target.closest('button');

    // Save original content
    const originalHTML = button.innerHTML;

    // Show loading
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    button.disabled = true;

    // Submit via AJAX
    fetch(form.action, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ quantity: 1 })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success || data.message || data.redirect) {
            // Show success
            button.innerHTML = '<i class="fas fa-check text-green-600"></i>';

            // Update cart count
            updateCartCount();

            // Revert button after 1.5s
            setTimeout(() => {
                button.innerHTML = originalHTML;
                button.disabled = false;
            }, 1500);

            // Show toast notification
            showToast('success', `"${productName}" ditambahkan ke keranjang`);
        } else {
            throw new Error('Failed to add to cart');
        }
    })
    .catch(error => {
        button.innerHTML = originalHTML;
        button.disabled = false;
        showToast('error', 'Gagal menambahkan ke keranjang');
    });

    return false;
}

// Update cart count
function updateCartCount() {
    fetch('{{ route("cart.count") }}')
        .then(response => response.json())
        .then(data => {
            const cartCount = document.getElementById('cart-count');
            if (cartCount) {
                cartCount.textContent = data.count;
                cartCount.classList.toggle('hidden', data.count === 0);
            }
        });
}

// Toast notification
function showToast(type, message) {
    // Create toast element
    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 z-50 px-4 py-3 rounded-lg shadow-lg ${
        type === 'success' ? 'bg-green-50 border border-green-200 text-green-800' :
        'bg-red-50 border border-red-200 text-red-800'
    }`;
    toast.innerHTML = `
        <div class="flex items-center">
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} mr-3"></i>
            <span>${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-4">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;

    document.body.appendChild(toast);

    // Remove after 3 seconds
    setTimeout(() => {
        if (toast.parentNode) {
            toast.remove();
        }
    }, 3000);
}

// Initialize cart count on page load
document.addEventListener('DOMContentLoaded', function() {
    updateCartCount();
});
</script>
