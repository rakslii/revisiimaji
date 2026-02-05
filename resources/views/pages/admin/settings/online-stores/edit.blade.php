@extends('pages.admin.layouts.app')

@section('title', 'Edit Online Store')
@section('page-title', 'Edit Online Store')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.settings.online-stores.update', $store->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Store Name *</label>
                    <input type="text" 
                           name="name" 
                           id="name"
                           value="{{ old('name', $store->name) }}"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Platform -->
                <div>
                    <label for="platform" class="block text-sm font-medium text-gray-700 mb-2">Platform *</label>
                    <select name="platform" 
                            id="platform"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                            required>
                        <option value="">Select Platform</option>
                        <option value="ecommerce" {{ old('platform', $store->platform) == 'ecommerce' ? 'selected' : '' }}>E-commerce</option>
                        <option value="social_media" {{ old('platform', $store->platform) == 'social_media' ? 'selected' : '' }}>Social Media</option>
                        <option value="marketplace" {{ old('platform', $store->platform) == 'marketplace' ? 'selected' : '' }}>Marketplace</option>
                    </select>
                    @error('platform')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- URL -->
                <div>
                    <label for="url" class="block text-sm font-medium text-gray-700 mb-2">Store URL *</label>
                    <input type="url" 
                           name="url" 
                           id="url"
                           value="{{ old('url', $store->url) }}"
                           placeholder="https://example.com/store"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                           required>
                    @error('url')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Store Username -->
                <div>
                    <label for="store_username" class="block text-sm font-medium text-gray-700 mb-2">Store Username (Optional)</label>
                    <input type="text" 
                           name="store_username" 
                           id="store_username"
                           value="{{ old('store_username', $store->store_username) }}"
                           placeholder="@username or store-id"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                    @error('store_username')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description (Optional)</label>
                    <textarea name="description" 
                              id="description"
                              rows="3"
                              class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('description', $store->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Color Settings -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Primary Color -->
                    <div>
                        <label for="color" class="block text-sm font-medium text-gray-700 mb-2">Primary Color</label>
                        <div class="flex items-center">
                            <input type="color" 
                                   name="color" 
                                   id="color"
                                   value="{{ old('color', $store->color ?: '#193497') }}"
                                   class="w-10 h-10 border rounded mr-2">
                            <input type="text" 
                                   id="color_text"
                                   value="{{ old('color', $store->color ?: '#193497') }}"
                                   class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                        @error('color')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Gradient From -->
                    <div>
                        <label for="gradient_from" class="block text-sm font-medium text-gray-700 mb-2">Gradient Start</label>
                        <div class="flex items-center">
                            <input type="color" 
                                   name="gradient_from" 
                                   id="gradient_from"
                                   value="{{ old('gradient_from', $store->gradient_from ?: '#193497') }}"
                                   class="w-10 h-10 border rounded mr-2">
                            <input type="text" 
                                   id="gradient_from_text"
                                   value="{{ old('gradient_from', $store->gradient_from ?: '#193497') }}"
                                   class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                        @error('gradient_from')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Gradient To -->
                    <div>
                        <label for="gradient_to" class="block text-sm font-medium text-gray-700 mb-2">Gradient End</label>
                        <div class="flex items-center">
                            <input type="color" 
                                   name="gradient_to" 
                                   id="gradient_to"
                                   value="{{ old('gradient_to', $store->gradient_to ?: '#720e87') }}"
                                   class="w-10 h-10 border rounded mr-2">
                            <input type="text" 
                                   id="gradient_to_text"
                                   value="{{ old('gradient_to', $store->gradient_to ?: '#720e87') }}"
                                   class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                        @error('gradient_to')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Icon Class -->
                <div>
                    <label for="icon_class" class="block text-sm font-medium text-gray-700 mb-2">Icon Class (FontAwesome)</label>
                    <input type="text" 
                           name="icon_class" 
                           id="icon_class"
                           value="{{ old('icon_class', $store->icon_class ?: 'fas fa-store') }}"
                           placeholder="fas fa-store"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                    <p class="mt-1 text-sm text-gray-500">Example: fas fa-store, fab fa-shopify, fab fa-whatsapp</p>
                    @error('icon_class')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Order & Status -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Order -->
                    <div>
                        <label for="order" class="block text-sm font-medium text-gray-700 mb-2">Display Order</label>
                        <input type="number" 
                               name="order" 
                               id="order"
                               value="{{ old('order', $store->order) }}"
                               min="0"
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        @error('order')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <div class="flex items-center space-x-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" 
                                       name="is_active" 
                                       value="1"
                                       {{ old('is_active', $store->is_active) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-600">Active</span>
                            </label>
                        </div>
                        @error('is_active')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Buttons -->
                <div class="pt-6 flex space-x-4">
                    <button type="submit"
                            class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        <i class="fas fa-save mr-2"></i>Update Store
                    </button>
                    <a href="{{ route('admin.settings.online-stores.index') }}"
                       class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Update color text input when color picker changes
    document.getElementById('color').addEventListener('input', function(e) {
        document.getElementById('color_text').value = e.target.value;
    });
    
    document.getElementById('gradient_from').addEventListener('input', function(e) {
        document.getElementById('gradient_from_text').value = e.target.value;
    });
    
    document.getElementById('gradient_to').addEventListener('input', function(e) {
        document.getElementById('gradient_to_text').value = e.target.value;
    });
    
    // Update color picker when text input changes
    document.getElementById('color_text').addEventListener('input', function(e) {
        document.getElementById('color').value = e.target.value;
    });
    
    document.getElementById('gradient_from_text').addEventListener('input', function(e) {
        document.getElementById('gradient_from').value = e.target.value;
    });
    
    document.getElementById('gradient_to_text').addEventListener('input', function(e) {
        document.getElementById('gradient_to').value = e.target.value;
    });
</script>
@endpush