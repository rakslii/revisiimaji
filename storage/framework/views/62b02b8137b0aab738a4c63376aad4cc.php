

<?php $__env->startSection('title', $product->name . ' - Cipta Imaji'); ?>
<?php $__env->startPush('styles'); ?>
<style>
#cartToast {
  transform: translateX(400px);
  transition: transform .3s ease;
}
#cartToast.show {
  transform: translateX(0);
}


</style>
<?php $__env->startSection('content'); ?>
<div class="bg-[#f9f0f1] min-h-screen py-8">
    <div class="container mx-auto px-4">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm">
                <li><a href="<?php echo e(route('home')); ?>" class="text-gray-500 hover:text-[#193497] transition-colors"><i class="fas fa-home mr-1"></i> Beranda</a></li>
                <li><i class="fas fa-chevron-right text-gray-300 text-xs"></i></li>
                <li><a href="<?php echo e(route('products.index')); ?>" class="text-gray-500 hover:text-[#193497] transition-colors">Produk</a></li>
                <li><i class="fas fa-chevron-right text-gray-300 text-xs"></i></li>
                <li class="font-semibold text-[#193497] truncate max-w-xs"><?php echo e($product->name); ?></li>
            </ol>
        </nav>

        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">
                <!-- Product Images -->
                <div class="p-8 lg:p-12 bg-[#f9f0f1]">
                    <!-- Main Image -->
                    <div class="bg-white rounded-3xl h-[500px] flex items-center justify-center mb-6 relative overflow-hidden group shadow-lg">
    <img 
        src="<?php echo e(asset('storage/'.$product->image)); ?>" 
        alt="<?php echo e($product->name); ?>"
        class="w-full h-full object-cover"
        onerror="this.onerror=null; this.src='<?php echo e(asset('images/default-product.jpg')); ?>'">

                        <div class="absolute top-4 left-4 flex flex-col gap-2">
                            <?php if($product->discount_percent > 0): ?>
                                <span class="bg-[#f91f01] text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg">-<?php echo e($product->discount_percent); ?>% OFF</span>
                            <?php endif; ?>
                            <?php if($product->category === 'instan'): ?>
                                <span class="bg-[#193497] text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg"><i class="fas fa-bolt mr-1"></i> Instan</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
   <!-- Thumbnails -->
<div class="grid grid-cols-4 gap-3 mb-6">
    <?php for($i = 0; $i < 4; $i++): ?>
    <div class="rounded-2xl h-28 overflow-hidden cursor-pointer hover:ring-4 ring-[#193497] transition-all duration-300 shadow-md thumbnail-item">
        <img src="<?php echo e(asset('storage/'.$product->image)); ?>" alt="Thumbnail <?php echo e($i + 1); ?>" class="w-full h-full object-cover">
    </div>
    <?php endfor; ?>
</div>

                    <!-- Quick Info Cards -->
                    <div class="space-y-3">
                        <div class="bg-white rounded-xl p-4 shadow-md border-l-4 border-[#193497]">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-shield-check text-[#193497] text-lg"></i>
                                    </div>
                                    <div>
                                        <div class="text-xs text-gray-500">Garansi Kualitas</div>
                                        <div class="font-bold text-gray-800">100% Original</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl p-4 shadow-md border-l-4 border-green-500">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-truck-fast text-green-600 text-lg"></i>
                                    </div>
                                    <div>
                                        <div class="text-xs text-gray-500">Pengiriman</div>
                                        <div class="font-bold text-gray-800">Gratis Ongkir*</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl p-4 shadow-md border-l-4 border-purple-500">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-clock text-purple-600 text-lg"></i>
                                    </div>
                                    <div>
                                        <div class="text-xs text-gray-500">Waktu Produksi</div>
                                        <div class="font-bold text-gray-800">
                                            <?php if($product->category === 'instan'): ?>
                                                1 Hari Kerja
                                            <?php else: ?>
                                                3-7 Hari Kerja
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-r from-[#193497] to-[#142a7a] rounded-xl p-4 shadow-lg text-white">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-headset text-white text-lg"></i>
                                    </div>
                                    <div>
                                        <div class="text-xs text-white/80">Customer Support</div>
                                        <div class="font-bold">24/7 Online</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Social Share Buttons -->
                    <div class="flex gap-3 mt-6">
                        <button class="flex-1 bg-white hover:bg-red-50 text-red-500 py-3 rounded-full font-semibold transition-all shadow-md flex items-center justify-center border border-red-200">
                            <i class="fas fa-heart mr-2"></i> Wishlist
                        </button>
                        <button class="flex-1 bg-white hover:bg-blue-50 text-[#193497] py-3 rounded-full font-semibold transition-all shadow-md flex items-center justify-center border border-blue-200">
                            <i class="fas fa-share-alt mr-2"></i> Share
                        </button>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="p-8 lg:p-12">
                    <div class="flex flex-wrap items-center gap-2 mb-4">
                        <?php if($product->category): ?>
                            <span class="px-4 py-2 text-xs font-bold rounded-full <?php echo e($product->category === 'instan' ? 'bg-blue-100 text-[#193497]' : 'bg-purple-100 text-purple-600'); ?>">
                                <?php echo e($product->category === 'instan' ? 'PRODUK INSTAN' : 'PRODUK CUSTOM'); ?>

                            </span>
                        <?php endif; ?>
                    </div>

                    <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4 leading-tight"><?php echo e($product->name); ?></h1>
                    
                    <?php if($product->short_description): ?>
                        <p class="text-gray-600 text-lg mb-6 leading-relaxed"><?php echo e($product->short_description); ?></p>
                    <?php endif; ?>

                    <div class="flex items-center gap-6 mb-8 pb-8 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="flex text-yellow-400 mr-2">
                                <?php $rating = $product->rating ?? 4.5; ?>
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <i class="fas fa-star <?php echo e($i <= floor($rating) ? '' : 'text-gray-300'); ?>"></i>
                                <?php endfor; ?>
                            </div>
                            <span class="text-gray-700 font-semibold"><?php echo e(number_format($rating, 1)); ?></span>
                        </div>
                        <div class="h-6 w-px bg-gray-300"></div>
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-shopping-bag mr-2"></i>
                            <span><strong><?php echo e($product->sales_count ?? 127); ?></strong> Terjual</span>
                        </div>
                    </div>

                    <!-- Pricing Tiers -->
                    <div class="mb-8 bg-gradient-to-r from-blue-50 to-purple-50 rounded-2xl p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-tags text-[#193497] mr-2"></i>
                            Harga per pcs
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center bg-white rounded-xl p-4">
                                <span class="text-gray-700 font-semibold">1 - 100 pcs</span>
                                <span class="text-[#193497] font-bold">Rp <?php echo e(number_format($product->price, 0, ',', '.')); ?></span>
                            </div>
                            <div class="flex justify-between items-center bg-white rounded-xl p-4">
                                <span class="text-gray-700 font-semibold">≥ 101 pcs</span>
                                <span class="text-green-600 font-bold">Rp <?php echo e(number_format($product->price * 0.85, 0, ',', '.')); ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Order Form -->
                    <div class="bg-gray-50 rounded-2xl p-6 mb-8 border-2 border-gray-200">
                        <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                            <i class="fas fa-shopping-cart text-[#193497] mr-2"></i>
                            Atur Pesanan
                        </h3>
                        
                        <!-- Product Selection -->
                        <div class="mb-6">
                            <label class="block text-gray-700 font-semibold mb-3">Pilih Produk dan Bahan Tote bag</label>
                            <select class="w-full bg-white border-2 border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:border-[#193497]">
                                <option><?php echo e($product->name); ?></option>
                            </select>
                        </div>

                        <!-- Quantity -->
                        <div class="mb-6">
                            <label class="block text-gray-700 font-semibold mb-3">Jumlah (Min Order: <?php echo e($product->min_order); ?> pcs)</label>
                            <div class="flex items-center gap-4">
                                <div class="flex items-center bg-white rounded-xl border-2 border-gray-200 overflow-hidden">
                                    <button type="button" class="qty-minus w-12 h-12 bg-gray-100 hover:bg-[#193497] hover:text-white flex items-center justify-center transition-colors">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" id="quantity" value="<?php echo e($product->min_order); ?>" min="<?php echo e($product->min_order); ?>" class="w-20 h-12 text-center border-none font-bold text-xl focus:outline-none">
                                    <button type="button" class="qty-plus w-12 h-12 bg-gray-100 hover:bg-[#193497] hover:text-white flex items-center justify-center transition-colors">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="mb-6">
                            <label class="block text-gray-700 font-semibold mb-3">Keterangan</label>
                            <textarea id="order-notes" rows="4" class="w-full bg-white border-2 border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:border-[#193497] resize-none" placeholder="Tambahkan catatan untuk pesanan Anda..."></textarea>
                        </div>

                        <!-- File Upload -->
                        <div class="mb-6">
                            <label class="block text-gray-700 font-semibold mb-3">
                                Upload File <span class="text-sm text-gray-500">(PDF, JPG, ZIP, RAR max 50MB)</span>
                            </label>
                            <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-[#193497] transition-colors cursor-pointer" id="upload-area">
                                <input type="file" id="file-upload" class="hidden" accept=".pdf,.jpg,.jpeg,.png,.zip,.rar,.ai,.psd,.cdr">
                                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                                <p class="text-gray-600 font-semibold">Upload File</p>
                                <p class="text-sm text-gray-500">Klik atau drag file ke sini</p>
                            </div>
                            <div id="file-preview" class="mt-3 hidden">
                                <div class="bg-green-50 border border-green-200 rounded-xl p-3 flex items-center justify-between">
                                    <div class="flex items-center">
                                        <i class="fas fa-file text-green-600 text-xl mr-3"></i>
                                        <span class="text-gray-700 font-semibold" id="file-name"></span>
                                    </div>
                                    <button type="button" id="remove-file" class="text-red-500 hover:text-red-700">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Promo Code -->
                        <div class="mb-6">
                            <label class="block text-gray-700 font-semibold mb-3">Promo</label>
                            <div class="flex gap-3">
                                <input type="text" id="promo-code" placeholder="Masukkan Kode Promo" class="flex-1 bg-white border-2 border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:border-[#193497]">
                                <button type="button" id="apply-promo" class="bg-[#193497] hover:bg-blue-700 text-white font-semibold px-6 rounded-xl transition-colors flex items-center">
                                    <i class="fas fa-sync-alt mr-2"></i>
                                </button>
                            </div>
                            <div id="promo-message" class="mt-2 text-sm hidden"></div>
                        </div>

                        <!-- Order Summary -->
                        <div class="bg-white rounded-2xl p-6 mb-6 border border-gray-200">
                            <div class="space-y-3 mb-4">
                                <div class="flex justify-between text-gray-700">
                                    <span>Waktu Pengerjaan</span>
                                    <span class="font-semibold">1 HARI</span>
                                </div>
                                <div class="flex justify-between text-gray-700">
                                    <span>Harga Barang</span>
                                    <span class="font-semibold" id="item-price">Rp <?php echo e(number_format($product->price * $product->min_order, 0, ',', '.')); ?></span>
                                </div>
                                <div class="flex justify-between text-gray-700">
                                    <span>Jumlah</span>
                                    <span class="font-semibold" id="display-quantity"><?php echo e($product->min_order); ?></span>
                                </div>
                                <div class="flex justify-between text-green-600" id="discount-row" style="display: none;">
                                    <span>Diskon</span>
                                    <span class="font-semibold" id="discount-amount">- Rp 0</span>
                                </div>
                            </div>
                            <div class="border-t pt-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-700 font-semibold">Total Harga</span>
                                    <span class="text-3xl font-bold text-[#193497]" id="total-price">Rp <?php echo e(number_format($product->price * $product->min_order, 0, ',', '.')); ?></span>
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="grid grid-cols-1 gap-3">
                            <!-- Add to Cart -->
                            <form action="<?php echo e(route('cart.add', $product->id)); ?>" method="POST" id="add-to-cart-form">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="quantity" id="form-quantity" value="<?php echo e($product->min_order); ?>">
                                <input type="hidden" name="notes" id="form-notes">
                                <input type="hidden" name="file" id="form-file">
                                <button type="submit" class="w-full bg-white border-2 border-[#193497] text-[#193497] hover:bg-[#193497] hover:text-white font-bold py-4 px-6 rounded-xl flex items-center justify-center transition-all shadow-lg hover:shadow-2xl transform hover:scale-[1.02]">
                                    <i class="fas fa-shopping-cart mr-3 text-xl"></i>
                                    <span class="text-lg">Tambah ke Keranjang</span>
                                </button>
                            </form>

                            <!-- Buy Now -->
                            <button type="button" id="buy-now-btn" class="w-full bg-[#193497] hover:bg-[#0f2354] text-white font-bold py-4 px-6 rounded-xl flex items-center justify-center transition-all shadow-lg hover:shadow-2xl transform hover:scale-[1.02]">
                                <i class="fas fa-bolt mr-3 text-xl"></i>
                                <span class="text-lg">Beli Sekarang</span>
                            </button>

                            <!-- WhatsApp -->
                            <button type="button" id="whatsapp-btn" class="w-full bg-[#193497] hover:bg-[#0f2354] text-white font-bold py-4 px-6 rounded-xl flex items-center justify-center transition-all shadow-lg hover:shadow-2xl transform hover:scale-[1.02]">
                                <i class="fab fa-whatsapp mr-3 text-2xl"></i>
                                <span class="text-lg">Konsultasi via WhatsApp</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <div class="border-t border-gray-200">
                <div class="flex border-b border-gray-200">
                    <button class="tab-button active px-8 py-4 font-bold text-[#193497] border-b-4 border-[#193497]" data-tab="description">RINCIAN PRODUK</button>
                    <button class="tab-button px-8 py-4 font-bold text-gray-600 hover:text-[#193497]" data-tab="reviews">ULASAN (1)</button>
                </div>

                <div class="p-8 lg:p-12">
                    <!-- Description Tab -->
                    <div id="description-tab" class="tab-content">
                        <div class="prose max-w-none text-gray-700">
                            <p class="mb-4"><?php echo e($product->description); ?></p>
                            
                            <h3 class="text-xl font-bold mt-6 mb-3">Spesifikasi:</h3>
                            <ul class="list-disc pl-6 space-y-2">
                                <li>Material: Kanvas natural (Cotton)</li>
                                <li>Warna: Natural (Beige)</li>
                                <li>Ukuran: 35 x 40 cm</li>
                                <li>Ukuran Desain: 21x30cm</li>
                            </ul>

                            <h3 class="text-xl font-bold mt-6 mb-3">Instruksi Perawatan:</h3>
                            <ul class="list-disc pl-6 space-y-2">
                                <li>Dicuci menggunakan tangan, hindari pencucian dengan mesin</li>
                                <li>Jangan diperas</li>
                                <li>Hindari penggunaan pemutih pakaian</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Reviews Tab -->
                    <div id="reviews-tab" class="tab-content hidden">
                        <h2 class="text-2xl font-bold mb-6">Ulasan Pelanggan</h2>
                        <div class="bg-gray-50 rounded-xl p-6">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-[#193497] rounded-full flex items-center justify-center text-white font-bold mr-4">A</div>
                                <div>
                                    <h4 class="font-bold">Pelanggan 1</h4>
                                    <div class="flex text-yellow-400 text-sm">
                                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="text-gray-700">Produk sangat bagus, kualitas cetakan tajam dan warna sesuai ekspektasi!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4">
    <div class="relative max-w-4xl max-h-[90vh]">
        <button id="closeModal" class="absolute -top-12 right-0 text-white hover:text-gray-300 text-4xl font-bold">
            <i class="fas fa-times"></i>
        </button>
        <img id="modalImage" src="" alt="Product Image" class="max-w-full max-h-[85vh] object-contain rounded-lg shadow-2xl">
    </div>
</div>

<!-- Toast Notification -->
<div id="cartToast" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-4 rounded-xl shadow-2xl transform translate-x-[400px] transition-transform duration-300 z-[60] flex items-center gap-3">
    <i class="fas fa-check-circle text-2xl"></i>
    <div>
        <div class="font-bold">Berhasil!</div>
        <div class="text-sm">Produk ditambahkan ke keranjang</div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>

// Image Modal
const imageModal = document.getElementById('imageModal');
const modalImage = document.getElementById('modalImage');
const closeModal = document.getElementById('closeModal');
const thumbnails = document.querySelectorAll('.thumbnail-item');
const mainImage = document.querySelector('.bg-white.rounded-3xl.h-\\[500px\\] img');

// Array untuk menyimpan semua gambar
let imageArray = [];
let currentImageIndex = 0;

// Populate image array (1 main image + 4 thumbnails = 5 total)
imageArray.push(mainImage.src); // Main image
thumbnails.forEach(thumb => {
    imageArray.push(thumb.querySelector('img').src);
});

// Function to show image at index
function showImageAtIndex(index) {
    if (index < 0) index = imageArray.length - 1;
    if (index >= imageArray.length) index = 0;
    
    currentImageIndex = index;
    modalImage.src = imageArray[index];
}

// Click on thumbnail
thumbnails.forEach((thumb, index) => {
    thumb.addEventListener('click', function() {
        showImageAtIndex(index + 1); // +1 karena index 0 adalah main image
        imageModal.classList.remove('hidden');
        imageModal.classList.add('flex');
    });
});

// Click on main image
if (mainImage) {
    mainImage.parentElement.style.cursor = 'pointer';
    mainImage.parentElement.addEventListener('click', function() {
        showImageAtIndex(0); // Main image ada di index 0
        imageModal.classList.remove('hidden');
        imageModal.classList.add('flex');
    });
}

// Close modal
closeModal.addEventListener('click', function() {
    imageModal.classList.add('hidden');
    imageModal.classList.remove('flex');
});

// Close on background click
imageModal.addEventListener('click', function(e) {
    if (e.target === imageModal) {
        imageModal.classList.add('hidden');
        imageModal.classList.remove('flex');
    }
});

// Keyboard navigation - Arrow keys untuk slide
document.addEventListener('keydown', function(e) {
    if (!imageModal.classList.contains('hidden')) {
        if (e.key === 'ArrowLeft') {
            showImageAtIndex(currentImageIndex - 1);
        } else if (e.key === 'ArrowRight') {
            showImageAtIndex(currentImageIndex + 1);
        } else if (e.key === 'Escape') {
            imageModal.classList.add('hidden');
            imageModal.classList.remove('flex');
        }
    }
});

// Swipe support untuk mobile (optional)
let touchStartX = 0;
let touchEndX = 0;

modalImage.addEventListener('touchstart', (e) => {
    touchStartX = e.changedTouches[0].screenX;
});

modalImage.addEventListener('touchend', (e) => {
    touchEndX = e.changedTouches[0].screenX;
    handleSwipe();
});

function handleSwipe() {
    if (touchEndX < touchStartX - 50) {
        // Swipe left - next image
        showImageAtIndex(currentImageIndex + 1);
    }
    if (touchEndX > touchStartX + 50) {
        // Swipe right - previous image
        showImageAtIndex(currentImageIndex - 1);
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const minusBtn = document.querySelector('.qty-minus');
    const plusBtn = document.querySelector('.qty-plus');
    const qtyInput = document.getElementById('quantity');
    const formQty = document.getElementById('form-quantity');
    const totalEl = document.getElementById('total-price');
    const itemPriceEl = document.getElementById('item-price');
    const displayQtyEl = document.getElementById('display-quantity');
    const notesInput = document.getElementById('order-notes');
    const formNotes = document.getElementById('form-notes');
    const discountRow = document.getElementById('discount-row');
    const discountAmount = document.getElementById('discount-amount');

    const basePrice = <?php echo e($product->price); ?>;
    const minOrder = <?php echo e($product->min_order); ?>;
    let promoDiscount = 0;

    function formatRupiah(val) {
        return 'Rp ' + val.toLocaleString('id-ID');
    }

    function calculateUnitPrice(qty) {
        if (qty >= 101) return basePrice * 0.85;
        return basePrice;
    }

    function updateTotal() {
        let qty = parseInt(qtyInput.value);
        if (qty < minOrder) qty = minOrder;

        const unitPrice = calculateUnitPrice(qty);
        const subtotal = unitPrice * qty;
        const finalTotal = subtotal - promoDiscount;

        qtyInput.value = qty;
        formQty.value = qty;
        displayQtyEl.textContent = qty;
        itemPriceEl.textContent = formatRupiah(subtotal);
        totalEl.textContent = formatRupiah(finalTotal);

        if (promoDiscount > 0) {
            discountRow.style.display = 'flex';
            discountAmount.textContent = '- ' + formatRupiah(promoDiscount);
        } else {
            discountRow.style.display = 'none';
        }
    }

    minusBtn.addEventListener('click', () => {
        let qty = parseInt(qtyInput.value);
        if (qty > minOrder) {
            qtyInput.value = qty - 1;
            updateTotal();
        }
    });

    plusBtn.addEventListener('click', () => {
        qtyInput.value = parseInt(qtyInput.value) + 1;
        updateTotal();
    });

    qtyInput.addEventListener('change', updateTotal);
    notesInput.addEventListener('input', () => formNotes.value = notesInput.value);

    // File Upload
    const uploadArea = document.getElementById('upload-area');
    const fileInput = document.getElementById('file-upload');
    const filePreview = document.getElementById('file-preview');
    const fileName = document.getElementById('file-name');
    const removeFile = document.getElementById('remove-file');
    const formFile = document.getElementById('form-file');

    uploadArea.addEventListener('click', () => fileInput.click());

    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.classList.add('border-[#193497]', 'bg-blue-50');
    });

    uploadArea.addEventListener('dragleave', () => {
        uploadArea.classList.remove('border-[#193497]', 'bg-blue-50');
    });

    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('border-[#193497]', 'bg-blue-50');
        if (e.dataTransfer.files.length > 0) handleFile(e.dataTransfer.files[0]);
    });

    fileInput.addEventListener('change', (e) => {
        if (e.target.files.length > 0) handleFile(e.target.files[0]);
    });

    function handleFile(file) {
        const maxSize = 50 * 1024 * 1024;
        if (file.size > maxSize) {
            alert('File terlalu besar! Maksimal 50MB');
            return;
        }
        fileName.textContent = file.name;
        filePreview.classList.remove('hidden');
        formFile.value = file.name;
    }

    removeFile.addEventListener('click', (e) => {
        e.stopPropagation();
        fileInput.value = '';
        filePreview.classList.add('hidden');
        formFile.value = '';
    });

    // Promo Code
    const promoInput = document.getElementById('promo-code');
    const applyPromo = document.getElementById('apply-promo');
    const promoMessage = document.getElementById('promo-message');

    const validPromos = {
        'DISKON10': 0.10,
        'HEMAT20': 0.20
    };

    applyPromo.addEventListener('click', () => {
        const code = promoInput.value.trim().toUpperCase();
        
        if (!code) {
            showPromoMessage('Masukkan kode promo', 'error');
            return;
        }

        if (validPromos[code]) {
            const qty = parseInt(qtyInput.value);
            const unitPrice = calculateUnitPrice(qty);
            const subtotal = unitPrice * qty;
            promoDiscount = Math.floor(subtotal * validPromos[code]);
            showPromoMessage(`Berhasil! Hemat ${formatRupiah(promoDiscount)}`, 'success');
            updateTotal();
        } else {
            showPromoMessage('Kode tidak valid', 'error');
            promoDiscount = 0;
            updateTotal();
        }
    });

    function showPromoMessage(msg, type) {
        promoMessage.textContent = msg;
        promoMessage.className = 'mt-2 text-sm ' + (type === 'success' ? 'text-green-600' : 'text-red-600');
        promoMessage.classList.remove('hidden');
    }

    // Tabs
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            const targetTab = button.getAttribute('data-tab');
            
            tabButtons.forEach(btn => {
                btn.classList.remove('active', 'text-[#193497]', 'border-[#193497]');
                btn.classList.add('text-gray-600');
            });
            
            button.classList.add('active', 'text-[#193497]', 'border-[#193497]');
            button.classList.remove('text-gray-600');
            
            tabContents.forEach(content => content.classList.add('hidden'));
            document.getElementById(targetTab + '-tab').classList.remove('hidden');
        });
    });

    // Buy Now Button
    const buyNowBtn = document.getElementById('buy-now-btn');
    buyNowBtn.addEventListener('click', function() {
        // Simpan data ke session storage atau langsung redirect dengan parameter
        const qty = qtyInput.value;
        const notes = notesInput.value;
        const file = formFile.value;
        const productId = <?php echo e($product->id); ?>;
        
        // Redirect ke checkout dengan data
        let checkoutUrl = "<?php echo e(route('cart.checkout')); ?>";
        const params = new URLSearchParams({
            product_id: productId,
            quantity: qty,
            direct_buy: 1
        });
        
        if (notes) params.append('notes', notes);
        if (file) params.append('file', file);
        
        window.location.href = checkoutUrl + '?' + params.toString();
    });

    // WhatsApp Button
    const whatsappBtn = document.getElementById('whatsapp-btn');
    whatsappBtn.addEventListener('click', function() {
        const qty = qtyInput.value;
        const notes = notesInput.value;
        const file = formFile.value;
        
        // Nomor WhatsApp admin
        const phoneNumber = '6283848817194';
        
        // Product URL
        const productUrl = window.location.href;
        
        // Build WhatsApp message
        let message = `Halo Admin Cipta Imaji! 👋

Saya tertarik dengan produk berikut:

📦 *Produk:* <?php echo e($product->name); ?>

🔗 *Link:* ${productUrl}
📊 *Jumlah:* ${qty} pcs
💰 *Total Harga:* ${totalEl.textContent}`;

        if (notes) {
            message += `

📝 *Catatan:*
${notes}`;
        }

        if (file) {
            message += `

📎 *File Design:* ${file}`;
        }

        message += `

Mohon informasi lebih lanjut untuk pemesanan ini. Terima kasih! 🙏`;

        // Encode message
        const encodedMessage = encodeURIComponent(message);
        
        // WhatsApp URL
        const whatsappUrl = `https://wa.me/${phoneNumber}?text=${encodedMessage}`;
        
        // Open WhatsApp
        window.open(whatsappUrl, '_blank');
    });

   updateTotal();

const cartForm = document.getElementById('add-to-cart-form');
const cartToast = document.getElementById('cartToast');

cartForm.addEventListener('submit', function(e) {
  e.preventDefault();

  const formData = new FormData(cartForm);

  fetch(cartForm.action, {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
    },
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      cartToast.classList.add('show');

      setTimeout(() => {
        cartToast.classList.remove('show');
      }, 3000);

      const cartCountEl = document.getElementById('cart-count');
      if (cartCountEl && data.cart_count !== undefined) {
        cartCountEl.textContent = data.cart_count;
      }
    } else {
      alert(data.message || 'Gagal nambah ke keranjang');
    }
  })
  .catch(() => {
    alert('Error pas nambah ke keranjang');
  });
});

});

</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\cangcut\revisiimaji\resources\views\pages\products\show.blade.php ENDPATH**/ ?>