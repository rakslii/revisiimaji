@extends('pages.admin.layouts.app')

@section('title', 'Product Promotion Details')
@section('page-title', 'Promotion Details')
@section('page-description', 'View promotion information')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <div>
                    <h1 class="text-xl font-bold text-gray-800">Product Promotion</h1>
                    <p class="text-gray-600 mt-1">
                        {{ $promotion->name ?? 'Product Promotion' }}
                        @if($promotion->promo_code_id)
                        <span class="ml-2 text-sm text-blue-600">
                            <i class="fas fa-link"></i> Linked to {{ $promotion->promoCode->code ?? 'Promo Code' }}
                        </span>
                        @endif
                    </p>
                </div>
                <div class="flex items-center gap-2">
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

            <div class="p-6">
                <!-- Product & Promotion Info -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                    <!-- Product Card -->
                    <div class="lg:col-span-1">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Product</h3>
                            <div class="flex items-center gap-4">
                                @if($promotion->product->image_url)
                                <div class="flex-shrink-0">
                                    <img src="{{ $promotion->product->image_url }}" 
                                         alt="{{ $promotion->product->name }}"
                                         class="w-20 h-20 rounded-lg object-cover">
                                </div>
                                @endif
                                <div>
                                    <h4 class="font-medium text-gray-900">
                                        <a href="{{ route('admin.products.show', $promotion->product_id) }}" 
                                           class="text-blue-600 hover:text-blue-800">
                                            {{ $promotion->product->name }}
                                        </a>
                                    </h4>
                                    <div class="mt-2 space-y-1">
                                        <div class="flex items-center gap-2">
                                            <span class="text-lg font-bold text-blue-600">
                                                Rp {{ number_format($promotion->product->price, 0, ',', '.') }}
                                            </span>
                                            @if($promotion->product->has_discount)
                                            <span class="text-sm line-through text-gray-400">
                                                Rp {{ number_format($promotion->product->final_price, 0, ',', '.') }}
                                            </span>
                                            @endif
                                        </div>
                                        <div class="text-sm text-gray-600">
                                            <i class="fas fa-box mr-1"></i> Stock: {{ $promotion->product->stock }}
                                        </div>
                                        <div class="text-sm text-gray-600">
                                            <i class="fas fa-tag mr-1"></i> {{ $promotion->product->category_name }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Discount Info -->
                    <div class="lg:col-span-2">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Discount Value -->
                            <div class="bg-white border border-gray-200 rounded-lg p-4">
                                <h3 class="text-sm font-medium text-gray-600 mb-2">Discount Value</h3>
                                <div class="flex items-center gap-2">
                                    <span class="text-3xl font-bold text-gray-800">
                                        {{ $promotion->formatted_value }}
                                    </span>
                                    <span class="px-2 py-1 rounded text-sm 
                                        {{ $promotion->type == 'percentage' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                        {{ ucfirst($promotion->type) }}
                                    </span>
                                </div>
                                <div class="mt-4">
                                    <div class="text-sm text-gray-600">Final Price</div>
                                    <div class="text-xl font-bold text-green-600">
                                        Rp {{ number_format($promotion->getFinalPrice($promotion->product->price, 1), 0, ',', '.') }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        Discount: Rp {{ number_format($promotion->getDiscountAmount($promotion->product->price, 1), 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>

                            <!-- Usage Info -->
                            <div class="bg-white border border-gray-200 rounded-lg p-4">
                                <h3 class="text-sm font-medium text-gray-600 mb-2">Usage</h3>
                                <div class="space-y-3">
                                    <div>
                                        <div class="flex justify-between text-sm text-gray-600">
                                            <span>Used</span>
                                            <span>{{ $promotion->used_count }}</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                                            <div class="bg-blue-600 h-2 rounded-full" 
                                                 style="width: {{ $promotion->quota ? min(100, ($promotion->used_count / $promotion->quota) * 100) : 0 }}%"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="text-sm text-gray-600">Remaining Uses</div>
                                        <div class="text-xl font-bold text-gray-800">
                                            {{ $promotion->remaining_uses ?? 'Unlimited' }}
                                        </div>
                                    </div>
                                    @if($promotion->min_quantity > 1)
                                    <div>
                                        <div class="text-sm text-gray-600">Minimum Quantity</div>
                                        <div class="text-lg font-medium text-gray-800">
                                            {{ $promotion->min_quantity }} pieces
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Validity & Conditions -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Validity Period -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Validity Period</h3>
                        <div class="space-y-3">
                            <div>
                                <div class="text-sm text-gray-600">Valid From</div>
                                <div class="font-medium">
                                    {{ $promotion->valid_from->format('d M Y, H:i') }}
                                </div>
                            </div>
                            <div>
                                <div class="text-sm text-gray-600">Valid Until</div>
                                <div class="font-medium">
                                    {{ $promotion->valid_until->format('d M Y, H:i') }}
                                </div>
                            </div>
                            <div>
                                <div class="text-sm text-gray-600">Remaining Time</div>
                                <div class="font-medium {{ $promotion->remaining_days <= 3 ? 'text-red-600' : 'text-green-600' }}">
                                    {{ $promotion->remaining_days }} days
                                    ({{ $promotion->valid_until->diffForHumans() }})
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Conditions -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Conditions</h3>
                        <div class="space-y-3">
                            @if($promotion->min_purchase)
                            <div>
                                <div class="text-sm text-gray-600">Minimum Purchase</div>
                                <div class="font-medium">
                                    Rp {{ number_format($promotion->min_purchase, 0, ',', '.') }}
                                </div>
                            </div>
                            @endif
                            <div>
                                <div class="text-sm text-gray-600">Priority</div>
                                <div class="font-medium">
                                    {{ $promotion->priority }} / 100
                                </div>
                            </div>
                            <div>
                                <div class="text-sm text-gray-600">Exclusive</div>
                                <div class="font-medium {{ $promotion->is_exclusive ? 'text-green-600' : 'text-gray-600' }}">
                                    {{ $promotion->is_exclusive ? 'Yes' : 'No' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="border-t border-gray-200 pt-6">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div class="space-y-1">
                            <div class="text-sm text-gray-600">
                                <i class="fas fa-calendar-plus mr-1"></i>
                                Created: {{ $promotion->created_at->format('d M Y, H:i') }}
                            </div>
                            <div class="text-sm text-gray-600">
                                <i class="fas fa-edit mr-1"></i>
                                Updated: {{ $promotion->updated_at->format('d M Y, H:i') }}
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <a href="{{ route('admin.product-promotions.edit', $promotion->id) }}" 
                               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                            <form action="{{ route('admin.product-promotions.toggle-status', $promotion->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition">
                                    <i class="fas fa-power-off mr-1"></i>
                                    {{ $promotion->is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                            <form action="{{ route('admin.product-promotions.destroy', $promotion->id) }}" method="POST" 
                                  onsubmit="return confirm('Delete this promotion?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                                    <i class="fas fa-trash mr-1"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="flex justify-between items-center">
            <a href="{{ route('admin.product-promotions.index') }}" 
               class="inline-flex items-center text-blue-600 hover:text-blue-800">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to All Promotions
            </a>
            <a href="{{ route('admin.products.show', $promotion->product_id) }}" 
               class="inline-flex items-center text-green-600 hover:text-green-800">
                <i class="fas fa-box mr-2"></i>
                View Product
            </a>
        </div>
    </div>
</div>
@endsection