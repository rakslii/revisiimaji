@extends('pages.admin.layouts.app')

@section('title', 'Edit Promo Code')
@section('page-title', 'Edit Promo Code')
@section('page-description', 'Update discount code settings')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Edit Promo Code</h1>
            <p class="text-gray-600 mt-1">Update discount code settings</p>
        </div>
        <a href="{{ route('admin.promos.index') }}" 
           class="flex items-center gap-2 bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <form action="{{ route('admin.promos.update', $promoCode->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="p-6 space-y-6">
                <!-- Basic Information -->
                <div class="border-b pb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Basic Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Code -->
                        <div>
                            <label for="code" class="block text-sm font-medium text-gray-700 mb-1">
                                Promo Code *
                            </label>
                            <input type="text" id="code" name="code" value="{{ old('code', $promoCode->code) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   required>
                            @error('code')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                Promo Name *
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name', $promoCode->name) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Type -->
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 mb-1">
                                Discount Type *
                            </label>
                            <select id="type" name="type" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                    onchange="toggleValueField()" required>
                                <option value="">Select Type</option>
                                <option value="percentage" {{ old('type', $promoCode->type) == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                                <option value="nominal" {{ old('type', $promoCode->type) == 'nominal' ? 'selected' : '' }}>Nominal (Rp)</option>
                            </select>
                            @error('type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Value -->
                        <div>
                            <label for="value" class="block text-sm font-medium text-gray-700 mb-1">
                                Discount Value *
                            </label>
                            <div class="relative">
                                <input type="number" id="value" name="value" value="{{ old('value', $promoCode->value) }}" step="0.01"
                                       class="w-full pl-4 pr-12 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       min="0" required>
                                <span id="value-suffix" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500"></span>
                            </div>
                            @error('value')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Min Purchase -->
                        <div>
                            <label for="min_purchase" class="block text-sm font-medium text-gray-700 mb-1">
                                Minimum Purchase (Optional)
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                                <input type="number" id="min_purchase" name="min_purchase" value="{{ old('min_purchase', $promoCode->min_purchase) }}" step="1000"
                                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       min="0">
                            </div>
                            @error('min_purchase')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Quota -->
                        <div>
                            <label for="quota" class="block text-sm font-medium text-gray-700 mb-1">
                                Usage Quota *
                            </label>
                            <input type="number" id="quota" name="quota" value="{{ old('quota', $promoCode->quota) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   min="{{ $promoCode->used_count }}" required>
                            @error('quota')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Already used: {{ $promoCode->used_count }} times</p>
                        </div>
                    </div>
                </div>

                <!-- Validity Period -->
                <div class="border-b pb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Validity Period</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Valid From -->
                        <div>
                            <label for="valid_from" class="block text-sm font-medium text-gray-700 mb-1">
                                Valid From *
                            </label>
                            <input type="datetime-local" id="valid_from" name="valid_from" 
                                   value="{{ old('valid_from', $promoCode->valid_from->format('Y-m-d\TH:i')) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   required>
                            @error('valid_from')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Valid Until -->
                        <div>
                            <label for="valid_until" class="block text-sm font-medium text-gray-700 mb-1">
                                Valid Until *
                            </label>
                            <input type="datetime-local" id="valid_until" name="valid_until"
                                   value="{{ old('valid_until', $promoCode->valid_until->format('Y-m-d\TH:i')) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   required>
                            @error('valid_until')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Status</h3>
                    <div class="flex items-center">
                        <input type="checkbox" id="is_active" name="is_active" value="1" 
                               {{ old('is_active', $promoCode->is_active) ? 'checked' : '' }}
                               class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="is_active" class="ml-2 text-sm text-gray-700">
                            Activate this promo code
                        </label>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="px-6 py-4 bg-gray-50 border-t flex justify-end gap-3">
                <a href="{{ route('admin.promos.index') }}" 
                   class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <i class="fas fa-save mr-2"></i> Update Promo Code
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function toggleValueField() {
        const type = document.getElementById('type').value;
        const suffix = document.getElementById('value-suffix');
        
        if (type === 'percentage') {
            suffix.textContent = '%';
        } else if (type === 'nominal') {
            suffix.textContent = 'Rp';
        } else {
            suffix.textContent = '';
        }
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        toggleValueField();
    });
</script>
@endpush