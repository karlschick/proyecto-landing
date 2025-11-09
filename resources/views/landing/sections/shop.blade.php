@if(($settings->shop_enabled ?? true) && isset($products) && $products->count())
<section id="shop" class="py-16 bg-gray-200">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-center mb-10">Nuestra Tienda</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($products as $product)
                @php
                    $defaultImage = asset('images/settings/default-product.png');
                    $imageUrl = method_exists($product, 'getImageUrl')
                        ? ($product->image ? $product->getImageUrl() : $defaultImage)
                        : ($product->image ? asset('images/products/' . $product->image) : $defaultImage);
                @endphp

                <div class="bg-white rounded-2xl shadow hover:shadow-lg transition p-5 flex justify-between items-center gap-4">
                    {{-- Texto --}}
                    <div class="flex-1 text-left">
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">{{ $product->name }}</h3>
                        <p class="text-gray-600 text-sm mb-3">
                            {{ Str::limit($product->description, 80) }}
                        </p>

                        <div class="flex justify-between items-center">
                            <span class="text-base font-bold text-indigo-600">
                                ${{ number_format($product->price, 0, ',', '.') }}
                            </span>
                            <a href="{{ route('shop.show', $product->slug) }}"
                               class="text-xs text-white bg-indigo-600 px-3 py-1.5 rounded-lg hover:bg-indigo-700 transition">
                                Ver más
                            </a>
                        </div>
                    </div>

                    {{-- Imagen al lado derecho --}}
                    <div class="flex-shrink-0">
                        <img src="{{ $imageUrl }}"
                             alt="{{ $product->name }}"
                             class="w-24 h-24 object-cover rounded-xl shadow-md">
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
