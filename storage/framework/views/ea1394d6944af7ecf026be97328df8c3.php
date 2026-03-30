<?php $__env->startSection('title', 'Editor Hero'); ?>
<?php $__env->startSection('page-title', 'Editor de Hero'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl">
    <div class="bg-white rounded-lg shadow p-6">
        <form action="<?php echo e(route('admin.hero.update')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div x-data="{
                heroBackgroundType: '<?php echo e(old('hero_background_type', $settings->hero_background_type ?? 'color')); ?>',
                overlayOpacity: <?php echo e(old('hero_overlay_opacity', $settings->hero_overlay_opacity ?? 0.5)); ?>,
                selectedImage: '<?php echo e(old('hero_background_image_selected', $settings->hero_background_image ?? '')); ?>'
            }" class="space-y-6">

                <!-- Activar Hero -->
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="hero_enabled" id="hero_enabled" value="1"
                           <?php echo e($settings->hero_enabled ? 'checked' : ''); ?>

                           class="w-5 h-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
                    <label for="hero_enabled" class="text-base font-semibold text-gray-800">Hero Activo</label>
                </div>

                <!-- Mostrar Logo en vez de título -->
                <div class="flex items-center gap-2 p-3 bg-gray-50 rounded-lg">
                    <input type="hidden" name="hero_show_logo_instead" value="0">
                    <input type="checkbox" name="hero_show_logo_instead" id="hero_show_logo_instead" value="1"
                        <?php echo e($settings->hero_show_logo_instead ? 'checked' : ''); ?>

                        class="w-5 h-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-500"
                        onchange="document.getElementById('logo-positioner').style.display = this.checked ? 'block' : 'none'">
                    <label for="hero_show_logo_instead" class="text-sm font-medium text-gray-800">
                        Mostrar Logo en vez del Título
                    </label>
                </div>

                <!-- Posicionador de Logo (JS puro, sin Alpine) -->
                <div id="logo-positioner" class="border-2 border-blue-200 rounded-xl p-5 bg-blue-50 space-y-4"
                     style="<?php echo e($settings->hero_show_logo_instead ? '' : 'display:none'); ?>">
                    <h4 class="font-semibold text-blue-800 text-base">Posición del Logo en el Hero</h4>
                    <p class="text-sm text-gray-600">Arrastra el logo dentro del preview, o usa los sliders.</p>

                    <div id="hero-preview"
                         class="relative w-full rounded-lg overflow-hidden border-2 border-blue-300 cursor-crosshair select-none"
                         style="height: 240px; background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);">
                        <div class="absolute inset-0 bg-black" style="opacity: 0.4;"></div>
                        <div class="absolute inset-0 pointer-events-none" style="opacity:0.15;">
                            <div class="absolute top-0 bottom-0 border-l border-white" style="left:33.3%"></div>
                            <div class="absolute top-0 bottom-0 border-l border-white" style="left:66.6%"></div>
                            <div class="absolute left-0 right-0 border-t border-white" style="top:33.3%"></div>
                            <div class="absolute left-0 right-0 border-t border-white" style="top:66.6%"></div>
                            <div class="absolute top-0 bottom-0 border-l border-yellow-300" style="left:50%;opacity:0.6"></div>
                            <div class="absolute left-0 right-0 border-t border-yellow-300" style="top:50%;opacity:0.6"></div>
                        </div>
                        <img id="logo-preview-img"
                             src="<?php echo e($settings->getLogoUrl()); ?>"
                             class="absolute object-contain drop-shadow-lg pointer-events-none"
                             style="height:<?php echo e(round(($settings->hero_logo_size ?? 112) * 0.35)); ?>px; max-width:200px; left:<?php echo e($settings->hero_logo_x ?? 50); ?>%; top:<?php echo e($settings->hero_logo_y ?? 50); ?>%; transform:translate(-50%,-50%);">
                        <div id="logo-coords" class="absolute bottom-2 right-2 bg-black/70 text-white text-xs px-2 py-1 rounded font-mono">
                            X: <?php echo e($settings->hero_logo_x ?? 50); ?>% / Y: <?php echo e($settings->hero_logo_y ?? 50); ?>%
                        </div>
                        <div class="absolute top-2 left-2 bg-black/50 text-white text-xs px-2 py-1 rounded">Arrastra para posicionar</div>
                    </div>

                    <div class="space-y-1">
                        <label class="flex justify-between text-sm font-medium text-gray-700">
                            <span>Posición Horizontal</span>
                            <span id="lbl-x" class="font-bold text-blue-600"><?php echo e($settings->hero_logo_x ?? 50); ?>%</span>
                        </label>
                        <input id="slider-x" type="range" min="0" max="100" step="1"
                               value="<?php echo e($settings->hero_logo_x ?? 50); ?>"
                               class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-blue-600"
                               oninput="updateLogoPos()">
                        <div class="flex justify-between text-xs text-gray-400"><span>Izquierda</span><span>Centro</span><span>Derecha</span></div>
                    </div>

                    <div class="space-y-1">
                        <label class="flex justify-between text-sm font-medium text-gray-700">
                            <span>Posición Vertical</span>
                            <span id="lbl-y" class="font-bold text-blue-600"><?php echo e($settings->hero_logo_y ?? 50); ?>%</span>
                        </label>
                        <input id="slider-y" type="range" min="0" max="100" step="1"
                               value="<?php echo e($settings->hero_logo_y ?? 50); ?>"
                               class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-blue-600"
                               oninput="updateLogoPos()">
                        <div class="flex justify-between text-xs text-gray-400"><span>Arriba</span><span>Centro</span><span>Abajo</span></div>
                    </div>

                    <div class="space-y-1">
                        <label class="flex justify-between text-sm font-medium text-gray-700">
                            <span>Tamaño del Logo</span>
                            <span id="lbl-size" class="font-bold text-blue-600"><?php echo e($settings->hero_logo_size ?? 112); ?>px</span>
                        </label>
                        <input id="slider-size" type="range" min="40" max="300" step="4"
                               value="<?php echo e($settings->hero_logo_size ?? 112); ?>"
                               class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-blue-600"
                               oninput="updateLogoPos()">
                        <div class="flex justify-between text-xs text-gray-400"><span>40px</span><span>112px</span><span>300px</span></div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700">Posiciones rápidas</label>
                        <div class="grid grid-cols-3 gap-2">
                            <button type="button" onclick="setLogoPreset(50,25)" class="py-2 text-xs bg-white border border-gray-300 rounded-lg hover:border-blue-400 hover:bg-blue-50 transition">Arriba</button>
                            <button type="button" onclick="setLogoPreset(50,50)" class="py-2 text-xs bg-white border border-gray-300 rounded-lg hover:border-blue-400 hover:bg-blue-50 transition">Centro</button>
                            <button type="button" onclick="setLogoPreset(50,70)" class="py-2 text-xs bg-white border border-gray-300 rounded-lg hover:border-blue-400 hover:bg-blue-50 transition">Abajo</button>
                            <button type="button" onclick="setLogoPreset(20,50)" class="py-2 text-xs bg-white border border-gray-300 rounded-lg hover:border-blue-400 hover:bg-blue-50 transition">Izquierda</button>
                            <button type="button" onclick="setLogoPreset(50,30)" class="py-2 text-xs bg-white border border-gray-300 rounded-lg hover:border-blue-400 hover:bg-blue-50 transition">Default</button>
                            <button type="button" onclick="setLogoPreset(80,50)" class="py-2 text-xs bg-white border border-gray-300 rounded-lg hover:border-blue-400 hover:bg-blue-50 transition">Derecha</button>
                        </div>
                    </div>

                    <input type="hidden" name="hero_logo_x"    id="input-logo-x"    value="<?php echo e($settings->hero_logo_x ?? 50); ?>">
                    <input type="hidden" name="hero_logo_y"    id="input-logo-y"    value="<?php echo e($settings->hero_logo_y ?? 50); ?>">
                    <input type="hidden" name="hero_logo_size" id="input-logo-size" value="<?php echo e($settings->hero_logo_size ?? 112); ?>">
                </div>

                <!-- Tipo de fondo -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <label class="block text-sm font-semibold text-gray-800 mb-3">Tipo de Fondo</label>
                    <div class="grid grid-cols-3 gap-3">
                        <label class="flex items-center gap-2 p-3 border-2 rounded-lg cursor-pointer transition"
                               :class="heroBackgroundType === 'color' ? 'border-blue-500 bg-blue-50' : 'border-gray-300 hover:border-blue-300'">
                            <input type="radio" name="hero_background_type" value="color" x-model="heroBackgroundType" class="w-4 h-4 text-blue-600">
                            <div>
                                <div class="font-medium text-sm">Color Sólido</div>
                                <div class="text-xs text-gray-500">Gradiente</div>
                            </div>
                        </label>
                        <label class="flex items-center gap-2 p-3 border-2 rounded-lg cursor-pointer transition"
                               :class="heroBackgroundType === 'image' ? 'border-blue-500 bg-blue-50' : 'border-gray-300 hover:border-blue-300'">
                            <input type="radio" name="hero_background_type" value="image" x-model="heroBackgroundType" class="w-4 h-4 text-blue-600">
                            <div>
                                <div class="font-medium text-sm">Imagen</div>
                                <div class="text-xs text-gray-500">Foto de fondo</div>
                            </div>
                        </label>
                        <label class="flex items-center gap-2 p-3 border-2 rounded-lg cursor-pointer transition"
                               :class="heroBackgroundType === 'video' ? 'border-blue-500 bg-blue-50' : 'border-gray-300 hover:border-blue-300'">
                            <input type="radio" name="hero_background_type" value="video" x-model="heroBackgroundType" class="w-4 h-4 text-blue-600">
                            <div>
                                <div class="font-medium text-sm">Video</div>
                                <div class="text-xs text-gray-500">Video de fondo</div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Imagen -->
                <div x-show="heroBackgroundType === 'image'" class="bg-gray-50 p-4 rounded-lg border border-gray-200" x-transition>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Imagen de Fondo</label>

                    <?php if($settings->hero_background_image): ?>
                        <div class="mb-3">
                            <img src="<?php echo e($settings->getHeroBackgroundImageUrl()); ?>" alt="Hero Background" class="h-32 object-cover rounded-lg shadow">
                            <p class="text-xs text-gray-600 mt-1">Imagen actual: <?php echo e($settings->hero_background_image); ?></p>
                        </div>
                    <?php endif; ?>

                    <?php
                        $heroImagesPath = public_html_path('images/hero');
                        $heroImages = [];
                        if (is_dir($heroImagesPath)) {
                            $files = glob($heroImagesPath . '/*.{jpg,jpeg,png,webp,gif}', GLOB_BRACE);
                            foreach ($files as $file) {
                                $heroImages[] = 'hero/' . basename($file);
                            }
                        }
                    ?>

                    <?php if(count($heroImages) > 0): ?>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Imágenes guardadas (<?php echo e(count($heroImages)); ?>) — haz clic para seleccionar
                            </label>
                            <div class="grid grid-cols-3 md:grid-cols-4 gap-2 max-h-64 overflow-y-auto p-2 border border-gray-200 rounded-lg bg-white">
                                <?php $__currentLoopData = $heroImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="relative cursor-pointer group" @click="selectedImage = '<?php echo e($img); ?>'">
                                        <img src="<?php echo e(asset('images/' . $img)); ?>" alt="<?php echo e(basename($img)); ?>"
                                             class="w-full h-20 object-cover rounded-lg border-2 transition"
                                             :class="selectedImage === '<?php echo e($img); ?>' ? 'border-blue-500 ring-2 ring-blue-300' : 'border-gray-200 group-hover:border-blue-300'">
                                        <?php if($settings->hero_background_image === $img): ?>
                                            <span class="absolute top-1 right-1 bg-blue-500 text-white text-xs px-1 rounded">Actual</span>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <input type="hidden" name="hero_background_image_selected" :value="selectedImage">
                            <p class="text-xs text-gray-500 mt-1" x-show="selectedImage">
                                Seleccionada: <span x-text="selectedImage" class="font-medium text-blue-600"></span>
                            </p>
                        </div>
                    <?php endif; ?>

                    <label class="block text-sm font-medium text-gray-700 mb-1">O subir nueva imagen</label>
                    <input type="file" name="hero_background_image" accept="image/jpeg,image/png,image/jpg,image/webp"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Formatos: JPG, PNG, WEBP. Máx: 5MB. Recomendado: 1920x1080px</p>
                </div>

                <!-- Video -->
                <div x-show="heroBackgroundType === 'video'" class="bg-gray-50 p-4 rounded-lg border border-gray-200" x-transition>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Video de Fondo</label>
                    <?php if($settings->hero_background_video): ?>
                        <div class="mb-3">
                            <video class="h-32 object-cover rounded-lg shadow" controls>
                                <source src="<?php echo e($settings->getHeroBackgroundVideoUrl()); ?>" type="video/mp4">
                            </video>
                            <p class="text-xs text-gray-600 mt-1">Video actual: <?php echo e($settings->hero_background_video); ?></p>
                        </div>
                    <?php endif; ?>

                    <?php
                        $heroVideosPath = public_html_path('videos/hero');
                        $heroVideos = [];
                        if (is_dir($heroVideosPath)) {
                            $files = glob($heroVideosPath . '/*.{mp4,webm,ogg}', GLOB_BRACE);
                            foreach ($files as $file) {
                                $heroVideos[] = 'hero/' . basename($file);
                            }
                        }
                    ?>

                    <?php if(count($heroVideos) > 0): ?>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Videos guardados (<?php echo e(count($heroVideos)); ?>) — haz clic para seleccionar
                            </label>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-2 max-h-64 overflow-y-auto p-2 border border-gray-200 rounded-lg bg-white"
                                x-data="{ selectedVideo: '<?php echo e($settings->hero_background_video ?? ''); ?>' }">
                                <?php $__currentLoopData = $heroVideos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="relative cursor-pointer group" @click="selectedVideo = '<?php echo e($vid); ?>'">
                                        <video class="w-full h-24 object-cover rounded-lg border-2 transition"
                                            :class="selectedVideo === '<?php echo e($vid); ?>' ? 'border-blue-500 ring-2 ring-blue-300' : 'border-gray-200 group-hover:border-blue-300'"
                                            muted preload="metadata">
                                            <source src="<?php echo e(asset('videos/' . $vid)); ?>" type="video/mp4">
                                        </video>
                                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                            <div class="bg-black bg-opacity-40 rounded-full p-2">
                                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M8 5v14l11-7z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <?php if($settings->hero_background_video === $vid): ?>
                                            <span class="absolute top-1 right-1 bg-blue-500 text-white text-xs px-1 rounded">Actual</span>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <input type="hidden" name="hero_background_video_selected" :value="selectedVideo">
                                <p class="text-xs text-gray-500 mt-1 col-span-full" x-show="selectedVideo">
                                    Seleccionado: <span x-text="selectedVideo" class="font-medium text-blue-600"></span>
                                </p>
                            </div>
                        </div>
                    <?php endif; ?>

                    <label class="block text-sm font-medium text-gray-700 mb-1">O subir nuevo video</label>
                    <input type="file" name="hero_background_video" accept="video/mp4,video/webm,video/ogg"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Formatos: MP4, WEBM, OGG. Máx: 50MB.</p>
                </div>

                <!-- Opacidad -->
                <div x-show="heroBackgroundType === 'image' || heroBackgroundType === 'video'" class="bg-gray-50 p-4 rounded-lg border border-gray-200" x-transition>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Opacidad del Overlay:
                        <span x-text="Math.round(overlayOpacity * 100) + '%'" class="font-bold text-blue-600"></span>
                    </label>
                    <input type="range" name="hero_overlay_opacity" x-model="overlayOpacity" min="0" max="1" step="0.05"
                           class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                    <div class="flex justify-between text-xs text-gray-500 mt-1">
                        <span>Transparente (0%)</span>
                        <span>Oscuro (100%)</span>
                    </div>
                </div>

                <!-- Textos -->
                <div class="border-t pt-4 space-y-3">
                    <h4 class="font-semibold text-gray-800">Textos del Hero</h4>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Título Principal</label>
                        <input type="text" name="hero_title" value="<?php echo e(old('hero_title', $settings->hero_title)); ?>"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Subtítulo</label>
                        <textarea name="hero_subtitle" rows="2"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"><?php echo e(old('hero_subtitle', $settings->hero_subtitle)); ?></textarea>
                    </div>
                    <div class="grid md:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Texto del Botón</label>
                            <input type="text" name="hero_button_text" value="<?php echo e(old('hero_button_text', $settings->hero_button_text)); ?>"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">URL del Botón</label>
                            <input type="text" name="hero_button_url" value="<?php echo e(old('hero_button_url', $settings->hero_button_url)); ?>"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex items-center justify-between pt-4 border-t">
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="text-gray-600 hover:text-gray-800 font-medium">
                        ← Volver al Dashboard
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition">
                        Guardar Cambios
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
(function() {
    var preview  = document.getElementById('hero-preview');
    var imgEl    = document.getElementById('logo-preview-img');
    var coordsEl = document.getElementById('logo-coords');
    var sliderX  = document.getElementById('slider-x');
    var sliderY  = document.getElementById('slider-y');
    var sliderS  = document.getElementById('slider-size');
    var inputX   = document.getElementById('input-logo-x');
    var inputY   = document.getElementById('input-logo-y');
    var inputS   = document.getElementById('input-logo-size');
    var lblX     = document.getElementById('lbl-x');
    var lblY     = document.getElementById('lbl-y');
    var lblSize  = document.getElementById('lbl-size');

    function updateLogoPos() {
        var x    = parseInt(sliderX.value);
        var y    = parseInt(sliderY.value);
        var size = parseInt(sliderS.value);
        imgEl.style.left      = x + '%';
        imgEl.style.top       = y + '%';
        imgEl.style.height    = Math.round(size * 0.35) + 'px';
        coordsEl.textContent  = 'X: ' + x + '% / Y: ' + y + '%';
        lblX.textContent      = x + '%';
        lblY.textContent      = y + '%';
        lblSize.textContent   = size + 'px';
        inputX.value          = x;
        inputY.value          = y;
        inputS.value          = size;
    }

    window.updateLogoPos = updateLogoPos;

    window.setLogoPreset = function(x, y) {
        sliderX.value = x;
        sliderY.value = y;
        updateLogoPos();
    };

    var dragging = false;
    preview.addEventListener('mousedown',  startDrag);
    preview.addEventListener('touchstart', startDrag, { passive: false });

    function startDrag(e) {
        dragging = true;
        moveLogo(e);
        window.addEventListener('mousemove', moveLogo);
        window.addEventListener('mouseup',   stopDrag);
        window.addEventListener('touchmove', moveLogo, { passive: false });
        window.addEventListener('touchend',  stopDrag);
    }

    function stopDrag() {
        dragging = false;
        window.removeEventListener('mousemove', moveLogo);
        window.removeEventListener('mouseup',   stopDrag);
        window.removeEventListener('touchmove', moveLogo);
        window.removeEventListener('touchend',  stopDrag);
    }

    function moveLogo(e) {
        if (!dragging) return;
        var rect    = preview.getBoundingClientRect();
        var clientX = e.touches ? e.touches[0].clientX : e.clientX;
        var clientY = e.touches ? e.touches[0].clientY : e.clientY;
        sliderX.value = Math.round(Math.min(100, Math.max(0, ((clientX - rect.left) / rect.width)  * 100)));
        sliderY.value = Math.round(Math.min(100, Math.max(0, ((clientY - rect.top)  / rect.height) * 100)));
        updateLogoPos();
        if (e.preventDefault) e.preventDefault();
    }
})();
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\htdocs\skubox\landing\resources\views/admin/hero/index.blade.php ENDPATH**/ ?>