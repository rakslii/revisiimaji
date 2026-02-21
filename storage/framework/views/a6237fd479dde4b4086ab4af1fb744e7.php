<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 bg-gray-50 border-b">
        <div class="text-sm text-gray-600">
            Showing <?php echo e($products->count()); ?> product consultation links
        </div>
    </div>
    
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone Number</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Display Text</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="h-10 w-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="<?php echo e($item->icon ?? 'fab fa-whatsapp'); ?> text-green-600"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-900"><?php echo e($item->product->name ?? 'Unknown Product'); ?></div>
                                <div class="text-sm text-gray-500"><?php echo e($item->name ?? 'No alias'); ?></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-sm text-gray-900"><?php echo e($item->phone_number); ?></span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-sm text-gray-600"><?php echo e($item->display_text); ?></span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($item->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                            <i class="fas fa-circle mr-1 text-xs"></i>
                            <?php echo e($item->is_active ? 'Active' : 'Inactive'); ?>

                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <div class="flex space-x-3">
                            <button onclick="editProduct(<?php echo e($item->id); ?>)" 
                                    class="text-blue-600 hover:text-blue-900 transition-colors"
                                    title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            
                            <form action="<?php echo e(route('admin.settings.consultations.product.toggle', $item->id)); ?>" 
                                  method="POST" 
                                  class="inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" 
                                        class="<?php echo e($item->is_active ? 'text-yellow-600 hover:text-yellow-900' : 'text-green-600 hover:text-green-900'); ?> transition-colors"
                                        title="<?php echo e($item->is_active ? 'Deactivate' : 'Activate'); ?>">
                                    <i class="fas <?php echo e($item->is_active ? 'fa-pause' : 'fa-play'); ?>"></i>
                                </button>
                            </form>
                            
                            <form action="<?php echo e(route('admin.settings.consultations.product.destroy', $item->id)); ?>" 
                                  method="POST" 
                                  class="inline"
                                  onsubmit="return confirm('Delete this product consultation link? This action cannot be undone.')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" 
                                        class="text-red-600 hover:text-red-900 transition-colors"
                                        title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            
                            <a href="https://wa.me/<?php echo e(preg_replace('/[^0-9]/', '', $item->phone_number)); ?>?text=<?php echo e(urlencode($item->message_template ?? 'Halo, saya ingin konsultasi tentang produk ini')); ?>" 
                               target="_blank"
                               class="text-green-600 hover:text-green-900 transition-colors"
                               title="Test Link">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                        <i class="fas fa-box-open text-4xl mb-4 text-gray-300"></i>
                        <p class="text-lg">No product consultation links found</p>
                        <p class="text-sm mt-2">Click "Add Product Link" to create consultation for a product</p>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
function editProduct(id) {
    fetch(`/admin/settings/consultations/product/${id}/edit`)
        .then(response => response.json())
        .then(data => {
            // Populate form
            document.getElementById('product_product_id').value = data.product_id;
            document.getElementById('product_name').value = data.name || '';
            document.getElementById('product_phone').value = data.phone_number;
            document.getElementById('product_display_text').value = data.display_text;
            document.getElementById('product_message_template').value = data.message_template || '';
            document.getElementById('product_custom_message').value = data.custom_message || '';
            document.getElementById('product_message_format').value = data.message_format;
            document.getElementById('product_icon').value = data.icon || 'fab fa-whatsapp';
            document.getElementById('product_button_color').value = data.button_color || '#25D366';
            document.getElementById('product_button_style').value = data.button_style;
            document.getElementById('product_show_price').checked = data.show_price_in_message;
            document.getElementById('product_is_active').checked = data.is_active;
            
            // SET FORM ACTION DAN METHOD
            const form = document.getElementById('form-product');
            
            // SET ACTION URL DENGAN ID
            form.action = `/admin/settings/consultations/product/${id}`;
            
            // SET METHOD SPOOFING
            let methodInput = form.querySelector('input[name="_method"]');
            if (!methodInput) {
                methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                form.appendChild(methodInput);
            }
            methodInput.value = 'PUT';
            
            // Ganti judul modal
            document.querySelector('#productModal h3').textContent = 'Edit Product Consultation';
            document.querySelector('#productModal button[type="submit"] span').textContent = 'Update';
            
            openModal('productModal');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to load data');
        });
}
</script><?php /**PATH C:\laragon\www\revisiimaji\resources\views/pages/admin/settings/consultations/partials/product-table.blade.php ENDPATH**/ ?>