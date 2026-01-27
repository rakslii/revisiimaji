@extends('pages.admin.layouts.app')

@section('title', 'Promo Code Details')
@section('page-title', 'Promo Code Details')
@section('page-description', 'View discount code information')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Promo Code Details</h1>
            <p class="text-gray-600 mt-1">View discount code information</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.promos.index') }}" 
               class="flex items-center gap-2 bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <a href="{{ route('admin.promos.edit', $promoCode->id) }}" 
               class="flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                <i class="fas fa-edit"></i> Edit
            </a>
        </div>
    </div>

    <!-- Details Card -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6 space-y-6">
            <!-- Basic Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Promo Code</label>
                        <p class="mt-1 text-lg font-semibold text-gray-900">
                            <code class="bg-gray-100 px-3 py-1 rounded font-mono">{{ $promoCode->code }}</code>
                        </p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Name</label>
                        <p class="mt-1 text-lg font-medium text-gray-900">{{ $promoCode->name }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Type</label>
                        <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                            {{ $promoCode->type == 'percentage' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                            {{ ucfirst($promoCode->type) }}
                        </span>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Discount Value</label>
                        <p class="mt-1 text-2xl font-bold text-gray-900">
                            {{ $promoCode->formatted_value }}
                        </p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Minimum Purchase</label>
                        <p class="mt-1 text-lg text-gray-900">
                            @if($promoCode->min_purchase)
                                Rp {{ number_format($promoCode->min_purchase, 0, ',', '.') }}
                            @else
                                <span class="text-gray-400">No minimum</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Usage Stats -->
            <div class="border-t pt-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Usage Statistics</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-500">Used</label>
                        <p class="mt-1 text-3xl font-bold text-gray-900">{{ $promoCode->used_count }}</p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-500">Quota</label>
                        <p class="mt-1 text-3xl font-bold text-gray-900">{{ $promoCode->quota }}</p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-500">Remaining</label>
                        <p class="mt-1 text-3xl font-bold 
                            {{ ($promoCode->quota - $promoCode->used_count) <= 0 ? 'text-red-600' : 'text-green-600' }}">
                            {{ max(0, $promoCode->quota - $promoCode->used_count) }}
                        </p>
                    </div>
                </div>
                
                <!-- Progress Bar -->
                @if($promoCode->quota > 0)
                <div class="mt-4">
                    <div class="flex justify-between text-sm text-gray-600 mb-1">
                        <span>Usage Progress</span>
                        <span>{{ number_format(($promoCode->used_count / $promoCode->quota) * 100, 1) }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" 
                             style="width: {{ min(100, ($promoCode->used_count / $promoCode->quota) * 100) }}%"></div>
                    </div>
                </div>
                @endif
            </div>
            
            <!-- Validity -->
            <div class="border-t pt-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Validity Period</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Valid From</label>
                        <p class="mt-1 text-lg text-gray-900">
                            {{ $promoCode->valid_from->format('d F Y H:i') }}
                        </p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Valid Until</label>
                        <p class="mt-1 text-lg text-gray-900">
                            {{ $promoCode->valid_until->format('d F Y H:i') }}
                        </p>
                    </div>
                </div>
                
                <!-- Countdown -->
                @if($promoCode->is_active && $promoCode->valid_until > now())
                <div class="mt-4 p-4 bg-blue-50 rounded-lg">
                    <p class="text-sm text-blue-800">
                        <i class="fas fa-clock mr-2"></i>
                        This promo code will expire in 
                        <span class="font-semibold">
                            {{ $promoCode->valid_until->diffForHumans() }}
                        </span>
                    </p>
                </div>
                @endif
            </div>
            
            <!-- Status -->
            <div class="border-t pt-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Status</h3>
                <div class="flex items-center gap-4">
                    @php
                        $status = $promoCode->status;
                        $statusClasses = [
                            'active' => 'bg-green-100 text-green-800',
                            'inactive' => 'bg-gray-100 text-gray-800',
                            'expired' => 'bg-red-100 text-red-800',
                            'upcoming' => 'bg-yellow-100 text-yellow-800',
                            'quota_exceeded' => 'bg-orange-100 text-orange-800'
                        ];
                        $statusLabels = [
                            'active' => 'Active',
                            'inactive' => 'Inactive',
                            'expired' => 'Expired',
                            'upcoming' => 'Upcoming',
                            'quota_exceeded' => 'Quota Exceeded'
                        ];
                    @endphp
                    <span class="px-4 py-2 rounded-full text-sm font-medium {{ $statusClasses[$status] }}">
                        {{ $statusLabels[$status] }}
                    </span>
                    
                    <!-- Validity Check -->
                    @if(!$promoCode->isValid())
                    <div class="text-sm text-red-600">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        This promo code is not currently valid for use.
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection