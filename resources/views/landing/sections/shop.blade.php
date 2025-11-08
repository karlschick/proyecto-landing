@if($settings->products_enabled && isset($products) && $products->count())
<section id="shop" class="py-16 bg-gray-50">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-center mb-10">Nuestra Tienda</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($products as $product)
                <div class="bg-white rounded-2xl shadow hover:shadow-lg transition p-6">
                    @if($product->image)
                        <img src="{{ asset('images/products/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover rounded-xl mb-4">
                    @endif

                    <h3 class="text-xl font-semibold mb-2">{{ $product->name }}</h3>
                    <p class="text-gray-600 mb-4">{{ Str::limit($product->description, 100) }}</p>

                    <div class="flex justify-between items-center">
                        <span class="text-lg font-bold text-indigo-600">
                            ${{ number_format($product->price, 2) }}
                        </span>
                        <a href="{{ route('shop.show', $product->slug) }}"
                           class="text-sm text-white bg-indigo-600 px-4 py-2 rounded hover:bg-indigo-700 transition">
                            Ver más
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
