<?php $__env->startSection('title', 'Estadísticas'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-5xl mx-auto">

    
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Estadísticas</h1>
            <p class="text-sm text-gray-500 mt-1">Administra los contadores de la sección Stats del landing.</p>
        </div>
        <button onclick="document.getElementById('modal-create').classList.remove('hidden')"
                class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
            + Nueva estadística
        </button>
    </div>

    
    <?php if(session('success')): ?>
        <div class="mb-4 bg-green-50 border border-green-200 text-green-800 text-sm rounded-lg px-4 py-3">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="mb-4 bg-red-50 border border-red-200 text-red-800 text-sm rounded-lg px-4 py-3">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 mb-6">

        <div class="flex items-center justify-between mb-4">
            <h2 class="text-sm font-semibold text-gray-700">Colores de la sección</h2>
            <span id="unsaved-badge"
                  class="hidden text-xs font-medium bg-amber-100 text-amber-700 border border-amber-200 px-3 py-1 rounded-full">
                ● Cambios sin guardar
            </span>
        </div>

        <form action="<?php echo e(route('admin.stats.update-colors')); ?>" method="POST" id="colors-form">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="flex flex-wrap items-end gap-6">

                
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-2">Fondo de la sección</label>
                    <div class="flex items-center gap-3">
                        <input type="color"
                               name="stats_bg_color"
                               id="stats_bg_color"
                               value="<?php echo e($settings->stats_bg_color ?? '#000000'); ?>"
                               class="w-10 h-10 rounded-lg border border-gray-300 cursor-pointer p-0.5"
                               oninput="updatePreview(); markUnsaved()"
                               onchange="updatePreview(); markUnsaved()">
                        <input type="text"
                               id="stats_bg_color_text"
                               value="<?php echo e($settings->stats_bg_color ?? '#000000'); ?>"
                               maxlength="7"
                               class="w-24 border border-gray-300 rounded-lg px-3 py-2 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-primary/50"
                               oninput="syncColor('stats_bg_color', this.value)">
                    </div>
                </div>

                
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-2">Color del número</label>
                    <div class="flex items-center gap-3">
                        <input type="color"
                               name="stats_number_color"
                               id="stats_number_color"
                               value="<?php echo e($settings->stats_number_color ?? '#f5f500'); ?>"
                               class="w-10 h-10 rounded-lg border border-gray-300 cursor-pointer p-0.5"
                               oninput="updatePreview(); markUnsaved()"
                               onchange="updatePreview(); markUnsaved()">
                        <input type="text"
                               id="stats_number_color_text"
                               value="<?php echo e($settings->stats_number_color ?? '#f5f500'); ?>"
                               maxlength="7"
                               class="w-24 border border-gray-300 rounded-lg px-3 py-2 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-primary/50"
                               oninput="syncColor('stats_number_color', this.value)">
                    </div>
                </div>

                
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-xs font-medium text-gray-600 mb-2">Preview</label>
                    <div id="color-preview"
                         class="rounded-lg px-6 py-3 flex items-center justify-center gap-8 transition-colors"
                         style="background-color: <?php echo e($settings->stats_bg_color ?? '#000000'); ?>;">
                        <div class="text-center">
                            <div id="preview-number" class="text-3xl font-bold"
                                 style="color: <?php echo e($settings->stats_number_color ?? '#f5f500'); ?>;">150+</div>
                            <div class="text-xs mt-1" style="color: #9ca3af;">Proyectos</div>
                        </div>
                        <div class="text-center">
                            <div id="preview-number-2" class="text-3xl font-bold"
                                 style="color: <?php echo e($settings->stats_number_color ?? '#f5f500'); ?>;">95%</div>
                            <div class="text-xs mt-1" style="color: #9ca3af;">Satisfacción</div>
                        </div>
                    </div>
                </div>

            </div>

            
            <div class="mt-4">
                <p class="text-xs text-gray-500 mb-2">Combinaciones rápidas:</p>
                <div class="flex flex-wrap gap-2">
                    <?php
                    $presets = [
                        ['label' => 'Negro / Amarillo',  'bg' => '#000000', 'num' => '#f5f500'],
                        ['label' => 'Negro / Blanco',    'bg' => '#000000', 'num' => '#ffffff'],
                        ['label' => 'Blanco / Negro',    'bg' => '#ffffff', 'num' => '#111111'],
                        ['label' => 'Azul / Blanco',     'bg' => '#1e3a5f', 'num' => '#ffffff'],
                        ['label' => 'Gris / Amarillo',   'bg' => '#1f2937', 'num' => '#fbbf24'],
                        ['label' => 'Verde / Blanco',    'bg' => '#064e3b', 'num' => '#ffffff'],
                        ['label' => 'Rojo / Blanco',     'bg' => '#7f1d1d', 'num' => '#ffffff'],
                        ['label' => 'Morado / Amarillo', 'bg' => '#3b0764', 'num' => '#fde047'],
                    ];
                    ?>
                    <?php $__currentLoopData = $presets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $preset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <button type="button"
                            onclick="applyPreset('<?php echo e($preset['bg']); ?>', '<?php echo e($preset['num']); ?>')"
                            class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-gray-200 hover:border-gray-400 text-xs text-gray-600 transition">
                        <span class="w-3 h-3 rounded-full border border-gray-300 inline-block" style="background: <?php echo e($preset['bg']); ?>;"></span>
                        <span class="w-3 h-3 rounded-full border border-gray-300 inline-block" style="background: <?php echo e($preset['num']); ?>;"></span>
                        <?php echo e($preset['label']); ?>

                    </button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            
            <div class="mt-5 pt-4 border-t border-gray-100 flex items-center justify-between">
                <p class="text-xs text-gray-400">Los cambios no se aplican al landing hasta que guardes.</p>
                <button type="submit"
                        id="save-colors-btn"
                        class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-5 py-2 rounded-lg transition">
                    Guardar colores
                </button>
            </div>

        </form>
    </div>

    
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
                <?php $__empty_1 = true; $__currentLoopData = $stats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3 text-gray-500"><?php echo e($stat->order); ?></td>
                    <td class="px-4 py-3 font-medium text-gray-900"><?php echo e($stat->label); ?></td>
                    <td class="px-4 py-3">
                        <span class="font-bold text-base"
                              style="color: <?php echo e($settings->stats_number_color ?? '#f5f500'); ?>; background: <?php echo e($settings->stats_bg_color ?? '#000000'); ?>; padding: 2px 8px; border-radius: 6px;">
                            <?php echo e($stat->value); ?>

                        </span>
                    </td>
                    <td class="px-4 py-3 text-gray-600"><?php echo e($stat->target); ?></td>
                    <td class="px-4 py-3 text-gray-600"><?php echo e($stat->suffix ?: '—'); ?></td>
                    <td class="px-4 py-3 text-gray-500"><?php echo e($stat->duration); ?>ms / paso <?php echo e($stat->step); ?></td>
                    <td class="px-4 py-3">
                        <form action="<?php echo e(route('admin.stats.toggle', $stat)); ?>" method="POST">
                            <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                            <button type="submit"
                                    class="inline-flex items-center gap-1 text-xs font-medium px-2 py-1 rounded-full transition
                                           <?php echo e($stat->is_active ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-gray-100 text-gray-500 hover:bg-gray-200'); ?>">
                                <?php echo e($stat->is_active ? 'Activo' : 'Inactivo'); ?>

                            </button>
                        </form>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button onclick='openEdit(<?php echo json_encode($stat, 15, 512) ?>)'
                                    class="text-xs text-blue-600 hover:text-blue-800 font-medium transition">
                                Editar
                            </button>
                            <form action="<?php echo e(route('admin.stats.destroy', $stat)); ?>" method="POST"
                                  onsubmit="return confirm('¿Eliminar esta estadística?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit"
                                        class="text-xs text-red-500 hover:text-red-700 font-medium transition">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="8" class="px-4 py-10 text-center text-gray-400">
                        No hay estadísticas todavía.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    
    <div class="mt-4 bg-blue-50 border border-blue-100 rounded-lg px-4 py-3 text-xs text-blue-700">
        <strong>Tip animación:</strong>
        <em>Target</em> = número real al que llega el contador.
        <em>Sufijo</em> = lo que se muestra tras el número (<code>+</code>, <code>%</code>, etc.).
        <em>Velocidad</em> = intervalo en ms entre ticks (menor = más rápido).
        <em>Paso</em> = cuánto incrementa el contador por tick.
    </div>

</div>


<div id="modal-create" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Nueva estadística</h2>
        <form action="<?php echo e(route('admin.stats.store')); ?>" method="POST" class="space-y-4">
            <?php echo csrf_field(); ?>
            <?php echo $__env->make('admin.stats._form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button"
                        onclick="document.getElementById('modal-create').classList.add('hidden')"
                        class="text-sm text-gray-600 hover:text-gray-900 px-4 py-2 rounded-lg border border-gray-200 transition">
                    Cancelar
                </button>
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                    Crear
                </button>
            </div>
        </form>
    </div>
</div>


<div id="modal-edit" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Editar estadística</h2>
        <form id="form-edit" method="POST" class="space-y-4">
            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
            <?php echo $__env->make('admin.stats._form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button"
                        onclick="document.getElementById('modal-edit').classList.add('hidden')"
                        class="text-sm text-gray-600 hover:text-gray-900 px-4 py-2 rounded-lg border border-gray-200 transition">
                    Cancelar
                </button>
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                    Guardar cambios
                </button>
            </div>
        </form>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
// ── Estado ────────────────────────────────────────────────────
let hasUnsavedChanges = false;

function markUnsaved() {
    if (hasUnsavedChanges) return;
    hasUnsavedChanges = true;
    document.getElementById('unsaved-badge').classList.remove('hidden');
}

// ── Preview en tiempo real ─────────────────────────────────────
function updatePreview() {
    const bg  = document.getElementById('stats_bg_color').value;
    const num = document.getElementById('stats_number_color').value;

    document.getElementById('color-preview').style.backgroundColor = bg;
    document.getElementById('preview-number').style.color  = num;
    document.getElementById('preview-number-2').style.color = num;

    document.getElementById('stats_bg_color_text').value     = bg;
    document.getElementById('stats_number_color_text').value = num;
}

function syncColor(id, value) {
    if (/^#[0-9A-Fa-f]{6}$/.test(value)) {
        document.getElementById(id).value = value;
        updatePreview();
        markUnsaved();
    }
}

function applyPreset(bg, num) {
    document.getElementById('stats_bg_color').value          = bg;
    document.getElementById('stats_number_color').value      = num;
    document.getElementById('stats_bg_color_text').value     = bg;
    document.getElementById('stats_number_color_text').value = num;
    updatePreview();
    markUnsaved();
}

// ── Advertir si sale con cambios sin guardar ──────────────────
window.addEventListener('beforeunload', function (e) {
    if (hasUnsavedChanges) {
        e.preventDefault();
        e.returnValue = '';
    }
});

// ── Limpiar flag al guardar el form de colores ────────────────
document.getElementById('colors-form').addEventListener('submit', function () {
    hasUnsavedChanges = false;
});

// ── Modal editar ──────────────────────────────────────────────
function openEdit(stat) {
    const form = document.getElementById('form-edit');
    form.action = `/admin/stats/${stat.id}`;
    form.querySelector('[name="label"]').value       = stat.label;
    form.querySelector('[name="value"]').value       = stat.value;
    form.querySelector('[name="target"]').value      = stat.target;
    form.querySelector('[name="suffix"]').value      = stat.suffix ?? '';
    form.querySelector('[name="duration"]').value    = stat.duration;
    form.querySelector('[name="step"]').value        = stat.step;
    form.querySelector('[name="order"]').value       = stat.order;
    form.querySelector('[name="is_active"]').checked = stat.is_active;
    document.getElementById('modal-edit').classList.remove('hidden');
}
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\htdocs\skubox\landing\resources\views/admin/stats/index.blade.php ENDPATH**/ ?>