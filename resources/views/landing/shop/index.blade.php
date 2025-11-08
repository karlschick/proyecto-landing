@extends('landing.layout')

@section('title', 'Tienda')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-12">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-bold mb-2">Nuestra Tienda</h1>
            <p class="text-blue-100">Encuentra los mejores productos con envío a toda Colombia</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar - Filtros -->
            <aside class="lg:w-64 flex-shrink-0">
                <div class="bg-white rounded-lg shadow p-6 sticky top-4">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Filtros</h3>

                    <form method="GET" action="{{ route('shop.index') }}">
                        <!-- Búsqueda -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Buscar</label>
                            <input type="text" name="search" value="{{ request('search') }}"
                                   placeholder="Buscar productos..."
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <!-- Categorías -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Categorías</label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="radio" name="category" value=""
                                           {{ request('category') == '' ? 'checked' : '' }}
                                           class="w-4 h-4 text-blue-600">
                                    <span class="ml-2 text-sm text-gray-700">Todas</span>
                                </label>
                                @foreach($categories as $category)
                                <label class="flex items-center">
                                    <input type="radio" name="category" value="{{ $category->id }}"
                                           {{ request('category') == $category->id ? 'checked' : '' }}
                                           class="w-4 h-4 text-blue-600">
                                    <span class="ml-2 text-sm text-gray-700">
                                        {{ $category->name }}
                                        <span class="text-gray-400">({{ $category->products_count }})</span>
                                    </span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Ordenamiento -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ordenar por</label>
                            <select name="sort" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Más recientes</option>
                                <option value="featured" {{ request('sort') == 'featured' ? 'selected' : '' }}>Destacados</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Precio: Menor a Mayor</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Precio: Mayor a Menor</option>
                                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nombre A-Z</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition">
                                Aplicar Filtros
                            </button>
                            @if(request()->hasAny(['search', 'category', 'sort']))
                            <a href="{{ route('shop.index') }}" class="block w-full text-center bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-semibold transition">
                                Limpiar Filtros
                            </a>
                            @endif
                        </div>
                    </form>
                </div>
            </aside>

            <!-- Productos -->
            <main class="flex-1">
                <!-- Productos Destacados -->
                @if($featuredProducts->count() > 0 && !request()->hasAny(['search', 'category', 'sort']))
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Productos Destacados</h2>
                    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($featuredProducts as $product)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition group">
                            <a href="{{ route('shop.show', $product->slug) }}" class="block">
                                <div class="relative aspect-square overflow-hidden">
                                    <img src="{{ $product->getFeaturedImageUrl() }}"
                                         alt="{{ $product->name }}"
                                         class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                                    @if($product->hasDiscount())
                                    <div class="absolute top-2 right-2 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                                        -{{ $product->getDiscountPercentage() }}%
                                    </div>
                                    @endif
                                    @if($product->is_featured)
                                    <div class="absolute top-2 left-2 bg-yellow-400 text-yellow-900 px-3 py-1 rounded-full text-xs font-bold">
                                        ⭐ Destacado
                                    </div>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <h3 class="font-semibold text-gray-800 mb-2 line-clamp-2 group-hover:text-blue-600 transition">
                                        {{ $product->name }}
                                    </h3>
                                    @if($product->short_description)
                                    <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $product->short_description }}</p>
                                    @endif
                                    <div class="flex items-center justify-between">
                                        <div>
                                            @if($product->hasDiscount())
                                            <p class="text-sm text-gray-500 line-through">${{ number_format($product->compare_price, 0, ',', '.') }}</p>
                                            @endif
                                            <p class="text-xl font-bold text-blue-600">${{ number_format($product->price, 0, ',', '.') }}</p>
                                        </div>
                                        @if($product->isInStock())
                                        <span class="text-xs text-green-600 font-medium">En stock</span>
                                        @else
                                        <span class="text-xs text-red-600 font-medium">Agotado</span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Todos los Productos -->
                <div>
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-2xl font-bold text-gray-800">
                            @if(request('search'))
                                Resultados para "{{ request('search') }}"
                            @elseif(request('category'))
                                {{ $categories->firstWhere('id', request('category'))->name ?? 'Productos' }}
                            @else
                                Todos los Productos
                            @endif
                        </h2>
                        <p class="text-gray-600">{{ $products->total() }} productos</p>
                    </div>

                    @if($products->count() > 0)
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($products as $product)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition group">
                            <a href="{{ route('shop.show', $product->slug) }}" class="block">
                                <div class="relative aspect-square overflow-hidden">
                                    <img src="{{ $product->getFeaturedImageUrl() }}"
                                         alt="{{ $product->name }}"
                                         class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                                    @if($product->hasDiscount())
                                    <div class="absolute top-2 right-2 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                                        -{{ $product->getDiscountPercentage() }}%
                                    </div>
                                    @endif
                                    @if($product->is_featured)
                                    <div class="absolute top-2 left-2 bg-yellow-400 text-yellow-900 px-3 py-1 rounded-full text-xs font-bold">
                                        ⭐ Destacado
                                    </div>
                                    @endif
                                </div>
                                <div class="p-4">
                                    @if($product->category)
                                    <p class="text-xs text-gray-500 mb-1">{{ $product->category->name }}</p>
                                    @endif
                                    <h3 class="font-semibold text-gray-800 mb-2 line-clamp-2 group-hover:text-blue-600 transition">
                                        {{ $product->name }}
                                    </h3>
                                    @if($product->short_description)
                                    <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $product->short_description }}</p>
                                    @endif
                                    <div class="flex items-center justify-between">
                                        <div>
                                            @if($product->hasDiscount())
                                            <p class="text-sm text-gray-500 line-through">${{ number_format($product->compare_price, 0, ',', '.') }}</p>
                                            @endif
                                            <p class="text-xl font-bold text-blue-600">${{ number_format($product->price, 0, ',', '.') }}</p>
                                        </div>
                                        @if($product->isInStock())
                                        <span class="text-xs text-green-600 font-medium">En stock</span>
                                        @else
                                        <span class="text-xs text-red-600 font-medium">Agotado</span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>

                    <!-- Paginación -->
                    <div class="mt-8">
                        {{ $products->appends(request()->query())->links() }}
                    </div>
                    @else
                    <div class="bg-white rounded-lg shadow p-12 text-center">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h3 class="text-xl font-semibold text-gray-700 mb-2">No se encontraron productos</h3>
                        <p class="text-gray-500 mb-6">Intenta con otros criterios de búsqueda</p>
                        <a href="{{ route('shop.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                            Ver todos los productos
                        </a>
                    </div>
                    @endif
                </div>
            </main>
        </div>
    </div>
</div>
@endsection
