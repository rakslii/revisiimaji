<!-- Promo Modal -->
<div id="promoModal"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-black/70 backdrop-blur-sm">

    <div class="relative bg-white rounded-3xl max-w-md w-full mx-4 overflow-hidden shadow-2xl animate-fade-in">
        
        <!-- Close Button -->
        <button onclick="closePromo()"
                class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 text-xl">
            <i class="fas fa-times"></i>
        </button>

        <!-- Image -->
        <div class="bg-[#193497] p-8 text-center">
            <h2 class="text-3xl font-bold text-white mb-2">
                🎉 PROMO SPESIAL
            </h2>
            <p class="text-white/80">
                Diskon cetak banner & stiker
            </p>
        </div>

        <button onclick="closePromo()"
        class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 text-xl">
    <i class="fas fa-times"></i>
</button>


        <!-- Content -->
        <div class="p-6 text-center">
            <p class="text-gray-700 mb-4">
                Dapatkan <span class="font-bold text-[#193497]">Diskon 20%</span>
                untuk semua produk hari ini!
            </p>

            <div class="text-2xl font-bold text-[#720e87] mb-6">
                KODE: <span class="tracking-widest">IMAJI20</span>
            </div>

            <a href="{{ route('products.index') }}"
               class="inline-block bg-[#193497] text-white px-6 py-3 rounded-full font-bold hover:bg-[#720e87] transition">
                Pakai Sekarang
            </a>
        </div>
    </div>
</div>
