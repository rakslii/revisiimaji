<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['title', 'value', 'icon', 'color' => 'blue']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['title', 'value', 'icon', 'color' => 'blue']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
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
?>

<div class="bg-white rounded-lg shadow p-6">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-600"><?php echo e($title); ?></p>
            <p class="text-2xl font-bold text-gray-900 mt-1"><?php echo e($value); ?></p>
        </div>
        <div class="<?php echo e($iconColors[$color] ?? $iconColors['blue']); ?>">
            <i class="<?php echo e($icon); ?> text-3xl"></i>
        </div>
    </div>
</div><?php /**PATH C:\laragon\www\cangcut\revisiimaji\resources\views/pages/admin/components/stats-card.blade.php ENDPATH**/ ?>