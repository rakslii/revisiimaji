<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Cipta Imaji - Digital Printing'); ?></title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Vite -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="font-sans bg-gray-50">
    <?php echo $__env->make('layouts.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    <!-- Modern Notification Container -->
    <div id="notificationContainer" class="fixed top-6 right-6 z-[9999] flex flex-col gap-3 max-w-md pointer-events-none"></div>
    
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