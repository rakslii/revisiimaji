<footer class="bg-gray-900 text-white pt-12 pb-8">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Company Info -->
            <div>
                <div class="flex items-center space-x-2 mb-4">
                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-print text-white"></i>
                    </div>
                    <span class="text-xl font-bold">Cipta Imaji</span>
                </div>
                <p class="text-gray-400 mb-4">
                    Digital printing terpercaya dengan kualitas terbaik sejak 2024.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white">
                        <i class="fab fa-instagram text-xl"></i>
                    </a>
                    <a href="<?php echo e(route('whatsapp.chat')); ?>" target="_blank" class="text-gray-400 hover:text-white">
                        <i class="fab fa-whatsapp text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white">
                        <i class="fab fa-facebook text-xl"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Menu Cepat</h3>
                <ul class="space-y-2">
                    <li><a href="<?php echo e(route('home')); ?>" class="text-gray-400 hover:text-white">Beranda</a></li>
                    <li><a href="<?php echo e(route('products.index')); ?>?category=instan" class="text-gray-400 hover:text-white">Produk Instan</a></li>
                    <li><a href="<?php echo e(route('products.index')); ?>?category=non-instan" class="text-gray-400 hover:text-white">Produk Custom</a></li>
                    <li><a href="<?php echo e(route('whatsapp.chat')); ?>" target="_blank" class="text-gray-400 hover:text-white">Konsultasi</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Kontak Kami</h3>
                <ul class="space-y-3">
                    <li class="flex items-center space-x-3">
                        <i class="fas fa-phone text-blue-400"></i>
                        <span class="text-gray-400">+62 812-3456-7890</span>
                    </li>
                    <li class="flex items-center space-x-3">
                        <i class="fas fa-envelope text-blue-400"></i>
                        <span class="text-gray-400">info@ciptaimaji.com</span>
                    </li>
                    <li class="flex items-center space-x-3">
                        <i class="fas fa-map-marker-alt text-blue-400"></i>
                        <span class="text-gray-400">Jakarta, Indonesia</span>
                    </li>
                </ul>
            </div>

            <!-- Business Hours -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Jam Operasional</h3>
                <ul class="space-y-2 text-gray-400">
                    <li class="flex justify-between">
                        <span>Senin - Jumat</span>
                        <span>08:00 - 17:00</span>
                    </li>
                    <li class="flex justify-between">
                        <span>Sabtu</span>
                        <span>08:00 - 15:00</span>
                    </li>
                    <li class="flex justify-between">
                        <span>Minggu</span>
                        <span class="text-red-400">Libur</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Copyright -->
        <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-500">
            <p>&copy; <?php echo e(date('Y')); ?> Cipta Imaji Digital Printing. All rights reserved.</p>
            <p class="mt-2 text-sm">Made with <i class="fas fa-heart text-red-500"></i> for Indonesia's creative industry</p>
        </div>
    </div>
</footer><?php /**PATH C:\laragon\www\cangcut\revisiimaji\resources\views\layouts\footer.blade.php ENDPATH**/ ?>