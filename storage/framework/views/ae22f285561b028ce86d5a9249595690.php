

<?php $__env->startSection('title', $product->name); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800"><?php echo e($product->name); ?></h1>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                            <i class="fas fa-home mr-2"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400"></i>
                            <a href="<?php echo e(route('admin.products.index')); ?>" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600">Products</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500"><?php echo e($product->name); ?></span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
        <div class="flex gap-2">
            <a href="<?php echo e(route('admin.products.edit', $product->id)); ?>"
               class="flex items-center gap-2 bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="<?php echo e(route('admin.products.index')); ?>"
               class="flex items-center gap-2 bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Product Image & Basic Info -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Main Product Image -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-center">
                    <?php
                        $mainImage = $product->primary_image_url ?: $product->image_url;
                    ?>

                    <div class="relative mb-4">
                        <img src="<?php echo e($mainImage); ?>"
                             alt="<?php echo e($product->name); ?>"
                             id="mainProductImage"
                             class="w-full h-64 object-cover rounded-lg mx-auto cursor-pointer hover:opacity-90 transition-opacity">

                        <!-- Image badge -->
                        <div class="absolute top-2 left-2">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-600 text-white">
                                Main Image
                            </span>
                        </div>

                        <!-- Zoom icon -->
                        <div class="absolute bottom-2 right-2">
                            <button onclick="openImageModal('<?php echo e($mainImage); ?>')"
                                    class="p-2 bg-white rounded-full shadow hover:bg-gray-100">
                                <i class="fas fa-search-plus text-gray-600"></i>
                            </button>
                        </div>
                    </div>

                    <h3 class="text-xl font-bold text-gray-800 mb-2"><?php echo e($product->name); ?></h3>

                    <div class="flex justify-center gap-2 mb-4">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full
                            <?php echo e($product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                            <?php echo e($product->is_active ? 'Active' : 'Inactive'); ?>

                        </span>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                            <?php echo e($product->category_name); ?>

                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mt-6">
                        <div class="text-center">
                            <p class="text-sm text-gray-500">Product ID</p>
                            <p class="text-lg font-bold text-gray-800">#<?php echo e($product->id); ?></p>
                        </div>
                        <div class="text-center">
                            <p class="text-sm text-gray-500">Total Images</p>
                            <p class="text-lg font-bold text-blue-600">
                                <?php echo e($product->getTotalImagesCount()); ?>

                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Image Gallery -->
            <?php if(count($product->all_images) > 0): ?>
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b">
                    <h3 class="text-lg font-medium text-gray-900">Image Gallery</h3>
                    <p class="text-sm text-gray-500 mt-1"><?php echo e(count($product->all_images)); ?> images available</p>
                </div>
                <div class="p-4">
                    <div class="grid grid-cols-4 gap-3" id="imageGallery">
                        <?php $__currentLoopData = $product->all_images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($image['url']): ?>
                                <div class="relative group">
                                    <img src="<?php echo e($image['url']); ?>"
                                         alt="Product Image <?php echo e($index + 1); ?>"
                                         onclick="changeMainImage('<?php echo e($image['url']); ?>')"
                                         class="w-full h-20 object-cover rounded-lg cursor-pointer hover:opacity-80 transition-opacity">

                                    <!-- Image type badge -->
                                    <div class="absolute top-1 left-1">
                                        <span class="px-1 py-0.5 text-xs font-semibold rounded-full
                                            <?php echo e($image['type'] === 'main' ? 'bg-blue-600 text-white' :
                                               ($image['type'] === 'legacy' ? 'bg-gray-600 text-white' :
                                               'bg-green-600 text-white')); ?>">
                                            <?php echo e($image['type'] === 'main' ? 'M' :
                                               ($image['type'] === 'legacy' ? 'L' : 'G')); ?>

                                        </span>
                                    </div>

                                    <!-- View button -->
                                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button onclick="openImageModal('<?php echo e($image['url']); ?>')"
                                                class="p-2 bg-white rounded-full shadow hover:bg-gray-100">
                                            <i class="fas fa-eye text-gray-600 text-sm"></i>
                                        </button>
                                    </div>

                                    <!-- Image info on hover -->
                                    <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-70 text-white text-xs p-1 rounded-b-lg opacity-0 group-hover:opacity-100 transition-opacity">
                                        <div class="truncate"><?php echo e($image['field'] ?? 'Image'); ?></div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Image Stats -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b">
                    <h3 class="text-lg font-medium text-gray-900">Image Statistics</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="p-2 bg-blue-100 rounded-lg mr-3">
                                <i class="fas fa-image text-blue-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Total Images</p>
                                <p class="text-lg font-bold text-gray-800"><?php echo e($product->getTotalImagesCount()); ?></p>
                            </div>
                        </div>
                    </div>

                    <?php
                        $imageTypes = [];
                        foreach($product->all_images as $image) {
                            $type = $image['type'] ?? 'unknown';
                            if(!isset($imageTypes[$type])) {
                                $imageTypes[$type] = 0;
                            }
                            $imageTypes[$type]++;
                        }
                    ?>

                    <?php $__currentLoopData = $imageTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="p-2 <?php echo e($type === 'main' ? 'bg-green-100' :
                                                  ($type === 'legacy' ? 'bg-yellow-100' : 'bg-purple-100')); ?> rounded-lg mr-3">
                                <i class="fas <?php echo e($type === 'main' ? 'fa-star' :
                                                  ($type === 'legacy' ? 'fa-archive' : 'fa-images')); ?>

                                           <?php echo e($type === 'main' ? 'text-green-600' :
                                              ($type === 'legacy' ? 'text-yellow-600' : 'text-purple-600')); ?>"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500"><?php echo e(ucfirst($type)); ?> Images</p>
                                <p class="text-lg font-bold text-gray-800"><?php echo e($count); ?></p>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>

        <!-- Right Column - Product Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Product Details Card -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b">
                    <h3 class="text-lg font-medium text-gray-900">Product Details</h3>
                </div>
                <div class="p-6">
                    <!-- Price & Stock -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Price</p>
                            <div class="flex items-baseline">
                                <span class="text-2xl font-bold text-gray-800">
                                    <?php echo e($product->formatted_price); ?>

                                </span>
                                <?php if($product->discount_percent > 0): ?>
                                    <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        -<?php echo e($product->discount_percent); ?>%
                                    </span>
                                <?php endif; ?>
                            </div>
                            <?php if($product->discount_percent > 0): ?>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">Discounted Price</p>
                                    <p class="text-xl font-bold text-green-600">
                                        <?php echo e($product->formatted_final_price); ?>

                                    </p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 mb-1">Stock</p>
                            <div class="flex items-center">
                                <p class="text-2xl font-bold
                                    <?php echo e($product->stock > 10 ? 'text-green-600' :
                                       ($product->stock > 0 ? 'text-yellow-600' : 'text-red-600')); ?>">
                                    <?php echo e($product->stock); ?>

                                </p>
                                <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full
                                    <?php echo e($product->stock > 10 ? 'bg-green-100 text-green-800' :
                                       ($product->stock > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800')); ?>">
                                    <?php echo e($product->stock > 10 ? 'Good' :
                                       ($product->stock > 0 ? 'Low' : 'Empty')); ?>

                                </span>
                            </div>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 mb-1">Category</p>
                            <div class="flex items-center">
                                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                                    <?php echo e($product->category_name); ?>

                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Short Description -->
                    <?php if($product->short_description): ?>
                    <div class="mb-6">
                        <p class="text-sm text-gray-500 mb-2">Short Description</p>
                        <p class="text-gray-700"><?php echo e($product->short_description); ?></p>
                    </div>
                    <?php endif; ?>

                    <!-- Full Description -->
                    <div class="mb-6">
                        <p class="text-sm text-gray-500 mb-2">Description</p>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-gray-700 whitespace-pre-line"><?php echo e($product->description); ?></p>
                        </div>
                    </div>

                    <!-- Specifications -->
                    <?php if($product->specifications && is_array($product->specifications) && count($product->specifications) > 0): ?>
                    <div class="mb-6">
                        <p class="text-sm text-gray-500 mb-3">Specifications</p>
                        <div class="bg-gray-50 rounded-lg overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200">
                                <tbody class="divide-y divide-gray-200">
                                    <?php $__currentLoopData = $product->specifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $spec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(isset($spec['key']) || isset($spec['value'])): ?>
                                        <tr class="hover:bg-gray-100">
                                            <td class="px-4 py-3 text-sm font-medium text-gray-700 border-r border-gray-200 w-1/3">
                                                <?php echo e($spec['key'] ?? 'N/A'); ?>

                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-600">
                                                <?php echo e($spec['value'] ?? 'N/A'); ?>

                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Additional Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Minimum Order</p>
                            <p class="text-gray-700 font-medium"><?php echo e($product->min_order); ?> item(s)</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Sales Count</p>
                            <p class="text-gray-700 font-medium"><?php echo e($product->sales_count); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Rating</p>
                            <p class="text-gray-700 font-medium"><?php echo e($product->rating ? number_format($product->rating, 1) : 'N/A'); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Discount</p>
                            <p class="text-gray-700 font-medium">
                                <?php if($product->discount_percent > 0): ?>
                                    <?php echo e($product->discount_percent); ?>% (<?php echo e($product->formatted_discount_amount); ?>)
                                <?php else: ?>
                                    No Discount
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>

                    <!-- Timestamps - PERBAIKAN DI SINI -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Created At</p>
                            <p class="text-gray-700">
                                <?php if($product->created_at): ?>
                                    <?php echo e($product->created_at->format('d M Y H:i')); ?>

                                <?php else: ?>
                                    N/A
                                <?php endif; ?>
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Last Updated</p>
                            <p class="text-gray-700">
                                <?php if($product->updated_at): ?>
                                    <?php echo e($product->updated_at->format('d M Y H:i')); ?>

                                <?php else: ?>
                                    N/A
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Actions -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b">
                    <h3 class="text-lg font-medium text-gray-900">Product Actions</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <a href="<?php echo e(route('admin.products.edit', $product->id)); ?>"
                           class="flex items-center justify-center gap-2 bg-yellow-600 text-white px-4 py-3 rounded-lg hover:bg-yellow-700 transition-colors">
                            <i class="fas fa-edit"></i>
                            <span>Edit Product</span>
                        </a>

                        <button type="button"
                                onclick="showDeleteModal(<?php echo e($product->id); ?>, '<?php echo e(addslashes($product->name)); ?>')"
                                class="flex items-center justify-center gap-2 bg-red-600 text-white px-4 py-3 rounded-lg hover:bg-red-700 transition-colors">
                            <i class="fas fa-trash"></i>
                            <span>Delete Product</span>
                        </button>

                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-90 flex items-center justify-center hidden z-50 p-4">
    <div class="relative max-w-4xl w-full">
        <button onclick="closeImageModal()"
                class="absolute -top-10 right-0 text-white hover:text-gray-300 text-2xl">
            <i class="fas fa-times"></i>
        </button>
        <img id="modalImage" src="" alt="" class="w-full h-auto rounded-lg">
        <div class="mt-4 text-center text-white">
            <p id="imageCaption" class="text-sm opacity-75"></p>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
        <div class="px-6 py-4 border-b">
            <h3 class="text-lg font-medium text-gray-900">Confirm Delete</h3>
        </div>
        <div class="px-6 py-4">
            <p id="deleteModalBody" class="text-gray-700"></p>
            <p class="text-sm text-red-600 mt-2">
                <i class="fas fa-exclamation-triangle mr-1"></i>
                This will also delete all product images!
            </p>
        </div>
        <div class="px-6 py-4 border-t flex justify-end gap-3">
            <button type="button"
                    onclick="document.getElementById('deleteModal').classList.add('hidden')"
                    class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">
                Cancel
            </button>
            <form id="deleteForm" method="POST" class="inline">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    Delete Product
                </button>
            </form>
        </div>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
<style>
#imageGallery img {
    transition: transform 0.2s ease;
}
#imageGallery img:hover {
    transform: scale(1.05);
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Change main image when clicking on gallery thumbnails
function changeMainImage(imageUrl) {
    const mainImage = document.getElementById('mainProductImage');
    mainImage.src = imageUrl;

    // Add visual feedback
    mainImage.classList.add('opacity-50');
    setTimeout(() => {
        mainImage.classList.remove('opacity-50');
    }, 300);
}

// Open image in modal
function openImageModal(imageUrl) {
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    modalImage.src = imageUrl;
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden'; // Prevent scrolling
}

// Close image modal
function closeImageModal() {
    const modal = document.getElementById('imageModal');
    modal.classList.add('hidden');
    document.body.style.overflow = ''; // Re-enable scrolling
}

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
    }
});

// Close modal when clicking outside
document.getElementById('imageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeImageModal();
    }
});

// Delete product modal
function showDeleteModal(id, productName) {
    const form = document.getElementById('deleteForm');
    form.action = `/admin/products/${id}`;

    document.getElementById('deleteModalBody').innerHTML =
        `Are you sure you want to delete <strong>"${productName}"</strong>?<br>
         This action cannot be undone and will permanently delete the product and all its images.`;

    document.getElementById('deleteModal').classList.remove('hidden');
}

// Close delete modal when clicking outside
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        this.classList.add('hidden');
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('pages.admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\revisiimaji\resources\views/pages/admin/products/show.blade.php ENDPATH**/ ?>