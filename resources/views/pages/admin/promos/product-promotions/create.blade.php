@extends('pages.admin.layouts.app')

@section('title', 'Create Product Promotion')
@section('page-title', 'Create Promotion for ' . $product->name)
@section('page-description', 'Set up special promotion for this product')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="space-y-6">
        <!-- Product Info Card -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-6">
                <div class="flex items-start gap-4">
                    <!-- Product Image -->
                    <div class="flex-shrink-0">
                        <img src="{{ $product->image_url }}" 
                             alt="{{ $product->name }}"
                             class="w-20 h-20 rounded-lg object-cover">
                    </div>
                    
                    <!-- Product Details -->
                    <div class="flex-1">
                        <h2 class="text-xl font-bold text-gray-800">{{ $product->name }}</h2>
                        <div class="mt-2 space-y-1">
                            <div class="flex items-center gap-4">
                                <span class="text-lg font-bold text-blue-600">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                                @if($product->has_discount)
                                <span class="text-sm line-through text-gray-400">
                                    Rp {{ number_format($product->final_price, 0, ',', '.') }}
                                </span>
                                <span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-medium rounded">
                                    -{{ $product->discount_percent }}%
                                </span>
                                @endif
                            </div>
                            <div class="text-sm text-gray-600">
                                <span class="inline-flex items-center gap-1">
                                    <i class="fas fa-box"></i> Stock: {{ $product->stock }}
                                </span>
                                <span class="inline-flex items-center gap-1 ml-4">
                                    <i class="fas fa-tag"></i> {{ $product->category_name }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
      <!-- Active Promotions Count -->
<div class="text-right">
    <div class="text-sm text-gray-500">All Promotions</div>
    <div class="text-2xl font-bold text-green-600">
        {{ $product->productPromotions->count() }}
    </div>
</div>
                </div>
            </div>
        </div>

        <!-- Promotion Form -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-6">
                <form action="{{ route('admin.product-promotions.store', $product->id) }}" method="POST">
                    @csrf
                    
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
                                           value="{{ old('name') }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                           placeholder="e.g., Flash Sale, Weekend Special">
                                    <p class="mt-1 text-xs text-gray-500">Leave empty to use default format</p>
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
                                            <option value="{{ $promo->id }}" {{ old('promo_code_id') == $promo->id ? 'selected' : '' }}>
                                                {{ $promo->code }} - {{ $promo->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="mt-1 text-xs text-gray-500">Optional: link to existing promo code</p>
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
                                        <option value="percentage" {{ old('type') == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                                        <option value="nominal" {{ old('type') == 'nominal' ? 'selected' : '' }}>Nominal (Rp)</option>
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
                                               value="{{ old('value') }}"
                                               required
                                               class="w-full pl-12 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                               placeholder="0.00">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span id="value-prefix" class="text-gray-500 sm:text-sm">
                                                {{ old('type') == 'percentage' ? '%' : 'Rp' }}
                                            </span>
                                        </div>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">
                                        Max nominal: Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </p>
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
                                           value="{{ old('valid_from') }}"
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
                                           value="{{ old('valid_until') }}"
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
                                        Usage Quota (Optional)
                                    </label>
                                    <input type="number" 
                                           name="quota" 
                                           id="quota"
                                           min="1"
                                           value="{{ old('quota') }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                           placeholder="Unlimited">
                                    <p class="mt-1 text-xs text-gray-500">Max total uses, leave empty for unlimited</p>
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
                                           value="{{ old('min_purchase') }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                           placeholder="No minimum">
                                    <p class="mt-1 text-xs text-gray-500">Minimum cart amount</p>
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
                                           value="{{ old('min_quantity', 1) }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <p class="mt-1 text-xs text-gray-500">Minimum product quantity</p>
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
                                            Priority
                                        </label>
                                        <input type="number" 
                                               name="priority" 
                                               id="priority"
                                               min="0"
                                               max="100"
                                               value="{{ old('priority', 0) }}"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        <p class="mt-1 text-xs text-gray-500">Higher number = higher priority (0-100)</p>
                                    </div>
                                    
                                    <!-- Empty column for alignment -->
                                    <div></div>
                                </div>

                                <!-- Checkboxes -->
                                <div class="space-y-3">
                                    <div class="flex items-center">
                                        <input type="checkbox" 
                                               name="is_active" 
                                               id="is_active"
                                               value="1"
                                               {{ old('is_active', true) ? 'checked' : '' }}
                                               class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        <label for="is_active" class="ml-2 block text-sm text-gray-900">
                                            Activate promotion immediately
                                        </label>
                                    </div>
                                    
                                    <div class="flex items-center">
                                        <input type="checkbox" 
                                               name="is_exclusive" 
                                               id="is_exclusive"
                                               value="1"
                                               {{ old('is_exclusive') ? 'checked' : '' }}
                                               class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        <label for="is_exclusive" class="ml-2 block text-sm text-gray-900">
                                            Exclusive (cannot be combined with other promotions)
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Preview -->
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Preview</h3>
                            
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="font-medium text-gray-900">Product Price</h4>
                                        <p class="text-sm text-gray-600">Original price before promotion</p>
                                    </div>
                                    <div class="text-lg font-bold text-gray-800">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </div>
                                </div>
                                
                                <div class="mt-4 border-t border-gray-200 pt-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="font-medium text-green-600">Discount Applied</h4>
                                            <p class="text-sm text-gray-600" id="preview-discount-label">
                                                --%
                                            </p>
                                        </div>
                                        <div class="text-lg font-bold text-green-600" id="preview-discount">
                                            - Rp 0
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-4 border-t border-gray-200 pt-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="font-medium text-blue-600">Final Price</h4>
                                            <p class="text-sm text-gray-600">Price after discount</p>
                                        </div>
                                        <div class="text-xl font-bold text-blue-600" id="preview-final-price">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="border-t border-gray-200 pt-6 flex justify-end space-x-3">
                            <a href="{{ route('admin.product-promotions.select-product') }}" 
                               class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Create Promotion
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
    // Update value prefix and preview
    document.addEventListener('DOMContentLoaded', function() {
        const productPrice = {{ $product->price }};
        const typeSelect = document.getElementById('type');
        const valueInput = document.getElementById('value');
        const previewDiscountLabel = document.getElementById('preview-discount-label');
        const previewDiscount = document.getElementById('preview-discount');
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
        
        // Set default dates
        const now = new Date();
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 30);
        
        const formatDate = (date) => date.toISOString().slice(0, 16);
        
        if (!document.getElementById('valid_from').value) {
            document.getElementById('valid_from').value = formatDate(now);
        }
        
        if (!document.getElementById('valid_until').value) {
            document.getElementById('valid_until').value = formatDate(tomorrow);
        }
        
        // Initial preview update
        updatePreview();
    });
</script>
@endpush
@endsection