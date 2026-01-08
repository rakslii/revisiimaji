@props(['type' => 'success'])

@php
    $styles = [
        'success' => 'bg-green-50 border-green-400 text-green-800',
        'error' => 'bg-red-50 border-red-400 text-red-800',
        'warning' => 'bg-yellow-50 border-yellow-400 text-yellow-800',
        'info' => 'bg-blue-50 border-blue-400 text-blue-800',
    ];
    
    $icons = [
        'success' => 'fas fa-check-circle',
        'error' => 'fas fa-exclamation-circle',
        'warning' => 'fas fa-exclamation-triangle',
        'info' => 'fas fa-info-circle',
    ];
    
    // Get message from session
    $message = session('success') ?? session('error') ?? session('warning') ?? session('info') ?? null;
    
    // Determine type from session
    if (session('success')) $type = 'success';
    if (session('error')) $type = 'error';
    if (session('warning')) $type = 'warning';
    if (session('info')) $type = 'info';
@endphp

@if($message)
<div class="p-4 rounded-lg border {{ $styles[$type] ?? $styles['success'] }} mb-4">
    <div class="flex items-center">
        <i class="{{ $icons[$type] ?? $icons['success'] }} mr-3"></i>
        <span>{{ $message }}</span>
    </div>
</div>
@endif