<nav class="bg-gradient-to-r from-blue-900 via-blue-800 to-blue-900 shadow-2xl sticky top-0 z-50 border-b border-blue-700">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">
            <!-- Logo -->
            <a href="<?php echo e(route('home')); ?>" class="flex items-center group">
                <img src="<?php echo e(asset('img/LOGO.png')); ?>" 
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
                <a href="<?php echo e(route('home')); ?>" class="text-white hover:text-yellow-400 font-medium transition-colors duration-300 <?php echo e(request()->routeIs('home') ? 'text-yellow-400' : ''); ?>">
                    Beranda
                </a>
                <a href="<?php echo e(route('products.index')); ?>" class="text-white hover:text-yellow-400 font-medium transition-colors duration-300 <?php echo e(request()->routeIs('products.*') ? 'text-yellow-400' : ''); ?>">
                    Produk
                </a>
                
               <!-- ONLINE STORES DROPDOWN -->
                <div class="relative dropdown-container" data-dropdown-id="stores">
                    <button class="dropdown-toggle text-white hover:text-yellow-400 font-medium transition-colors duration-300 flex items-center space-x-1">
                        <span>Online Store</span>
                        <i class="fas fa-chevron-down text-xs transition-transform duration-300 dropdown-arrow"></i>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div class="dropdown-menu left-1/2 transform -translate-x-1/2 mt-2 w-72 py-4 border border-gray-100">
                        <!-- Header -->
                        <div class="px-4 pb-3 border-b border-gray-100">
                            <h3 class="font-bold text-gray-900 text-sm">Toko Online Kami</h3>
                            <p class="text-xs text-gray-500 mt-1">Kunjungi store kami di platform berikut:</p>
                        </div>
                        
                        <!-- Store Links -->
                        <div class="px-2 py-2">
                            <!-- Shopee -->
                            <a href="https://shopee.co.id/ciptaimaji" 
                               target="_blank"
                               class="flex items-center px-4 py-3 rounded-xl hover:bg-orange-50 transition-all duration-200 group/store">
                                <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center shadow-sm">
                                    <i class="fab fa-shopify text-white text-lg"></i>
                                </div>
                                <div class="ml-3 flex-1">
                                    <span class="font-semibold text-gray-900 text-sm">Shopee Store</span>
                                    <p class="text-xs text-gray-500 mt-0.5">Beli produk di Shopee</p>
                                </div>
                                <i class="fas fa-external-link-alt text-gray-400 text-sm group-hover/store:text-orange-500 transition-colors"></i>
                            </a>
                            
                            <!-- Tokopedia -->
                            <a href="https://tokopedia.com/ciptaimaji" 
                               target="_blank"
                               class="flex items-center px-4 py-3 rounded-xl hover:bg-green-50 transition-all duration-200 group/store mt-1">
                                <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-sm">
                                    <i class="fas fa-store text-white text-lg"></i>
                                </div>
                                <div class="ml-3 flex-1">
                                    <span class="font-semibold text-gray-900 text-sm">Tokopedia</span>
                                    <p class="text-xs text-gray-500 mt-0.5">Beli produk di Tokopedia</p>
                                </div>
                                <i class="fas fa-external-link-alt text-gray-400 text-sm group-hover/store:text-green-500 transition-colors"></i>
                            </a>
                            
                            <!-- Instagram -->
                            <a href="https://instagram.com/ciptaimaji" 
                               target="_blank"
                               class="flex items-center px-4 py-3 rounded-xl hover:bg-pink-50 transition-all duration-200 group/store mt-1">
                                <div class="w-10 h-10 bg-gradient-to-br from-pink-500 to-purple-600 rounded-xl flex items-center justify-center shadow-sm">
                                    <i class="fab fa-instagram text-white text-lg"></i>
                                </div>
                                <div class="ml-3 flex-1">
                                    <span class="font-semibold text-gray-900 text-sm">Instagram</span>
                                    <p class="text-xs text-gray-500 mt-0.5">Follow & DM untuk order</p>
                                </div>
                                <i class="fas fa-external-link-alt text-gray-400 text-sm group-hover/store:text-pink-500 transition-colors"></i>
                            </a>
                            
                            <!-- Bukalapak -->
                            <a href="https://bukalapak.com/ciptaimaji" 
                               target="_blank"
                               class="flex items-center px-4 py-3 rounded-xl hover:bg-blue-50 transition-all duration-200 group/store mt-1">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-sm">
                                    <i class="fas fa-shopping-bag text-white text-lg"></i>
                                </div>
                                <div class="ml-3 flex-1">
                                    <span class="font-semibold text-gray-900 text-sm">Bukalapak</span>
                                    <p class="text-xs text-gray-500 mt-0.5">Beli produk di Bukalapak</p>
                                </div>
                                <i class="fas fa-external-link-alt text-gray-400 text-sm group-hover/store:text-blue-500 transition-colors"></i>
                            </a>
                            
                            <!-- Lazada -->
                            <a href="https://lazada.co.id/ciptaimaji" 
                               target="_blank"
                               class="flex items-center px-4 py-3 rounded-xl hover:bg-red-50 transition-all duration-200 group/store mt-1">
                                <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-orange-500 rounded-xl flex items-center justify-center shadow-sm">
                                    <i class="fab fa-laravel text-white text-lg"></i>
                                </div>
                                <div class="ml-3 flex-1">
                                    <span class="font-semibold text-gray-900 text-sm">Lazada</span>
                                    <p class="text-xs text-gray-500 mt-0.5">Beli produk di Lazada</p>
                                </div>
                                <i class="fas fa-external-link-alt text-gray-400 text-sm group-hover/store:text-red-500 transition-colors"></i>
                            </a>
                        </div>
                        
                        <!-- Footer -->
                        <div class="px-4 pt-3 border-t border-gray-100">
                            <p class="text-xs text-gray-500 text-center">Klik untuk mengunjungi store</p>
                        </div>
                    </div>
                </div>
                
                <a href="<?php echo e(route('whatsapp.chat')); ?>" target="_blank" class="text-white hover:text-yellow-400 font-medium transition-colors duration-300">
                    <i class="fab fa-whatsapp mr-1"></i> Chat
                </a>
                <a href="<?php echo e(route('about')); ?>" 
                   class="text-white hover:text-yellow-400 font-medium transition-colors duration-300 
                <?php echo e(request()->routeIs('about') ? 'text-yellow-400' : ''); ?>">
                    About Us
                </a>

                <?php if(auth()->guard()->check()): ?>
                    <div class="flex items-center space-x-4">
                        <!-- Cart Icon -->
                        <a href="<?php echo e(route('cart.index')); ?>" class="relative group">
                            <div class="w-10 h-10 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center transition-all duration-300">
                                <i class="fas fa-shopping-cart text-xl text-white group-hover:text-yellow-400"></i>
                            </div>
                            <?php
                                $cartCount = auth()->user()->cart_items_count;
                            ?>
                            <?php if($cartCount > 0): ?>
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center cart-counter animate-pulse">
                                    <?php echo e($cartCount); ?>

                                </span>
                            <?php else: ?>
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center cart-counter hidden">
                                    0
                                </span>
                            <?php endif; ?>
                        </a>

                        <!-- USER PROFILE DROPDOWN -->
                        <div class="relative dropdown-container" data-dropdown-id="profile">
                            <button class="dropdown-toggle flex items-center space-x-2 bg-white/10 hover:bg-white/20 px-4 py-2 rounded-full transition-all duration-300">
                                <?php if(auth()->user()->avatar): ?>
                                    <img src="<?php echo e(auth()->user()->avatar); ?>" alt="Avatar" class="w-8 h-8 rounded-full border-2 border-yellow-400">
                                <?php else: ?>
                                    <div class="w-8 h-8 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center text-blue-900 font-bold">
                                        <?php echo e(substr(auth()->user()->name, 0, 1)); ?>

                                    </div>
                                <?php endif; ?>
                                <span class="text-white font-medium"><?php echo e(Str::limit(auth()->user()->name, 15)); ?></span>
                                <i class="fas fa-chevron-down text-white text-sm dropdown-arrow"></i>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div class="dropdown-menu right-0 mt-2 w-56 py-2">
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm font-bold text-gray-900"><?php echo e(auth()->user()->name); ?></p>
                                    <p class="text-xs text-gray-500"><?php echo e(auth()->user()->email); ?></p>
                                </div>
                                
                                <div>
                                    <a href="<?php echo e(route('orders.index')); ?>" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 transition-colors duration-200">
                                        <i class="fas fa-box text-blue-600 w-5"></i>
                                        <span class="ml-3">Pesanan Saya</span>
                                    </a>
                                    
                                    <a href="<?php echo e(route('profile.index')); ?>" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 transition-colors duration-200">
                                        <i class="fas fa-user text-blue-600 w-5"></i>
                                        <span class="ml-3">Profil</span>
                                    </a>
                                    
                                    <?php if(auth()->user()->isAdmin()): ?>
                                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center px-4 py-3 text-gray-700 hover:bg-purple-50 border-t border-gray-100 transition-colors duration-200">
                                        <i class="fas fa-cog text-purple-600 w-5"></i>
                                        <span class="ml-3">Admin Panel</span>
                                    </a>
                                    <?php endif; ?>
                                    
                                    <form method="POST" action="<?php echo e(route('logout')); ?>" class="border-t border-gray-100">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="flex items-center w-full px-4 py-3 text-red-600 hover:bg-red-50 transition-colors duration-200">
                                            <i class="fas fa-sign-out-alt w-5"></i>
                                            <span class="ml-3">Logout</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="<?php echo e(route('google.login')); ?>" class="bg-yellow-400 hover:bg-yellow-300 text-blue-900 px-6 py-2.5 rounded-full font-bold transition-all duration-300 shadow-lg hover:shadow-xl flex items-center space-x-2">
                        <i class="fab fa-google"></i>
                        <span>Login</span>
                    </a>
                <?php endif; ?>
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
                <a href="<?php echo e(route('home')); ?>" class="text-white hover:bg-white/10 px-4 py-3 rounded-lg font-medium transition-all duration-300 <?php echo e(request()->routeIs('home') ? 'bg-white/10 text-yellow-400' : ''); ?>">
                    <i class="fas fa-home mr-3"></i> Beranda
                </a>
                <a href="<?php echo e(route('products.index')); ?>" class="text-white hover:bg-white/10 px-4 py-3 rounded-lg font-medium transition-all duration-300 <?php echo e(request()->routeIs('products.*') ? 'bg-white/10 text-yellow-400' : ''); ?>">
                    <i class="fas fa-box mr-3"></i> Produk
                </a>
                
                <!-- Online Stores Mobile -->
                <div class="text-white hover:bg-white/10 px-4 py-3 rounded-lg font-medium transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas fa-store mr-3"></i>
                            <span>Online Store</span>
                        </div>
                        <i class="fas fa-chevron-down transition-transform duration-300" id="mobile-store-arrow"></i>
                    </div>
                    
                    <!-- Mobile Store Links (Hidden by default) -->
                    <div id="mobile-store-links" class="mt-3 pl-8 space-y-2 hidden">
                        <!-- Shopee -->
                        <a href="https://shopee.co.id/ciptaimaji" target="_blank"
                           class="flex items-center py-2 text-white/80 hover:text-yellow-300 transition-colors">
                            <div class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center mr-3">
                                <i class="fab fa-shopify text-white text-sm"></i>
                            </div>
                            <span class="text-sm">Shopee</span>
                        </a>
                        
                        <!-- Tokopedia -->
                        <a href="https://tokopedia.com/ciptaimaji" target="_blank"
                           class="flex items-center py-2 text-white/80 hover:text-yellow-300 transition-colors">
                            <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-store text-white text-sm"></i>
                            </div>
                            <span class="text-sm">Tokopedia</span>
                        </a>
                        
                        <!-- Instagram -->
                        <a href="https://instagram.com/ciptaimaji" target="_blank"
                           class="flex items-center py-2 text-white/80 hover:text-yellow-300 transition-colors">
                            <div class="w-8 h-8 bg-gradient-to-br from-pink-500 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                                <i class="fab fa-instagram text-white text-sm"></i>
                            </div>
                            <span class="text-sm">Instagram</span>
                        </a>
                        
                        <!-- Bukalapak -->
                        <a href="https://bukalapak.com/ciptaimaji" target="_blank"
                           class="flex items-center py-2 text-white/80 hover:text-yellow-300 transition-colors">
                            <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-shopping-bag text-white text-sm"></i>
                            </div>
                            <span class="text-sm">Bukalapak</span>
                        </a>
                        
                        <!-- Lazada -->
                        <a href="https://lazada.co.id/ciptaimaji" target="_blank"
                           class="flex items-center py-2 text-white/80 hover:text-yellow-300 transition-colors">
                            <div class="w-8 h-8 bg-gradient-to-br from-red-500 to-orange-500 rounded-lg flex items-center justify-center mr-3">
                                <i class="fab fa-laravel text-white text-sm"></i>
                            </div>
                            <span class="text-sm">Lazada</span>
                        </a>
                    </div>
                </div>
                
                <a href="<?php echo e(route('about')); ?>" 
                   class="text-white hover:bg-white/10 px-4 py-3 rounded-lg font-medium transition-all duration-300 
                   <?php echo e(request()->routeIs('about') ? 'bg-white/10 text-yellow-400' : ''); ?>">
                    <i class="fas fa-info-circle mr-3"></i> About Us
                </a>
                <a href="<?php echo e(route('whatsapp.chat')); ?>" target="_blank" class="text-white hover:bg-white/10 px-4 py-3 rounded-lg font-medium transition-all duration-300">
                    <i class="fab fa-whatsapp mr-3"></i> Chat WhatsApp
                </a>

                <?php if(auth()->guard()->check()): ?>
                    <div class="border-t border-white/10 pt-2 mt-2">
                        <a href="<?php echo e(route('cart.index')); ?>" class="text-white hover:bg-white/10 px-4 py-3 rounded-lg font-medium transition-all duration-300 flex items-center justify-between">
                            <span><i class="fas fa-shopping-cart mr-3"></i> Keranjang</span>
                            <?php
                                $cartCount = auth()->user()->cart_items_count;
                            ?>
                            <?php if($cartCount > 0): ?>
                                <span class="bg-red-500 text-white text-xs font-bold rounded-full h-6 w-6 flex items-center justify-center">
                                    <?php echo e($cartCount); ?>

                                </span>
                            <?php endif; ?>
                        </a>
                        <a href="<?php echo e(route('orders.index')); ?>" class="text-white hover:bg-white/10 px-4 py-3 rounded-lg font-medium transition-all duration-300">
                            <i class="fas fa-box mr-3"></i> Pesanan Saya
                        </a>
                        <a href="<?php echo e(route('profile.index')); ?>" class="text-white hover:bg-white/10 px-4 py-3 rounded-lg font-medium transition-all duration-300">
                            <i class="fas fa-user mr-3"></i> Profil
                        </a>
                        <?php if(auth()->user()->isAdmin()): ?>
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="text-white hover:bg-white/10 px-4 py-3 rounded-lg font-medium transition-all duration-300">
                            <i class="fas fa-cog mr-3"></i> Admin Panel
                        </a>
                        <?php endif; ?>
                        <form method="POST" action="<?php echo e(route('logout')); ?>" class="mt-2">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="w-full text-left text-red-400 hover:bg-white/10 px-4 py-3 rounded-lg font-medium transition-all duration-300">
                                <i class="fas fa-sign-out-alt mr-3"></i> Logout
                            </button>
                        </form>
                    </div>
                <?php else: ?>
                    <a href="<?php echo e(route('google.login')); ?>" class="bg-yellow-400 hover:bg-yellow-300 text-blue-900 px-6 py-3 rounded-full font-bold transition-all duration-300 text-center shadow-lg mt-4">
                        <i class="fab fa-google mr-2"></i> Login dengan Google
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<style>
/* ================= DROPDOWN STYLES ================= */
.dropdown-container {
    position: relative;
    display: inline-block;
}

.dropdown-menu {
    position: absolute;
    top: calc(100% + 8px);
    background: white;
    border-radius: 16px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px) scale(0.95);
    transform-origin: top center;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    pointer-events: none;
    z-index: 1000;
    border: 1px solid #f3f4f6;
    overflow: hidden;
    /* FORCE HIDDEN ON LOAD */
    display: none;
}

.dropdown-menu.show {
    opacity: 1;
    visibility: visible;
    transform: translateY(0) scale(1);
    pointer-events: auto;
    display: block;
}

.dropdown-arrow {
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.dropdown-container:hover .dropdown-arrow,
.dropdown-menu.show + .dropdown-toggle .dropdown-arrow {
    transform: rotate(180deg);
}

/* Mobile dropdown */
#mobile-store-links {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease-out;
}

#mobile-store-links.expanded {
    max-height: 500px;
    transition: max-height 0.5s ease-in;
}

/* ================= ANIMATIONS ================= */
.rotate-180 {
    transform: rotate(180deg);
}

/* ================= CART COUNTER ================= */
.cart-counter {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}

/* ================= NOTIFICATION STYLES ================= */
.notification-container {
    position: fixed;
    top: 24px;
    right: 24px;
    z-index: 9999;
    display: flex;
    flex-direction: column;
    gap: 12px;
    max-width: 380px;
    pointer-events: none;
}

.notification {
    background: white;
    border-radius: 16px;
    padding: 18px;
    display: flex;
    align-items: flex-start;
    gap: 14px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
    border: 1px solid #e5e7eb;
    transform: translateX(400px);
    transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    pointer-events: auto;
    position: relative;
    overflow: hidden;
}

.notification.show {
    transform: translateX(0);
}

.notification.hide {
    transform: translateX(400px);
}
</style>

<script>
/* ================= DROPDOWN MANAGEMENT ================= */
class DropdownManager {
    constructor() {
        this.dropdowns = new Map();
        this.hideTimeouts = new Map();
        this.HIDE_DELAY = 200;
        this.init();
    }

    init() {
        // Close all dropdowns first
        this.closeAllDropdowns();
        
        // Initialize dropdowns
        document.querySelectorAll('.dropdown-container').forEach(container => {
            const dropdown = container.querySelector('.dropdown-menu');
            const toggle = container.querySelector('.dropdown-toggle');
            const arrow = container.querySelector('.dropdown-arrow');
            
            if (dropdown && toggle) {
                const id = container.dataset.dropdownId || `dropdown-${this.dropdowns.size}`;
                this.dropdowns.set(id, { container, dropdown, toggle, arrow });
                
                // Setup event listeners
                this.setupDropdownEvents(container, dropdown, toggle, arrow);
            }
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', (e) => this.handleClickOutside(e));
        
        // Close dropdowns on ESC key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') this.closeAllDropdowns();
        });
        
        // Close dropdowns on window resize
        window.addEventListener('resize', () => this.closeAllDropdowns());
    }

    setupDropdownEvents(container, dropdown, toggle, arrow) {
        let hideTimeout;

        // Show dropdown on hover
        container.addEventListener('mouseenter', () => {
            clearTimeout(hideTimeout);
            this.showDropdown(dropdown, arrow);
        });

        // Hide dropdown with delay on leave
        container.addEventListener('mouseleave', () => {
            hideTimeout = setTimeout(() => {
                this.hideDropdown(dropdown, arrow);
            }, this.HIDE_DELAY);
        });

        // Keep dropdown open when hovering over it
        dropdown.addEventListener('mouseenter', () => {
            clearTimeout(hideTimeout);
            this.showDropdown(dropdown, arrow);
        });

        // Hide dropdown when leaving dropdown area
        dropdown.addEventListener('mouseleave', () => {
            hideTimeout = setTimeout(() => {
                this.hideDropdown(dropdown, arrow);
            }, this.HIDE_DELAY / 2);
        });

        // Store timeout reference
        this.hideTimeouts.set(dropdown, hideTimeout);
    }

    showDropdown(dropdown, arrow) {
        if (dropdown && !dropdown.classList.contains('show')) {
            dropdown.classList.add('show');
            if (arrow) arrow.classList.add('rotate-180');
            
            // Close other dropdowns
            this.closeOtherDropdowns(dropdown);
        }
    }

    hideDropdown(dropdown, arrow) {
        if (dropdown && dropdown.classList.contains('show')) {
            dropdown.classList.remove('show');
            if (arrow) arrow.classList.remove('rotate-180');
        }
    }

    closeOtherDropdowns(currentDropdown) {
        this.dropdowns.forEach(({ dropdown, arrow }) => {
            if (dropdown !== currentDropdown && dropdown.classList.contains('show')) {
                this.hideDropdown(dropdown, arrow);
            }
        });
    }

    closeAllDropdowns() {
        this.dropdowns.forEach(({ dropdown, arrow }) => {
            this.hideDropdown(dropdown, arrow);
        });
    }

    handleClickOutside(e) {
        let isDropdown = false;
        
        this.dropdowns.forEach(({ container, dropdown }) => {
            if (container.contains(e.target) || dropdown.contains(e.target)) {
                isDropdown = true;
            }
        });

        if (!isDropdown) {
            this.closeAllDropdowns();
        }
    }
}

/* ================= MOBILE MENU ================= */
function setupMobileMenu() {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function () {
            const icon = this.querySelector('i');
            mobileMenu.classList.toggle('hidden');
            icon.classList.toggle('fa-bars');
            icon.classList.toggle('fa-times');
        });
    }

    // Mobile store links toggle
    const mobileStoreLinks = document.getElementById('mobile-store-links');
    const mobileStoreArrow = document.getElementById('mobile-store-arrow');
    
    if (mobileStoreLinks && mobileStoreArrow) {
        const storeContainer = mobileStoreLinks.closest('div');
        storeContainer.addEventListener('click', function(e) {
            if (!e.target.closest('a')) {
                mobileStoreLinks.classList.toggle('expanded');
                mobileStoreArrow.classList.toggle('rotate-180');
            }
        });
    }
}

/* ================= CART SYSTEM ================= */
class CartSystem {
    constructor() {
        this.init();
    }

    async addToCart(event, productId, productName) {
        event.preventDefault();

        const form = event.target.closest('form');
        const button = event.target.closest('button');
        const originalHTML = button.innerHTML;

        // Show loading
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        button.disabled = true;

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();
            
            if (data.success) {
                // Show success state
                button.innerHTML = '<i class="fas fa-check text-green-600"></i>';
                
                // Update cart count
                this.updateCartCount();
                
                // Reset button after 1.5 seconds
                setTimeout(() => {
                    button.disabled = false;
                    button.innerHTML = originalHTML;
                }, 1500);
            } else {
                throw new Error(data.message || 'Gagal menambahkan ke keranjang');
            }
        } catch (error) {
            console.error('Cart error:', error);
            
            // Reset button
            button.disabled = false;
            button.innerHTML = originalHTML;
        }
    }

    async updateCartCount() {
        try {
            const response = await fetch('<?php echo e(route("cart.count")); ?>');
            const data = await response.json();
            
            document.querySelectorAll('.cart-counter').forEach(counter => {
                counter.textContent = data.count;
                counter.classList.toggle('hidden', data.count === 0);
            });
        } catch (error) {
            console.error('Error updating cart count:', error);
        }
    }

    init() {
        // Add to cart forms
        document.addEventListener('submit', (e) => {
            const form = e.target;
            if (form.matches('.add-to-cart-form')) {
                e.preventDefault();
                const productId = form.querySelector('[data-product-id]')?.value;
                const productName = form.querySelector('[data-product-name]')?.value;
                this.addToCart(e, productId, productName);
            }
        });

        // Initial cart count
        document.addEventListener('DOMContentLoaded', () => {
            this.updateCartCount();
        });
    }
}

/* ================= LIVE SEARCH SYSTEM ================= */
class LiveSearch {
    constructor() {
        this.timeout = null;
        this.config = {
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
        this.init();
    }

    init() {
        // Setup desktop search
        const desktopInput = document.getElementById(this.config.desktop.input);
        if (desktopInput) {
            desktopInput.addEventListener('input', (e) => {
                this.performSearch(e.target.value, 'desktop');
            });
        }

        // Setup mobile search
        const mobileInput = document.getElementById(this.config.mobile.input);
        if (mobileInput) {
            mobileInput.addEventListener('input', (e) => {
                this.performSearch(e.target.value, 'mobile');
            });
        }

        // Close search results when clicking outside
        document.addEventListener('click', (e) => {
            const desktopContainer = document.getElementById('navbarSearchContainer');
            const mobileContainer = document.getElementById('mobileSearchContainer');
            
            if (desktopContainer && !desktopContainer.contains(e.target)) {
                this.hideResults('desktop');
            }
            
            if (mobileContainer && !mobileContainer.contains(e.target)) {
                this.hideResults('mobile');
            }
        });
    }

    performSearch(query, mode) {
        if (query.length < 2) {
            this.hideResults(mode);
            return;
        }

        this.showLoading(mode);
        clearTimeout(this.timeout);

        this.timeout = setTimeout(async () => {
            try {
                const response = await fetch('<?php echo e(route("products.live-search")); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                    },
                    body: JSON.stringify({ search: query, per_page: 5 })
                });

                const data = await response.json();
                this.renderResults(data, mode);
            } catch (error) {
                console.error('Search error:', error);
                this.hideResults(mode);
            }
        }, 300);
    }

    renderResults(data, mode) {
        const cfg = this.config[mode];
        const list = document.getElementById(cfg.list);
        const container = document.getElementById(cfg.results);
        const empty = document.getElementById(cfg.empty);
        const loading = document.getElementById(cfg.loading);

        if (loading) loading.classList.add('hidden');

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
            empty?.classList.remove('hidden');
            container?.classList.remove('hidden');
            return;
        }

        empty?.classList.add('hidden');
        list.innerHTML = products.map(p => `
            <a href="/products/${p.id}"
               class="flex gap-4 px-4 py-3 hover:bg-[#f9f0f1] transition border-b border-[#191f01]/10">
                <div class="w-14 h-14 bg-white rounded-lg flex items-center justify-center border overflow-hidden">
                    <img src="${p.image}" class="max-w-full max-h-full object-contain">
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-[#191f01] truncate">${p.name}</p>
                    <p class="text-sm font-bold text-[#193497]">${p.price}</p>
                </div>
                <i class="fas fa-chevron-right text-[#191f01]/40 self-center"></i>
            </a>
        `).join('');

        container?.classList.remove('hidden');
    }

    showLoading(mode) {
        const cfg = this.config[mode];
        const container = document.getElementById(cfg.results);
        const loading = document.getElementById(cfg.loading);
        const list = document.getElementById(cfg.list);
        const empty = document.getElementById(cfg.empty);

        if (container) container.classList.remove('hidden');
        if (loading) loading.classList.remove('hidden');
        if (list) list.innerHTML = '';
        if (empty) empty.classList.add('hidden');
    }

    hideResults(mode) {
        const container = document.getElementById(this.config[mode].results);
        if (container) container.classList.add('hidden');
    }
}

/* ================= INITIALIZE EVERYTHING ================= */
document.addEventListener('DOMContentLoaded', function() {
    // Initialize dropdown manager
    window.dropdownManager = new DropdownManager();
    
    // Initialize cart system
    window.cartSystem = new CartSystem();
    
    // Initialize live search
    window.liveSearch = new LiveSearch();
    
    // Setup mobile menu
    setupMobileMenu();
    
    // Force close all dropdowns on load (just in case)
    setTimeout(() => {
        if (window.dropdownManager) {
            window.dropdownManager.closeAllDropdowns();
        }
    }, 100);
    
    // Close dropdowns when clicking on a link inside dropdown
    document.querySelectorAll('.dropdown-menu a').forEach(link => {
        link.addEventListener('click', () => {
            if (window.dropdownManager) {
                window.dropdownManager.closeAllDropdowns();
            }
        });
    });
});

// Close dropdowns on page unload
window.addEventListener('beforeunload', function() {
    if (window.dropdownManager) {
        window.dropdownManager.closeAllDropdowns();
    }
});

// Close dropdowns when navigating (for SPA/Turbo links)
document.addEventListener('turbolinks:before-visit', function() {
    if (window.dropdownManager) {
        window.dropdownManager.closeAllDropdowns();
    }
});
</script><?php /**PATH C:\laragon\www\revisiimaji\resources\views/layouts/navbar.blade.php ENDPATH**/ ?>