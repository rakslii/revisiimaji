@extends('pages.admin.layouts.app')

@section('title', 'General Settings')
@section('page-title', 'General Settings')
@section('page-description', 'Basic store configuration')

@section('content')
<div class="space-y-6">
    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- General Settings Form -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b">
            <h2 class="text-xl font-semibold">Store Information</h2>
            <p class="text-gray-600 text-sm mt-1">Basic information about your store</p>
        </div>

        <form method="POST" action="{{ route('admin.settings.general.update') }}" class="p-6">
            @csrf

            <div class="space-y-6">
                <!-- Site Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Site Name *</label>
                    <input type="text" 
                           name="site_name" 
                           value="{{ old('site_name', $settingValues['site_name'] ?? '') }}"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                           required>
                    @error('site_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Site Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Site Email *</label>
                    <input type="email" 
                           name="site_email" 
                           value="{{ old('site_email', $settingValues['site_email'] ?? '') }}"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                           required>
                    @error('site_email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Site Phone -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Site Phone *</label>
                        <input type="text" 
                               name="site_phone" 
                               value="{{ old('site_phone', $settingValues['site_phone'] ?? '') }}"
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                               required>
                        @error('site_phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- WhatsApp Number -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">WhatsApp Number *</label>
                        <input type="text" 
                               name="whatsapp_number" 
                               value="{{ old('whatsapp_number', $settingValues['whatsapp_number'] ?? '') }}"
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                               placeholder="6281234567890"
                               required>
                        @error('whatsapp_number')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- WhatsApp Message -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Default WhatsApp Message</label>
                    <textarea name="whatsapp_message" 
                              rows="3"
                              class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('whatsapp_message', $settingValues['whatsapp_message'] ?? '') }}</textarea>
                    <p class="mt-1 text-sm text-gray-500">Default message when customers contact via WhatsApp</p>
                    @error('whatsapp_message')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Site Address -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Store Address</label>
                    <textarea name="site_address" 
                              rows="3"
                              class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('site_address', $settingValues['site_address'] ?? '') }}</textarea>
                    @error('site_address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Currency & Timezone -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Currency -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Currency *</label>
                        <select name="currency" 
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                                required>
                            <option value="IDR" {{ old('currency', $settingValues['currency'] ?? '') == 'IDR' ? 'selected' : '' }}>Indonesian Rupiah (IDR)</option>
                            <option value="USD" {{ old('currency', $settingValues['currency'] ?? '') == 'USD' ? 'selected' : '' }}>US Dollar (USD)</option>
                            <option value="SGD" {{ old('currency', $settingValues['currency'] ?? '') == 'SGD' ? 'selected' : '' }}>Singapore Dollar (SGD)</option>
                            <option value="MYR" {{ old('currency', $settingValues['currency'] ?? '') == 'MYR' ? 'selected' : '' }}>Malaysian Ringgit (MYR)</option>
                        </select>
                        @error('currency')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Timezone -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Timezone *</label>
                        <select name="timezone" 
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                                required>
                            <option value="Asia/Jakarta" {{ old('timezone', $settingValues['timezone'] ?? '') == 'Asia/Jakarta' ? 'selected' : '' }}>Asia/Jakarta (WIB)</option>
                            <option value="Asia/Makassar" {{ old('timezone', $settingValues['timezone'] ?? '') == 'Asia/Makassar' ? 'selected' : '' }}>Asia/Makassar (WITA)</option>
                            <option value="Asia/Jayapura" {{ old('timezone', $settingValues['timezone'] ?? '') == 'Asia/Jayapura' ? 'selected' : '' }}>Asia/Jayapura (WIT)</option>
                            <option value="UTC" {{ old('timezone', $settingValues['timezone'] ?? '') == 'UTC' ? 'selected' : '' }}>UTC</option>
                        </select>
                        @error('timezone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Maintenance Mode -->
                <div class="border-t pt-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Maintenance Mode</h3>
                            <p class="text-sm text-gray-500">When enabled, your store will be temporarily unavailable to customers</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" 
                                   name="maintenance_mode" 
                                   value="1"
                                   {{ old('maintenance_mode', $settingValues['maintenance_mode'] ?? false) ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-600"></div>
                        </label>
                    </div>
                    @error('maintenance_mode')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="pt-6">
                    <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Save Settings
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection