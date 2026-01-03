@props(['product'])

<div {{ $attributes->merge(['class' => 'group']) }}>
    <div
        class="bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 h-full flex flex-col hover:border-blue-200">
        <!-- Product Image -->
        <div class="relative overflow-hidden h-48 bg-gradient-to-br from-blue-50 to-gray-50">
            @if ($product->discount_percent > 0)
                <div class="absolute top-3 left-3 z-10">
                    <span class="bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full">
                        -{{ $product->discount_percent }}%
                    </span>
                </div>
            @endif

            <!-- Product Image -->
            @if ($product->hasMedia('products'))
                <img src="{{ $product->getFirstMediaUrl('products') }}" alt="{{ $product->name }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
            @else
                <div class="w-full h-full flex items-center justify-center p-4">
                    <i class="fas fa-print text-blue-200 text-6xl"></i>
                </div>
            @endif


            <!-- Add to Cart Button -->
            <div class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="add-to-cart-form">
                    @csrf
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit"
                        class="w-10 h-10 bg-white rounded-full shadow-md flex items-center justify-center hover:bg-green-50 hover:text-green-600 transition-colors duration-200"
                        onclick="return addToCart(event, {{ $product->id }}, '{{ $product->name }}')">
                        <i class="fas fa-shopping-cart text-gray-600"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Product Info -->
        <div class="p-4 flex-grow flex flex-col">
            <!-- Category Badge -->
            @if ($product->category)
                <div class="mb-2">
                    @php
                        $categoryType = is_object($product->category) ? $product->category->type : $product->category;
                        $categoryName = is_object($product->category)
                            ? $product->category->name
                            : ($product->category === 'instan'
                                ? 'Produk Instan'
                                : 'Produk Custom');
                        $isInstan = $categoryType === 'instan';
                    @endphp
                    <span
                        class="inline-block px-2 py-1 text-xs font-semibold rounded 
                        {{ $isInstan ? 'bg-blue-100 text-blue-600' : 'bg-purple-100 text-purple-600' }}">
                        {{ $categoryName }}
                    </span>
                </div>
            @endif

            <!-- Product Name -->
            <h3 class="font-bold text-gray-800 mb-2 line-clamp-1 group-hover:text-blue-600 transition-colors">
                <a href="{{ route('products.show', $product->id) }}" class="hover:underline">
                    {{ $product->name }}
                </a>
            </h3>

            <!-- Short Description -->
            <p class="text-gray-600 text-sm mb-3 line-clamp-2 flex-grow">
                {{ $product->short_description ?: Str::limit($product->description, 100) }}
            </p>

            <!-- Price -->
            <div class="mb-3">
                @if ($product->discount_percent > 0)
                    @php
                        $discountedPrice = $product->price - ($product->price * $product->discount_percent) / 100;
                    @endphp
                    <div class="flex items-center gap-2">
                        <span class="text-lg font-bold text-red-600">
                            Rp {{ number_format($discountedPrice, 0, ',', '.') }}
                        </span>
                        <span class="text-sm text-gray-400 line-through">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </span>
                    </div>
                @else
                    <span class="text-lg font-bold text-blue-600">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </span>
                @endif
            </div>

            <!-- Rating & Sales -->
            <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                <div class="flex items-center">
                    <div class="flex text-yellow-400 mr-1">
                        @php
                            $rating = $product->rating ?? 0;
                        @endphp
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= floor($rating))
                                <i class="fas fa-star text-sm"></i>
                            @elseif($i == ceil($rating) && $rating - floor($rating) >= 0.3)
                                <i class="fas fa-star-half-alt text-sm"></i>
                            @else
                                <i class="far fa-star text-sm"></i>
                            @endif
                        @endfor
                    </div>
                    <span class="ml-1">{{ number_format($rating, 1) }}</span>
                </div>
                <span>Terjual {{ $product->sales_count ?? 0 }}</span>
            </div>

            <!-- Action Button -->
            <div class="mt-auto">
                <a href="{{ route('products.show', $product->id) }}"
                    class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center font-semibold py-2.5 px-4 rounded-lg transition-colors duration-300">
                    <i class="fas fa-eye mr-2"></i> Lihat Detail
                </a>
            </div>
        </div>
    </div>
</div>
