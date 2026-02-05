@extends('pages.admin.layouts.app')

@section('title', 'Online Stores')
@section('page-title', 'Online Stores')
@section('page-description', 'Manage online store platforms')

@section('content')
<div class="space-y-6">
    <!-- Header with Create Button -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Online Stores</h1>
            <p class="text-gray-600">Manage all online store platforms</p>
        </div>
        <a href="{{ route('admin.settings.online-stores.create') }}" 
           class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
            <i class="fas fa-plus mr-2"></i>Add Store
        </a>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            {{ session('error') }}
        </div>
    @endif

    <!-- Filter Tabs -->
    <div class="border-b border-gray-200">
        <nav class="-mb-px flex space-x-8">
            <a href="?filter=all" 
               class="{{ (!request('filter') || request('filter') == 'all') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500' }} 
                      whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                All Stores
            </a>
            <a href="?filter=active" 
               class="{{ request('filter') == 'active' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500' }} 
                      whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Active
            </a>
            <a href="?filter=ecommerce" 
               class="{{ request('filter') == 'ecommerce' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500' }} 
                      whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                E-commerce
            </a>
            <a href="?filter=social_media" 
               class="{{ request('filter') == 'social_media' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500' }} 
                      whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Social Media
            </a>
        </nav>
    </div>

    <!-- Online Stores Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($stores as $store)
            <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-200">
                <!-- Store Header -->
                <div class="p-6" style="{{ $store->gradient_style }}">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-white bg-opacity-20 rounded-lg">
                                <i class="{{ $store->icon_class }} text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-white">{{ $store->name }}</h3>
                                <span class="text-white text-opacity-80 text-sm">{{ $store->platform_label }}</span>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            @if($store->is_active)
                                <span class="px-2 py-1 bg-green-500 text-white text-xs rounded-full">Active</span>
                            @else
                                <span class="px-2 py-1 bg-gray-500 text-white text-xs rounded-full">Inactive</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Store Details -->
                <div class="p-6">
                    @if($store->description)
                        <p class="text-gray-600 text-sm mb-4">{{ Str::limit($store->description, 100) }}</p>
                    @endif

                    <div class="space-y-3">
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-link w-5 mr-2"></i>
                            <a href="{{ $store->url }}" target="_blank" class="text-blue-600 hover:underline">
                                {{ $store->display_url }}
                            </a>
                        </div>

                        @if($store->store_username)
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-user w-5 mr-2"></i>
                                <span>{{ $store->store_username }}</span>
                            </div>
                        @endif

                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-sort-numeric-down w-5 mr-2"></i>
                            <span>Order: {{ $store->order }}</span>
                        </div>
                    </div>
                </div>

                <!-- Store Actions -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-between items-center">
                    <a href="{{ $store->url }}" target="_blank" 
                       class="text-sm text-blue-600 hover:text-blue-800">
                        <i class="fas fa-external-link-alt mr-1"></i> Visit Store
                    </a>
                    
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.settings.online-stores.edit', $store->id) }}" 
                           class="px-3 py-1 text-sm bg-blue-100 text-blue-700 rounded hover:bg-blue-200">
                            <i class="fas fa-edit"></i>
                        </a>
                        
                        <form action="{{ route('admin.settings.online-stores.destroy', $store->id) }}" 
                              method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this store?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1 text-sm bg-red-100 text-red-700 rounded hover:bg-red-200">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3">
                <div class="text-center py-12">
                    <i class="fas fa-store text-4xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No online stores found</h3>
                    <p class="text-gray-500">Get started by adding your first online store.</p>
                    <a href="{{ route('admin.settings.online-stores.create') }}" 
                       class="mt-4 inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        <i class="fas fa-plus mr-2"></i> Add Store
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($stores->hasPages())
        <div class="bg-white px-6 py-4 border-t border-gray-200 rounded-lg">
            {{ $stores->links() }}
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .gradient-bg {
        background: linear-gradient(135deg, var(--gradient-from), var(--gradient-to));
    }
</style>
@endpush