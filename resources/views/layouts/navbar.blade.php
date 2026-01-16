<nav class="bg-gradient-to-r from-blue-900 via-blue-800 to-blue-900 shadow-2xl sticky top-0 z-50 border-b border-blue-700">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">
<!-- Logo -->
<a href="{{ route('home') }}" class="flex items-center group">
    <img src="{{ asset('img/LOGO.png') }}" 
         alt="Cipta Imaji Logo" 
         class="w-24 h-24 object-contain transform group-hover:scale-110 transition-all duration-300 -my-4 ml-6 mr-5">
    <div>
        <span class="text-xl font-bold text-white">Cipta Imaji</span>
        <div class="text-xs text-blue-200">Digital Printing</div>
    </div>
</a>

            <!-- Center Search Bar (Desktop) -->
            <div class="hidden lg:flex flex-1 max-w-2xl mx-8">
                <div class="w-full relative">
                    <input type="text" 
                           placeholder="Cari produk, kategori, atau layanan..."
                           class="w-full px-6 py-3 pr-12 rounded-full 
bg-[#193497]/40 backdrop-blur-sm 
border border-[#d2f801]/40 
text-white placeholder-white/70 
focus:outline-none focus:bg-[#193497]/60 
focus:border-[#d2f801] 
transition-all duration-300">
                    <button class="absolute right-2 top-1/2 transform -translate-y-1/2 
w-10 h-10 bg-[#d2f801] hover:bg-yellow-300 
rounded-full flex items-center justify-center 
transition-colors duration-300 shadow-lg">
                        <i class="fas fa-search text-[#193497]"></i>
                    </button>
                </div>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-6">
                <a href="{{ route('home') }}" class="text-white hover:text-yellow-400 font-medium transition-colors duration-300 {{ request()->routeIs('home') ? 'text-yellow-400' : '' }}">
                    Beranda
                </a>
                <a href="{{ route('products.index') }}" class="text-white hover:text-yellow-400 font-medium transition-colors duration-300 {{ request()->routeIs('products.*') ? 'text-yellow-400' : '' }}">
                    Produk
                </a>
                <a href="{{ route('whatsapp.chat') }}" target="_blank" class="text-white hover:text-yellow-400 font-medium transition-colors duration-300">
                    <i class="fab fa-whatsapp mr-1"></i> Chat
                </a>

                @auth
                    <div class="flex items-center space-x-4">
                        <!-- Cart Icon -->
                        <a href="{{ route('cart.index') }}" class="relative group">
                            <div class="w-10 h-10 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center transition-all duration-300">
                                <i class="fas fa-shopping-cart text-xl text-white group-hover:text-yellow-400"></i>
                            </div>
                            @php
                                $cartCount = auth()->user()->cart_items_count;
                            @endphp
                            @if($cartCount > 0)
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center cart-counter animate-pulse">
                                    {{ $cartCount }}
                                </span>
                            @else
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center cart-counter hidden">
                                    0
                                </span>
                            @endif
                        </a>

                        <!-- User Dropdown -->
                        <div class="relative group">
                            <button class="flex items-center space-x-2 bg-white/10 hover:bg-white/20 px-4 py-2 rounded-full transition-all duration-300 focus:outline-none">
                                @if(auth()->user()->avatar)
                                    <img src="{{ auth()->user()->avatar }}" alt="Avatar" class="w-8 h-8 rounded-full border-2 border-yellow-400">
                                @else
                                    <div class="w-8 h-8 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center text-blue-900 font-bold">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                @endif
                                <span class="text-white font-medium">{{ Str::limit(auth()->user()->name, 15) }}</span>
                                <i class="fas fa-chevron-down text-white text-sm"></i>
                            </button>

                            <!-- Dropdown Menu -->
                            <div class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-2xl py-2 hidden group-hover:block transform origin-top-right transition-all duration-200">
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm font-bold text-gray-900">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                                </div>
                                
                                <a href="{{ route('orders.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 transition-colors duration-200">
                                    <i class="fas fa-box text-blue-600 w-5"></i>
                                    <span class="ml-3">Pesanan Saya</span>
                                </a>
                                
                                <a href="{{ route('profile.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 transition-colors duration-200">
                                    <i class="fas fa-user text-blue-600 w-5"></i>
                                    <span class="ml-3">Profil</span>
                                </a>
                                
                                @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-purple-50 border-t border-gray-100 transition-colors duration-200">
                                    <i class="fas fa-cog text-purple-600 w-5"></i>
                                    <span class="ml-3">Admin Panel</span>
                                </a>
                                @endif
                                
                                <form method="POST" action="{{ route('logout') }}" class="border-t border-gray-100">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full px-4 py-3 text-red-600 hover:bg-red-50 transition-colors duration-200">
                                        <i class="fas fa-sign-out-alt w-5"></i>
                                        <span class="ml-3">Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('google.login') }}" class="bg-yellow-400 hover:bg-yellow-300 text-blue-900 px-6 py-2.5 rounded-full font-bold transition-all duration-300 shadow-lg hover:shadow-xl flex items-center space-x-2">
                        <i class="fab fa-google"></i>
                        <span>Login</span>
                    </a>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <button id="mobile-menu-button" class="md:hidden text-white p-2 hover:bg-white/10 rounded-lg transition-colors duration-300">
                <i class="fas fa-bars text-2xl"></i>
            </button>
        </div>

        <!-- Mobile Search (visible on mobile) -->
        <div class="lg:hidden pb-4">
            <div class="relative">
                <input type="text" 
                       placeholder="Cari produk..."
                       class="w-full px-4 py-2 pr-10 rounded-full 
bg-[#193497]/40 backdrop-blur-sm 
border border-[#d2f801]/40 
text-white placeholder-white/70 
focus:outline-none focus:bg-[#193497]/60 
focus:border-[#d2f801] 
transition-all duration-300">
                <button class="absolute right-1 top-1/2 transform -translate-y-1/2 
w-8 h-8 bg-[#d2f801] hover:bg-yellow-300 
rounded-full flex items-center justify-center 
transition-colors duration-300">
                    <i class="fas fa-search text-[#193497] text-sm"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden hidden pb-4 border-t border-white/10">
            <div class="flex flex-col space-y-2 pt-4">
                <a href="{{ route('home') }}" class="text-white hover:bg-white/10 px-4 py-3 rounded-lg font-medium transition-all duration-300 {{ request()->routeIs('home') ? 'bg-white/10 text-yellow-400' : '' }}">
                    <i class="fas fa-home mr-3"></i> Beranda
                </a>
                <a href="{{ route('products.index') }}" class="text-white hover:bg-white/10 px-4 py-3 rounded-lg font-medium transition-all duration-300 {{ request()->routeIs('products.*') ? 'bg-white/10 text-yellow-400' : '' }}">
                    <i class="fas fa-box mr-3"></i> Produk
                </a>
                <a href="{{ route('whatsapp.chat') }}" target="_blank" class="text-white hover:bg-white/10 px-4 py-3 rounded-lg font-medium transition-all duration-300">
                    <i class="fab fa-whatsapp mr-3"></i> Chat WhatsApp
                </a>

                @auth
                    <div class="border-t border-white/10 pt-2 mt-2">
                        <a href="{{ route('cart.index') }}" class="text-white hover:bg-white/10 px-4 py-3 rounded-lg font-medium transition-all duration-300 flex items-center justify-between">
                            <span><i class="fas fa-shopping-cart mr-3"></i> Keranjang</span>
                            @php
                                $cartCount = auth()->user()->cart_items_count;
                            @endphp
                            @if($cartCount > 0)
                                <span class="bg-red-500 text-white text-xs font-bold rounded-full h-6 w-6 flex items-center justify-center">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>
                        <a href="{{ route('orders.index') }}" class="text-white hover:bg-white/10 px-4 py-3 rounded-lg font-medium transition-all duration-300">
                            <i class="fas fa-box mr-3"></i> Pesanan Saya
                        </a>
                        <a href="{{ route('profile.index') }}" class="text-white hover:bg-white/10 px-4 py-3 rounded-lg font-medium transition-all duration-300">
                            <i class="fas fa-user mr-3"></i> Profil
                        </a>
                        @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="text-white hover:bg-white/10 px-4 py-3 rounded-lg font-medium transition-all duration-300">
                            <i class="fas fa-cog mr-3"></i> Admin Panel
                        </a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="mt-2">
                            @csrf
                            <button type="submit" class="w-full text-left text-red-400 hover:bg-white/10 px-4 py-3 rounded-lg font-medium transition-all duration-300">
                                <i class="fas fa-sign-out-alt mr-3"></i> Logout
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('google.login') }}" class="bg-yellow-400 hover:bg-yellow-300 text-blue-900 px-6 py-3 rounded-full font-bold transition-all duration-300 text-center shadow-lg mt-4">
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
    
    // Animate icon
    const icon = this.querySelector('i');
    if (menu.classList.contains('hidden')) {
        icon.classList.remove('fa-times');
        icon.classList.add('fa-bars');
    } else {
        icon.classList.remove('fa-bars');
        icon.classList.add('fa-times');
    }
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
            const cartCounters = document.querySelectorAll('.cart-counter');
            cartCounters.forEach(counter => {
                counter.textContent = data.count;
                counter.classList.toggle('hidden', data.count === 0);
            });
        });
}

// Toast notification
function showToast(type, message) {
    // Create toast element
    const toast = document.createElement('div');
    toast.className = `fixed top-20 right-4 z-50 px-6 py-4 rounded-2xl shadow-2xl transform transition-all duration-300 ${
        type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
    }`;
    toast.style.animation = 'slideInRight 0.3s ease-out';
    toast.innerHTML = `
        <div class="flex items-center space-x-3">
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} text-2xl"></i>
            <span class="font-medium">${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 hover:bg-white/20 rounded-full p-1 transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;

    document.body.appendChild(toast);

    // Remove after 3 seconds
    setTimeout(() => {
        toast.style.animation = 'slideOutRight 0.3s ease-in';
        setTimeout(() => {
            if (toast.parentNode) {
                toast.remove();
            }
        }, 300);
    }, 3000);
}

// Initialize cart count on page load
document.addEventListener('DOMContentLoaded', function() {
    @auth
    updateCartCount();
    @endauth
});

// Add animation keyframes
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);
</script>