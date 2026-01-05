@extends('pages.admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-description', 'Ringkasan data toko Anda')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @include('pages.admin.components.stats-card', [
            'title' => 'Total Orders',
            'value' => $stats['total_orders'] ?? 0,
            'icon' => 'fas fa-shopping-cart',
            'color' => 'blue'
        ])
        
        @include('pages.admin.components.stats-card', [
            'title' => 'Total Customers',
            'value' => $stats['total_customers'] ?? 0,
            'icon' => 'fas fa-users',
            'color' => 'green'
        ])
        
        @include('pages.admin.components.stats-card', [
            'title' => 'Total Products',
            'value' => $stats['total_products'] ?? 0,
            'icon' => 'fas fa-box',
            'color' => 'purple'
        ])
        
        @include('pages.admin.components.stats-card', [
            'title' => 'Promo Codes',
            'value' => $stats['total_promo_codes'] ?? 0,
            'icon' => 'fas fa-tag',
            'color' => 'orange'
        ])
    </div>
    
    <!-- Recent Orders -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold">Recent Orders</h2>
                <a href="{{ route('admin.orders') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                    View All <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
        <div class="overflow-x-auto">
            @include('pages.admin.components.datatable', [
                'headers' => ['Order ID', 'Customer', 'Amount', 'Status', 'Date'],
                'data' => $recent_orders ?? []
            ])
        </div>
    </div>
</div>
@endsection