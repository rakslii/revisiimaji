

<?php $__env->startSection('title', 'Produk Digital Printing - Cipta Imaji'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-gradient-to-b from-gray-50 to-white min-h-screen">
    <!-- Hero Section -->
    <div class="relative bg-[#193497] text-white overflow-hidden">
        <!-- Decorative Elements -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-[#d2f801] rounded-full opacity-10 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-[#7209b7] rounded-full opacity-10 blur-3xl"></div>

        <div class="container mx-auto px-4 py-12 md:py-16 relative z-10">
            <div class="max-w-4xl">
                <h1 class="text-4xl md:text-6xl font-bold mb-4 leading-tight">
                    Katalog <span class="text-[#d2f801]">Produk</span>
                </h1>
                <p class="text-xl md:text-2xl opacity-90 mb-8">
                    Temukan solusi printing terbaik untuk kebutuhan bisnis dan personal Anda
                </p>

                <!-- Search Box -->
                <div class="max-w-3xl">
                    <div class="relative">
                        <input type="text"
                               id="liveSearchInput"
                               name="search"
                               value="<?php echo e(request('search')); ?>"
                               placeholder="Cari produk: brosur, banner, kartu nama..."
                               class="w-full px-6 py-5 pr-16 rounded-2xl bg-[#f9f0f1] text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-yellow-400/50 shadow-2xl text-lg">
                        <button type="button" id="searchButton" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-[#d2f801] hover:bg-yellow-300 text-blue-900 p-4 rounded-xl transition-colors shadow-lg">
                            <i class="fas fa-search text-xl"></i>
                        </button>
                    </div>
                    <div id="searchResultsInfo" class="text-white mt-2 text-sm hidden">
                        <i class="fas fa-spinner fa-spin mr-2"></i>
                        <span>Mencari...</span>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="grid grid-cols-3 gap-6 mt-8">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-[#d2f801]"><?php echo e($products->total()); ?>+</div>
                        <div class="text-sm text-[#f9f0f1]/70">Produk Tersedia</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-[#d2f801]">24h</div>
                        <div class="text-sm text-[#f9f0f1]/70">Produksi Cepat</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-[#d2f801]">100%</div>
                        <div class="text-sm text-[#f9f0f1]/70">Garansi Kualitas</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8 md:py-12">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Filters -->
            <div class="lg:w-1/4">
                <div class="bg-[#f9f0f1] rounded-3xl shadow-xl p-6 sticky top-6 border border-gray-100">
                   <!-- Categories -->
<div class="mb-8">
    <h3 class="font-bold text-xl mb-6 text-gray-800 flex items-center">
        <div class="w-10 h-10 bg-gradient-to-br bg-[#193497] rounded-xl flex items-center justify-center mr-3">
            <i class="fas fa-tags text-white"></i>
        </div>
        Kategori
    </h3>
    <div class="space-y-2">
        <!-- Semua Produk -->
        <button type="button"
               onclick="applyFilter('category', '')"
               class="w-full group flex items-center px-4 py-3 rounded-xl transition-all duration-300 <?php echo e(!request('category') ? 'bg-[#193497] text-white shadow-lg' : 'text-gray-600 hover:bg-gray-50'); ?>">
            <i class="fas fa-th-large mr-3 <?php echo e(!request('category') ? 'text-[#d2f801]' : 'text-[#193497]'); ?>"></i>
            <span class="font-semibold">Semua Produk</span>
            <?php if(!request('category')): ?>
            <i class="fas fa-check ml-auto"></i>
            <?php endif; ?>
        </button>

        <!-- Produk Instan -->
        <button type="button"
               onclick="applyFilter('category', 'instan')"
               class="w-full group flex items-center px-4 py-3 rounded-xl transition-all duration-300 <?php echo e(request('category') == 'instan' ? 'bg-blue-50 text-[#193497] font-semibold border-2 border-[#193497]/30' : 'text-gray-600 hover:bg-gray-50'); ?>">
            <i class="fas fa-bolt mr-3 text-[#193497]"></i>
            <span>Produk Instan</span>
            <?php if(request('category') == 'instan'): ?>
            <i class="fas fa-check ml-auto text-[#193497]"></i>
            <?php endif; ?>
        </button>

        <!-- Produk Non-Instan -->
        <button type="button"
               onclick="applyFilter('category', 'non-instan')"
               class="w-full group flex items-center px-4 py-3 rounded-xl transition-all duration-300 <?php echo e(request('category') == 'non-instan' ? 'bg-purple-50 text-[#7209b7] font-semibold border-2 border-purple-200' : 'text-gray-600 hover:bg-gray-50'); ?>">
            <i class="fas fa-gem mr-3 text-[#7209b7]"></i>
            <span>Produk Non Instan</span>
            <?php if(request('category') == 'non-instan'): ?>
            <i class="fas fa-check ml-auto text-[#7209b7]"></i>
            <?php endif; ?>
        </button>
    </div>
</div>

                    <!-- Sort Options -->
                    <div class="pt-6 border-t border-gray-200">
                        <h3 class="font-bold text-xl mb-6 text-gray-800 flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-br bg-[#f91f01] rounded-xl flex items-center justify-center mr-3">
                                <i class="fas fa-sort-amount-down text-white"></i>
                            </div>
                            Urutkan
                        </h3>
                        <div id="sortForm">
                            <div class="space-y-2">
                                <label class="flex items-center px-4 py-3 rounded-xl cursor-pointer transition-all duration-300 <?php echo e($selectedSort == 'latest' ? 'bg-[#193497]/10 border-2 border-[#193497]/30' : 'hover:bg-gray-50'); ?>">
                                    <input type="radio" name="sort" value="latest"
                                           <?php echo e($selectedSort == 'latest' ? 'checked' : ''); ?>

                                           onchange="applyFilter('sort', 'latest')"
                                           class="mr-3 w-5 h-5 text-[#193497] focus:ring-[#193497]">
                                    <span class="font-medium <?php echo e($selectedSort == 'latest' ? 'text-[#193497]' : 'text-gray-700'); ?>">Terbaru</span>
                                </label>
                                <label class="flex items-center px-4 py-3 rounded-xl cursor-pointer transition-all duration-300 <?php echo e($selectedSort == 'popular' ? 'bg-[#193497]/10 border-2 border-[#193497]/30' : 'hover:bg-gray-50'); ?>">
                                    <input type="radio" name="sort" value="popular"
                                           <?php echo e($selectedSort == 'popular' ? 'checked' : ''); ?>

                                           onchange="applyFilter('sort', 'popular')"
                                           class="mr-3 w-5 h-5 text-[#193497] focus:ring-[#193497]">
                                    <span class="font-medium <?php echo e($selectedSort == 'popular' ? 'text-[#193497]' : 'text-gray-700'); ?>">Terlaris</span>
                                </label>
                                <label class="flex items-center px-4 py-3 rounded-xl cursor-pointer transition-all duration-300 <?php echo e($selectedSort == 'price_asc' ? 'bg-[#193497]/10 border-2 border-[#193497]/30' : 'hover:bg-gray-50'); ?>">
                                    <input type="radio" name="sort" value="price_asc"
                                           <?php echo e($selectedSort == 'price_asc' ? 'checked' : ''); ?>

                                           onchange="applyFilter('sort', 'price_asc')"
                                           class="mr-3 w-5 h-5 text-[#193497] focus:ring-[#193497]">
                                    <span class="font-medium <?php echo e($selectedSort == 'price_asc' ? 'text-[#193497]' : 'text-gray-700'); ?>">Harga Terendah</span>
                                </label>
                                <label class="flex items-center px-4 py-3 rounded-xl cursor-pointer transition-all duration-300 <?php echo e($selectedSort == 'price_desc' ? 'bg-[#193497]/10 border-2 border-[#193497]/30' : 'hover:bg-gray-50'); ?>">
                                    <input type="radio" name="sort" value="price_desc"
                                           <?php echo e($selectedSort == 'price_desc' ? 'checked' : ''); ?>

                                           onchange="applyFilter('sort', 'price_desc')"
                                           class="mr-3 w-5 h-5 text-[#193497] focus:ring-[#193497]">
                                    <span class="font-medium <?php echo e($selectedSort == 'price_desc' ? 'text-[#193497]' : 'text-gray-700'); ?>">Harga Tertinggi</span>
                                </label>
                                <label class="flex items-center px-4 py-3 rounded-xl cursor-pointer transition-all duration-300 <?php echo e($selectedSort == 'discount' ? 'bg-[#193497]/10 border-2 border-[#193497]/30' : 'hover:bg-gray-50'); ?>">
                                    <input type="radio" name="sort" value="discount"
                                           <?php echo e($selectedSort == 'discount' ? 'checked' : ''); ?>

                                           onchange="applyFilter('sort', 'discount')"
                                           class="mr-3 w-5 h-5 text-[#193497] focus:ring-[#193497]">
                                    <span class="font-medium <?php echo e($selectedSort == 'discount' ? 'text-[#193497]' : 'text-gray-700'); ?>">Diskon Terbesar</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Promo Banner -->
                    <div class="mt-8 bg-[#f91f01] text-[#f9f0f1] rounded-2xl p-6 text-center">
                        <i class="fas fa-gift text-white text-4xl mb-3"></i>
                        <h4 class="font-bold text-white mb-2">Promo Spesial!</h4>
                        <p class="text-white text-sm mb-4">Diskon hingga 30% untuk order pertama</p>
                        <a href="<?php echo e(route('whatsapp.chat')); ?>" target="_blank" class="inline-block bg-[#f9f0f1] text-orange-600 px-4 py-2 rounded-full font-bold text-sm hover:bg-gray-100 transition-colors">
                            Klaim Sekarang
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:w-3/4">
                <!-- Results Header -->
                <div class="bg-[#f9f0f1] rounded-3xl shadow-lg p-6 mb-8 border border-gray-100">
                    <div class="flex flex-col md:flex-row md:items-center justify-between">
                        <div>
                            <h2 class="text-3xl font-bold text-gray-800 mb-2" id="resultsTitle">
                                <?php if(request('search')): ?>
                                    <i class="fas fa-search text-[#193497] mr-2"></i>
                                    "<?php echo e(request('search')); ?>"
                                <?php elseif(request('category')): ?>
                                    <?php if(request('category') == 'instan'): ?>
                                        <i class="fas fa-bolt text-[#193497] mr-2"></i>
                                        Produk Instan
                                    <?php elseif(request('category') == 'non-instan'): ?>
                                        <i class="fas fa-gem text-[#7209b7] mr-2"></i>
                                        Produk Non Instan
                                    <?php else: ?>
                                        <i class="fas fa-tag text-[#193497] mr-2"></i>
                                        Semua Produk
                                    <?php endif; ?>
                                <?php else: ?>
                                    <i class="fas fa-th-large text-[#193497] mr-2"></i>
                                    Semua Produk
                                <?php endif; ?>
                            </h2>
                            <p class="text-gray-600 flex items-center" id="resultsCount">
                                <i class="fas fa-box mr-2 text-[#193497]"></i>
                                <strong><?php echo e($products->total()); ?></strong>&nbsp;produk ditemukan
                            </p>
                        </div>

                        <div class="mt-4 md:mt-0">
                            <div class="flex items-center space-x-3">
                                <span class="text-gray-600 hidden md:block font-medium">Tampilan:</span>
                                <div class="flex bg-gray-100 rounded-xl p-1">
                                    <button class="p-3 rounded-lg bg-[#f9f0f1] shadow-md transition-all">
                                        <i class="fas fa-th-large text-[#193497]"></i>
                                    </button>
                                    <button class="p-3 rounded-lg text-gray-500 hover:text-gray-700 transition-all">
                                        <i class="fas fa-list"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products Grid Container -->
                <div id="productsContainer">
                    <?php if($products->count() > 0): ?>
                        <?php if (isset($component)) { $__componentOriginal62fd43497a41ce52ec2b2a2b96b6ad7c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal62fd43497a41ce52ec2b2a2b96b6ad7c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.partials.products.grid','data' => ['products' => $products]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('partials.products.grid'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['products' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($products)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal62fd43497a41ce52ec2b2a2b96b6ad7c)): ?>
<?php $attributes = $__attributesOriginal62fd43497a41ce52ec2b2a2b96b6ad7c; ?>
<?php unset($__attributesOriginal62fd43497a41ce52ec2b2a2b96b6ad7c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal62fd43497a41ce52ec2b2a2b96b6ad7c)): ?>
<?php $component = $__componentOriginal62fd43497a41ce52ec2b2a2b96b6ad7c; ?>
<?php unset($__componentOriginal62fd43497a41ce52ec2b2a2b96b6ad7c); ?>
<?php endif; ?>
                    <?php else: ?>
                        <!-- Empty State -->
                        <div class="bg-[#f9f0f1] rounded-3xl shadow-lg p-12 text-center">
                            <i class="fas fa-search text-gray-300 text-8xl mb-6"></i>
                            <h3 class="text-2xl font-bold text-gray-800 mb-3">Produk Tidak Ditemukan</h3>
                            <p class="text-gray-600 mb-8 max-w-md mx-auto">
                                Maaf, kami tidak menemukan produk yang sesuai dengan pencarian Anda. Coba kata kunci lain atau hubungi kami untuk produk custom.
                            </p>
                            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                                <button onclick="resetFilters()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold transition-colors">
                                    <i class="fas fa-th-large mr-2"></i> Lihat Semua Produk
                                </button>
                                <a href="<?php echo e(route('whatsapp.chat')); ?>" target="_blank" class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-xl font-semibold transition-colors">
                                    <i class="fab fa-whatsapp mr-2"></i> Konsultasi
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Pagination Container -->
                <?php if($products->hasPages()): ?>
                <div id="paginationContainer" class="mt-12">
                    <div class="flex justify-center">
                        <?php echo e($products->withQueryString()->links()); ?>

                    </div>
                </div>
                <?php endif; ?>

                <!-- Call to Action -->
                <div class="mt-12 relative bg-gradient-to-r bg-[#193497] text-white rounded-3xl p-12 overflow-hidden">
                    <!-- Decorative Elements -->
                    <div class="absolute top-0 right-0 w-64 h-64 bg-[#d2f801] rounded-full opacity-10 blur-3xl"></div>
                    <div class="absolute bottom-0 left-0 w-64 h-64 bg-[#7209b7] rounded-full opacity-10 blur-3xl"></div>

                    <div class="text-center relative z-10">
                        <div class="w-20 h-20 bg-[#d2f801] rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-2xl">
                            <i class="fas fa-headset text-blue-900 text-4xl"></i>
                        </div>
                        <h3 class="text-3xl md:text-4xl font-bold mb-4">
                            Butuh Produk <span class="text-[#d2f801]">Custom</span>?
                        </h3>
                        <p class="text-xl mb-8 opacity-90 max-w-2xl mx-auto">
                            Tim desainer profesional kami siap membantu mewujudkan ide kreatif Anda. Konsultasi gratis tanpa biaya!
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="<?php echo e(route('whatsapp.chat')); ?>" target="_blank"
                               class="group inline-flex items-center justify-center bg-[#d2f801] hover:bg-yellow-300 text-blue-900 font-bold px-8 py-4 rounded-xl transition-all duration-300 shadow-2xl hover:shadow-yellow-400/50 transform hover:scale-105">
                                <i class="fab fa-whatsapp mr-3 text-2xl"></i>
                                <span class="text-lg">Chat WhatsApp</span>
                                <i class="fas fa-arrow-right ml-3 group-hover:translate-x-2 transition-transform"></i>
                            </a>
                            <a href="tel:<?php echo e(env('SITE_PHONE', '+6281234567890')); ?>"
                               class="inline-flex items-center justify-center bg-[#f9f0f1]/10 backdrop-blur-sm border-2 border-white text-white hover:bg-[#f9f0f1] hover:text-blue-900 font-bold px-8 py-4 rounded-xl transition-all duration-300">
                                <i class="fas fa-phone mr-3 text-xl"></i>
                                <span class="text-lg">Telepon Kami</span>
                            </a>
                        </div>

                        <!-- Trust Badges -->
                        <div class="grid grid-cols-3 gap-6 mt-12 max-w-2xl mx-auto">
                            <div class="text-center">
                                <div class="text-4xl font-bold text-[#d2f801] mb-1">5K+</div>
                                <div class="text-sm text-[#f9f0f1]/70">Produk Terjual</div>
                            </div>
                            <div class="text-center">
                                <div class="text-4xl font-bold text-[#d2f801] mb-1">98%</div>
                                <div class="text-sm text-[#f9f0f1]/70">Kepuasan</div>
                            </div>
                            <div class="text-center">
                                <div class="text-4xl font-bold text-[#d2f801] mb-1">1K+</div>
                                <div class="text-sm text-[#f9f0f1]/70">Review Positif</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Pagination Styling */
.pagination {
    display: flex;
    justify-content: center;
    list-style: none;
    padding: 0;
    gap: 8px;
}

.pagination li a,
.pagination li span {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 48px;
    height: 48px;
    padding: 0 16px;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s;
}

.pagination li.active span {
    background: #193497;
    color: white;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
}

.pagination li:not(.active):not(.disabled) a {
    color: #4b5563;
    background: white;
    border: 2px solid #e5e7eb;
}

.pagination li:not(.active):not(.disabled) a:hover {
    background: #f3f4f6;
    border-color: #3b82f6;
    color: #3b82f6;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.pagination li.disabled span {
    color: #9ca3af;
    cursor: not-allowed;
    background: #f9fafb;
}

/* Loading Animation */
.loading-spinner {
    border: 3px solid #f3f3f3;
    border-top: 3px solid #193497;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 1s linear infinite;
    margin: 20px auto;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
console.log('🔧 Products page loaded - Debug mode ON');

// State variables
let currentFilters = {
    search: "<?php echo e(request('search', '')); ?>",
    category: "<?php echo e(request('category', '')); ?>",
    sort: "<?php echo e($selectedSort ?? 'latest'); ?>",
    page: <?php echo e(request('page', 1)); ?>

};

let isSearching = false;

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    console.log('📍 DOM loaded, current filters:', currentFilters);
    
    // Initial UI state
    updateCategoryUI(currentFilters.category);
    updateSortUI(currentFilters.sort);
    
    // Setup search
    const searchInput = document.getElementById('liveSearchInput');
    const searchButton = document.getElementById('searchButton');
    
    if (searchInput) {
        searchInput.value = currentFilters.search;
        
        // Search on Enter
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                console.log('🔍 Enter key pressed');
                applyFilter('search', this.value);
            }
        });
        
        // Search on input with debounce
        let searchTimeout;
        searchInput.addEventListener('input', function(e) {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                console.log('🔍 Input changed:', this.value);
                applyFilter('search', this.value);
            }, 500);
        });
    }
    
    if (searchButton) {
        searchButton.addEventListener('click', function() {
            console.log('🔍 Search button clicked');
            applyFilter('search', searchInput.value);
        });
    }
    
    console.log('✅ Initialization complete');
});

// Apply filter function - FIXED
function applyFilter(type, value) {
    console.log(`🎯 applyFilter called: ${type} = "${value}"`);
    
    // Update filter
    currentFilters[type] = value;
    
    // Reset page for non-page filters
    if (type !== 'page') {
        currentFilters.page = 1;
    }
    
    console.log('📋 Updated filters:', currentFilters);
    
    // Update UI
    updateCategoryUI(currentFilters.category);
    updateSortUI(currentFilters.sort);
    
    // Update URL
    updateURL();
    
    // Update results title
    updateResultsTitle();
    
    // Perform search
    performLiveSearch();
}

// Update category buttons UI - FIXED
function updateCategoryUI(category) {
    console.log('🎨 Updating category UI for:', category);
    
    // Get all category buttons
    const buttons = document.querySelectorAll('[onclick*="applyFilter(\'category\'"]');
    
    buttons.forEach(button => {
        // Extract value from onclick attribute
        const onclickAttr = button.getAttribute('onclick');
        const match = onclickAttr.match(/applyFilter\('category',\s*'([^']*)'/);
        
        if (match) {
            const buttonValue = match[1]; // '' (empty), 'instan', or 'non-instan'
            const isActive = buttonValue === category;
            
            console.log(`   Button "${buttonValue}": ${isActive ? 'active' : 'inactive'}`);
            
            // Reset all active classes
            button.classList.remove(
                'bg-[#193497]', 'text-white', 'shadow-lg',
                'bg-blue-50', 'text-[#193497]', 'border-2', 'border-[#193497]/30', 'font-semibold',
                'bg-purple-50', 'text-[#7209b7]', 'border-2', 'border-purple-200', 'font-semibold'
            );
            
            // Remove check icons
            const checkIcon = button.querySelector('.fa-check');
            if (checkIcon) {
                checkIcon.remove();
            }
            
            // Set classes based on value and active state
            if (isActive) {
                if (buttonValue === '') {
                    // All Products - active
                    button.classList.add('bg-[#193497]', 'text-white', 'shadow-lg');
                    // Add check icon
                    button.innerHTML += '<i class="fas fa-check ml-auto"></i>';
                } else if (buttonValue === 'instan') {
                    // Instan - active
                    button.classList.add('bg-blue-50', 'text-[#193497]', 'border-2', 'border-[#193497]/30', 'font-semibold');
                    // Add check icon
                    button.innerHTML += '<i class="fas fa-check ml-auto text-[#193497]"></i>';
                } else if (buttonValue === 'non-instan') {
                    // Non-Instan - active
                    button.classList.add('bg-purple-50', 'text-[#7209b7]', 'border-2', 'border-purple-200', 'font-semibold');
                    // Add check icon
                    button.innerHTML += '<i class="fas fa-check ml-auto text-[#7209b7]"></i>';
                }
            } else {
                // Not active - set default classes
                button.classList.add('text-gray-600', 'hover:bg-gray-50');
            }
        }
    });
}

// Update sort UI
function updateSortUI(sortValue) {
    console.log('🎨 Updating sort UI for:', sortValue);
    
    // Update radio buttons
    document.querySelectorAll('input[name="sort"]').forEach(radio => {
        const isChecked = radio.value === sortValue;
        radio.checked = isChecked;
        
        const label = radio.closest('label');
        if (label) {
            // Reset classes
            label.classList.remove('bg-[#193497]/10', 'border-2', 'border-[#193497]/30');
            
            // Add active classes if checked
            if (isChecked) {
                label.classList.add('bg-[#193497]/10', 'border-2', 'border-[#193497]/30');
            }
            
            // Update text color
            const span = label.querySelector('span');
            if (span) {
                span.classList.toggle('text-[#193497]', isChecked);
                span.classList.toggle('text-gray-700', !isChecked);
            }
        }
    });
}

// Update browser URL
function updateURL() {
    console.log('🌐 Updating URL');
    
    const url = new URL(window.location.href);
    
    // Clear params
    ['search', 'category', 'sort', 'page'].forEach(param => {
        url.searchParams.delete(param);
    });
    
    // Add current filters
    Object.keys(currentFilters).forEach(key => {
        if (currentFilters[key] && currentFilters[key] !== '') {
            url.searchParams.set(key, currentFilters[key]);
        }
    });
    
    window.history.replaceState({}, '', url.toString());
    console.log('   New URL:', url.toString());
}

// Update results title
function updateResultsTitle() {
    const titleElement = document.getElementById('resultsTitle');
    if (!titleElement) return;
    
    let titleHtml = '';
    
    if (currentFilters.search) {
        titleHtml = `<i class="fas fa-search text-[#193497] mr-2"></i>"${currentFilters.search}"`;
    } else if (currentFilters.category) {
        if (currentFilters.category === 'instan') {
            titleHtml = `<i class="fas fa-bolt text-[#193497] mr-2"></i>Produk Instan`;
        } else if (currentFilters.category === 'non-instan') {
            titleHtml = `<i class="fas fa-gem text-[#7209b7] mr-2"></i>Produk Non Instan`;
        } else {
            titleHtml = `<i class="fas fa-th-large text-[#193497] mr-2"></i>Semua Produk`;
        }
    } else {
        titleHtml = `<i class="fas fa-th-large text-[#193497] mr-2"></i>Semua Produk`;
    }
    
    titleElement.innerHTML = titleHtml;
}

// Perform live search
async function performLiveSearch() {
    if (isSearching) {
        console.log('⏳ Search already in progress');
        return;
    }
    
    isSearching = true;
    console.log('🚀 Starting live search with:', currentFilters);
    
    // Show loading
    const resultsInfo = document.getElementById('searchResultsInfo');
    if (resultsInfo) {
        resultsInfo.classList.remove('hidden');
        resultsInfo.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i><span>Mencari...</span>';
    }
    
    try {
        // Prepare data
        const formData = new FormData();
        formData.append('search', currentFilters.search || '');
        formData.append('category', currentFilters.category || '');
        formData.append('sort', currentFilters.sort || 'latest');
        formData.append('page', currentFilters.page || 1);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.content || '<?php echo e(csrf_token()); ?>');
        
        console.log('📤 Sending POST to:', '<?php echo e(route("products.live-search")); ?>');
        
        // Send request
        const response = await fetch('<?php echo e(route("products.live-search")); ?>', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            body: formData
        });
        
        console.log('📥 Response status:', response.status);
        const data = await response.json();
        console.log('📊 Response data:', data);
        
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${data.message || 'Server error'}`);
        }
        
        if (data.success) {
            console.log('✅ Search successful, updating UI');
            
            // Update products grid
            document.getElementById('productsContainer').innerHTML = data.html;
            
            // Update pagination
            const paginationContainer = document.getElementById('paginationContainer');
            if (data.pagination) {
                if (!paginationContainer) {
                    const newDiv = document.createElement('div');
                    newDiv.id = 'paginationContainer';
                    newDiv.className = 'mt-12';
                    newDiv.innerHTML = '<div class="flex justify-center">' + data.pagination + '</div>';
                    document.getElementById('productsContainer').after(newDiv);
                } else {
                    paginationContainer.innerHTML = '<div class="flex justify-center">' + data.pagination + '</div>';
                }
            } else if (paginationContainer) {
                paginationContainer.remove();
            }
            
            // Update results count
            const resultsCount = document.getElementById('resultsCount');
            if (resultsCount) {
                resultsCount.innerHTML = 
                    `<i class="fas fa-box mr-2 text-[#193497]"></i>
                     <strong>${data.total}</strong>&nbsp;produk ditemukan`;
            }
            
        } else {
            throw new Error(data.message || 'Search failed');
        }
        
    } catch (error) {
        console.error('❌ Live search error:', error);
        
        // Show error
        document.getElementById('productsContainer').innerHTML = `
            <div class="bg-red-50 border border-red-200 rounded-3xl p-8 text-center">
                <i class="fas fa-exclamation-circle text-red-500 text-4xl mb-4"></i>
                <h3 class="text-xl font-bold text-red-800 mb-2">Terjadi Kesalahan</h3>
                <p class="text-red-600 mb-4">${error.message}</p>
                <button onclick="performLiveSearch()" 
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-redo mr-2"></i>Coba Lagi
                </button>
            </div>
        `;
    } finally {
        // Hide loading
        if (resultsInfo) {
            resultsInfo.classList.add('hidden');
        }
        
        isSearching = false;
        console.log('🏁 Search completed');
        
        // Reattach pagination listeners
        setTimeout(attachPaginationListeners, 100);
    }
}

// Attach pagination listeners
function attachPaginationListeners() {
    console.log('📄 Attaching pagination listeners');
    document.querySelectorAll('.pagination a').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const url = new URL(this.href);
            const page = url.searchParams.get('page');
            if (page) {
                console.log('📄 Pagination to page:', page);
                applyFilter('page', page);
            }
        });
    });
}

// Reset all filters
function resetFilters() {
    console.log('🔄 Resetting all filters');
    currentFilters = {
        search: '',
        category: '',
        sort: 'latest',
        page: 1
    };
    
    // Clear search input
    const searchInput = document.getElementById('liveSearchInput');
    if (searchInput) searchInput.value = '';
    
    // Update UI
    updateCategoryUI('');
    updateSortUI('latest');
    updateResultsTitle();
    
    // Perform search
    performLiveSearch();
}

// Export functions untuk testing
window.applyFilter = applyFilter;
window.performLiveSearch = performLiveSearch;
window.currentFilters = currentFilters;
window.updateCategoryUI = updateCategoryUI;
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\revisiimaji\resources\views/pages/products/index.blade.php ENDPATH**/ ?>