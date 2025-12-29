@props(['products'])

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    @forelse($products as $product)
        <x-ui.product-card :product="$product" />
    @empty
        <div class="col-span-full">
            <div class="text-center py-12">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-search text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Produk Tidak Ditemukan</h3>
                <p class="text-gray-500 mb-6">Tidak ada produk yang sesuai dengan filter pencarian Anda.</p>
                <a href="{{ route('products.index') }}" class="inline-flex items-center text-blue-600 font-semibold hover:text-blue-800">
                    <i class="fas fa-sync-alt mr-2"></i> Reset Filter
                </a>
            </div>
        </div>
    @endforelse
</div>