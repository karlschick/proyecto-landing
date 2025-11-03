@extends('admin.layout')

@section('title', 'Detalle de Lead')
@section('page-title', 'Detalle del Lead #' . $lead->id)

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- Botón Volver -->
    <div>
        <a href="{{ route('admin.leads.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Volver a la lista
        </a>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">

        <!-- Columna Principal -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Información del Lead -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $lead->name }}</h2>
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $lead->getStatusBadge() }}">
                                {{ $lead->getStatusText() }}
                            </span>
                            @if($lead->isNew())
                                <span class="px-3 py-1 text-sm font-bold rounded-full bg-red-500 text-white animate-pulse">
                                    NUEVO
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="text-right text-sm text-gray-500">
                        <p>Recibido:</p>
                        <p class="font-semibold text-gray-700">{{ $lead->created_at->format('d/m/Y H:i') }}</p>
                        <p class="text-xs mt-1">{{ $lead->getTimeAgo() }}</p>
                    </div>
                </div>

                <!-- Datos de Contacto -->
                <div class="grid md:grid-cols-2 gap-6 mb-6 p-4 bg-gray-50 rounded-lg">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Email</label>
                        <a href="mailto:{{ $lead->email }}"
                           class="text-blue-600 hover:text-blue-800 font-medium flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            {{ $lead->email }}
                        </a>
                    </div>

                    @if($lead->phone)
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Teléfono</label>
                        <a href="tel:{{ $lead->phone }}"
                           class="text-green-600 hover:text-green-800 font-medium flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            {{ $lead->phone }}
                        </a>
                    </div>
                    @endif
                </div>

                @if($lead->subject)
                <div class="mb-6">
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Asunto</label>
                    <p class="text-gray-800 font-medium">{{ $lead->subject }}</p>
                </div>
                @endif

                <!-- Mensaje -->
                <div class="mb-6">
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Mensaje</label>
                    <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-blue-500">
                        <p class="text-gray-800 leading-relaxed whitespace-pre-wrap">{{ $lead->message }}</p>
                    </div>
                </div>

                <!-- Acciones Rápidas -->
                <div class="flex flex-wrap gap-3 pt-6 border-t">
                    <a href="mailto:{{ $lead->email }}"
                       class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Responder por Email
                    </a>

                    @if($lead->phone)
                    <a href="tel:{{ $lead->phone }}"
                       class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        Llamar
                    </a>
                    @endif

                    <form action="{{ route('admin.leads.destroy', $lead) }}" method="POST"
                          onsubmit="return confirm('¿Estás seguro de eliminar este lead?')"
                          class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Eliminar
                        </button>
                    </form>
                </div>
            </div>

            <!-- Notas del Admin -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Notas Internas
                </h3>
                <form action="{{ route('admin.leads.update-notes', $lead) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <textarea name="admin_notes" rows="6"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Escribe aquí tus notas sobre este lead...">{{ old('admin_notes', $lead->admin_notes) }}</textarea>
                    <button type="submit"
                            class="mt-3 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                        Guardar Notas
                    </button>
                </form>
            </div>
        </div>

        <!-- Columna Lateral -->
        <div class="space-y-6">

            <!-- Cambiar Estado -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Estado del Lead</h3>
                <form action="{{ route('admin.leads.update-status', $lead) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <select name="status"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 mb-3"
                            onchange="this.form.submit()">
                        <option value="nuevo" {{ $lead->status == 'nuevo' ? 'selected' : '' }}>Nuevo</option>
                        <option value="contactado" {{ $lead->status == 'contactado' ? 'selected' : '' }}>Contactado</option>
                        <option value="calificado" {{ $lead->status == 'calificado' ? 'selected' : '' }}>Calificado</option>
                        <option value="convertido" {{ $lead->status == 'convertido' ? 'selected' : '' }}>Convertido</option>
                        <option value="descartado" {{ $lead->status == 'descartado' ? 'selected' : '' }}>Descartado</option>
                    </select>
                    <noscript>
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                            Actualizar
                        </button>
                    </noscript>
                </form>
            </div>

            <!-- Información Técnica -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Información Técnica</h3>
                <div class="space-y-3 text-sm">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">ID</label>
                        <p class="text-gray-800 font-mono">#{{ $lead->id }}</p>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">IP Address</label>
                        <p class="text-gray-800 font-mono">{{ $lead->ip_address ?? 'N/A' }}</p>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">User Agent</label>
                        <p class="text-gray-600 text-xs break-all">{{ $lead->user_agent ?? 'N/A' }}</p>
                    </div>

                    @if($lead->read_at)
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Leído</label>
                        <p class="text-gray-800">{{ $lead->read_at->format('d/m/Y H:i') }}</p>
                    </div>
                    @endif

                    @if($lead->contacted_at)
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Contactado</label>
                        <p class="text-gray-800">{{ $lead->contacted_at->format('d/m/Y H:i') }}</p>
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
