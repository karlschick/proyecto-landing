@extends('admin.layout')

@section('title', 'Pagos Pendientes - Daviplata')
@section('page-title', 'Pagos Pendientes - Daviplata')

@section('content')
<div class="mb-6">
    <div class="bg-orange-50 border-l-4 border-orange-500 p-4 rounded">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="w-6 h-6 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-orange-800">
                    Verificación Manual de Pagos QR
                </h3>
                <p class="mt-1 text-sm text-orange-700">
                    Revisa tu cuenta de Daviplata (<strong>+57 311 893 9652</strong>) y verifica los pagos recibidos antes de aprobarlos.
                </p>
            </div>
        </div>
    </div>
</div>

@if($payments->isEmpty())
<div class="bg-white rounded-lg shadow-md p-12 text-center">
    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    <h3 class="text-xl font-semibold text-gray-700 mb-2">No hay pagos pendientes</h3>
    <p class="text-gray-500">Todos los pagos QR han sido verificados</p>
</div>
@else
<div class="space-y-6">
    @foreach($payments as $payment)
    @php
        $order = $payment->order;
        $address = $order->shippingAddress;
    @endphp

    <div class="bg-white rounded-lg shadow-md overflow-hidden border-l-4 border-orange-500">
        <!-- Header -->
        <div class="bg-gray-50 px-6 py-4 border-b flex justify-between items-center">
            <div>
                <h3 class="font-bold text-gray-900">
                    Orden #{{ $order->order_number }}
                </h3>
                <p class="text-sm text-gray-600">
                    Recibido: {{ $payment->created_at->format('d/m/Y H:i') }}
                    ({{ $payment->created_at->diffForHumans() }})
                </p>
            </div>
            <div class="text-right">
                <span class="text-2xl font-bold text-orange-600">
                    ${{ number_format($order->total, 0, ',', '.') }}
                </span>
            </div>
        </div>

        <div class="p-6">
            <div class="grid md:grid-cols-2 gap-6">
                <!-- Cliente -->
                <div>
                    <h4 class="font-semibold text-gray-900 mb-3">👤 Información del Cliente</h4>
                    <div class="space-y-2 text-sm">
                        <p><strong>Nombre:</strong> {{ $address->full_name }}</p>
                        <p><strong>Email:</strong> {{ $address->email }}</p>
                        <p><strong>Teléfono:</strong> {{ $address->phone }}</p>
                    </div>
                </div>

                <!-- Productos -->
                <div>
                    <h4 class="font-semibold text-gray-900 mb-3">📦 Productos</h4>
                    <div class="space-y-2">
                        @foreach($order->items as $item)
                        <div class="flex items-center gap-2 text-sm">
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-semibold">
                                {{ $item->quantity }}x
                            </span>
                            <span class="text-gray-700">{{ $item->product_name }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Formularios de Acción -->
            <div class="mt-6 pt-6 border-t">
                <div class="grid md:grid-cols-2 gap-4">
                    <!-- Verificar Pago -->
                    <form action="{{ route('admin.payments.verify', $payment) }}" method="POST" class="space-y-3">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Referencia de Daviplata *
                            </label>
                            <input type="text"
                                   name="transaction_reference"
                                   required
                                   placeholder="Ej: DVP123456789"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Notas (opcional)
                            </label>
                            <textarea name="notes"
                                      rows="2"
                                      placeholder="Observaciones..."
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"></textarea>
                        </div>
                        <button type="submit"
                                class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-semibold transition flex items-center justify-center gap-2"
                                onclick="return confirm('¿Confirmas que recibiste el pago en Daviplata?')">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            ✅ Verificar y Aprobar
                        </button>
                    </form>

                    <!-- Rechazar Pago -->
                    <form action="{{ route('admin.payments.reject', $payment) }}" method="POST" class="space-y-3">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Motivo del rechazo *
                            </label>
                            <textarea name="rejection_reason"
                                      required
                                      rows="2"
                                      placeholder="Explica por qué rechazas este pago..."
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500"></textarea>
                        </div>
                        <button type="submit"
                                class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-semibold transition flex items-center justify-center gap-2 mt-14"
                                onclick="return confirm('¿Estás seguro de rechazar este pago? La orden será cancelada.')">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            ❌ Rechazar Pago
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Paginación -->
    <div class="mt-6">
        {{ $payments->links() }}
    </div>
</div>
@endif
@endsection
