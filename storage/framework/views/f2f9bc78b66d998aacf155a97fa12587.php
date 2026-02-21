<!-- Custom Product Modal -->
<div id="customModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-3xl shadow-lg rounded-lg bg-white">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Add Custom Product</h3>
            <button onclick="closeModal('customModal')" 
                    class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form id="form-custom" method="POST" action="<?php echo e(route('admin.settings.consultations.custom.store')); ?>">
            <?php echo csrf_field(); ?>
            <form id="form-custom" method="POST" action="<?php echo e(route('admin.settings.consultations.custom.store')); ?>">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="_method" value="POST"> 
    
            <input type="hidden" name="_method" value="POST">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Product Name *</label>
                    <input type="text" 
                           id="custom_name"
                           name="name"
                           required
                           placeholder="e.g., Kaos Custom, Stiker Custom"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Slug</label>
                    <input type="text" 
                           id="custom_slug"
                           name="slug"
                           placeholder="auto-generated"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea id="custom_description"
                          name="description"
                          rows="2"
                          placeholder="Deskripsi produk custom..."
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                    <input type="text" 
                           id="custom_phone"
                           name="phone_number"
                           required
                           placeholder="081234567890"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Display Text *</label>
                    <input type="text" 
                           id="custom_display_text"
                           name="display_text"
                           required
                           value="Konsultasi Produk Custom"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Icon</label>
                    <select id="custom_icon" name="icon" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="fab fa-whatsapp">WhatsApp</option>
                        <option value="fas fa-paint-brush">Paint Brush</option>
                        <option value="fas fa-crop-alt">Crop</option>
                        <option value="fas fa-pencil-ruler">Pencil Ruler</option>
                        <option value="fas fa-tshirt">T-Shirt</option>
                        <option value="fas fa-mug-hot">Mug</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Order</label>
                    <input type="number" 
                           id="custom_order"
                           name="order"
                           min="0"
                           value="0"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Message Template</label>
                <textarea id="custom_message_template"
                          name="message_template"
                          rows="2"
                          placeholder="Halo, saya ingin konsultasi tentang [PRODUCT_NAME]. Bisa dibantu?"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                <p class="text-xs text-gray-500 mt-1">Gunakan [PRODUCT_NAME] untuk nama produk</p>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Custom Fields (JSON Format)</label>
                <textarea id="custom_custom_fields"
                          name="custom_fields"
                          rows="4"
                          placeholder='[{"name": "Jenis Bahan", "type": "select", "options": ["Katun", "Polyester"]}, {"name": "Ukuran", "type": "text"}, {"name": "Jumlah", "type": "number"}]'
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 font-mono text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                <p class="text-xs text-gray-500 mt-1">JSON array untuk field tambahan yang akan diisi customer</p>
            </div>
            
            <div class="mb-6">
                <label class="flex items-center">
                    <input type="checkbox" 
                           id="custom_is_active"
                           name="is_active"
                           value="1"
                           checked
                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-600">Active</span>
                </label>
            </div>
            
            <div class="flex justify-end space-x-3">
                <button type="button"
                        onclick="closeModal('customModal')"
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    <span>Add Custom Product</span>
                </button>
            </div>
        </form>
    </div>
</div><?php /**PATH C:\laragon\www\revisiimaji\resources\views/pages/admin/settings/consultations/modals/custom-modal.blade.php ENDPATH**/ ?>