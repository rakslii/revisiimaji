@extends('pages.admin.layouts.app')

@section('title', 'Banner Management')
@section('page-title', 'Banner Management')
@section('page-description', 'Manage promotional banners and popups on your website')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Flash Messages -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ session('error') }}
            </div>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="rounded-lg bg-blue-100 p-3 mr-4">
                    <i class="fas fa-images text-blue-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Banners</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $banners->count() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="rounded-lg bg-green-100 p-3 mr-4">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Active</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $banners->where('is_active', true)->count() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="rounded-lg bg-purple-100 p-3 mr-4">
                    <i class="fas fa-home text-purple-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Home Banners</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $homeBanners->count() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="rounded-lg bg-yellow-100 p-3 mr-4">
                    <i class="fas fa-window-restore text-yellow-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Popups</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $popups->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="border-b">
            <nav class="flex -mb-px">
                <a href="{{ route('admin.settings.banners.index', ['tab' => 'home']) }}" 
                   class="py-4 px-6 font-medium text-sm border-b-2 {{ ($tab == 'home') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    <i class="fas fa-home mr-2"></i>Home Banners
                    <span class="ml-1 bg-gray-200 text-gray-800 text-xs px-2 py-0.5 rounded-full">{{ $homeBanners->count() }}</span>
                </a>
                <a href="{{ route('admin.settings.banners.index', ['tab' => 'popup']) }}" 
                   class="py-4 px-6 font-medium text-sm border-b-2 {{ ($tab == 'popup') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    <i class="fas fa-window-restore mr-2"></i>Popups
                    <span class="ml-1 bg-gray-200 text-gray-800 text-xs px-2 py-0.5 rounded-full">{{ $popups->count() }}</span>
                </a>
                <a href="{{ route('admin.settings.banners.index', ['tab' => 'stats']) }}" 
                   class="py-4 px-6 font-medium text-sm border-b-2 {{ ($tab == 'stats') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    <i class="fas fa-chart-bar mr-2"></i>Statistics
                </a>
            </nav>
        </div>
    </div>

    <!-- Content based on Tab -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if($tab == 'home')
            @include('pages.admin.settings.banners.tabs.home')
        @elseif($tab == 'popup')
            @include('pages.admin.settings.banners.tabs.popup')
        @elseif($tab == 'stats')
            @include('pages.admin.settings.banners.tabs.statistics')
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
<script>
function toggleStatus(id, button) {
    fetch(`/admin/settings/banners/${id}/toggle-active`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const icon = button.querySelector('i');
            const badge = button.closest('tr').querySelector('.status-badge');
            
            if (data.is_active) {
                icon.className = 'fas fa-toggle-on text-green-600 text-xl';
                if (badge) {
                    badge.innerHTML = '<span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Active</span>';
                }
            } else {
                icon.className = 'fas fa-toggle-off text-gray-400 text-xl';
                if (badge) {
                    badge.innerHTML = '<span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs">Inactive</span>';
                }
            }
        }
    })
    .catch(error => console.error('Error:', error));
}

function deleteBanner(id, name) {
    if (confirm(`Are you sure you want to delete "${name}"? This action cannot be undone.`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/settings/banners/${id}`;
        form.innerHTML = `
            @csrf
            @method('DELETE')
        `;
        document.body.appendChild(form);
        form.submit();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const container = document.querySelector('.banners-list');
    if (container && typeof Sortable !== 'undefined') {
        new Sortable(container, {
            animation: 150,
            handle: '.cursor-move',
            onEnd: function(evt) {
                const items = Array.from(container.children);
                const orderData = items.map((item, index) => {
                    const id = item.getAttribute('data-id');
                    return parseInt(id);
                }).filter(id => !isNaN(id));
                
                fetch('{{ route("admin.settings.banners.update-order") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ orders: orderData })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Order updated successfully');
                    }
                })
                .catch(error => console.error('Error reordering:', error));
            }
        });
    }
});
</script>
@endpush