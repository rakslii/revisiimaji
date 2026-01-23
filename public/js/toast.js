// Toast Notification System
function showToast(message, type = 'success') {
    const container = document.getElementById('toast-container');
    
    // Icon berdasarkan tipe
    const icons = {
        success: '<i class="fas fa-check-circle"></i>',
        error: '<i class="fas fa-times-circle"></i>',
        warning: '<i class="fas fa-exclamation-triangle"></i>',
        info: '<i class="fas fa-info-circle"></i>'
    };
    
    // Warna berdasarkan tipe
    const colors = {
        success: 'bg-green-500',
        error: 'bg-red-500',
        warning: 'bg-yellow-500',
        info: 'bg-blue-500'
    };
    
    // Buat elemen toast
    const toast = document.createElement('div');
    toast.className = `${colors[type]} text-white px-6 py-4 rounded-lg shadow-lg flex items-center space-x-3 transform transition-all duration-300 ease-out translate-x-full opacity-0 min-w-[300px] max-w-md`;
    
    toast.innerHTML = `
        <span class="text-xl">${icons[type]}</span>
        <span class="flex-1 font-medium">${message}</span>
        <button onclick="this.parentElement.remove()" class="text-white hover:text-gray-200 transition-colors">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    container.appendChild(toast);
    
    // Animasi masuk
    setTimeout(() => {
        toast.classList.remove('translate-x-full', 'opacity-0');
    }, 10);
    
    // Auto-hide setelah 3 detik
    setTimeout(() => {
        toast.classList.add('translate-x-full', 'opacity-0');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Handle Add to Cart
document.addEventListener('DOMContentLoaded', function() {
    const addToCartForms = document.querySelectorAll('.add-to-cart-form');
    
    addToCartForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const button = this.querySelector('.add-to-cart-btn');
            const originalHtml = button.innerHTML;
            
            // Loading state
            button.disabled = true;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            
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
                    // 🍞 Tampilkan Toast
                    showToast(data.message, 'success');
                    
                    // Update cart count di navbar
                    const cartBadge = document.querySelector('.cart-count');
                    if (cartBadge) {
                        cartBadge.textContent = data.cart_count;
                        cartBadge.classList.remove('hidden');
                    }
                } else {
                    showToast(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Terjadi kesalahan, coba lagi!', 'error');
            })
            .finally(() => {
                // Reset button
                button.disabled = false;
                button.innerHTML = originalHtml;
            });
        });
    });
});