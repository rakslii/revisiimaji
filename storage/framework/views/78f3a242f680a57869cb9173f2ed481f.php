

<?php $__env->startSection('title', 'Create New Order'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Create New Order</h1>
            <p class="text-gray-600 mt-1">Add a new customer order</p>
        </div>
        <div>
            <a href="<?php echo e(route('admin.orders.index')); ?>" 
               class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">
                <i class="fas fa-arrow-left mr-2"></i>Back to Orders
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow">
        <form action="<?php echo e(route('admin.orders.store')); ?>" method="POST" id="orderForm">
            <?php echo csrf_field(); ?>
            
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Order Information</h3>
            </div>
            
            <div class="p-6 space-y-6">
                <!-- Customer Selection -->
                <div>
                    <label for="customer_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Customer <span class="text-red-500">*</span>
                    </label>
                    <select name="customer_id" id="customer_id" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Select Customer</option>
                        <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($customer->id); ?>" <?php echo e(old('customer_id') == $customer->id ? 'selected' : ''); ?>>
                                <?php echo e($customer->name); ?> - <?php echo e($customer->phone); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['customer_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Products Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Products <span class="text-red-500">*</span>
                    </label>
                    
                    <!-- Add Products Button -->
                    <button type="button" 
                            onclick="openProductModal()"
                            class="w-full p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-gray-400 hover:bg-gray-50 text-center">
                        <i class="fas fa-plus text-gray-400 mr-2"></i>
                        <span class="text-gray-700">Click to Add Products</span>
                    </button>
                    
                    <!-- Selected Products Table -->
                    <div class="mt-4 border rounded-lg overflow-hidden" id="productsTableContainer" style="display: none;">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                                </tr>
                            </thead>
                            <tbody id="selectedProducts" class="bg-white divide-y divide-gray-200">
                                <!-- Products will be added here dynamically -->
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <td colspan="3" class="px-4 py-3 text-right text-sm font-medium text-gray-700">Total</td>
                                    <td id="orderTotal" class="px-4 py-3 text-sm font-bold text-gray-900">Rp 0</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    
                    <!-- Hidden input for products data -->
                    <input type="hidden" name="products" id="productsInput" value="<?php echo e(old('products', '[]')); ?>">
                    <?php $__errorArgs = ['products'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Shipping Address -->
                <div>
                    <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-2">Shipping Address</label>
                    <textarea name="shipping_address" id="shipping_address" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Enter shipping address"><?php echo e(old('shipping_address')); ?></textarea>
                    <?php $__errorArgs = ['shipping_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Status and Payment -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Order Status</label>
                        <select name="status" id="status"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="pending" <?php echo e(old('status', 'pending') == 'pending' ? 'selected' : ''); ?>>Pending</option>
                            <option value="waiting_payment" <?php echo e(old('status') == 'waiting_payment' ? 'selected' : ''); ?>>Waiting Payment</option>
                            <option value="paid" <?php echo e(old('status') == 'paid' ? 'selected' : ''); ?>>Paid</option>
                            <option value="processing" <?php echo e(old('status') == 'processing' ? 'selected' : ''); ?>>Processing</option>
                            <option value="completed" <?php echo e(old('status') == 'completed' ? 'selected' : ''); ?>>Completed</option>
                            <option value="cancelled" <?php echo e(old('status') == 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                        </select>
                        <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div>
                        <label for="payment_status" class="block text-sm font-medium text-gray-700 mb-2">Payment Status</label>
                        <select name="payment_status" id="payment_status"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="unpaid" <?php echo e(old('payment_status', 'unpaid') == 'unpaid' ? 'selected' : ''); ?>>Unpaid</option>
                            <option value="paid" <?php echo e(old('payment_status') == 'paid' ? 'selected' : ''); ?>>Paid</option>
                        </select>
                        <?php $__errorArgs = ['payment_status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <!-- Payment Method -->
                <div>
                    <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">Payment Method</label>
                    <select name="payment_method" id="payment_method"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Select Payment Method</option>
                        <option value="cash" <?php echo e(old('payment_method') == 'cash' ? 'selected' : ''); ?>>Cash</option>
                        <option value="bank_transfer" <?php echo e(old('payment_method') == 'bank_transfer' ? 'selected' : ''); ?>>Bank Transfer</option>
                        <option value="credit_card" <?php echo e(old('payment_method') == 'credit_card' ? 'selected' : ''); ?>>Credit Card</option>
                        <option value="ewallet" <?php echo e(old('payment_method') == 'ewallet' ? 'selected' : ''); ?>>E-Wallet</option>
                    </select>
                    <?php $__errorArgs = ['payment_method'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Notes -->
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                    <textarea name="notes" id="notes" rows="2"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Additional notes for this order"><?php echo e(old('notes')); ?></textarea>
                    <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
            
            <!-- Form Actions -->
            <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                <a href="<?php echo e(route('admin.orders.index')); ?>" 
                   class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Create Order
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Product Selection Modal -->
<div id="productModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full mx-4 max-h-[80vh] overflow-hidden flex flex-col">
        <!-- Modal Header -->
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-medium text-gray-900">Select Products</h3>
                <p class="text-sm text-gray-500 mt-1">Select products to add to the order</p>
            </div>
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" 
                           id="productSearch" 
                           placeholder="Search products..."
                           class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           onkeyup="searchProducts()">
                </div>
                <button type="button" 
                        onclick="closeProductModal()"
                        class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
        
        <!-- Products Grid -->
        <div class="flex-1 overflow-y-auto p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="productsGrid">
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="product-card border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow" 
                     data-name="<?php echo e(strtolower($product->name)); ?>"
                     data-category="<?php echo e(strtolower($product->category ?? '')); ?>">
                    <div class="flex items-start space-x-4">
                        <!-- Product Image -->
                        <div class="flex-shrink-0">
                            <img src="<?php echo e($product->image_url ?? '/images/placeholder.jpg'); ?>" 
                                 alt="<?php echo e($product->name); ?>"
                                 class="w-20 h-20 object-cover rounded-md">
                        </div>
                        
                        <!-- Product Info -->
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-900"><?php echo e($product->name); ?></h4>
                            <p class="text-sm text-gray-500 mt-1"><?php echo e($product->sku ?? 'N/A'); ?></p>
                            <p class="text-lg font-bold text-blue-600 mt-2">
                                Rp <?php echo e(number_format($product->price, 0, ',', '.')); ?>

                            </p>
                            <p class="text-sm text-gray-500 mt-1">
                                Stock: <span class="font-medium <?php echo e($product->stock < 10 ? 'text-red-600' : 'text-green-600'); ?>">
                                    <?php echo e($product->stock); ?>

                                </span>
                            </p>
                            
                            <!-- Quantity Selector -->
                            <div class="flex items-center mt-3">
                                <button type="button" 
                                        onclick="adjustQuantity('<?php echo e($product->id); ?>', -1)"
                                        class="px-3 py-1 border border-gray-300 rounded-l-lg hover:bg-gray-50">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" 
                                       id="quantity_<?php echo e($product->id); ?>"
                                       min="1"
                                       max="<?php echo e($product->stock); ?>"
                                       value="1"
                                       class="w-16 text-center border-y border-gray-300 py-1">
                                <button type="button" 
                                        onclick="adjustQuantity('<?php echo e($product->id); ?>', 1)"
                                        class="px-3 py-1 border border-gray-300 rounded-r-lg hover:bg-gray-50">
                                    <i class="fas fa-plus"></i>
                                </button>
                                <button type="button" 
                                        onclick="addToOrder(<?php echo e($product->id); ?>, <?php echo e($product->price); ?>, '<?php echo e($product->name); ?>')"
                                        class="ml-3 px-4 py-1 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">
                                    Add
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            
            <?php if($products->isEmpty()): ?>
            <div class="text-center py-12">
                <i class="fas fa-box-open fa-3x text-gray-300 mb-4"></i>
                <p class="text-gray-500">No products available</p>
            </div>
            <?php endif; ?>
        </div>
        
        <!-- Modal Footer -->
        <div class="px-6 py-4 border-t border-gray-200 flex justify-between items-center">
            <div>
                <span class="text-sm text-gray-600">
                    Selected: <span id="selectedCount" class="font-medium">0</span> products
                </span>
            </div>
            <div class="flex space-x-3">
                <button type="button" 
                        onclick="closeProductModal()"
                        class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">
                    Cancel
                </button>
                <button type="button" 
                        onclick="closeProductModal()"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Done
                </button>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
let selectedProducts = [];

// Load existing products if any (for form validation errors)
document.addEventListener('DOMContentLoaded', function() {
    const productsInput = document.getElementById('productsInput');
    if (productsInput && productsInput.value !== '[]') {
        selectedProducts = JSON.parse(productsInput.value);
        updateSelectedProductsTable();
    }
});

// Product Modal Functions
function openProductModal() {
    document.getElementById('productModal').classList.remove('hidden');
    updateSelectedCount();
}

function closeProductModal() {
    document.getElementById('productModal').classList.add('hidden');
}

function searchProducts() {
    const searchTerm = document.getElementById('productSearch').value.toLowerCase();
    const productCards = document.querySelectorAll('.product-card');
    
    productCards.forEach(card => {
        const productName = card.getAttribute('data-name');
        const productCategory = card.getAttribute('data-category');
        
        if (productName.includes(searchTerm) || productCategory.includes(searchTerm)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}

function adjustQuantity(productId, delta) {
    const input = document.getElementById('quantity_' + productId);
    let value = parseInt(input.value) || 0;
    const max = parseInt(input.max) || 999;
    
    value += delta;
    if (value < 1) value = 1;
    if (value > max) value = max;
    
    input.value = value;
}

function addToOrder(productId, price, productName) {
    const quantityInput = document.getElementById('quantity_' + productId);
    const quantity = parseInt(quantityInput.value) || 1;
    
    // Check if product already exists in selection
    const existingIndex = selectedProducts.findIndex(p => p.id == productId);
    
    if (existingIndex > -1) {
        // Update quantity
        selectedProducts[existingIndex].quantity += quantity;
    } else {
        // Add new product
        selectedProducts.push({
            id: productId,
            name: productName,
            price: price,
            quantity: quantity
        });
    }
    
    // Reset quantity input
    quantityInput.value = 1;
    
    // Update UI
    updateSelectedProductsTable();
    updateSelectedCount();
    
    // Show success message
    showToast('Product added to order', 'success');
}

function removeFromOrder(productId) {
    selectedProducts = selectedProducts.filter(p => p.id != productId);
    updateSelectedProductsTable();
    updateSelectedCount();
}

function updateSelectedProductsTable() {
    const tbody = document.getElementById('selectedProducts');
    const totalElement = document.getElementById('orderTotal');
    const productsInput = document.getElementById('productsInput');
    const container = document.getElementById('productsTableContainer');
    
    if (selectedProducts.length > 0) {
        container.style.display = 'block';
        
        tbody.innerHTML = '';
        let total = 0;
        
        selectedProducts.forEach(product => {
            const subtotal = product.price * product.quantity;
            total += subtotal;
            
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="px-4 py-3">
                    <div class="flex items-center">
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-900">${product.name}</p>
                            <p class="text-xs text-gray-500">Product ID: ${product.id}</p>
                        </div>
                    </div>
                </td>
                <td class="px-4 py-3 text-sm text-gray-900">
                    Rp ${formatNumber(product.price)}
                </td>
                <td class="px-4 py-3">
                    <div class="flex items-center">
                        <button type="button" 
                                onclick="updateProductQuantity(${product.id}, -1)"
                                class="px-2 py-1 border border-gray-300 rounded-l-lg hover:bg-gray-50">
                            <i class="fas fa-minus text-xs"></i>
                        </button>
                        <input type="number" 
                               value="${product.quantity}" 
                               min="1"
                               onchange="updateProductQuantity(${product.id}, this.value)"
                               class="w-16 text-center border-y border-gray-300 py-1">
                        <button type="button" 
                                onclick="updateProductQuantity(${product.id}, 1)"
                                class="px-2 py-1 border border-gray-300 rounded-r-lg hover:bg-gray-50">
                            <i class="fas fa-plus text-xs"></i>
                        </button>
                    </div>
                </td>
                <td class="px-4 py-3 text-sm font-medium text-gray-900">
                    Rp ${formatNumber(subtotal)}
                </td>
                <td class="px-4 py-3">
                    <button type="button" 
                            onclick="removeFromOrder(${product.id})"
                            class="text-red-600 hover:text-red-900">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(row);
        });
        
        totalElement.textContent = `Rp ${formatNumber(total)}`;
        productsInput.value = JSON.stringify(selectedProducts);
    } else {
        container.style.display = 'none';
        productsInput.value = '[]';
    }
}

function updateProductQuantity(productId, value) {
    const product = selectedProducts.find(p => p.id == productId);
    if (product) {
        if (typeof value === 'string') {
            product.quantity = parseInt(value) || 1;
        } else {
            product.quantity = Math.max(1, product.quantity + value);
        }
        updateSelectedProductsTable();
    }
}

function updateSelectedCount() {
    const countElement = document.getElementById('selectedCount');
    countElement.textContent = selectedProducts.length;
}

function formatNumber(number) {
    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function showToast(message, type = 'info') {
    // Create toast element
    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 px-4 py-3 rounded-lg shadow-lg z-50 ${
        type === 'success' ? 'bg-green-100 text-green-800 border border-green-200' :
        type === 'error' ? 'bg-red-100 text-red-800 border border-red-200' :
        'bg-blue-100 text-blue-800 border border-blue-200'
    }`;
    toast.innerHTML = `
        <div class="flex items-center">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} mr-2"></i>
            <span>${message}</span>
        </div>
    `;
    
    // Add to DOM
    document.body.appendChild(toast);
    
    // Remove after 3 seconds
    setTimeout(() => {
        toast.remove();
    }, 3000);
}

// Form validation
document.getElementById('orderForm').addEventListener('submit', function(e) {
    if (selectedProducts.length === 0) {
        e.preventDefault();
        showToast('Please add at least one product to the order', 'error');
        openProductModal();
    }
});

// Close modal when clicking outside
document.getElementById('productModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeProductModal();
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('pages.admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\IMAJI\revisiimaji\resources\views\pages\admin\orders\create.blade.php ENDPATH**/ ?>