@extends('pages.admin.layouts.app')

@section('title', 'Edit Banner')
@section('page-title', 'Edit Banner')
@section('page-description', 'Update banner information')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-blue-600">
                    <i class="fas fa-home mr-2"></i>Dashboard
                </a>
            </li>
            <li class="inline-flex items-center">
                <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                <a href="{{ route('admin.settings.banners.index') }}" class="text-gray-700 hover:text-blue-600">
                    Banners
                </a>
            </li>
            <li aria-current="page" class="inline-flex items-center">
                <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                <span class="text-blue-600 font-medium">Edit: {{ $banner->title ?? 'Banner' }}</span>
            </li>
        </ol>
    </nav>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <form action="{{ route('admin.settings.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Form Header -->
            <div class="px-6 py-4 bg-gray-50 border-b">
                <h3 class="text-lg font-medium text-gray-900">Edit Banner: {{ $banner->title ?? 'Untitled' }}</h3>
                <p class="text-sm text-gray-600 mt-1">Update the banner information below</p>
            </div>

            <!-- Form Body -->
            <div class="p-6">
                @if($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div>
                        <h4 class="font-medium text-gray-900 mb-4">Basic Information</h4>
                        
                        <!-- Title -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Title <span class="text-gray-400">(Optional)</span>
                            </label>
                            <input type="text" 
                                   name="title" 
                                   value="{{ old('title', $banner->title) }}"
                                   class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                   placeholder="e.g. Summer Sale 2024">
                            @error('title')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Subtitle -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Subtitle <span class="text-gray-400">(Optional)</span>
                            </label>
                            <input type="text" 
                                   name="subtitle" 
                                   value="{{ old('subtitle', $banner->subtitle) }}"
                                   class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                   placeholder="e.g. Up to 50% off">
                            @error('subtitle')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Description <span class="text-gray-400">(Optional)</span>
                            </label>
                            <textarea name="description" 
                                      rows="4"
                                      class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                      placeholder="Brief description of the promotion...">{{ old('description', $banner->description) }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Link -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Link URL <span class="text-gray-400">(Optional)</span>
                            </label>
                            <input type="url" 
                                   name="link" 
                                   value="{{ old('link', $banner->link) }}"
                                   placeholder="https://example.com/promo"
                                   class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            <p class="text-xs text-gray-500 mt-1">Leave empty if no link</p>
                            @error('link')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Button Text -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Button Text
                            </label>
                            <input type="text" 
                                   name="button_text" 
                                   value="{{ old('button_text', $banner->button_text) }}"
                                   class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            @error('button_text')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div>
                        <h4 class="font-medium text-gray-900 mb-4">Images & Settings</h4>
                        
                        <!-- Current Image -->
                        @if($banner->image_url)
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Current Image</label>
                            <div class="relative w-48 h-32 rounded-lg overflow-hidden border">
                                <img src="{{ $banner->image_url }}" alt="{{ $banner->title }}" class="w-full h-full object-cover">
                            </div>
                        </div>
                        @endif

                        <!-- Main Image Upload -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                New Banner Image <span class="text-gray-400">(Optional)</span>
                            </label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-blue-400 transition-colors">
                                <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                                <p class="text-sm text-gray-600">Click to upload new image</p>
                                <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF, WEBP up to 2MB</p>
                                <input type="file" 
                                       name="image" 
                                       id="image-input"
                                       accept="image/*"
                                       class="w-full mt-2">
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Leave empty to keep current image</p>
                            @error('image')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Mobile Image Upload -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                New Mobile Image <span class="text-gray-400">(Optional)</span>
                            </label>
                            <input type="file" 
                                   name="mobile_image" 
                                   accept="image/*"
                                   class="w-full rounded-lg border-gray-300">
                            <p class="text-xs text-gray-500 mt-1">Leave empty to keep current mobile image</p>
                            @error('mobile_image')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Display Order -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Display Order
                            </label>
                            <input type="number" 
                                   name="display_order" 
                                   value="{{ old('display_order', $banner->display_order) }}"
                                   min="0"
                                   class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <!-- Active Status -->
                        <div class="mb-4">
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       name="is_active" 
                                       value="1"
                                       {{ old('is_active', $banner->is_active) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Active</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Popup Settings (Only for popup type) -->
                @if($banner->type == 'popup')
                <div class="mt-8 pt-6 border-t">
                    <h4 class="font-medium text-gray-900 mb-4">Popup Settings</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Position -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Position</label>
                            <select name="position" class="w-full rounded-lg border-gray-300">
                                <option value="center" {{ old('position', $banner->position) == 'center' ? 'selected' : '' }}>Center</option>
                                <option value="top" {{ old('position', $banner->position) == 'top' ? 'selected' : '' }}>Top</option>
                                <option value="bottom" {{ old('position', $banner->position) == 'bottom' ? 'selected' : '' }}>Bottom</option>
                                <option value="left" {{ old('position', $banner->position) == 'left' ? 'selected' : '' }}>Left</option>
                                <option value="right" {{ old('position', $banner->position) == 'right' ? 'selected' : '' }}>Right</option>
                            </select>
                        </div>

                        <!-- Size -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Size</label>
                            <select name="size" class="w-full rounded-lg border-gray-300">
                                <option value="small" {{ old('size', $banner->size) == 'small' ? 'selected' : '' }}>Small</option>
                                <option value="medium" {{ old('size', $banner->size) == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="large" {{ old('size', $banner->size) == 'large' ? 'selected' : '' }}>Large</option>
                                <option value="full" {{ old('size', $banner->size) == 'full' ? 'selected' : '' }}>Full Screen</option>
                            </select>
                        </div>

                        <!-- Delay -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Delay (seconds)</label>
                            <input type="number" 
                                   name="delay_seconds" 
                                   value="{{ old('delay_seconds', $banner->delay_seconds) }}"
                                   min="0"
                                   max="60"
                                   class="w-full rounded-lg border-gray-300">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="show_close_button" value="1" {{ old('show_close_button', $banner->show_close_button) ? 'checked' : '' }} class="rounded">
                            <span class="ml-2 text-sm text-gray-700">Show close button</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="show_once_per_session" value="1" {{ old('show_once_per_session', $banner->show_once_per_session) ? 'checked' : '' }} class="rounded">
                            <span class="ml-2 text-sm text-gray-700">Show once per session</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="show_on_mobile" value="1" {{ old('show_on_mobile', $banner->show_on_mobile) ? 'checked' : '' }} class="rounded">
                            <span class="ml-2 text-sm text-gray-700">Show on mobile</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="show_on_desktop" value="1" {{ old('show_on_desktop', $banner->show_on_desktop) ? 'checked' : '' }} class="rounded">
                            <span class="ml-2 text-sm text-gray-700">Show on desktop</span>
                        </label>
                    </div>
                </div>

                <!-- Background Settings -->
                <div class="mt-6 pt-6 border-t">
                    <h4 class="font-medium text-gray-900 mb-4">Background Settings</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Background Color</label>
                            <div class="flex items-center">
                                <input type="color" 
                                       name="background_color" 
                                       value="{{ old('background_color', $banner->background_color ?? '#ffffff') }}"
                                       class="w-12 h-10 rounded border-gray-300 mr-2">
                                <input type="text" 
                                       value="{{ old('background_color', $banner->background_color ?? '#ffffff') }}"
                                       class="flex-1 rounded-lg border-gray-300"
                                       id="background_color_text">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Background Opacity (%)</label>
                            <input type="number" 
                                   name="background_opacity" 
                                   value="{{ old('background_opacity', $banner->background_opacity ?? 100) }}"
                                   min="0"
                                   max="100"
                                   class="w-full rounded-lg border-gray-300">
                        </div>
                    </div>
                </div>
                @endif

                <!-- Date Settings -->
                <div class="mt-6 pt-6 border-t">
                    <h4 class="font-medium text-gray-900 mb-4">Schedule (Optional)</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                            <input type="datetime-local" 
                                   name="start_date" 
                                   value="{{ old('start_date', $banner->start_date ? $banner->start_date->format('Y-m-d\TH:i') : '') }}"
                                   class="w-full rounded-lg border-gray-300">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                            <input type="datetime-local" 
                                   name="end_date" 
                                   value="{{ old('end_date', $banner->end_date ? $banner->end_date->format('Y-m-d\TH:i') : '') }}"
                                   class="w-full rounded-lg border-gray-300">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Footer -->
            <div class="px-6 py-4 bg-gray-50 border-t flex justify-end space-x-3">
                <a href="{{ route('admin.settings.banners.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                    <i class="fas fa-save mr-2"></i>
                    Update Banner
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
// Sync color input with text input
const colorInput = document.querySelector('input[name="background_color"]');
const colorText = document.getElementById('background_color_text');
if (colorInput && colorText) {
    colorInput.addEventListener('input', function() {
        colorText.value = this.value;
    });
    colorText.addEventListener('input', function() {
        colorInput.value = this.value;
    });
}
</script>
@endpush
@endsection