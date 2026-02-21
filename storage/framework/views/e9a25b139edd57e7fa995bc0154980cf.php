<!-- Product Consultation Modal -->
<div id="productModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-3xl shadow-lg rounded-lg bg-white">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Add Product Consultation Link</h3>
            <button onclick="closeModal('productModal')" 
                    class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form id="form-product" method="POST" action="<?php echo e(route('admin.settings.consultations.product.store')); ?>">
            <?php echo csrf_field(); ?>
            <form id="form-product" method="POST" action="<?php echo e(route('admin.settings.consultations.product.store')); ?>">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="_method" value="POST"> 
    
            <input type="hidden" name="_method" value="POST">
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Select Product *</label>
                <select id="product_product_id" name="product_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">-- Select Product --</option>
                    <?php $__currentLoopData = $allProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($product->id); ?>"><?php echo e($product->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alias Name (Optional)</label>
                    <input type="text" 
                           id="product_name"
                           name="name"
                           placeholder="e.g., CS Produk A"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                    <input type="text" 
                           id="product_phone"
                           name="phone_number"
                           required
                           placeholder="081234567890"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Display Text *</label>
                    <input type="text" 
                           id="product_display_text"
                           name="display_text"
                           required
                           value="Konsultasi via WhatsApp"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Icon</label>
                    <select id="product_icon" name="icon" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="fab fa-whatsapp">WhatsApp</option>
                        <option value="fas fa-phone">Phone</option>
                        <option value="fas fa-headset">Headset</option>
                        <option value="fas fa-comments">Comments</option>
                    </select>
                </div>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Message Template (Auto)</label>
                <textarea id="product_message_template"
                          name="message_template"
                          rows="2"
                          placeholder="Halo, saya tertarik dengan produk [PRODUCT_NAME]. Bisa info lebih lanjut?"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                <p class="text-xs text-gray-500 mt-1">
                    Variables: [PRODUCT_NAME], [PRODUCT_PRICE], [PRODUCT_CATEGORY], [PRODUCT_URL], [CUSTOMER_NAME]
                </p>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Custom Message (Manual - override template)</label>
                <textarea id="product_custom_message"
                          name="custom_message"
                          rows="2"
                          placeholder="Pesan khusus untuk produk ini..."
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Message Format</label>
                    <select id="product_message_format" name="message_format" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="text">Plain Text</option>
                        <option value="markdown">Markdown</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Button Color</label>
                    <input type="color" 
                           id="product_button_color"
                           name="button_color"
                           value="#25D366"
                           class="w-full h-10 border border-gray-300 rounded-lg">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Button Style</label>
                    <select id="product_button_style" name="button_style" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="solid">Solid</option>
                        <option value="outline">Outline</option>
                        <option value="gradient">Gradient</option>
                    </select>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="flex items-center">
                    <label class="flex items-center">
                        <input type="checkbox" 
                               id="product_show_price"
                               name="show_price_in_message"
                               value="1"
                               checked
                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-600">Show price in message</span>
                    </label>
                </div>
                
                <div class="flex items-center">
                    <label class="flex items-center">
                        <input type="checkbox" 
                               id="product_is_active"
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
                        onclick="closeModal('productModal')"
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    <span>Add Product Link</span>
                </button>
            </div>
        </form>
    </div>
</div><?php /**PATH C:\laragon\www\revisiimaji\resources\views/pages/admin/settings/consultations/modals/product-modal.blade.php ENDPATH**/ ?>