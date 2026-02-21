<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 bg-gray-50 border-b">
        <div class="text-sm text-gray-600">
            Showing <?php echo e($custom->count()); ?> custom product consultation links
        </div>
    </div>
    
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone Number</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Slug</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php $__empty_1 = true; $__currentLoopData = $custom; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50 draggable-item" draggable="true" data-id="<?php echo e($item->id); ?>">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <i class="fas fa-grip-vertical text-gray-400 mr-2 cursor-move"></i>
                            <span class="order-number text-sm text-gray-600"><?php echo e($item->order + 1); ?></span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="h-10 w-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="<?php echo e($item->icon ?? 'fab fa-whatsapp'); ?> text-purple-600"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-900"><?php echo e($item->name); ?></div>
                                <div class="text-sm text-gray-500"><?php echo e($item->display_text); ?></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-sm text-gray-900"><?php echo e($item->phone_number); ?></span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-xs text-gray-500"><?php echo e($item->slug); ?></span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($item->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                            <i class="fas fa-circle mr-1 text-xs"></i>
                            <?php echo e($item->is_active ? 'Active' : 'Inactive'); ?>

                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <div class="flex space-x-3">
                            <button onclick="editCustom(<?php echo e($item->id); ?>)" 
                                    class="text-blue-600 hover:text-blue-900 transition-colors"
                                    title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            
                            <form action="<?php echo e(route('admin.settings.consultations.custom.toggle', $item->id)); ?>" 
                                  method="POST" 
                                  class="inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" 
                                        class="<?php echo e($item->is_active ? 'text-yellow-600 hover:text-yellow-900' : 'text-green-600 hover:text-green-900'); ?> transition-colors"
                                        title="<?php echo e($item->is_active ? 'Deactivate' : 'Activate'); ?>">
                                    <i class="fas <?php echo e($item->is_active ? 'fa-pause' : 'fa-play'); ?>"></i>
                                </button>
                            </form>
                            
                            <form action="<?php echo e(route('admin.settings.consultations.custom.destroy', $item->id)); ?>" 
                                  method="POST" 
                                  class="inline"
                                  onsubmit="return confirm('Delete this custom product? This action cannot be undone.')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" 
                                        class="text-red-600 hover:text-red-900 transition-colors"
                                        title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            
                            <a href="<?php echo e(route('custom.product', $item->slug)); ?>" 
                               target="_blank"
                               class="text-gray-600 hover:text-gray-900 transition-colors"
                               title="View Page">
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        <i class="fas fa-paint-brush text-4xl mb-4 text-gray-300"></i>
                        <p class="text-lg">No custom products found</p>
                        <p class="text-sm mt-2">Click "Add Custom Product" to create a custom product consultation</p>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
function editCustom(id) {
    fetch(`/admin/settings/consultations/custom/${id}/edit`)
        .then(response => response.json())
        .then(data => {
            // Populate form
            document.getElementById('custom_name').value = data.name;
            document.getElementById('custom_slug').value = data.slug;
            document.getElementById('custom_description').value = data.description || '';
            document.getElementById('custom_phone').value = data.phone_number;
            document.getElementById('custom_display_text').value = data.display_text;
            document.getElementById('custom_icon').value = data.icon || 'fab fa-whatsapp';
            document.getElementById('custom_message_template').value = data.message_template || '';
            document.getElementById('custom_custom_fields').value = JSON.stringify(data.custom_fields, null, 2) || '';
            document.getElementById('custom_order').value = data.order;
            document.getElementById('custom_is_active').checked = data.is_active;
            
            // SET FORM ACTION DAN METHOD
            const form = document.getElementById('form-custom');
            
            // SET ACTION URL DENGAN ID
            form.action = `/admin/settings/consultations/custom/${id}`;
            
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
            document.querySelector('#customModal h3').textContent = 'Edit Custom Product';
            document.querySelector('#customModal button[type="submit"] span').textContent = 'Update';
            
            openModal('customModal');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to load data');
        });
}
</script><?php /**PATH C:\laragon\www\revisiimaji\resources\views/pages/admin/settings/consultations/partials/custom-table.blade.php ENDPATH**/ ?>