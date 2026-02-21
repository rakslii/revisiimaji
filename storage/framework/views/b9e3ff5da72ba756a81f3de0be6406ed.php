<!-- Section Modal -->
<div id="sectionModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-lg bg-white">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Section Management</h3>
            <button onclick="closeModal('sectionModal')" 
                    class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form id="form-section" method="POST" action="<?php echo e(route('admin.settings.about-us.sections.store')); ?>">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="_method" value="POST">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                    <input type="text" 
                           id="section_title"
                           name="title"
                           required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Subtitle</label>
                    <input type="text" 
                           id="section_subtitle"
                           name="subtitle"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Content (HTML allowed)</label>
                <textarea id="section_content"
                          name="content"
                          rows="4"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Section Type *</label>
                    <select id="section_type"
                            name="section_type"
                            required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select Type</option>
                        <?php $__currentLoopData = $sectionTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($key); ?>"><?php echo e($label); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Position</label>
                    <select id="section_position"
                            name="position"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="main">Main</option>
                        <option value="sidebar">Sidebar</option>
                        <option value="footer">Footer</option>
                    </select>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Order</label>
                    <input type="number" 
                           id="section_order"
                           name="order"
                           min="0"
                           value="0"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
            
            <div class="mb-6">
                <label class="flex items-center">
                    <input type="checkbox" 
                           id="section_is_active"
                           name="is_active"
                           value="1"
                           checked
                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-600">Active (visible on website)</span>
                </label>
            </div>
            
            <div class="flex justify-end space-x-3">
                <button type="button"
                        onclick="closeModal('sectionModal')"
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    <span>Add Section</span>
                </button>
            </div>
        </form>
    </div>
</div><?php /**PATH C:\laragon\www\revisiimaji\resources\views/pages/admin/settings/about-us/modals/section.blade.php ENDPATH**/ ?>