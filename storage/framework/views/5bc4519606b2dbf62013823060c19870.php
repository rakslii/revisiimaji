<script>
    // Toggle sidebar on mobile
    function toggleSidebar() {
        const sidebar = document.querySelector('aside');
        sidebar.classList.toggle('hidden');
    }
    
    // Format currency
    function formatCurrency(amount) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(amount);
    }
    
    // Confirm before delete
    function confirmDelete(message = 'Are you sure?') {
        return confirm(message);
    }
</script><?php /**PATH D:\ciptaimaji\revisiimaji\resources\views\pages\admin\layouts\scripts.blade.php ENDPATH**/ ?>