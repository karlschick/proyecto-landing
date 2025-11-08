@extends('landing.layout')

@section('title', $product->name)

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4">
        <!-- Breadcrumb -->
        <nav class="mb-6 text-sm">
            <ol class="flex items-center space-x-2 text-gray-600">
                <li><a href="{{ route('shop.index') }}" class="hover:text-blue-600">Tienda</a></li>
                <li><span class="mx-2">/</span></li>
                @if($product->category)
                    <li><a href="{{ route('shop.index', ['category' => $product->category_id]) }}" class="hover:text-blue-600">{{ $product->category->name }}</a></li>
                    <li><span class="mx-2">/</span></li>
                @endif
                <li class="text-gray-900 font-medium">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="grid lg:grid-cols-2 gap-8 mb-12">
            <!-- Imágenes -->
            <div>
                <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-4">
                    <div class="aspect-square relative">
                        <img id="mainImage" src="{{ $product->getFeaturedImageUrl() }}"
                             alt="{{ $product->name }}"
                             class="w-full h-full object-cover">
                        @if($product->hasDiscount())
                            <div class="absolute top-4 right-4 bg-red-500 text-white px-4 py-2 rounded-full text-lg font-bold">
                                -{{ $product->getDiscountPercentage() }}%
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Galería de miniaturas -->
                @if($product->gallery_images && count($product->gallery_images) > 0)
                    <div class="grid grid-cols-4 gap-3">
                        <button onclick="changeImage('{{ $product->getFeaturedImageUrl() }}')" class="aspect-square rounded-lg overflow-hidden border-2 border-blue-500">
                            <img src="{{ $product->getFeaturedImageUrl() }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        </button>
                        @foreach($product->getGalleryUrls() as $image)
                            <button onclick="changeImage('{{ $image }}')" class="aspect-square rounded-lg overflow-hidden border-2 border-gray-200 hover:border-blue-500 transition">
                                <img src="{{ $image }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Información del Producto -->
            <div class="bg-white rounded-lg shadow-lg p-8">
                @if($product->category)
                    <p class="text-sm text-blue-600 font-medium mb-2">{{ $product->category->name }}</p>
                @endif

                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>

                @if($product->short_description)
                    <p class="text-lg text-gray-600 mb-6">{{ $product->short_description }}</p>
                @endif

                <!-- Precio -->
                <div class="mb-6 pb-6 border-b border-gray-200">
                    @if($product->hasDiscount())
                        <p class="text-2xl text-gray-500 line-through mb-2">${{ number_format($product->compare_price, 0, ',', '.') }}</p>
                    @endif
                    <p class="text-4xl font-bold text-blue-600">${{ number_format($product->price, 0, ',', '.') }}</p>
                    @if($product->hasDiscount())
                        <p class="text-sm text-green-600 font-medium mt-2">¡Ahorra ${{ number_format($product->compare_price - $product->price, 0, ',', '.') }}!</p>
                    @endif
                </div>

                <!-- Stock -->
                <div class="mb-6">
                    @if($product->isInStock())
                        @if($product->track_quantity && $product->quantity <= 10)
                            <p class="text-orange-600 font-medium">
                                <svg class="inline w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                ¡Solo quedan {{ $product->quantity }} unidades!
                            </p>
                        @else
                            <p class="text-green-600 font-medium">
                                <svg class="inline w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                En stock - Disponible para envío inmediato
                            </p>
                        @endif
                    @else
                        <p class="text-red-600 font-medium">
                            <svg class="inline w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            Producto agotado
                        </p>
                    @endif
                </div>

                <!-- Agregar al Carrito -->
                @if($product->isInStock())
                    <form action="{{ route('cart.add', $product) }}" method="POST" class="mb-6">
                        @csrf
                        <div class="flex items-center gap-4 mb-4">
                            <label class="text-gray-700 font-medium">Cantidad:</label>
                            <input type="number" name="quantity" value="1" min="1"
                                   max="{{ $product->track_quantity ? $product->quantity : 999 }}"
                                   class="w-24 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg font-bold text-lg transition flex items-center justify-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Agregar al Carrito
                        </button>
                    </form>
                @else
                    <div class="bg-gray-100 text-gray-600 px-8 py-4 rounded-lg text-center font-semibold">
                        Producto no disponible
                    </div>
                @endif
            </div>
        </div>

        <!-- Descripción Completa -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Descripción del Producto</h2>
            <div class="prose max-w-none text-gray-700">
                {!! nl2br(e($product->description)) !!}
            </div>
        </div>

        <!-- Productos Relacionados -->
        @if($relatedProducts->count() > 0)
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Productos Relacionados</h2>
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $related)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition group">
                            <a href="{{ route('shop.show', $related->slug) }}" class="block">
                                <div class="relative aspect-square overflow-hidden">
                                    <img src="{{ $related->getFeaturedImageUrl() }}"
                                         alt="{{ $related->name }}"
                                         class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                                    @if($related->hasDiscount())
                                        <div class="absolute top-2 right-2 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                                            -{{ $related->getDiscountPercentage() }}%
                                        </div>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <h3 class="font-semibold text-gray-800 mb-2 line-clamp-2 group-hover:text-blue-600 transition">
                                        {{ $related->name }}
                                    </h3>
                                    <div class="flex items-center justify-between">
                                        <div>
                                            @if($related->hasDiscount())
                                                <p class="text-sm text-gray-500 line-through">${{ number_format($related->compare_price, 0, ',', '.') }}</p>
                                            @endif
                                            <p class="text-xl font-bold text-blue-600">${{ number_format($related->price, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

<script>
function changeImage(url) {
    document.getElementById('mainImage').src = url;
}
</script>
@endsection
