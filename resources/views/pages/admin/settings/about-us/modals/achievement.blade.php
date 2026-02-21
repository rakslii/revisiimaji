<!-- Achievement Modal -->
<div id="achievementModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-lg shadow-lg rounded-lg bg-white">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Achievement Management</h3>
            <button onclick="closeModal('achievementModal')" 
                    class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form id="form-achievement" method="POST" action="{{ route('admin.settings.about-us.achievements.store') }}">
            @csrf
            <input type="hidden" name="_method" value="POST">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                    <input type="text" 
                           id="achievement_title"
                           name="title"
                           required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Icon</label>
                    <select id="achievement_icon"
                            name="icon"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">No Icon</option>
                        @foreach($iconOptions as $key => $label)
                            <option value="{{ $key }}">{{ $label }} ({{ $key }})</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Value *</label>
                    <input type="text" 
                           id="achievement_value"
                           name="value"
                           required
                           placeholder="5000"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Suffix</label>
                    <input type="text" 
                           id="achievement_suffix"
                           name="suffix"
                           placeholder="+, %, etc"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea id="achievement_description"
                          name="description"
                          rows="2"
                          placeholder="Short description..."
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Order</label>
                    <input type="number" 
                           id="achievement_order"
                           name="order"
                           min="0"
                           value="0"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div class="flex items-center">
                    <label class="flex items-center">
                        <input type="checkbox" 
                               id="achievement_is_active"
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
                        onclick="closeModal('achievementModal')"
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    <span>Add Achievement</span>
                </button>
            </div>
        </form>
    </div>
</div>