

<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Etiqueta <span class="text-red-500">*</span></label>
    <input type="text" name="label" placeholder="Proyectos Completados"
           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary/50"
           required maxlength="100">
</div>

<div class="grid grid-cols-2 gap-3">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Valor mostrado <span class="text-red-500">*</span>
        </label>
        <input type="text" name="value" placeholder="150+"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary/50"
               required maxlength="20">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Target (número) <span class="text-red-500">*</span>
        </label>
        <input type="number" name="target" placeholder="150" min="0"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary/50"
               required>
    </div>
</div>

<div class="grid grid-cols-3 gap-3">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Sufijo</label>
        <input type="text" name="suffix" placeholder="+" maxlength="5"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary/50">
        <p class="text-xs text-gray-400 mt-1">ej: +, %, K+</p>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Velocidad (ms)</label>
        <input type="number" name="duration" placeholder="20" min="1" max="1000"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary/50"
               required>
        <p class="text-xs text-gray-400 mt-1">menor = más rápido</p>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Paso</label>
        <input type="number" name="step" placeholder="5" min="1"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary/50"
               required>
        <p class="text-xs text-gray-400 mt-1">incremento/tick</p>
    </div>
</div>

<div class="grid grid-cols-2 gap-3">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Orden</label>
        <input type="number" name="order" placeholder="1" min="0"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary/50">
    </div>
    <div class="flex items-end pb-2">
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" name="is_active" value="1" checked
                   class="w-4 h-4 rounded text-primary focus:ring-primary/50">
            <span class="text-sm text-gray-700">Activo</span>
        </label>
    </div>
</div>
<?php /**PATH D:\htdocs\skubox\landing\resources\views/admin/stats/_form.blade.php ENDPATH**/ ?>