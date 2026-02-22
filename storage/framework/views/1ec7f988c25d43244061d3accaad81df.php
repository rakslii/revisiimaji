<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Cipta Imaji - Digital Printing'); ?></title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Alpine.js untuk carousel -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    <!-- Vite -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="font-sans bg-gray-50">
    <?php echo $__env->make('layouts.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    <!-- Modern Notification Container -->
    <div id="notificationContainer" class="fixed top-6 right-6 z-[9999] flex flex-col gap-3 max-w-md pointer-events-none"></div>
    
    <!-- POPUP SECTION - AKAN MUNCUL OTOMATIS -->
    <?php if(isset($popup) && $popup && $popup->is_valid): ?>
    <?php
        // Cek device
        $isMobile = preg_match('/(android|iphone|ipad|mobile)/i', request()->userAgent());
        $isTablet = preg_match('/(ipad|tablet)/i', request()->userAgent());
        
        $showOnDevice = true;
        if ($isMobile && !$popup->show_on_mobile) $showOnDevice = false;
        if ($isTablet && !$popup->show_on_tablet) $showOnDevice = false;
        if (!$isMobile && !$isTablet && !$popup->show_on_desktop) $showOnDevice = false;
    ?>
    
    <?php if($showOnDevice): ?>
    <!-- Popup Modal -->
    <div id="promoPopup" 
         class="fixed inset-0 z-[99999] flex items-center justify-center p-4 transition-all duration-300 opacity-0 invisible"
         data-delay="<?php echo e($popup->delay_seconds ?? 3); ?>"
         data-once="<?php echo e($popup->show_once_per_session ? 'true' : 'false'); ?>"
         style="background-color: rgba(0,0,0,0.7); backdrop-filter: blur(8px);">
        
        <div class="relative w-full max-w-<?php echo e($popup->size == 'small' ? 'md' : ($popup->size == 'large' ? '4xl' : '2xl')); ?> transform transition-all duration-500 scale-95 opacity-0"
             id="popupContent"
             style="<?php echo e($popup->background_style); ?>">
            
            <!-- Popup Content -->
            <div class="relative overflow-hidden rounded-3xl shadow-2xl">
                <!-- Close Button -->
                <?php if($popup->show_close_button): ?>
                <button onclick="closePopup()" 
                        class="absolute top-4 right-4 z-20 w-12 h-12 bg-white/90 hover:bg-white rounded-full flex items-center justify-center shadow-lg hover:shadow-xl transition-all duration-300 group">
                    <i class="fas fa-times text-gray-600 group-hover:text-gray-900 text-xl"></i>
                </button>
                <?php endif; ?>
                
                <!-- Image -->
                <?php if($popup->image_url): ?>
                <div class="relative cursor-pointer" onclick="window.location='<?php echo e($popup->link ?? '#'); ?>'">
                    <img src="<?php echo e($isMobile && $popup->mobile_image_url ? $popup->mobile_image_url : $popup->image_url); ?>" 
                         alt="<?php echo e($popup->title); ?>"
                         class="w-full h-auto <?php echo e($popup->size == 'full' ? 'max-h-screen' : 'max-h-[80vh]'); ?> object-cover">
                    
                    <!-- Overlay jika ada teks -->
                    <?php if($popup->title || $popup->description): ?>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent flex items-end">
                        <div class="p-8 text-white">
                            <?php if($popup->subtitle): ?>
                            <p class="text-[#c0f820] font-semibold mb-2 text-lg"><?php echo e($popup->subtitle); ?></p>
                            <?php endif; ?>
                            
                            <?php if($popup->title): ?>
                            <h3 class="text-4xl font-bold mb-3"><?php echo e($popup->title); ?></h3>
                            <?php endif; ?>
                            
                            <?php if($popup->description): ?>
                            <p class="text-white/90 text-lg mb-4"><?php echo e($popup->description); ?></p>
                            <?php endif; ?>
                            
                            <?php if($popup->link): ?>
                            <span class="inline-flex items-center bg-[#c0f820] text-[#193497] px-6 py-3 rounded-full font-bold hover:bg-[#d4ff40] transition-all duration-300">
                                <?php echo e($popup->button_text ?? 'Lihat Promo'); ?>

                                <i class="fas fa-arrow-right ml-2"></i>
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                <?php else: ?>
                <!-- Content without image -->
                <div class="bg-white p-10 <?php echo e($popup->size == 'full' ? 'min-h-screen' : ''); ?>" 
                     onclick="window.location='<?php echo e($popup->link ?? '#'); ?>'"
                     style="cursor: pointer;">
                    <div class="text-center">
                        <?php if($popup->subtitle): ?>
                        <p class="text-[#c0f820] font-semibold text-lg mb-3"><?php echo e($popup->subtitle); ?></p>
                        <?php endif; ?>
                        
                        <?php if($popup->title): ?>
                        <h3 class="text-4xl font-bold text-gray-900 mb-4"><?php echo e($popup->title); ?></h3>
                        <?php endif; ?>
                        
                        <?php if($popup->description): ?>
                        <div class="text-gray-700 text-lg mb-8 leading-relaxed">
                            <?php echo e($popup->description); ?>

                        </div>
                        <?php endif; ?>
                        
                        <?php if($popup->link): ?>
                        <span class="inline-flex items-center bg-[#193497] text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-[#1e40af] transition-all duration-300 shadow-xl">
                            <?php echo e($popup->button_text ?? 'Lihat Promo'); ?>

                            <i class="fas fa-arrow-right ml-3"></i>
                        </span>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <script>
    // Popup functionality
    let popupShown = false;
    const popup = document.getElementById('promoPopup');
    const popupContent = document.getElementById('popupContent');
    const delay = parseInt(popup?.dataset.delay || '3') * 1000;
    const showOnce = popup?.dataset.once === 'true';
    
    function showPopup() {
        if (!popup || popupShown) return;
        
        // Check if already shown in this session
        if (showOnce && sessionStorage.getItem('popupShown')) {
            return;
        }
        
        popupShown = true;
        popup.classList.remove('invisible');
        
        setTimeout(() => {
            popup.classList.remove('opacity-0');
            popup.classList.add('opacity-100');
            
            setTimeout(() => {
                popupContent.classList.remove('scale-95', 'opacity-0');
                popupContent.classList.add('scale-100', 'opacity-100');
            }, 100);
            
            // Track view
            fetch('/api/banners/<?php echo e($popup->id); ?>/view', { 
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                }
            });
            
            // Save to session
            if (showOnce) {
                sessionStorage.setItem('popupShown', 'true');
            }
        }, 100);
    }
    
    function closePopup() {
        if (!popup) return;
        
        popupContent.classList.remove('scale-100', 'opacity-100');
        popupContent.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            popup.classList.remove('opacity-100');
            popup.classList.add('opacity-0');
            
            setTimeout(() => {
                popup.classList.add('invisible');
            }, 300);
        }, 200);
    }
    
    // Track click
    function trackPopupClick() {
        fetch('/api/banners/<?php echo e($popup->id); ?>/click', { 
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            }
        });
    }
    
    // Close on background click
    popup?.addEventListener('click', function(e) {
        if (e.target === popup) {
            closePopup();
        }
    });
    
    // Show popup after page load
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(showPopup, delay);
    });
    
    // Track click when popup content is clicked
    popupContent?.addEventListener('click', function() {
        trackPopupClick();
    });
    </script>
    <?php endif; ?>
    <?php endif; ?>
    
    <main class="min-h-screen">
        <?php echo $__env->yieldContent('content'); ?>
    </main>
    
    <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/js/app.js']); ?>
    
    <!-- Modern Notification System -->
    <script>
    class NotificationSystem {
        constructor() {
            this.container = document.getElementById('notificationContainer');
            this.notifications = new Map();
        }
        
        show(data) {
            const id = 'notification-' + Date.now() + '-' + Math.random().toString(36).substr(2, 9);
            const notification = this.createNotification(id, data);
            
            this.container.appendChild(notification);
            this.notifications.set(id, notification);
            
            // Animate in
            setTimeout(() => {
                notification.classList.remove('translate-x-full', 'opacity-0');
                notification.classList.add('translate-x-0', 'opacity-100');
            }, 10);
            
            // Auto remove after 5 seconds
            const timeout = setTimeout(() => {
                this.remove(id);
            }, 5000);
            
            // Store timeout ID
            notification.dataset.timeoutId = timeout;
            
            // Start progress bar
            const progressBar = notification.querySelector('.notification-progress-bar');
            if (progressBar) {
                progressBar.style.transition = 'width 5s linear';
                setTimeout(() => {
                    progressBar.style.width = '0%';
                }, 10);
            }
            
            return id;
        }
        
        createNotification(id, data) {
            const { type = 'success', title = '', message = '', product = null } = data;
            
            // Config based on type
            const config = {
                success: {
                    icon: 'check-circle',
                    iconColor: 'text-emerald-600',
                    bgColor: 'bg-emerald-50',
                    borderColor: 'border-emerald-200',
                    accentColor: 'bg-emerald-500',
                    progressColor: 'bg-emerald-500'
                },
                error: {
                    icon: 'exclamation-circle',
                    iconColor: 'text-red-600',
                    bgColor: 'bg-red-50',
                    borderColor: 'border-red-200',
                    accentColor: 'bg-red-500',
                    progressColor: 'bg-red-500'
                },
                warning: {
                    icon: 'exclamation-triangle',
                    iconColor: 'text-amber-600',
                    bgColor: 'bg-amber-50',
                    borderColor: 'border-amber-200',
                    accentColor: 'bg-amber-500',
                    progressColor: 'bg-amber-500'
                },
                info: {
                    icon: 'info-circle',
                    iconColor: 'text-blue-600',
                    bgColor: 'bg-blue-50',
                    borderColor: 'border-blue-200',
                    accentColor: 'bg-blue-500',
                    progressColor: 'bg-blue-500'
                }
            }[type];
            
            const notification = document.createElement('div');
            notification.id = id;
            notification.className = `
                notification relative w-96 ${config.bgColor} border ${config.borderColor} 
                rounded-xl shadow-xl transform transition-all duration-500 ease-out
                translate-x-full opacity-0 pointer-events-auto
            `;
            
            // Product info HTML if available
            let productHtml = '';
            if (product) {
                productHtml = `
                    <div class="mt-3 p-3 bg-white/50 rounded-lg border border-gray-100">
                        <div class="flex items-center gap-3">
                            ${product.image ? `
                                <img src="${product.image}" 
                                     alt="${product.name}"
                                     class="w-12 h-12 rounded-lg object-cover border border-gray-200">
                            ` : ''}
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-sm text-gray-800 truncate">${product.name}</p>
                                <div class="flex items-center justify-between mt-1">
                                    <span class="text-xs text-gray-600">${product.quantity} × ${product.price}</span>
                                    <span class="text-sm font-bold text-emerald-600">
                                        ${product.quantity > 1 ? product.quantity + ' pcs' : ''}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }
            
            notification.innerHTML = `
                <div class="absolute top-0 left-0 w-1 h-full ${config.accentColor} rounded-l-xl"></div>
                
                <div class="p-4 pl-5">
                    <div class="flex items-start gap-3">
                        <!-- Icon -->
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 ${config.iconColor} flex items-center justify-center rounded-full bg-white shadow-sm">
                                <i class="fas fa-${config.icon} text-lg"></i>
                            </div>
                        </div>
                        
                        <!-- Content -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-2">
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-bold text-gray-900 text-sm mb-1 flex items-center gap-2">
                                        ${title}
                                    </h4>
                                    <p class="text-gray-700 text-sm leading-relaxed">${message}</p>
                                    ${productHtml}
                                </div>
                                
                                <!-- Close Button -->
                                <button type="button" 
                                        onclick="window.notificationSystem.remove('${id}')"
                                        class="flex-shrink-0 w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full transition-colors">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Progress Bar -->
                    <div class="mt-3 h-1 bg-gray-200 rounded-full overflow-hidden">
                        <div class="notification-progress-bar h-full ${config.progressColor} rounded-full w-full"></div>
                    </div>
                </div>
            `;
            
            return notification;
        }
        
        remove(id) {
            const notification = this.notifications.get(id);
            if (!notification) return;
            
            // Clear timeout if exists
            if (notification.dataset.timeoutId) {
                clearTimeout(notification.dataset.timeoutId);
            }
            
            // Animate out
            notification.classList.remove('translate-x-0', 'opacity-100');
            notification.classList.add('translate-x-full', 'opacity-0');
            
            // Remove from DOM after animation
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
                this.notifications.delete(id);
            }, 500);
        }
        
        clearAll() {
            this.notifications.forEach((notification, id) => {
                this.remove(id);
            });
        }
    }
    
    // Initialize notification system
    window.notificationSystem = new NotificationSystem();
    
    // Cart notification function
    function showCartNotification(response) {
        if (response.success) {
            window.notificationSystem.show({
                type: 'success',
                title: response.title || 'Berhasil Ditambahkan!',
                message: response.message,
                product: response.product || null
            });
            
            // Update cart count
            updateCartCount();
        } else {
            window.notificationSystem.show({
                type: response.type || 'error',
                title: response.title || 'Gagal',
                message: response.message
            });
        }
    }
    
    // Update cart count function
    function updateCartCount() {
        fetch('<?php echo e(route("cart.count")); ?>')
            .then(response => response.json())
            .then(data => {
                // Update all cart counter elements
                document.querySelectorAll('.cart-counter').forEach(counter => {
                    const badge = counter.querySelector('.cart-badge');
                    if (badge) {
                        badge.textContent = data.count;
                        badge.classList.toggle('hidden', data.count === 0);
                    } else {
                        counter.textContent = data.count;
                        counter.classList.toggle('hidden', data.count === 0);
                    }
                });
            })
            .catch(error => console.error('Error updating cart count:', error));
    }
    
    // Handle add to cart forms globally
    document.addEventListener('DOMContentLoaded', function() {
        // Event delegation for all add-to-cart forms
        document.addEventListener('submit', function(e) {
            const form = e.target;
            if (!form.matches('.add-to-cart-form, form[action*="/cart/add"]')) return;
            
            e.preventDefault();
            
            const button = form.querySelector('button[type="submit"]');
            const originalContent = button.innerHTML;
            
            // Show loading state
            button.disabled = true;
            button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menambahkan...';
            
            // Submit form via AJAX
            fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                // Show notification
                showCartNotification(data);
                
                // Reset button
                button.disabled = false;
                button.innerHTML = originalContent;
            })
            .catch(error => {
                console.error('Error:', error);
                
                // Show error notification
                window.notificationSystem.show({
                    type: 'error',
                    title: 'Terjadi Kesalahan',
                    message: 'Gagal menambahkan produk ke keranjang.'
                });
                
                // Reset button
                button.disabled = false;
                button.innerHTML = originalContent;
            });
        });
        
        // Initial cart count update
        updateCartCount();
    });
    </script>
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\laragon\www\revisiimaji\resources\views/layouts/app.blade.php ENDPATH**/ ?>