@extends('pages.admin.layouts.app')

@section('title', 'Promo Management')
@section('page-title', 'Promo Management')
@section('page-description', 'Manage discount codes and product promotions')

@push('styles')
<style>
    .status-badge {
        @apply px-2 py-1 text-xs font-semibold rounded-full;
    }
    .status-active { @apply bg-green-100 text-green-800; }
    .status-inactive { @apply bg-gray-100 text-gray-800; }
    .status-expired { @apply bg-red-100 text-red-800; }
    .status-upcoming { @apply bg-yellow-100 text-yellow-800; }
    .status-quota_exceeded { @apply bg-orange-100 text-orange-800; }
    
    .promo-type-badge {
        @apply px-2 py-1 text-xs font-semibold rounded-full;
    }
    .type-percentage { @apply bg-blue-100 text-blue-800; }
    .type-nominal { @apply bg-green-100 text-green-800; }
</style>
@endpush

@section('content')
<div class="space-y-6">
    <!-- Header with Filters -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <!-- HAPUS H1 DI SINI KARENA SUDAH ADA DI LAYOUT -->
            <!-- <h1 class="text-2xl font-bold text-gray-800">Promo Management</h1> -->
            {{-- <p class="text-gray-600">Manage discount codes and product promotions</p> --}}
        </div>
        <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
            <!-- Product Promotions Button -->
            <a href="{{ route('admin.product-promotions.select-product') }}" 
               class="flex items-center justify-center gap-2 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                <i class="fas fa-tag"></i> Product Promotions
            </a>
            
            <!-- Create Promo Code Button -->
            <a href="{{ route('admin.promos.create') }}" 
               class="flex items-center justify-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-plus"></i> Create Promo Code
            </a>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Promo Codes Card -->
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Promo Codes</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ \App\Models\PromoCode::count() }}</h3>
                </div>
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-ticket-alt text-blue-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-3">
                <a href="{{ route('admin.promos.index') }}" 
                   class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 font-medium">
                    View All <i class="fas fa-arrow-right ml-1 text-xs"></i>
                </a>
            </div>
        </div>

        <!-- Product Promotions Card -->
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Product Promotions</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ \App\Models\ProductPromotion::count() }}</h3>
                </div>
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-tags text-green-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-3">
                <a href="{{ route('admin.product-promotions.select-product') }}" 
                   class="inline-flex items-center text-sm text-green-600 hover:text-green-800 font-medium">
                    Manage <i class="fas fa-arrow-right ml-1 text-xs"></i>
                </a>
            </div>
        </div>

        <!-- Active Promotions Card -->
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Active Promotions</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">
                        {{ \App\Models\PromoCode::where('is_active', true)
                            ->where('valid_from', '<=', now())
                            ->where('valid_until', '>=', now())
                            ->whereRaw('used_count < quota')
                            ->count() + 
                           \App\Models\ProductPromotion::where('is_active', true)
                            ->where('valid_from', '<=', now())
                            ->where('valid_until', '>=', now())
                            ->where(function($q) {
                                $q->whereNull('quota')->orWhereRaw('used_count < quota');
                            })
                            ->count() }}
                    </h3>
                </div>
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-bolt text-green-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-3">
                <span class="text-sm text-gray-600">
                    {{ \App\Models\PromoCode::where('is_active', true)
                        ->where('valid_from', '<=', now())
                        ->where('valid_until', '>=', now())
                        ->whereRaw('used_count < quota')
                        ->count() }} codes + 
                    {{ \App\Models\ProductPromotion::where('is_active', true)
                        ->where('valid_from', '<=', now())
                        ->where('valid_until', '>=', now())
                        ->where(function($q) {
                            $q->whereNull('quota')->orWhereRaw('used_count < quota');
                        })
                        ->count() }} products
                </span>
            </div>
        </div>

        <!-- Expiring Soon Card -->
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Expiring Soon</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">
                        {{ \App\Models\ProductPromotion::where('valid_until', '<=', now()->addDays(7))
                            ->where('valid_until', '>=', now())
                            ->where('is_active', true)
                            ->count() }}
                    </h3>
                </div>
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-3">
                <a href="{{ route('admin.product-promotions.index') }}?status=active" 
                   class="inline-flex items-center text-sm text-yellow-600 hover:text-yellow-800 font-medium">
                    Check <i class="fas fa-arrow-right ml-1 text-xs"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="bg-white rounded-lg shadow">
        <div class="border-b border-gray-200">
            <nav class="flex -mb-px">
                <a href="{{ route('admin.promos.index') }}" 
                   class="{{ request()->routeIs('admin.promos.*') && !request()->is('*/product-promotions*') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} flex-1 py-4 px-1 text-center border-b-2 font-medium text-sm">
                    <i class="fas fa-ticket-alt mr-2"></i> Promo Codes
                </a>
                <a href="{{ route('admin.product-promotions.select-product') }}" 
                   class="{{ request()->is('*/product-promotions*') ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} flex-1 py-4 px-1 text-center border-b-2 font-medium text-sm">
                    <i class="fas fa-tag mr-2"></i> Product Promotions
                </a>
                <a href="{{ route('admin.product-promotions.index') }}" 
                   class="{{ request()->routeIs('admin.product-promotions.index') ? 'border-purple-500 text-purple-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} flex-1 py-4 px-1 text-center border-b-2 font-medium text-sm">
                    <i class="fas fa-list mr-2"></i> All Promotions
                </a>
            </nav>
        </div>
    </div>

    <!-- Content based on active tab -->
    @if(request()->routeIs('admin.promos.*') && !request()->is('*/product-promotions*'))
        <!-- Filters for Promo Codes -->
        <div class="bg-white rounded-lg shadow p-4">
            <form action="{{ route('admin.promos.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1">
                    <input type="text" name="search" placeholder="Search by code or name..." 
                           value="{{ request('search') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                        <option value="quota_exceeded" {{ request('status') == 'quota_exceeded' ? 'selected' : '' }}>Quota Exceeded</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        <i class="fas fa-search"></i> Filter
                    </button>
                    <a href="{{ route('admin.promos.index') }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300">
                        Clear
                    </a>
                </div>
            </form>
        </div>

        <!-- Promo Codes Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <div>
                    <h2 class="text-lg font-semibold text-gray-800">Promo Codes</h2>
                    <p class="text-sm text-gray-600 mt-1">General discount codes for all customers</p>
                </div>
                <a href="{{ route('admin.promos.create') }}" 
                   class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <i class="fas fa-plus mr-1"></i> New Promo Code
                </a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Code</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Value</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Usage</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Valid Period</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Min Purchase</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($promoCodes as $promo)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <code class="bg-gray-100 px-2 py-1 rounded font-mono text-sm">{{ $promo->code }}</code>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $promo->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="promo-type-badge {{ $promo->type == 'percentage' ? 'type-percentage' : 'type-nominal' }}">
                                    {{ ucfirst($promo->type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                {{ $promo->formatted_value }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                <div class="flex flex-col">
                                    <span>{{ $promo->used_count }} / {{ $promo->quota }}</span>
                                    @if($promo->quota > 0)
                                    <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                                        <div class="bg-blue-600 h-2 rounded-full" 
                                             style="width: {{ min(100, ($promo->used_count / $promo->quota) * 100) }}%"></div>
                                    </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                <div class="flex flex-col">
                                    <span>{{ $promo->valid_from->format('d M Y') }}</span>
                                    <span class="text-xs text-gray-500">to</span>
                                    <span>{{ $promo->valid_until->format('d M Y') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                @if($promo->min_purchase)
                                    Rp {{ number_format($promo->min_purchase, 0, ',', '.') }}
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $status = $promo->status;
                                    $statusClasses = [
                                        'active' => 'status-active',
                                        'inactive' => 'status-inactive',
                                        'expired' => 'status-expired',
                                        'upcoming' => 'status-upcoming',
                                        'quota_exceeded' => 'status-quota_exceeded'
                                    ];
                                    $statusLabels = [
                                        'active' => 'Active',
                                        'inactive' => 'Inactive',
                                        'expired' => 'Expired',
                                        'upcoming' => 'Upcoming',
                                        'quota_exceeded' => 'Quota Exceeded'
                                    ];
                                @endphp
                                <span class="status-badge {{ $statusClasses[$status] }}">
                                    {{ $statusLabels[$status] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.promos.edit', $promo->id) }}" 
                                       class="text-blue-600 hover:text-blue-900 p-1" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <form action="{{ route('admin.promos.toggle-status', $promo->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-yellow-600 hover:text-yellow-900 p-1" 
                                                title="{{ $promo->is_active ? 'Deactivate' : 'Activate' }}">
                                            <i class="fas fa-power-off"></i>
                                        </button>
                                    </form>
                                    
                                    <form action="{{ route('admin.promos.destroy', $promo->id) }}" method="POST" class="inline" 
                                          onsubmit="return confirm('Are you sure you want to delete this promo code?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 p-1" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="px-6 py-8 text-center">
                                <div class="text-gray-400">
                                    <i class="fas fa-ticket-alt text-4xl mb-3"></i>
                                    <p class="text-lg">No promo codes found</p>
                                    <p class="text-sm mt-1">Create your first promo code to get started</p>
                                    <a href="{{ route('admin.promos.create') }}" 
                                       class="inline-block mt-4 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                                        Create Promo Code
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($promoCodes->hasPages())
            <div class="px-6 py-4 border-t">
                {{ $promoCodes->links() }}
            </div>
            @endif
        </div>
    
    @elseif(request()->is('*/product-promotions*'))
        <!-- Product Promotions Content (akan di-load dari route masing-masing) -->
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <i class="fas fa-tags text-4xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 text-lg">Select a product promotion option from the tabs above</p>
            <p class="text-gray-400 mt-1">Or click "Product Promotions" button to get started</p>
            <div class="mt-6">
                <a href="{{ route('admin.product-promotions.select-product') }}" 
                   class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    <i class="fas fa-arrow-right mr-2"></i> Go to Product Promotions
                </a>
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    // Highlight active tab on page load
    document.addEventListener('DOMContentLoaded', function() {
        const currentPath = window.location.pathname;
        const tabs = document.querySelectorAll('nav a');
        
        tabs.forEach(tab => {
            const tabHref = tab.getAttribute('href');
            if (currentPath.includes(tabHref.replace('/admin/', ''))) {
                tab.classList.add('border-blue-500', 'text-blue-600');
                tab.classList.remove('border-transparent', 'text-gray-500');
            }
        });
    });
</script>
@endpush