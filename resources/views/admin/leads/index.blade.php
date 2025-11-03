@extends('admin.layout')

@section('title', 'Leads')
@section('page-title', 'Gestión de Leads')

@section('content')
<div class="space-y-6">

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Nuevos</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $stats['nuevos'] }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">No Leídos</p>
                    <p class="text-2xl font-bold text-red-600">{{ $stats['no_leidos'] }}</p>
                </div>
                <div class="bg-red-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Contactados</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $stats['contactados'] }}</p>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Convertidos</p>
                    <p class="text-2xl font-bold text-green-600">{{ $stats['convertidos'] }}</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Actions -->
    <div class="bg-white rounded-lg shadow p-6">
        <form method="GET" class="grid md:grid-cols-4 gap-4">
            <!-- Búsqueda -->
            <div>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Buscar por nombre, email..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Estado -->
            <div>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Todos los estados</option>
                    <option value="nuevo" {{ request('status') == 'nuevo' ? 'selected' : '' }}>Nuevos</option>
                    <option value="contactado" {{ request('status') == 'contactado' ? 'selected' : '' }}>Contactados</option>
                    <option value="calificado" {{ request('status') == 'calificado' ? 'selected' : '' }}>Calificados</option>
                    <option value="convertido" {{ request('status') == 'convertido' ? 'selected' : '' }}>Convertidos</option>
                    <option value="descartado" {{ request('status') == 'descartado' ? 'selected' : '' }}>Descartados</option>
                </select>
            </div>

            <!-- Leído -->
            <div>
                <select name="read" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Todos</option>
                    <option value="unread" {{ request('read') == 'unread' ? 'selected' : '' }}>No leídos</option>
                    <option value="read" {{ request('read') == 'read' ? 'selected' : '' }}>Leídos</option>
                </select>
            </div>

            <!-- Botones -->
            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                    Filtrar
                </button>
                @if(request()->hasAny(['search', 'status', 'read']))
                <a href="{{ route('admin.leads.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition">
                    Limpiar
                </a>
                @endif
            </div>
        </form>

        <!-- Acciones masivas -->
        <div class="mt-4 flex gap-2">
            <a href="{{ route('admin.leads.export', request()->all()) }}"
               class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Exportar CSV
            </a>
        </div>
    </div>

    <!-- Tabla de Leads -->
    @if($leads->count() > 0)
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email / Teléfono</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mensaje</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($leads as $lead)
                        <tr class="hover:bg-gray-50 {{ $lead->isNew() ? 'bg-blue-50' : '' }}">
                        <!-- Estado -->
                        <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $lead->getStatusBadge() }}">
                        {{ $lead->getStatusText() }}
                        </span>
                        @if($lead->isNew())
                        <span class="ml-2 px-2 py-1 text-xs font-bold rounded-full bg-red-500 text-white animate-pulse">
                        NUEVO
                        </span>
                        @endif
                        </td>
                        <!-- Nombre -->
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            @if(!$lead->read_at)
                                <div class="w-2 h-2 bg-blue-500 rounded-full mr-2"></div>
                            @endif
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $lead->name }}</div>
                                @if($lead->subject)
                                    <div class="text-xs text-gray-500">{{ Str::limit($lead->subject, 30) }}</div>
                                @endif
                            </div>
                        </div>
                    </td>                    <!-- Email / Teléfono -->
                    <td class="px-6 py-4">
                        <div class="text-sm">
                            <a href="mailto:{{ $lead->email }}" class="text-blue-600 hover:text-blue-800 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                {{ $lead->email }}
                            </a>
                            @if($lead->phone)
                                <a href="tel:{{ $lead->phone }}" class="text-green-600 hover:text-green-800 flex items-center gap-1 mt-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    {{ $lead->phone }}
                                </a>
                            @endif
                        </div>
                    </td>                    <!-- Mensaje -->
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-600 max-w-md">
                            <p class="line-clamp-2">{{ $lead->message }}</p>
                        </div>
                    </td>                    <!-- Fecha -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $lead->created_at->format('d/m/Y') }}</div>
                        <div class="text-xs text-gray-500">{{ $lead->created_at->format('H:i') }}</div>
                        <div class="text-xs text-gray-400 mt-1">{{ $lead->getTimeAgo() }}</div>
                    </td>                    <!-- Acciones -->
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.leads.show', $lead) }}"
                               class="text-blue-600 hover:text-blue-900"
                               title="Ver detalles">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                            <form action="{{ route('admin.leads.destroy', $lead) }}" method="POST"
                                  onsubmit="return confirm('¿Estás seguro de eliminar este lead?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" title="Eliminar">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div><!-- Paginación -->
<div class="mt-6">
    {{ $leads->appends(request()->query())->links() }}
</div>
@else
<div class="bg-white rounded-lg shadow p-12 text-center">
    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
    </svg>
    <h3 class="text-xl font-semibold text-gray-700 mb-2">No hay leads</h3>
    <p class="text-gray-500">Los contactos aparecerán aquí cuando lleguen desde el formulario.</p>
</div>
@endif
</div>
@endsection
