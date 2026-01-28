@props(['products' => collect()])

@php
    // Pastikan $products adalah koleksi yang valid
    if (is_array($products)) {
        $products = collect($products);
    }
    
    // Debug info (bisa dihapus setelah berfungsi)
    // \Log::info('Grid component received products:', ['count' => $products->count()]);
@endphp

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    @forelse($products as $product)
        @php
            // Pastikan $product adalah object yang valid
            if (!is_object($product)) {
                continue;
            }
            
            // Cek jika product memiliki semua atribut yang diperlukan
            $isValidProduct = isset($product->id) && isset($product->name);
        @endphp
        
        @if($isValidProduct)
            <x-ui.product-card :product="$product" />
        @else
            {{-- Debug output jika product tidak valid --}}
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                <p class="text-yellow-700 text-sm">Produk data tidak valid</p>
            </div>
        @endif
    @empty
        <div class="col-span-full">
            <div class="text-center py-12">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-search text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Produk Tidak Ditemukan</h3>
                <p class="text-gray-500 mb-6">Tidak ada produk yang sesuai dengan filter pencarian Anda.</p>
                <a href="{{ route('products.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-[#193497] text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-sync-alt mr-2"></i> Reset Filter
                </a>
            </div>
        </div>
    @endforelse
</div>