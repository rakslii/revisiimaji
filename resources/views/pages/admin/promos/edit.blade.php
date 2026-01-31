@extends('pages.admin.layouts.app')

@section('title', 'Edit Promo Code')
@section('page-title', 'Edit Promo Code')
@section('page-description', 'Update promo code details')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6">
            <form action="{{ route('admin.promos.update', $promoCode->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    <!-- Code Field -->
                    <div>
                        <label for="code" class="block text-sm font-medium text-gray-700 mb-1">
                            Promo Code *
                        </label>
                        <input type="text" 
                               name="code" 
                               id="code"
                               value="{{ old('code', $promoCode->code) }}"
                               required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('code')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Name Field -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                            Promo Name *
                        </label>
                        <input type="text" 
                               name="name" 
                               id="name"
                               value="{{ old('name', $promoCode->name) }}"
                               required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Type Field -->
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 mb-1">
                                Discount Type *
                            </label>
                            <select name="type" 
                                    id="type"
                                    required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Type</option>
                                <option value="percentage" {{ old('type', $promoCode->type) == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                                <option value="nominal" {{ old('type', $promoCode->type) == 'nominal' ? 'selected' : '' }}>Nominal (Rp)</option>
                            </select>
                            @error('type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Value Field -->
                        <div>
                            <label for="value" class="block text-sm font-medium text-gray-700 mb-1">
                                Discount Value *
                            </label>
                            <div class="relative">
                                <input type="number" 
                                       name="value" 
                                       id="value"
                                       step="0.01"
                                       min="0"
                                       value="{{ old('value', $promoCode->value) }}"
                                       required
                                       class="w-full pl-12 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <div class="absolute left-0 top-0 h-full flex items-center px-3 border-r border-gray-300 bg-gray-50 rounded-l-lg">
                                    <span id="value-prefix" class="text-gray-500">
                                        {{ old('type', $promoCode->type) == 'percentage' ? '%' : 'Rp' }}
                                    </span>
                                </div>
                            </div>
                            @error('value')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Quota Field -->
                    <div>
                        <label for="quota" class="block text-sm font-medium text-gray-700 mb-1">
                            Usage Quota *
                        </label>
                        <input type="number" 
                               name="quota" 
                               id="quota"
                               min="{{ $promoCode->used_count }}"
                               value="{{ old('quota', $promoCode->quota) }}"
                               required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <p class="mt-1 text-xs text-gray-500">
                            Current usage: {{ $promoCode->used_count }} times
                            @if($promoCode->used_count > 0)
                                (Min quota: {{ $promoCode->used_count }})
                            @endif
                        </p>
                        @error('quota')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Minimum Purchase -->
                    <div>
                        <label for="min_purchase" class="block text-sm font-medium text-gray-700 mb-1">
                            Minimum Purchase (Rp)
                        </label>
                        <input type="number" 
                               name="min_purchase" 
                               id="min_purchase"
                               step="0.01"
                               min="0"
                               value="{{ old('min_purchase', $promoCode->min_purchase) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="0.00">
                        @error('min_purchase')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Valid From -->
                        <div>
                            <label for="valid_from" class="block text-sm font-medium text-gray-700 mb-1">
                                Valid From *
                            </label>
                            <input type="datetime-local" 
                                   name="valid_from" 
                                   id="valid_from"
                                   value="{{ old('valid_from', $promoCode->valid_from->format('Y-m-d\TH:i')) }}"
                                   required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('valid_from')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Valid Until -->
                        <div>
                            <label for="valid_until" class="block text-sm font-medium text-gray-700 mb-1">
                                Valid Until *
                            </label>
                            <input type="datetime-local" 
                                   name="valid_until" 
                                   id="valid_until"
                                   value="{{ old('valid_until', $promoCode->valid_until->format('Y-m-d\TH:i')) }}"
                                   required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('valid_until')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Active Status -->
                    <div class="flex items-center">
                        <input type="checkbox" 
                               name="is_active" 
                               id="is_active"
                               value="1"
                               {{ old('is_active', $promoCode->is_active) ? 'checked' : '' }}
                               class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="is_active" class="ml-2 block text-sm text-gray-700">
                            Activate this promo code
                        </label>
                    </div>

                    <!-- Status Info -->
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <h3 class="font-medium text-gray-700 mb-2">Current Status</h3>
                        <div class="flex items-center gap-2">
                            @php
                                $status = $promoCode->status;
                                $statusColors = [
                                    'active' => 'bg-green-100 text-green-800',
                                    'inactive' => 'bg-gray-100 text-gray-800',
                                    'expired' => 'bg-red-100 text-red-800',
                                    'upcoming' => 'bg-yellow-100 text-yellow-800',
                                    'quota_exceeded' => 'bg-orange-100 text-orange-800'
                                ];
                            @endphp
                            <span class="px-3 py-1 rounded-full text-sm font-medium {{ $statusColors[$status] }}">
                                {{ ucfirst($status) }}
                            </span>
                            <span class="text-sm text-gray-600">
                                @if($promoCode->isValid())
                                    (Valid and active)
                                @elseif(!$promoCode->is_active)
                                    (Inactive)
                                @elseif($promoCode->valid_until < now())
                                    (Expired)
                                @elseif($promoCode->valid_from > now())
                                    (Upcoming)
                                @elseif($promoCode->used_count >= $promoCode->quota)
                                    (Quota exceeded)
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end space-x-3">
                    <a href="{{ route('admin.promos.index') }}" 
                       class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                        Update Promo Code
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Update value prefix based on type selection
    document.getElementById('type').addEventListener('change', function() {
        const prefix = this.value === 'percentage' ? '%' : 'Rp';
        document.getElementById('value-prefix').textContent = prefix;
    });

    // Trigger initial type change
    document.addEventListener('DOMContentLoaded', function() {
        const typeSelect = document.getElementById('type');
        if (typeSelect.value) {
            typeSelect.dispatchEvent(new Event('change'));
        }
    });
</script>
@endpush
@endsection