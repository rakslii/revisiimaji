

<?php $__env->startSection('title', 'General Settings'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-6 max-w-6xl">
    <!-- Header dengan Breadcrumb -->
    <div class="mb-6">
        <nav class="flex mb-3" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="text-gray-700 hover:text-blue-600">
                        <i class="fas fa-home mr-2"></i>Dashboard
                    </a>
                </li>
                <li class="inline-flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <a href="<?php echo e(route('admin.settings.index')); ?>" class="text-gray-700 hover:text-blue-600">
                        Settings
                    </a>
                </li>
                <li aria-current="page" class="inline-flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-blue-600 font-medium">General Settings</span>
                </li>
            </ol>
        </nav>
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">General Settings</h1>
                <p class="text-gray-600 mt-1">Configure your store's basic information and preferences</p>
            </div>
            
            <div class="flex items-center space-x-2 text-sm text-gray-500">
                <i class="fas fa-info-circle text-blue-500"></i>
                <span>Last updated: <?php echo e(\App\Models\AdminSetting::where('group', 'general')->max('updated_at') ? \Carbon\Carbon::parse(\App\Models\AdminSetting::where('group', 'general')->max('updated_at'))->format('d/m/Y H:i') : 'Never'); ?></span>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    <?php if(session('success')): ?>
        <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded-r-lg">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-400 text-xl"></i>
                </div>
                <div class="ml-3">
                    <p class="text-green-800 font-medium">Success!</p>
                    <p class="text-green-700 mt-1"><?php echo e(session('success')); ?></p>
                </div>
                <div class="ml-auto pl-3">
                    <button type="button" onclick="this.parentElement.parentElement.remove()" class="text-green-700 hover:text-green-900">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-r-lg">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-400 text-xl"></i>
                </div>
                <div class="ml-3">
                    <p class="text-red-800 font-medium">Please fix the following errors:</p>
                    <ul class="list-disc list-inside text-red-700 mt-1 text-sm">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Main Form -->
    <form method="POST" action="<?php echo e(route('admin.settings.general.update')); ?>" class="space-y-6">
        <?php echo csrf_field(); ?>

        <!-- Store Information Card -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-blue-600">
                <div class="flex items-center">
                    <i class="fas fa-store text-white text-xl mr-3"></i>
                    <h2 class="text-lg font-medium text-white">Store Information</h2>
                </div>
                <p class="text-blue-100 text-sm mt-1">Basic information about your store</p>
            </div>
            
            <div class="p-6">
                <div class="space-y-6">
                    <!-- Site Name -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-signature mr-2 text-gray-400"></i>
                            Site Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="site_name" 
                               value="<?php echo e(old('site_name', $settingValues['site_name'] ?? '')); ?>"
                               placeholder="e.g., Cipta Imaji Printing"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                               required>
                        <p class="text-xs text-gray-500 mt-1">This will be displayed as your store name throughout the website</p>
                    </div>

                    <!-- Site Email -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-envelope mr-2 text-gray-400"></i>
                            Site Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" 
                               name="site_email" 
                               value="<?php echo e(old('site_email', $settingValues['site_email'] ?? '')); ?>"
                               placeholder="contact@yourstore.com"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                               required>
                        <p class="text-xs text-gray-500 mt-1">Official email address for notifications and customer inquiries</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Information Card -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-green-500 to-green-600">
                <div class="flex items-center">
                    <i class="fas fa-phone-alt text-white text-xl mr-3"></i>
                    <h2 class="text-lg font-medium text-white">Contact Information</h2>
                </div>
                <p class="text-green-100 text-sm mt-1">Store contact details for customers</p>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Site Phone -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-phone mr-2 text-gray-400"></i>
                            Phone Number <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500">+</span>
                            </div>
                            <input type="text" 
                                   name="site_phone" 
                                   value="<?php echo e(old('site_phone', $settingValues['site_phone'] ?? '')); ?>"
                                   placeholder="62 812 3456 7890"
                                   class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                   required>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Store's official phone number</p>
                    </div>

                    <!-- WhatsApp Number -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">
                            <i class="fab fa-whatsapp mr-2 text-green-500"></i>
                            WhatsApp Number <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500">+</span>
                            </div>
                            <input type="text" 
                                   name="whatsapp_number" 
                                   value="<?php echo e(old('whatsapp_number', $settingValues['whatsapp_number'] ?? '')); ?>"
                                   placeholder="62 812 3456 7890"
                                   class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                   required>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">For customer inquiries via WhatsApp</p>
                    </div>
                </div>

                <!-- Site Address -->
                <div class="mt-6 space-y-2">
                    <label class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-map-marker-alt mr-2 text-gray-400"></i>
                        Store Address
                    </label>
                    <textarea name="site_address" 
                              rows="2"
                              placeholder="Enter your store's physical address"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none"><?php echo e(old('site_address', $settingValues['site_address'] ?? '')); ?></textarea>
                    <p class="text-xs text-gray-500 mt-1">Physical location of your store (optional)</p>
                </div>

                <!-- WhatsApp Message -->
                <div class="mt-6 space-y-2">
                    <label class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-comment-dots mr-2 text-green-500"></i>
                        Default WhatsApp Message
                    </label>
                    <textarea name="whatsapp_message" 
                              rows="2"
                              placeholder="Enter default message for WhatsApp chat"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none"><?php echo e(old('whatsapp_message', $settingValues['whatsapp_message'] ?? '')); ?></textarea>
                    <p class="text-xs text-gray-500 mt-1">Pre-filled message when customers click WhatsApp button</p>
                </div>
            </div>
        </div>

        <!-- Regional Settings Card -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-purple-500 to-purple-600">
                <div class="flex items-center">
                    <i class="fas fa-globe text-white text-xl mr-3"></i>
                    <h2 class="text-lg font-medium text-white">Regional Settings</h2>
                </div>
                <p class="text-purple-100 text-sm mt-1">Configure currency and timezone</p>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Currency -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-money-bill-wave mr-2 text-gray-400"></i>
                            Currency <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <select name="currency" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors appearance-none"
                                    required>
                                <option value="">Select Currency</option>
                                <option value="IDR" <?php echo e(old('currency', $settingValues['currency'] ?? '') == 'IDR' ? 'selected' : ''); ?>>
                                    Indonesian Rupiah (IDR) - Rp
                                </option>
                                <option value="USD" <?php echo e(old('currency', $settingValues['currency'] ?? '') == 'USD' ? 'selected' : ''); ?>>
                                    US Dollar (USD) - $
                                </option>
                                <option value="SGD" <?php echo e(old('currency', $settingValues['currency'] ?? '') == 'SGD' ? 'selected' : ''); ?>>
                                    Singapore Dollar (SGD) - S$
                                </option>
                                <option value="MYR" <?php echo e(old('currency', $settingValues['currency'] ?? '') == 'MYR' ? 'selected' : ''); ?>>
                                    Malaysian Ringgit (MYR) - RM
                                </option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3">
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Primary currency for your store</p>
                    </div>

                    <!-- Timezone -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-clock mr-2 text-gray-400"></i>
                            Timezone <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <select name="timezone" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors appearance-none"
                                    required>
                                <option value="">Select Timezone</option>
                                <optgroup label="Indonesia">
                                    <option value="Asia/Jakarta" <?php echo e(old('timezone', $settingValues['timezone'] ?? '') == 'Asia/Jakarta' ? 'selected' : ''); ?>>
                                        Asia/Jakarta (WIB) - Western Indonesia Time
                                    </option>
                                    <option value="Asia/Makassar" <?php echo e(old('timezone', $settingValues['timezone'] ?? '') == 'Asia/Makassar' ? 'selected' : ''); ?>>
                                        Asia/Makassar (WITA) - Central Indonesia Time
                                    </option>
                                    <option value="Asia/Jayapura" <?php echo e(old('timezone', $settingValues['timezone'] ?? '') == 'Asia/Jayapura' ? 'selected' : ''); ?>>
                                        Asia/Jayapura (WIT) - Eastern Indonesia Time
                                    </option>
                                </optgroup>
                                <optgroup label="International">
                                    <option value="UTC" <?php echo e(old('timezone', $settingValues['timezone'] ?? '') == 'UTC' ? 'selected' : ''); ?>>
                                        UTC - Coordinated Universal Time
                                    </option>
                                    <option value="Asia/Singapore" <?php echo e(old('timezone', $settingValues['timezone'] ?? '') == 'Asia/Singapore' ? 'selected' : ''); ?>>
                                        Asia/Singapore (SGT)
                                    </option>
                                    <option value="Asia/Kuala_Lumpur" <?php echo e(old('timezone', $settingValues['timezone'] ?? '') == 'Asia/Kuala_Lumpur' ? 'selected' : ''); ?>>
                                        Asia/Kuala Lumpur (MYT)
                                    </option>
                                </optgroup>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3">
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Timezone for order timestamps and scheduling</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Maintenance Mode Card -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-yellow-500 to-orange-500">
                <div class="flex items-center">
                    <i class="fas fa-tools text-white text-xl mr-3"></i>
                    <h2 class="text-lg font-medium text-white">Maintenance & Security</h2>
                </div>
                <p class="text-yellow-100 text-sm mt-1">Store availability settings</p>
            </div>
            
            <div class="p-6">
                <!-- Maintenance Mode Toggle -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 mt-1">
                            <i class="fas fa-exclamation-triangle text-yellow-500 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900">Maintenance Mode</h3>
                            <p class="text-sm text-gray-600 mt-1">
                                When enabled, your store will be temporarily unavailable to customers. 
                                Only administrators can access the site.
                            </p>
                        </div>
                    </div>
                    
                    <div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="maintenance_mode" value="0">
                            <input type="checkbox" 
                                   name="maintenance_mode" 
                                   value="1"
                                   <?php echo e(old('maintenance_mode', $settingValues['maintenance_mode'] ?? false) ? 'checked' : ''); ?>

                                   class="sr-only peer">
                            <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-red-600"></div>
                        </label>
                    </div>
                </div>
                
                <!-- Maintenance Mode Warning -->
                <div class="mt-4 p-3 bg-red-50 border border-red-200 rounded-lg hidden" id="maintenanceWarning">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-circle text-red-500 mt-0.5 mr-2"></i>
                        <div>
                            <p class="text-sm font-medium text-red-800">Warning: Maintenance Mode Enabled</p>
                            <p class="text-sm text-red-600 mt-1">
                                Your store is currently inaccessible to customers. Only administrators can view the site.
                                Disable maintenance mode to make your store public again.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-t">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div class="text-sm text-gray-600">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        Fields marked with <span class="text-red-500">*</span> are required
                    </div>
                    
                    <div class="flex space-x-3">
                        <button type="button" 
                                onclick="resetForm()"
                                class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200 flex items-center">
                            <i class="fas fa-undo mr-2"></i>
                            Reset
                        </button>
                        
                        <button type="submit"
                                class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 flex items-center shadow-sm hover:shadow-md">
                            <i class="fas fa-save mr-2"></i>
                            Save All Settings
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* Custom select arrow */
    select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
    }
    
    select:focus {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%233b82f6' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
    }
    
    /* Custom scrollbar for select */
    select::-webkit-scrollbar {
        width: 8px;
    }
    
    select::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    select::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }
    
    select::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
    
    /* Smooth transitions */
    input, select, textarea, button {
        transition: all 0.2s ease-in-out;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Maintenance mode toggle handler
    const maintenanceToggle = document.querySelector('input[name="maintenance_mode"]');
    const maintenanceWarning = document.getElementById('maintenanceWarning');
    
    if (maintenanceToggle && maintenanceWarning) {
        // Show/hide warning based on current state
        if (maintenanceToggle.checked) {
            maintenanceWarning.classList.remove('hidden');
        }
        
        // Toggle warning on change
        maintenanceToggle.addEventListener('change', function() {
            if (this.checked) {
                maintenanceWarning.classList.remove('hidden');
            } else {
                maintenanceWarning.classList.add('hidden');
            }
        });
    }
    
    // Form validation
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            let firstErrorField = null;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('border-red-500', 'ring-2', 'ring-red-100');
                    isValid = false;
                    
                    if (!firstErrorField) {
                        firstErrorField = field;
                    }
                } else {
                    field.classList.remove('border-red-500', 'ring-2', 'ring-red-100');
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                
                // Scroll to first error field
                if (firstErrorField) {
                    firstErrorField.scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'center' 
                    });
                    firstErrorField.focus();
                }
                
                // Show error message
                showToast('Please fill in all required fields marked with *', 'error');
            }
        });
    }
    
    // Input validation feedback
    const inputs = document.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.hasAttribute('required') && !this.value.trim()) {
                this.classList.add('border-red-500');
            } else {
                this.classList.remove('border-red-500');
            }
        });
        
        input.addEventListener('input', function() {
            if (this.value.trim()) {
                this.classList.remove('border-red-500', 'ring-2', 'ring-red-100');
            }
        });
    });
    
    // Reset form button handler
    window.resetForm = function() {
        if (confirm('Are you sure you want to reset all changes? This cannot be undone.')) {
            form.reset();
            
            // Reset toggle switches
            const checkboxes = form.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            
            // Hide maintenance warning
            if (maintenanceWarning) {
                maintenanceWarning.classList.add('hidden');
            }
            
            showToast('Form has been reset to original values', 'info');
        }
    }
    
    // Toast notification function
    function showToast(message, type = 'info') {
        // Remove existing toast
        const existingToast = document.querySelector('.toast-notification');
        if (existingToast) {
            existingToast.remove();
        }
        
        // Create new toast
        const toast = document.createElement('div');
        toast.className = `toast-notification fixed top-4 right-4 z-50 px-4 py-3 rounded-lg shadow-lg transform transition-all duration-300 ${type === 'error' ? 'bg-red-100 border-l-4 border-red-500 text-red-700' : 'bg-blue-100 border-l-4 border-blue-500 text-blue-700'}`;
        
        const icon = type === 'error' ? 
            '<i class="fas fa-exclamation-circle mr-2"></i>' : 
            '<i class="fas fa-info-circle mr-2"></i>';
        
        toast.innerHTML = `
            <div class="flex items-center">
                ${icon}
                <span>${message}</span>
                <button type="button" class="ml-4 text-gray-500 hover:text-gray-700" onclick="this.parentElement.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        
        document.body.appendChild(toast);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (toast.parentElement) {
                toast.remove();
            }
        }, 5000);
    }
    
    // Phone number formatting
    const phoneInputs = document.querySelectorAll('input[name="site_phone"], input[name="whatsapp_number"]');
    phoneInputs.forEach(input => {
        input.addEventListener('input', function(e) {
            // Remove all non-digit characters
            let value = e.target.value.replace(/\D/g, '');
            
            // Format with spaces for readability
            if (value.length > 0) {
                // Remove leading zeros for country code
                if (value.startsWith('0')) {
                    value = value.substring(1);
                }
                
                // Format as 62 XXX XXXX XXXX
                if (value.length <= 2) {
                    value = value;
                } else if (value.length <= 5) {
                    value = `${value.substring(0, 2)} ${value.substring(2)}`;
                } else if (value.length <= 8) {
                    value = `${value.substring(0, 2)} ${value.substring(2, 5)} ${value.substring(5)}`;
                } else if (value.length <= 11) {
                    value = `${value.substring(0, 2)} ${value.substring(2, 5)} ${value.substring(5, 8)} ${value.substring(8)}`;
                } else {
                    value = `${value.substring(0, 2)} ${value.substring(2, 5)} ${value.substring(5, 8)} ${value.substring(8, 12)}`;
                }
            }
            
            e.target.value = value;
        });
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('pages.admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\revisiimaji\resources\views/pages/admin/settings/general/index.blade.php ENDPATH**/ ?>