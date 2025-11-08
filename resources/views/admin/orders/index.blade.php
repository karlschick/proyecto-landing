@extends('admin.layout')

@section('title', 'Órdenes')
@section('page-title', 'Gestión de Órdenes')

@section('content')
<!-- Estadísticas -->
<div class="grid md:grid-cols-4 lg:grid-cols-8 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-4">
        <div class="text-sm text-gray-600 mb-1">Total</div>
        <div class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</div>
    </div>
    <div class="bg-yellow-50 rounded-lg shadow p-4">
        <div class="text-sm text-yellow-700 mb-1">Pendientes</div>
        <div class="text-2xl font-bold text-yellow-900">{{ $stats['pending'] }}</div>
    </div>
    <div class="bg-green-50 rounded-lg shadow p-4">
        <div class="text-sm text-green-700 mb-1">Pagadas</div>
        <div class="text-2xl font-bold text-green-900">{{ $stats['paid'] }}</div>
    </div>
    <div class="bg-blue-50 rounded-lg shadow p-4">
        <div class="text-sm text-blue-700 mb-1">En Proceso</div>
        <div class="text-2xl font-bold text-blue-900">{{ $stats['processing'] }}</div>
    </div>
    <div class="bg-purple-50 rounded-lg shadow p-4">
        <div class="text-sm text-purple-700 mb-1">Enviadas</div>
        <div class="text-2xl font-bold text-purple-900">{{ $stats['shipped'] }}</div>
    </div>
    <div class="bg-green-50 rounded-lg shadow p-4">
        <div class="text-sm text-green-700 mb-1">Entregadas</div>
        <div class="text-2xl font-bold text-green-900">{{ $stats['delivered'] }}</div>
    </div>
    <div class="bg-red-50 rounded-lg shadow p-4">
        <div class="text-sm text-red-700 mb-1">Canceladas</div>
        <div class="text-2xl font-bold text-red-900">{{ $stats['cancelled'] }}</div>
    </div>
    <div class="bg-indigo-50 rounded-lg shadow p-4">
        <div class="text-sm text-indigo-700 mb-1">Ingresos</div>
        <div class="text-xl font-bold text-indigo-900">${{ number_format($stats['total_revenue'], 0, ',', '.') }}</div>
    </div>
</div>

<!-- Filtros -->
<div class="bg-white rounded-lg shadow p-4 mb-6">
    <form method="GET" class="grid md:grid-cols-5 gap-4">
        <div>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Buscar órdenes..."
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="">Todos los estados</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pendiente</option>
                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Pagado</option>
                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>En Proceso</option>
                <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Enviado</option>
                <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Entregado</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelado</option>
            </select>
        </div>

        <div>
            <input type="date" name="date_from" value="{{ request('date_from') }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <input type="date" name="date_to" value="{{ request('date_to') }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="flex gap-2">
            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                Filtrar
            </button>
            @if(request()->hasAny(['search', 'status', 'date_from', 'date_to']))
            <a href="{{ route('admin.orders.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition">
                Limpiar
            </a>
            @endif
            <a href="{{ route('admin.orders.export', request()->query()) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                Exportar
            </a>
        </div>
    </form>
</div>

@if($orders->count() > 0)
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Orden</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($orders as $order)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">#{{ $order->order_number }}</div>
                        <div class="text-sm text-gray-500">{{ $order->items->count() }} productos</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">
                            {{ $order->user?->name ?? $order->shippingAddress?->full_name ?? 'Invitado' }}
                        </div>
                        <div class="text-sm text-gray-500">
                            {{ $order->user?->email ?? $order->shippingAddress?->email ?? '' }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        {{ $order->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-bold text-gray-900">${{ number_format($order->total, 0, ',', '.') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $order->getStatusBadge() }}">
                            {{ $order->getStatusText() }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 hover:text-blue-900">
                            Ver Detalles
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">
    {{ $orders->appends(request()->query())->links() }}
</div>
@else
<div class="bg-white rounded-lg shadow p-12 text-center">
    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
    </svg>
    <h3 class="text-xl font-semibold text-gray-700 mb-2">No hay órdenes</h3>
    <p class="text-gray-500">Las órdenes de los clientes aparecerán aquí</p>
</div>
@endif
@endsection
