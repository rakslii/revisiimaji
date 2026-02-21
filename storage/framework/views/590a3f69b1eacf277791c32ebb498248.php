<!-- General Consultation Modal -->
<div id="generalModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-lg bg-white">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Add General Consultation Link</h3>
            <button onclick="closeModal('generalModal')" 
                    class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form id="form-general" method="POST" action="<?php echo e(route('admin.settings.consultations.general.store')); ?>">
            <?php echo csrf_field(); ?>
            <form id="form-general" method="POST" action="<?php echo e(route('admin.settings.consultations.general.store')); ?>">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="_method" value="POST"> 
    
            <input type="hidden" name="_method" value="POST">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Name *</label>
                    <input type="text" 
                           id="general_name"
                           name="name"
                           required
                           placeholder="e.g., CS Marketing, Support Team"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                    <input type="text" 
                           id="general_phone"
                           name="phone_number"
                           required
                           placeholder="081234567890"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Format: 08xxx atau 628xxx</p>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Display Text *</label>
                    <input type="text" 
                           id="general_display_text"
                           name="display_text"
                           required
                           value="Chat WhatsApp"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Icon</label>
                    <select id="general_icon" name="icon" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="fab fa-whatsapp">WhatsApp</option>
                        <option value="fas fa-phone">Phone</option>
                        <option value="fas fa-headset">Headset</option>
                        <option value="fas fa-comments">Comments</option>
                        <option value="fas fa-envelope">Email</option>
                        <option value="fas fa-message">Message</option>
                    </select>
                </div>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Location *</label>
                <select id="general_location" name="location" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="navbar">Navbar</option>
                    <option value="footer">Footer</option>
                    <option value="cta_section">CTA Section (Home)</option>
                    <option value="floating_button">Floating Button</option>
                    <option value="all">All Locations</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Message Template (Optional)</label>
                <textarea id="general_message_template"
                          name="message_template"
                          rows="3"
                          placeholder="Halo, saya ingin konsultasi. Bisa dibantu?"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                <p class="text-xs text-gray-500 mt-1">Gunakan [NAME] untuk nama customer</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Order</label>
                    <input type="number" 
                           id="general_order"
                           name="order"
                           min="0"
                           value="0"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div class="flex items-center">
                    <label class="flex items-center">
                        <input type="checkbox" 
                               id="general_is_active"
                               name="is_active"
                               value="1"
                               checked
                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-600">Active</span>
                    </label>
                </div>
            </div>
            
            <div class="flex justify-end space-x-3">
                <button type="button"
                        onclick="closeModal('generalModal')"
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    <span>Add Link</span>
                </button>
            </div>
        </form>
    </div>
</div><?php /**PATH C:\laragon\www\revisiimaji\resources\views/pages/admin/settings/consultations/modals/general-modal.blade.php ENDPATH**/ ?>