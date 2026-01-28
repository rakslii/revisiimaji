<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['products']));

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

foreach (array_filter((['products']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php if (isset($component)) { $__componentOriginald4f7943194772c0ad5b3954bb3a62e25 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald4f7943194772c0ad5b3954bb3a62e25 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.product-card','data' => ['product' => $product]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.product-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['product' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald4f7943194772c0ad5b3954bb3a62e25)): ?>
<?php $attributes = $__attributesOriginald4f7943194772c0ad5b3954bb3a62e25; ?>
<?php unset($__attributesOriginald4f7943194772c0ad5b3954bb3a62e25); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald4f7943194772c0ad5b3954bb3a62e25)): ?>
<?php $component = $__componentOriginald4f7943194772c0ad5b3954bb3a62e25; ?>
<?php unset($__componentOriginald4f7943194772c0ad5b3954bb3a62e25); ?>
<?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-span-full">
            <div class="text-center py-12">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-search text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Produk Tidak Ditemukan</h3>
                <p class="text-gray-500 mb-6">Tidak ada produk yang sesuai dengan filter pencarian Anda.</p>
                <a href="<?php echo e(route('products.index')); ?>" class="inline-flex items-center text-blue-600 font-semibold hover:text-blue-800">
                    <i class="fas fa-sync-alt mr-2"></i> Reset Filter
                </a>
            </div>
        </div>
    <?php endif; ?>
</div><?php /**PATH C:\laragon\www\IMAJI\revisiimaji\resources\views/components/partials/products/grid.blade.php ENDPATH**/ ?>