@extends('pages.admin.layouts.app')

@section('title', 'Promo Codes')
@section('page-title', 'Promo Code Management')
@section('page-description', 'Manage discount codes')

@push('styles')
<style>
    .status-badge {
        @apply px-2 py-1 text-xs font-semibold rounded-full;
    }
    .status-active { @apply bg-green-100 text-green-800; }
    .status-inactive { @apply bg-gray-100 text-gray-800; }
    .status-expired { @apply bg-red-100 text-red-800; }
    .status-upcoming { @apply bg-yellow-100 text-yellow-800; }
    .status-quota-exceeded { @apply bg-orange-100 text-orange-800; }
</style>
@endpush

@section('content')
<div class="space-y-6">
    <!-- Header with Filters -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Promo Codes</h1>
            <p class="text-gray-600 mt-1">Create and manage discount codes</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
            <a href="{{ route('admin.promos.create') }}" 
               class="flex items-center justify-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-plus"></i> Create Promo
            </a>
        </div>
    </div>

    <!-- Filters -->
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
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $promo->type == 'percentage' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
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
                                    'quota_exceeded' => 'status-quota-exceeded'
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
</div>
@endsection