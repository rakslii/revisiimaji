@php
    // LOAD ONLINE STORES DARI DATABASE
    try {
        $stores = \App\Models\OnlineStore::active()->ordered()->get();
    } catch (\Exception $e) {
        \Log::error('Failed to load online stores: ' . $e->getMessage());
        $stores = collect();
    }
@endphp

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
                <div class="w-full relative" id="navbarSearchContainer">
                    <input type="text" 
                           id="navbarSearchInput"
                           placeholder="Cari produk, kategori, atau layanan..."
                           autocomplete="off"
                           class="w-full px-6 py-3 pr-12 rounded-full 
                    bg-[#193497]/40 backdrop-blur-sm 
                    border border-[#d2f801]/40 
                    text-white placeholder-white/70 
                    focus:outline-none focus:bg-[#193497]/60 
                    focus:border-[#d2f801] 
                    transition-all duration-300">
                    <button id="navbarSearchButton" class="absolute right-2 top-1/2 transform -translate-y-1/2 
                    w-10 h-10 bg-[#d2f801] hover:bg-yellow-300 
                    rounded-full flex items-center justify-center 
                    transition-colors duration-300 shadow-lg">
                        <i class="fas fa-search text-[#193497]"></i>
                    </button>
                    
                    <!-- Search Results Dropdown -->
                    <div id="navbarSearchResults" class="absolute top-full left-0 right-0 mt-2 bg-white rounded-2xl shadow-2xl max-h-[500px] overflow-y-auto hidden z-50">
                        <!-- Loading State -->
                        <div id="searchLoading" class="hidden p-4 text-center">
                            <i class="fas fa-spinner fa-spin text-blue-600 text-2xl"></i>
                            <p class="text-gray-600 mt-2">Mencari...</p>
                        </div>
                        
                        <!-- Results akan diisi via JavaScript -->
                        <div id="searchResultsList"></div>
                        
                        <!-- No Results -->
                        <div id="searchNoResults" class="hidden p-8 text-center">
                            <i class="fas fa-search text-gray-300 text-4xl mb-3"></i>
                            <p class="text-gray-600 font-semibold">Produk tidak ditemukan</p>
                            <p class="text-gray-400 text-sm">Coba kata kunci lain</p>
                        </div>
                    </div>
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
                
               <!-- ONLINE STORES DROPDOWN - DATA DARI DATABASE -->
                @if($stores->count() > 0)
                <div class="relative dropdown-container" 
                     onmouseenter="showDropdown('stores')" 
                     onmouseleave="hideDropdownWithDelay('stores')">
                    <button class="text-white hover:text-yellow-400 font-medium transition-colors duration-300 flex items-center space-x-1 focus:outline-none">
                        <span>Online Store</span>
                        <i class="fas fa-chevron-down text-xs transition-transform duration-300" id="stores-arrow"></i>
                    </button>
                    
                    <!-- Transparent gap -->
                    <div class="dropdown-gap"></div>
                    
                    <!-- Dropdown Menu - DATA DARI DATABASE -->
                    <div id="stores-dropdown" class="dropdown-menu left-1/2 transform -translate-x-1/2 mt-2 w-72 py-4 border border-gray-100" 
                         style="display: none; opacity: 0; visibility: hidden;">
                        <!-- Header -->
                        <div class="px-4 pb-3 border-b border-gray-100">
                            <h3 class="font-bold text-gray-900 text-sm">Toko Online Kami</h3>
                            <p class="text-xs text-gray-500 mt-1">Kunjungi store kami di platform berikut:</p>
                        </div>
                        
                        <!-- Store Links - LOOP DARI DATABASE -->
                        <div class="px-2 py-2" onmouseenter="keepDropdownOpen('stores')" onmouseleave="hideDropdownWithDelay('stores')">
                            @foreach($stores as $store)
                            <a href="{{ $store->url }}" 
                               target="_blank"
                               class="flex items-center px-4 py-3 rounded-xl hover:bg-gray-50 transition-all duration-200 group/store mt-1 first:mt-0">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center shadow-sm" 
                                     style="background: linear-gradient(135deg, {{ $store->gradient_from }}, {{ $store->gradient_to }});">
                                    <i class="{{ $store->icon_class }} text-white text-lg"></i>
                                </div>
                                <div class="ml-3 flex-1">
                                    <span class="font-semibold text-gray-900 text-sm">{{ $store->name }}</span>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ $store->description }}</p>
                                </div>
                                <i class="fas fa-external-link-alt text-gray-400 text-sm group-hover/store:text-[{{ str_replace('#', '', $store->color) }}] transition-colors"></i>
                            </a>
                            @endforeach
                        </div>
                        
                        <!-- Footer -->
                        <div class="px-4 pt-3 border-t border-gray-100">
                            <p class="text-xs text-gray-500 text-center">Klik untuk mengunjungi store</p>
                        </div>
                    </div>
                </div>
                @endif
                
                <a href="{{ route('whatsapp.chat') }}" target="_blank" class="text-white hover:text-yellow-400 font-medium transition-colors duration-300">
                    <i class="fab fa-whatsapp mr-1"></i> Chat
                </a>
                <a href="{{ route('about') }}" 
                   class="text-white hover:text-yellow-400 font-medium transition-colors duration-300 
                {{ request()->routeIs('about') ? 'text-yellow-400' : '' }}">
                    About Us
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

                        <!-- USER PROFILE DROPDOWN -->
                        <div class="relative dropdown-container" 
                             onmouseenter="showDropdown('profile')" 
                             onmouseleave="hideDropdownWithDelay('profile')">
                            <button class="flex items-center space-x-2 bg-white/10 hover:bg-white/20 px-4 py-2 rounded-full transition-all duration-300 focus:outline-none">
                                @if(auth()->user()->avatar)
                                    <img src="{{ auth()->user()->avatar }}" alt="Avatar" class="w-8 h-8 rounded-full border-2 border-yellow-400">
                                @else
                                    <div class="w-8 h-8 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center text-blue-900 font-bold">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                @endif
                                <span class="text-white font-medium">{{ Str::limit(auth()->user()->name, 15) }}</span>
                                <i class="fas fa-chevron-down text-white text-sm" id="profile-arrow"></i>
                            </button>
                            
                            <!-- Transparent gap -->
                            <div class="dropdown-gap"></div>
                            
                            <!-- Dropdown Menu -->
                            <div id="profile-dropdown" class="dropdown-menu right-0 mt-2 w-56 py-2" 
                                 style="display: none; opacity: 0; visibility: hidden;">
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm font-bold text-gray-900">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                                </div>
                                
                                <div onmouseenter="keepDropdownOpen('profile')" onmouseleave="hideDropdownWithDelay('profile')">
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
            <div class="relative" id="mobileSearchContainer">
                <input type="text" 
                       id="mobileSearchInput"
                       placeholder="Cari produk..."
                       autocomplete="off"
                       class="w-full px-4 py-2 pr-10 rounded-full 
                bg-[#193497]/40 backdrop-blur-sm 
                border border-[#d2f801]/40 
                text-white placeholder-white/70 
                focus:outline-none focus:bg-[#193497]/60 
                focus:border-[#d2f801] 
                transition-all duration-300">
                <button id="mobileSearchButton" class="absolute right-1 top-1/2 transform -translate-y-1/2 
                w-8 h-8 bg-[#d2f801] hover:bg-yellow-300 
                rounded-full flex items-center justify-center 
                transition-colors duration-300">
                    <i class="fas fa-search text-[#193497] text-sm"></i>
                </button>
                
                <!-- Mobile Search Results Dropdown -->
                <div id="mobileSearchResults" class="absolute top-full left-0 right-0 mt-2 bg-white rounded-2xl shadow-2xl max-h-[400px] overflow-y-auto hidden z-50">
                    <div id="mobileSearchLoading" class="hidden p-4 text-center">
                        <i class="fas fa-spinner fa-spin text-blue-600 text-xl"></i>
                        <p class="text-gray-600 text-sm mt-2">Mencari...</p>
                    </div>
                    <div id="mobileSearchResultsList"></div>
                    <div id="mobileSearchNoResults" class="hidden p-6 text-center">
                        <i class="fas fa-search text-gray-300 text-3xl mb-2"></i>
                        <p class="text-gray-600 text-sm">Produk tidak ditemukan</p>
                    </div>
                </div>
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
                
                <!-- Online Stores Mobile - DATA DARI DATABASE -->
                @if($stores->count() > 0)
                <div class="text-white hover:bg-white/10 px-4 py-3 rounded-lg font-medium transition-all duration-300">
                    <div class="flex items-center justify-between" onclick="toggleMobileStores()">
                        <div class="flex items-center">
                            <i class="fas fa-store mr-3"></i>
                            <span>Online Store</span>
                        </div>
                        <i class="fas fa-chevron-down transition-transform duration-300" id="mobile-store-arrow"></i>
                    </div>
                    
                    <!-- Mobile Store Links (Hidden by default) - DATA DARI DATABASE -->
                    <div id="mobile-store-links" class="mt-3 pl-8 space-y-2 hidden">
                        @foreach($stores as $store)
                        <a href="{{ $store->url }}" target="_blank"
                           class="flex items-center py-2 text-white/80 hover:text-yellow-300 transition-colors">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3" 
                                 style="background: linear-gradient(135deg, {{ $store->gradient_from }}, {{ $store->gradient_to }});">
                                <i class="{{ $store->icon_class }} text-white text-sm"></i>
                            </div>
                            <span class="text-sm">{{ $store->name }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <a href="{{ route('about') }}" 
                   class="text-white hover:bg-white/10 px-4 py-3 rounded-lg font-medium transition-all duration-300 
                   {{ request()->routeIs('about') ? 'bg-white/10 text-yellow-400' : '' }}">
                    <i class="fas fa-info-circle mr-3"></i> About Us
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

<!-- Alpine.js for dropdown interactions -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<script>
/* ================= FIX DROPDOWN AUTOMATIC OPEN ================= */
// Pastikan semua dropdown tertutup saat page load
document.addEventListener('DOMContentLoaded', function() {
    // Force hide semua dropdown
    document.querySelectorAll('.dropdown-menu').forEach(dropdown => {
        dropdown.style.display = 'none';
        dropdown.style.opacity = '0';
        dropdown.style.visibility = 'hidden';
    });
    
    // Reset semua arrow
    document.querySelectorAll('[id$="-arrow"]').forEach(arrow => {
        arrow.classList.remove('rotate-180');
    });
});

/* ================= DROPDOWN FUNCTIONS ================= */
function showDropdown(id) {
    const dropdown = document.getElementById(id + '-dropdown');
    const arrow = document.getElementById(id + '-arrow');
    
    if (dropdown && arrow) {
        dropdown.style.display = 'block';
        dropdown.style.opacity = '1';
        dropdown.style.visibility = 'visible';
        arrow.classList.add('rotate-180');
        
        // Tutup dropdown lainnya
        closeOtherDropdowns(id);
    }
}

function hideDropdown(id) {
    const dropdown = document.getElementById(id + '-dropdown');
    const arrow = document.getElementById(id + '-arrow');
    
    if (dropdown && arrow) {
        dropdown.style.opacity = '0';
        dropdown.style.visibility = 'hidden';
        arrow.classList.remove('rotate-180');
        
        // Tunggu transisi selesai baru sembunyikan display
        setTimeout(() => {
            dropdown.style.display = 'none';
        }, 300);
    }
}

function hideDropdownWithDelay(id) {
    setTimeout(() => hideDropdown(id), 200);
}

function keepDropdownOpen(id) {
    // Hanya untuk mencegah auto-hide saat masih di dalam dropdown
}

function closeOtherDropdowns(currentId) {
    ['stores', 'profile'].forEach(id => {
        if (id !== currentId) {
            hideDropdown(id);
        }
    });
}

/* ================= MOBILE MENU ================= */
document.getElementById('mobile-menu-button')?.addEventListener('click', function () {
    const menu = document.getElementById('mobile-menu');
    const icon = this.querySelector('i');

    menu.classList.toggle('hidden');
    icon.classList.toggle('fa-bars');
    icon.classList.toggle('fa-times');
});

function toggleMobileStores() {
    const links = document.getElementById('mobile-store-links');
    const arrow = document.getElementById('mobile-store-arrow');
    
    if (links.classList.contains('hidden')) {
        links.classList.remove('hidden');
        arrow.classList.add('rotate-180');
    } else {
        links.classList.add('hidden');
        arrow.classList.remove('rotate-180');
    }
}

/* ================= ADD TO CART (AJAX) ================= */
function addToCart(event, productId, productName) {
    event.preventDefault();

    const form = event.target.closest('form');
    const button = event.target.closest('button');
    const originalHTML = button.innerHTML;

    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    button.disabled = true;

    fetch(form.action, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ quantity: 1 })
    })
    .then(res => res.json())
    .then(() => {
        button.innerHTML = '<i class="fas fa-check text-green-600"></i>';
        updateCartCount();
        showToast('success', `"${productName}" ditambahkan ke keranjang`);

        setTimeout(() => {
            button.innerHTML = originalHTML;
            button.disabled = false;
        }, 1500);
    })
    .catch(() => {
        button.innerHTML = originalHTML;
        button.disabled = false;
        showToast('error', 'Gagal menambahkan ke keranjang');
    });
}

/* ================= CART COUNT ================= */
function updateCartCount() {
    fetch('{{ route("cart.count") }}')
        .then(res => res.json())
        .then(data => {
            document.querySelectorAll('.cart-counter').forEach(counter => {
                counter.textContent = data.count;
                counter.classList.toggle('hidden', data.count === 0);
            });
        });
}

document.addEventListener('DOMContentLoaded', () => {
    @auth updateCartCount(); @endauth
});

/* ================= TOAST NOTIFICATION ================= */
function showToast(type, message) {
    // Gunakan notification system dari app.blade.php jika ada
    if (window.notificationSystem) {
        window.notificationSystem.show({
            type: type,
            title: type === 'success' ? 'Berhasil Ditambahkan!' : 'Gagal',
            message: message,
            duration: 3000
        });
    } else {
        // Fallback ke toast sederhana
        const toast = document.createElement('div');
        toast.className = `fixed top-20 right-4 z-50 px-6 py-4 rounded-2xl shadow-xl ${
            type === 'success' ? 'bg-green-500' : 'bg-red-500'
        } text-white animate-slideIn`;
        toast.innerHTML = `
            <div class="flex items-center gap-3">
                <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
                <span>${message}</span>
            </div>
        `;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }
}

/* ================= LIVE SEARCH ================= */
let searchTimeout = null;

const searchConfig = {
    desktop: {
        input: 'navbarSearchInput',
        results: 'navbarSearchResults',
        list: 'searchResultsList',
        loading: 'searchLoading',
        empty: 'searchNoResults'
    },
    mobile: {
        input: 'mobileSearchInput',
        results: 'mobileSearchResults',
        list: 'mobileSearchResultsList',
        loading: 'mobileSearchLoading',
        empty: 'mobileSearchNoResults'
    }
};

function performSearch(query, mode) {
    if (query.length < 2) return hideResults(mode);

    showLoading(mode);
    clearTimeout(searchTimeout);

    searchTimeout = setTimeout(() => {
        fetch('{{ route("products.live-search") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ search: query, per_page: 5 })
        })
        .then(res => res.json())
        .then(data => renderResults(data, mode))
        .catch(() => hideResults(mode));
    }, 300);
}

function renderResults(data, mode) {
    const cfg = searchConfig[mode];
    const list = document.getElementById(cfg.list);
    const container = document.getElementById(cfg.results);
    const empty = document.getElementById(cfg.empty);
    document.getElementById(cfg.loading).classList.add('hidden');

    let products = [];
    if (data.html) {
        const doc = new DOMParser().parseFromString(data.html, 'text/html');
        doc.querySelectorAll('[data-product-id]').forEach(card => {
            products.push({
                id: card.dataset.productId,
                name: card.querySelector('[data-product-name]')?.innerText || '',
                price: card.querySelector('[data-product-price]')?.innerText || '',
                image: card.querySelector('img')?.src || ''
            });
        });
    }

    if (!products.length) {
        list.innerHTML = '';
        empty.classList.remove('hidden');
        container.classList.remove('hidden');
        return;
    }

    empty.classList.add('hidden');
    list.innerHTML = products.map(p => `
        <a href="/products/${p.id}"
           class="flex gap-4 px-4 py-3 hover:bg-gray-50 transition border-b border-gray-100">
            <div class="w-14 h-14 bg-white rounded-lg flex items-center justify-center border overflow-hidden">
                <img src="${p.image}" class="max-w-full max-h-full object-contain">
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-semibold text-gray-900 truncate">${p.name}</p>
                <p class="text-sm font-bold text-blue-600">${p.price}</p>
            </div>
            <i class="fas fa-chevron-right text-gray-400 self-center"></i>
        </a>
    `).join('');

    container.classList.remove('hidden');
}

function showLoading(mode) {
    const cfg = searchConfig[mode];
    document.getElementById(cfg.results).classList.remove('hidden');
    document.getElementById(cfg.loading).classList.remove('hidden');
    document.getElementById(cfg.list).innerHTML = '';
    document.getElementById(cfg.empty).classList.add('hidden');
}

function hideResults(mode) {
    document.getElementById(searchConfig[mode].results).classList.add('hidden');
}

/* ================= EVENTS ================= */
['desktop','mobile'].forEach(mode => {
    const input = document.getElementById(searchConfig[mode].input);
    input?.addEventListener('input', e => performSearch(e.target.value, mode));
});

document.addEventListener('click', e => {
    if (!document.getElementById('navbarSearchContainer')?.contains(e.target)) hideResults('desktop');
    if (!document.getElementById('mobileSearchContainer')?.contains(e.target)) hideResults('mobile');
});

// Tutup dropdown saat klik di luar
document.addEventListener('click', function(e) {
    if (!e.target.closest('.dropdown-container') && !e.target.closest('.dropdown-menu')) {
        ['stores', 'profile'].forEach(id => {
            hideDropdown(id);
        });
    }
});
</script>

<style>
/* Custom animations */
@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

.animate-slideIn {
    animation: slideIn 0.3s ease-out;
}

/* Rotate transition */
.rotate-180 {
    transform: rotate(180deg);
    transition: transform 0.3s ease;
}

/* Dropdown Hover Intent Styles */
.dropdown-container {
    position: relative;
}

.dropdown-menu {
    position: absolute;
    top: 100%;
    background: white;
    border-radius: 1rem;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    pointer-events: none;
    z-index: 100;
    /* INI YANG PERBAIKAN - Force hide dulu */
    display: none !important;
}

/* Hanya tampilkan saat di-hover */
.dropdown-container:hover .dropdown-menu {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
    pointer-events: auto;
    display: block !important;
}

/* Add a transparent gap between button and dropdown */
.dropdown-gap {
    position: absolute;
    top: 100%;
    left: 0;
    width: 100%;
    height: 16px;
    background: transparent;
    pointer-events: none;
}

.dropdown-container:hover .dropdown-gap {
    pointer-events: auto;
}

/* Dynamic color classes untuk hover icon */
.text-ff5722 { color: #ff5722 !important; }
.text-43b549 { color: #43b549 !important; }
.text-e1306c { color: #e1306c !important; }
.text-e31f27 { color: #e31f27 !important; }
.text-0f146d { color: #0f146d !important; }
.text-000000 { color: #000000 !important; }
</style>