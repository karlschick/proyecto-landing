@extends('admin.layout')

@section('title', 'Detalle de Orden')
@section('page-title', 'Orden #' . $order->order_number)

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.orders.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
        ← Volver a órdenes
    </a>
</div>

<div class="grid lg:grid-cols-3 gap-6">
    <!-- Columna Principal -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Productos -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Productos ({{ $order->items->count() }})</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($order->items as $item)
                    <div class="flex gap-4 pb-4 border-b border-gray-200 last:border-0">
                        @if($item->product)
                            <img src="{{ $item->product->getFeaturedImageUrl() }}" alt="{{ $item->product_name }}" class="w-20 h-20 object-cover rounded">
                        @else
                            <div class="w-20 h-20 bg-gray-200 rounded flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-900">{{ $item->product_name }}</h4>
                            <p class="text-sm text-gray-600">SKU: {{ $item->product_sku }}</p>
                            <p class="text-sm text-gray-600">Cantidad: {{ $item->quantity }}</p>
                            <p class="text-sm text-gray-600">Precio: ${{ number_format($item->price, 0, ',', '.') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-gray-900">${{ number_format($item->subtotal, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Totales -->
                <div class="mt-6 pt-6 border-t border-gray-200 space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Subtotal:</span>
                        <span class="font-semibold">${{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">IVA (19%):</span>
                        <span class="font-semibold">${{ number_format($order->tax, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Envío:</span>
                        <span class="font-semibold">${{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold pt-2 border-t border-gray-300">
                        <span>Total:</span>
                        <span>${{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dirección de Envío -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Dirección de Envío</h3>
            </div>
            <div class="p-6">
                @if($order->shippingAddress)
                    <div class="space-y-2">
                        <p class="font-semibold text-gray-900">{{ $order->shippingAddress->full_name }}</p>
                        <p class="text-gray-600">{{ $order->shippingAddress->email }}</p>
                        <p class="text-gray-600">{{ $order->shippingAddress->phone }}</p>
                        <p class="text-gray-600 mt-3">{{ $order->shippingAddress->getFullAddress() }}</p>
                        @if($order->shippingAddress->notes)
                            <div class="mt-4 p-3 bg-yellow-50 rounded">
                                <p class="text-sm font-medium text-yellow-800">Notas:</p>
                                <p class="text-sm text-yellow-700">{{ $order->shippingAddress->notes }}</p>
                            </div>
                        @endif
                    </div>
                @else
                    <p class="text-gray-500">No hay información de envío</p>
                @endif
            </div>
        </div>

        <!-- Información de Pago -->
        @if($order->payment)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Información de Pago</h3>
            </div>
            <div class="p-6">
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Método de Pago</p>
                        <p class="font-semibold text-gray-900 capitalize">{{ str_replace('_', ' ', $order->payment->payment_method) }}</p>
                    </div>
                    @if($order->payment->payment_gateway)
                    <div>
                        <p class="text-sm text-gray-600">Pasarela</p>
                        <p class="font-semibold text-gray-900 capitalize">{{ $order->payment->payment_gateway }}</p>
                    </div>
                    @endif
                    @if($order->payment->transaction_id)
                    <div>
                        <p class="text-sm text-gray-600">ID de Transacción</p>
                        <p class="font-semibold text-gray-900">{{ $order->payment->transaction_id }}</p>
                    </div>
                    @endif
                    <div>
                        <p class="text-sm text-gray-600">Estado del Pago</p>
                        <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full {{ $order->payment->getStatusBadge() }}">
                            {{ ucfirst($order->payment->status) }}
                        </span>
                    </div>
                    @if($order->payment->paid_at)
                    <div>
                        <p class="text-sm text-gray-600">Fecha de Pago</p>
                        <p class="font-semibold text-gray-900">{{ $order->payment->paid_at->format('d/m/Y H:i') }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Columna Lateral -->
    <div class="space-y-6">
        <!-- Información de la Orden -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Información</h3>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <p class="text-sm text-gray-600">Número de Orden</p>
                    <p class="font-semibold text-gray-900">#{{ $order->order_number }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Fecha</p>
                    <p class="font-semibold text-gray-900">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Cliente</p>
                    <p class="font-semibold text-gray-900">{{ $order->user?->name ?? 'Invitado' }}</p>
                    @if($order->user)
                        <p class="text-sm text-gray-600">{{ $order->user->email }}</p>
                    @endif
                </div>
                <div>
                    <p class="text-sm text-gray-600">Estado</p>
                    <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full {{ $order->getStatusBadge() }}">
                        {{ $order->getStatusText() }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Cambiar Estado -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Cambiar Estado</h3>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 mb-3">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pendiente</option>
                        <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Pagado</option>
                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>En Proceso</option>
                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Enviado</option>
                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Entregado</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                        <option value="refunded" {{ $order->status == 'refunded' ? 'selected' : '' }}>Reembolsado</option>
                    </select>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition">
                        Actualizar Estado
                    </button>
                </form>
            </div>
        </div>

        <!-- Acciones -->
        @if($order->canBeCancelled())
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Acciones</h3>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.orders.cancel', $order) }}" method="POST" onsubmit="return confirm('¿Estás seguro de cancelar esta orden? Esta acción restaurará el inventario.')">
                    @csrf
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-semibold transition">
                        Cancelar Orden
                    </button>
                </form>
            </div>
        </div>
        @endif

        <!-- Timeline -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Historial</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex gap-3">
                        <div class="flex-shrink-0 w-2 h-2 mt-2 rounded-full bg-blue-500"></div>
                        <div>
                            <p class="font-medium text-sm text-gray-900">Orden Creada</p>
                            <p class="text-xs text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                    @if($order->paid_at)
                    <div class="flex gap-3">
                        <div class="flex-shrink-0 w-2 h-2 mt-2 rounded-full bg-green-500"></div>
                        <div>
                            <p class="font-medium text-sm text-gray-900">Pagado</p>
                            <p class="text-xs text-gray-500">{{ $order->paid_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    @endif

                    @if($order->shipped_at)
                    <div class="flex gap-3">
                        <div class="flex-shrink-0 w-2 h-2 mt-2 rounded-full bg-purple-500"></div>
                        <div>
                            <p class="font-medium text-sm text-gray-900">Enviado</p>
                            <p class="text-xs text-gray-500">{{ $order->shipped_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    @endif

                    @if($order->delivered_at)
                    <div class="flex gap-3">
                        <div class="flex-shrink-0 w-2 h-2 mt-2 rounded-full bg-green-600"></div>
                        <div>
                            <p class="font-medium text-sm text-gray-900">Entregado</p>
                            <p class="text-xs text-gray-500">{{ $order->delivered_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    @endif

                    @if($order->cancelled_at)
                    <div class="flex gap-3">
                        <div class="flex-shrink-0 w-2 h-2 mt-2 rounded-full bg-red-500"></div>
                        <div>
                            <p class="font-medium text-sm text-gray-900">Cancelado</p>
                            <p class="text-xs text-gray-500">{{ $order->cancelled_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
