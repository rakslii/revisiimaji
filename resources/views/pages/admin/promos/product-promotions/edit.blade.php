@extends('pages.admin.layouts.app')

@section('title', 'Edit Product Promotion')
@section('page-title', 'Edit Promotion')
@section('page-description', 'Update promotion details')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="space-y-6">
        <!-- Product Info -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center gap-4">
                @if($promotion->product->image_url)
                <div class="flex-shrink-0">
                    <img src="{{ $promotion->product->image_url }}" 
                         alt="{{ $promotion->product->name }}"
                         class="w-16 h-16 rounded-lg object-cover">
                </div>
                @endif
                <div>
                    <h2 class="text-xl font-bold text-gray-800">{{ $promotion->product->name }}</h2>
                    <div class="mt-2 flex items-center gap-4">
                        <span class="text-lg font-bold text-blue-600">
                            Rp {{ number_format($promotion->product->price, 0, ',', '.') }}
                        </span>
                        <span class="text-sm text-gray-600">
                            <i class="fas fa-box mr-1"></i> Stock: {{ $promotion->product->stock }}
                        </span>
                        <span class="text-sm text-gray-600">
                            <i class="fas fa-tag mr-1"></i> {{ $promotion->product->category_name }}
                        </span>
                    </div>
                </div>
                <div class="ml-auto">
                    @php
                        $status = $promotion->status;
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
                </div>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-6">
                <form action="{{ route('admin.product-promotions.update', $promotion->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-6">
                        <!-- Basic Info -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Promotion Information</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Promotion Name -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                        Promotion Name (Optional)
                                    </label>
                                    <input type="text" 
                                           name="name" 
                                           id="name"
                                           value="{{ old('name', $promotion->name) }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                           placeholder="e.g., Flash Sale, Weekend Special">
                                </div>

                                <!-- Link to Promo Code -->
                                <div>
                                    <label for="promo_code_id" class="block text-sm font-medium text-gray-700 mb-1">
                                        Link to Promo Code (Optional)
                                    </label>
                                    <select name="promo_code_id" 
                                            id="promo_code_id"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        <option value="">No Promo Code Link</option>
                                        @foreach($promoCodes as $promo)
                                            <option value="{{ $promo->id }}" {{ old('promo_code_id', $promotion->promo_code_id) == $promo->id ? 'selected' : '' }}>
                                                {{ $promo->code }} - {{ $promo->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Discount Settings -->
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Discount Settings</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Discount Type -->
                                <div>
                                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">
                                        Discount Type *
                                    </label>
                                    <select name="type" 
                                            id="type"
                                            required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        <option value="">Select Type</option>
                                        <option value="percentage" {{ old('type', $promotion->type) == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                                        <option value="nominal" {{ old('type', $promotion->type) == 'nominal' ? 'selected' : '' }}>Nominal (Rp)</option>
                                    </select>
                                </div>

                                <!-- Discount Value -->
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
                                               max="{{ $promotion->type == 'nominal' ? $promotion->product->price : '' }}"
                                               value="{{ old('value', $promotion->value) }}"
                                               required
                                               class="w-full pl-12 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span id="value-prefix" class="text-gray-500 sm:text-sm">
                                                {{ old('type', $promotion->type) == 'percentage' ? '%' : 'Rp' }}
                                            </span>
                                        </div>
                                    </div>
                                    @if($promotion->type == 'nominal')
                                    <p class="mt-1 text-xs text-gray-500">
                                        Max: Rp {{ number_format($promotion->product->price, 0, ',', '.') }}
                                    </p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Validity Period -->
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Validity Period</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Valid From -->
                                <div>
                                    <label for="valid_from" class="block text-sm font-medium text-gray-700 mb-1">
                                        Valid From *
                                    </label>
                                    <input type="datetime-local" 
                                           name="valid_from" 
                                           id="valid_from"
                                           value="{{ old('valid_from', $promotion->valid_from->format('Y-m-d\TH:i')) }}"
                                           required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>

                                <!-- Valid Until -->
                                <div>
                                    <label for="valid_until" class="block text-sm font-medium text-gray-700 mb-1">
                                        Valid Until *
                                    </label>
                                    <input type="datetime-local" 
                                           name="valid_until" 
                                           id="valid_until"
                                           value="{{ old('valid_until', $promotion->valid_until->format('Y-m-d\TH:i')) }}"
                                           required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>
                            </div>
                        </div>

                        <!-- Conditions & Limits -->
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Conditions & Limits</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <!-- Quota -->
                                <div>
                                    <label for="quota" class="block text-sm font-medium text-gray-700 mb-1">
                                        Usage Quota
                                    </label>
                                    <input type="number" 
                                           name="quota" 
                                           id="quota"
                                           min="{{ $promotion->used_count }}"
                                           value="{{ old('quota', $promotion->quota) }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                           placeholder="Unlimited">
                                    <p class="mt-1 text-xs text-gray-500">
                                        Used: {{ $promotion->used_count }}
                                        @if($promotion->used_count > 0)
                                        (Min: {{ $promotion->used_count }})
                                        @endif
                                    </p>
                                </div>

                                <!-- Min Purchase -->
                                <div>
                                    <label for="min_purchase" class="block text-sm font-medium text-gray-700 mb-1">
                                        Min Purchase (Rp)
                                    </label>
                                    <input type="number" 
                                           name="min_purchase" 
                                           id="min_purchase"
                                           step="0.01"
                                           min="0"
                                           value="{{ old('min_purchase', $promotion->min_purchase) }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                           placeholder="No minimum">
                                </div>

                                <!-- Min Quantity -->
                                <div>
                                    <label for="min_quantity" class="block text-sm font-medium text-gray-700 mb-1">
                                        Min Quantity
                                    </label>
                                    <input type="number" 
                                           name="min_quantity" 
                                           id="min_quantity"
                                           min="1"
                                           value="{{ old('min_quantity', $promotion->min_quantity ?? 1) }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>
                            </div>
                        </div>

                        <!-- Advanced Settings -->
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Advanced Settings</h3>
                            
                            <div class="space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Priority -->
                                    <div>
                                        <label for="priority" class="block text-sm font-medium text-gray-700 mb-1">
                                            Priority (0-100)
                                        </label>
                                        <input type="number" 
                                               name="priority" 
                                               id="priority"
                                               min="0"
                                               max="100"
                                               value="{{ old('priority', $promotion->priority) }}"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        <p class="mt-1 text-xs text-gray-500">Higher number = higher priority</p>
                                    </div>
                                    
                                    <!-- Empty column -->
                                    <div></div>
                                </div>

                                <!-- Checkboxes -->
                                <div class="space-y-3">
                                    <div class="flex items-center">
                                        <input type="checkbox" 
                                               name="is_active" 
                                               id="is_active"
                                               value="1"
                                               {{ old('is_active', $promotion->is_active) ? 'checked' : '' }}
                                               class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        <label for="is_active" class="ml-2 block text-sm text-gray-900">
                                            Active promotion
                                        </label>
                                    </div>
                                    
                                    <div class="flex items-center">
                                        <input type="checkbox" 
                                               name="is_exclusive" 
                                               id="is_exclusive"
                                               value="1"
                                               {{ old('is_exclusive', $promotion->is_exclusive) ? 'checked' : '' }}
                                               class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        <label for="is_exclusive" class="ml-2 block text-sm text-gray-900">
                                            Exclusive (cannot combine with other promotions)
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Preview -->
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Price Preview</h3>
                            
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="text-center">
                                        <div class="text-sm text-gray-600">Original Price</div>
                                        <div class="text-xl font-bold text-gray-800">
                                            Rp {{ number_format($promotion->product->price, 0, ',', '.') }}
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-sm text-gray-600">Discount</div>
                                        <div class="text-xl font-bold text-green-600" id="preview-discount">
                                            - Rp 0
                                        </div>
                                        <div class="text-xs text-gray-500" id="preview-discount-label">
                                            --
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-sm text-gray-600">Final Price</div>
                                        <div class="text-2xl font-bold text-blue-600" id="preview-final-price">
                                            Rp {{ number_format($promotion->product->price, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="border-t border-gray-200 pt-6 flex justify-end space-x-3">
                            <a href="{{ route('admin.product-promotions.show', $promotion->id) }}" 
                               class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Update Promotion
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const productPrice = {{ $promotion->product->price }};
        const typeSelect = document.getElementById('type');
        const valueInput = document.getElementById('value');
        const previewDiscount = document.getElementById('preview-discount');
        const previewDiscountLabel = document.getElementById('preview-discount-label');
        const previewFinalPrice = document.getElementById('preview-final-price');
        
        function updatePreview() {
            const type = typeSelect.value;
            const value = parseFloat(valueInput.value) || 0;
            
            // Update prefix
            const prefix = type === 'percentage' ? '%' : 'Rp';
            document.getElementById('value-prefix').textContent = prefix;
            
            // Calculate discount
            let discount = 0;
            let finalPrice = productPrice;
            
            if (type === 'percentage') {
                discount = (productPrice * value) / 100;
                previewDiscountLabel.textContent = value + '% discount';
            } else if (type === 'nominal') {
                discount = Math.min(value, productPrice);
                previewDiscountLabel.textContent = 'Rp ' + formatNumber(value) + ' discount';
            }
            
            finalPrice = Math.max(0, productPrice - discount);
            
            // Update preview
            previewDiscount.textContent = '- Rp ' + formatNumber(discount);
            previewFinalPrice.textContent = 'Rp ' + formatNumber(finalPrice);
        }
        
        function formatNumber(num) {
            return num.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
        
        // Event listeners
        typeSelect.addEventListener('change', updatePreview);
        valueInput.addEventListener('input', updatePreview);
        
        // Initial preview update
        updatePreview();
    });
</script>
@endpush
@endsection