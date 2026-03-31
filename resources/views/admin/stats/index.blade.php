@extends('admin.layout')

@section('title', 'Estadísticas')

@section('content')
<div class="max-w-5xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Estadísticas</h1>
            <p class="text-sm text-gray-500 mt-1">Administra los contadores de la sección Stats del landing.</p>
        </div>
        <button onclick="document.getElementById('modal-create').classList.remove('hidden')"
                class="bg-primary hover:bg-primary/90 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
            + Nueva estadística
        </button>
    </div>

    {{-- Alertas --}}
    @if(session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-800 text-sm rounded-lg px-4 py-3">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 bg-red-50 border border-red-200 text-red-800 text-sm rounded-lg px-4 py-3">
            {{ session('error') }}
        </div>
    @endif

    {{-- Tabla --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">Orden</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">Etiqueta</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">Valor</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">Target</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">Sufijo</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">Velocidad</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">Estado</th>
                    <th class="text-right px-4 py-3 font-medium text-gray-600">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($stats as $stat)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3 text-gray-500">{{ $stat->order }}</td>
                    <td class="px-4 py-3 font-medium text-gray-900">{{ $stat->label }}</td>
                    <td class="px-4 py-3">
                        <span class="text-accent font-bold text-base">{{ $stat->value }}</span>
                    </td>
                    <td class="px-4 py-3 text-gray-600">{{ $stat->target }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $stat->suffix ?: '—' }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $stat->duration }}ms / paso {{ $stat->step }}</td>
                    <td class="px-4 py-3">
                        <form action="{{ route('admin.stats.toggle', $stat) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit"
                                    class="inline-flex items-center gap-1 text-xs font-medium px-2 py-1 rounded-full transition
                                           {{ $stat->is_active ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-gray-100 text-gray-500 hover:bg-gray-200' }}">
                                {{ $stat->is_active ? 'Activo' : 'Inactivo' }}
                            </button>
                        </form>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex items-center justify-end gap-2">
                            {{-- Editar --}}
                            <button onclick='openEdit(@json($stat))'
                                    class="text-xs text-blue-600 hover:text-blue-800 font-medium transition">
                                Editar
                            </button>
                            {{-- Eliminar --}}
                            <form action="{{ route('admin.stats.destroy', $stat) }}" method="POST"
                                  onsubmit="return confirm('¿Eliminar esta estadística?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="text-xs text-red-500 hover:text-red-700 font-medium transition">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-4 py-10 text-center text-gray-400">
                        No hay estadísticas todavía.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Tip animación --}}
    <div class="mt-4 bg-blue-50 border border-blue-100 rounded-lg px-4 py-3 text-xs text-blue-700">
        <strong>Tip animación:</strong>
        <span class="font-normal">
            <em>Target</em> = número real al que llega el contador.
            <em>Sufijo</em> = lo que se muestra tras el número (<code>+</code>, <code>%</code>, etc.).
            <em>Velocidad</em> = intervalo en ms entre ticks (menor = más rápido).
            <em>Paso</em> = cuánto incrementa el contador por tick.
        </span>
    </div>
</div>

{{-- ═══════════════════════════════════════
     MODAL CREAR
════════════════════════════════════════ --}}
<div id="modal-create" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Nueva estadística</h2>
        <form action="{{ route('admin.stats.store') }}" method="POST" class="space-y-4">
            @csrf
            @include('admin.stats._form')
            <div class="flex justify-end gap-3 pt-2">
                <button type="button"
                        onclick="document.getElementById('modal-create').classList.add('hidden')"
                        class="text-sm text-gray-600 hover:text-gray-900 px-4 py-2 rounded-lg border border-gray-200 transition">
                    Cancelar
                </button>
                <button type="submit"
                        class="bg-primary hover:bg-primary/90 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                    Crear
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ═══════════════════════════════════════
     MODAL EDITAR
════════════════════════════════════════ --}}
<div id="modal-edit" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Editar estadística</h2>
        <form id="form-edit" method="POST" class="space-y-4">
            @csrf @method('PUT')
            @include('admin.stats._form')
            <div class="flex justify-end gap-3 pt-2">
                <button type="button"
                        onclick="document.getElementById('modal-edit').classList.add('hidden')"
                        class="text-sm text-gray-600 hover:text-gray-900 px-4 py-2 rounded-lg border border-gray-200 transition">
                    Cancelar
                </button>
                <button type="submit"
                        class="bg-primary hover:bg-primary/90 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                    Guardar cambios
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openEdit(stat) {
    const form = document.getElementById('form-edit');
    form.action = `/admin/stats/${stat.id}`;

    form.querySelector('[name="label"]').value    = stat.label;
    form.querySelector('[name="value"]').value    = stat.value;
    form.querySelector('[name="target"]').value   = stat.target;
    form.querySelector('[name="suffix"]').value   = stat.suffix ?? '';
    form.querySelector('[name="duration"]').value = stat.duration;
    form.querySelector('[name="step"]').value     = stat.step;
    form.querySelector('[name="order"]').value    = stat.order;
    form.querySelector('[name="is_active"]').checked = stat.is_active;

    document.getElementById('modal-edit').classList.remove('hidden');
}
</script>
@endpush

@endsection
