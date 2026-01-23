<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['product']));

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

foreach (array_filter((['product']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    // Pastikan data valid
    $categoryType = $product->category_type ?? 'unknown';
    $categoryName = $product->category_name ?? 'Produk';
    $isInstan = $categoryType === 'instan';
    
    $rating = $product->rating ?? 0;
    $salesCount = $product->sales_count ?? 0;
    
    // Gunakan Str helper
    if (!function_exists('str_limit')) {
        function str_limit($string, $limit = 100, $end = '...') {
            if (mb_strlen($string) <= $limit) {
                return $string;
            }
            return mb_substr($string, 0, $limit) . $end;
        }
    }
    
    $shortDescription = $product->short_description ?? str_limit($product->description ?? '', 100);
    
    $hasDiscount = $product->has_discount ?? false;
    $finalPrice = $product->final_price ?? $product->price ?? 0;
    $originalPrice = $product->price ?? 0;
    $discountPercent = $product->discount_percent ?? 0;
    
    $imageUrl = $product->image_url ?? asset('images/default-product.jpg');
?>

<div <?php echo e($attributes->merge(['class' => 'group'])); ?>>
    <div class="bg-[#f9f0f1] rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-[#191f01]/10 h-full flex flex-col hover:border-[#193497]">
        <!-- Product Image -->
        <div class="relative overflow-hidden h-48 bg-[#f9f0f1]">
            <?php if($hasDiscount && $discountPercent > 0): ?>
                <div class="absolute top-3 left-3 z-10">
                    <span class="bg-[#f91f01] text-[#f9f0f1] text-xs font-bold px-3 py-1 rounded-full">
                        -<?php echo e($discountPercent); ?>%
                    </span>
                </div>
            <?php endif; ?>

            <div class="w-full h-full flex items-center justify-center bg-white p-2">
    <img src="<?php echo e($imageUrl); ?>" 
         alt="<?php echo e($product->name); ?>"
         class="max-w-full max-h-full object-contain group-hover:scale-105 transition-transform duration-300"
         onerror="this.onerror=null; this.src='<?php echo e(asset('images/default-product.jpg')); ?>'">
</div>

            <!-- Add to Cart Button -->
            <div class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <form action="<?php echo e(route('cart.add', $product->id)); ?>" method="POST" class="add-to-cart-form">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit"
                        class="w-10 h-10 bg-white rounded-full shadow-md flex items-center justify-center hover:bg-[#7209b7] hover:text-white transition-colors duration-200 add-to-cart-btn"
                        title="Tambah ke Keranjang"
                        data-product-id="<?php echo e($product->id); ?>"
                        data-product-name="<?php echo e($product->name); ?>">
                        <i class="fas fa-shopping-cart text-gray-600 hover:text-white"></i>
                    </button>
                </form>
            </div>
        </div>


        <!-- Product Info -->
        <div class="p-4 flex-grow flex flex-col">
            <!-- Category Badge -->
            <div class="mb-2">
                <span class="inline-block px-2 py-1 text-xs font-semibold rounded 
                    <?php echo e($isInstan ? 'bg-[#193497]/10 text-[#193497]' : 'bg-[#7209b7]/10 text-[#7209b7]'); ?>">
                    <?php echo e($categoryName); ?>

                </span>
            </div>

            <!-- Product Name -->
            <h3 class="font-bold text-gray-800 mb-2 line-clamp-1 group-hover:text-[#193497] transition-colors">
                <a href="<?php echo e(route('products.show', $product->id)); ?>" class="hover:underline">
                    <?php echo e($product->name); ?>

                </a>
            </h3>

            <!-- Short Description -->
            <p class="text-gray-600 text-sm mb-3 line-clamp-2 flex-grow">
                <?php echo e($shortDescription); ?>

            </p>

            <!-- Price -->
            <div class="mb-3">
                <?php if($hasDiscount && $discountPercent > 0): ?>
                    <div class="flex items-center gap-2">
                        <span class="text-lg font-bold text-[#f91f01]">
                            Rp <?php echo e(number_format($finalPrice, 0, ',', '.')); ?>

                        </span>
                        <span class="text-sm text-gray-400 line-through">
                            Rp <?php echo e(number_format($originalPrice, 0, ',', '.')); ?>

                        </span>
                    </div>
                <?php else: ?>
                    <span class="text-lg font-bold text-[#7209b7]">
                        Rp <?php echo e(number_format($originalPrice, 0, ',', '.')); ?>

                    </span>
                <?php endif; ?>
            </div>

            <!-- Rating & Sales -->
            <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                <div class="flex items-center">
                    <div class="flex text-yellow-400 mr-1">
                        <?php for($i = 1; $i <= 5; $i++): ?>
                            <?php if($i <= floor($rating)): ?>
                                <i class="fas fa-star text-sm"></i>
                            <?php elseif($i == ceil($rating) && $rating - floor($rating) >= 0.3): ?>
                                <i class="fas fa-star-half-alt text-sm"></i>
                            <?php else: ?>
                                <i class="far fa-star text-sm"></i>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </div>
                    <span class="ml-1"><?php echo e(number_format($rating, 1)); ?></span>
                </div>
                <span>Terjual <?php echo e(number_format($salesCount)); ?></span>
            </div>

            <!-- Action Button -->
            <div class="mt-auto">
                <a href="<?php echo e(route('products.show', $product->id)); ?>"
                    class="block w-full bg-[#193497] hover:bg-[#f72585] text-white text-center font-semibold py-2.5 px-4 rounded-lg transition-colors duration-300 hover:shadow-lg">
                    <i class="fas fa-eye mr-2"></i> Lihat Detail
                </a>
            </div>
        </div>
    </div>
</div><?php /**PATH C:\laragon\www\cangcut\revisiimaji\resources\views/components/ui/product-card.blade.php ENDPATH**/ ?>