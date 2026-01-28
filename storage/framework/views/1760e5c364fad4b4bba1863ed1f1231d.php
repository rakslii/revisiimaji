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
    
    <main class="min-h-screen">
        <?php echo $__env->yieldContent('content'); ?>
    </main>
    
    <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    <!-- Toast Container -->
    <div id="toast-container" class="fixed top-20 right-4 z-50 space-y-2"></div>
    
    <!-- Cart Toast Script -->
<!-- Cart Toast Script -->
<script>
    // Toast Notification
    function showToast(message, type = 'success') {
        const container = document.getElementById('toast-container');
        
        const icons = {
            success: '✓',
            error: '✕',
        };
        
        const colors = {
            success: 'bg-green-500',
            error: 'bg-red-500',
        };
        
        const toast = document.createElement('div');
        toast.className = `${colors[type]} text-white px-6 py-4 rounded-lg shadow-lg flex items-center space-x-3 transform transition-all duration-300 translate-x-full min-w-[320px]`;
        
        toast.innerHTML = `
            <span class="text-2xl font-bold">${icons[type]}</span>
            <span class="flex-1 font-medium">${message}</span>
            <button onclick="this.parentElement.remove()" class="text-white hover:text-gray-200">
                <i class="fas fa-times"></i>
            </button>
        `;
        
        container.appendChild(toast);
        
        setTimeout(() => toast.classList.remove('translate-x-full'), 10);
        setTimeout(() => {
            toast.classList.add('translate-x-full');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
    
    // Update Cart Count
    function updateCartCount() {
        fetch('<?php echo e(route("cart.count")); ?>')
            .then(response => response.json())
            .then(data => {
                const cartCounters = document.querySelectorAll('.cart-counter');
                cartCounters.forEach(counter => {
                    counter.textContent = data.count;
                    if (data.count > 0) {
                        counter.classList.remove('hidden');
                    } else {
                        counter.classList.add('hidden');
                    }
                });
            })
            .catch(error => console.error('Error updating cart count:', error));
    }
    
    // Handle Add to Cart Forms
    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('.add-to-cart-form');
        
        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const button = this.querySelector('button[type="submit"]');
                const icon = button.querySelector('i');
                const originalClass = icon ? icon.className : '';
                
                // Loading
                button.disabled = true;
                if (icon) {
                    icon.className = 'fas fa-spinner fa-spin';
                }
                
                fetch(this.action, {
                    method: 'POST',
                    body: new FormData(this),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast(data.message, 'success');
                        
                        // Update cart count
                        if (typeof updateCartCount === 'function') {
                            updateCartCount();
                        }
                    } else {
                        showToast(data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Terjadi kesalahan!', 'error');
                })
                .finally(() => {
                    button.disabled = false;
                    if (icon) {
                        icon.className = originalClass;
                    }
                });
            });
        });
    });
</script>
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\laragon\www\IMAJI\revisiimaji\resources\views\layouts\app.blade.php ENDPATH**/ ?>