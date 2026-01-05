@props(['title', 'value', 'icon', 'color' => 'blue'])

@php
    $colors = [
        'blue' => 'bg-blue-500',
        'green' => 'bg-green-500', 
        'purple' => 'bg-purple-500',
        'orange' => 'bg-orange-500',
        'red' => 'bg-red-500',
    ];
    
    $iconColors = [
        'blue' => 'text-blue-500',
        'green' => 'text-green-500',
        'purple' => 'text-purple-500',
        'orange' => 'text-orange-500',
        'red' => 'text-red-500',
    ];
@endphp

<div class="bg-white rounded-lg shadow p-6">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-600">{{ $title }}</p>
            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $value }}</p>
        </div>
        <div class="{{ $iconColors[$color] ?? $iconColors['blue'] }}">
            <i class="{{ $icon }} text-3xl"></i>
        </div>
    </div>
</div>