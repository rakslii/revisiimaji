<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['type' => 'success']));

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

foreach (array_filter((['type' => 'success']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
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
?>

<?php if($message): ?>
<div class="p-4 rounded-lg border <?php echo e($styles[$type] ?? $styles['success']); ?> mb-4">
    <div class="flex items-center">
        <i class="<?php echo e($icons[$type] ?? $icons['success']); ?> mr-3"></i>
        <span><?php echo e($message); ?></span>
    </div>
</div>
<?php endif; ?><?php /**PATH F:\PROJECT-CODINGAN-CLIENT\revisiimaji\resources\views\pages\admin\components\alert.blade.php ENDPATH**/ ?>