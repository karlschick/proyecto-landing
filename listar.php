<?php
/**
 * Genera un listado de la estructura del proyecto Laravel Landing Page
 * - Muestra estructura organizada del proyecto
 * - Excluye carpetas innecesarias (node_modules, vendor, storage)
 * - Incluye solo las carpetas relevantes del código
 */

// === CONFIGURACIÓN ===

// Carpetas principales a incluir
$carpetas_incluidas = [
    'app',
    'bootstrap',
    'config',
    'database',
    'public',
    'resources',
    'routes',
    'storage/app/public',
    'tests'
];

// 🔴 Carpetas que quieres EXCLUIR (rutas relativas)
$carpetas_excluidas = [
    'vendor',
    'node_modules',
    'storage/framework',
    'storage/logs',
    'bootstrap/cache',
    '.git',
    '.idea',
    'public/storage',
    'public/hot',
    'public/build'
];

// Extensiones de archivo a incluir
$extensiones_incluidas = [
    'php',
    'blade.php',
    'js',
    'css',
    'json',
    'env',
    'md',
    'sql',
    'xml',
    'yaml',
    'yml'
];

// Archivo de salida
$archivo_salida = __DIR__ . '/estructura_landing_page.txt';

/**
 * Función para verificar si una ruta debe ser excluida
 */
function debeExcluir($ruta, $carpetas_excluidas)
{
    $rutaNormalizada = str_replace('\\', '/', $ruta);

    foreach ($carpetas_excluidas as $excluida) {
        $excluida = str_replace('\\', '/', $excluida);
        if (strpos($rutaNormalizada, '/' . $excluida) !== false ||
            strpos($rutaNormalizada, $excluida . '/') !== false) {
            return true;
        }
    }
    return false;
}

/**
 * Función para verificar si un archivo debe ser incluido
 */
function debeIncluirArchivo($archivo, $extensiones_incluidas)
{
    // Archivos importantes sin extensión
    $archivos_importantes = [
        '.env.example',
        '.gitignore',
        '.editorconfig',
        'artisan',
        'composer.json',
        'composer.lock',
        'package.json',
        'package-lock.json',
        'tailwind.config.js',
        'vite.config.js',
        'README.md',
        'phpunit.xml'
    ];

    if (in_array($archivo, $archivos_importantes)) {
        return true;
    }

    $extension = pathinfo($archivo, PATHINFO_EXTENSION);
    return in_array($extension, $extensiones_incluidas);
}

/**
 * Función recursiva para listar estructura de carpetas y archivos
 */
function listarCarpeta($ruta, $prefijo = "│   ", &$salida = "", $carpetas_excluidas = [], $extensiones_incluidas = [], $nivel = 0)
{
    if (!is_dir($ruta) || $nivel > 10) return; // Límite de profundidad

    if (debeExcluir($ruta, $carpetas_excluidas)) {
        return;
    }

    $archivos = @scandir($ruta);
    if ($archivos === false) return;

    // Separar carpetas y archivos
    $carpetas = [];
    $archivos_filtrados = [];

    foreach ($archivos as $archivo) {
        if ($archivo === '.' || $archivo === '..') continue;

        $path = $ruta . DIRECTORY_SEPARATOR . $archivo;

        if (debeExcluir($path, $carpetas_excluidas)) {
            continue;
        }

        if (is_dir($path)) {
            $carpetas[] = $archivo;
        } elseif (debeIncluirArchivo($archivo, $extensiones_incluidas)) {
            $archivos_filtrados[] = $archivo;
        }
    }

    // Ordenar
    sort($carpetas);
    sort($archivos_filtrados);

    // Mostrar carpetas primero
    foreach ($carpetas as $carpeta) {
        $path = $ruta . DIRECTORY_SEPARATOR . $carpeta;
        $salida .= $prefijo . "├── " . $carpeta . "/" . PHP_EOL;
        listarCarpeta($path, $prefijo . "│   ", $salida, $carpetas_excluidas, $extensiones_incluidas, $nivel + 1);
    }

    // Mostrar archivos
    foreach ($archivos_filtrados as $archivo) {
        $salida .= $prefijo . "├── " . $archivo . PHP_EOL;
    }
}

/**
 * Función para listar archivos en la raíz del proyecto
 */
function listarArchivosRaiz($rutaBase, &$salida, $extensiones_incluidas)
{
    if (!is_dir($rutaBase)) return;

    $archivos = @scandir($rutaBase);
    if ($archivos === false) return;

    $archivos_mostrar = [];

    foreach ($archivos as $archivo) {
        if ($archivo === '.' || $archivo === '..') continue;

        $path = $rutaBase . DIRECTORY_SEPARATOR . $archivo;
        if (is_file($path) && debeIncluirArchivo($archivo, $extensiones_incluidas)) {
            $archivos_mostrar[] = $archivo;
        }
    }

    sort($archivos_mostrar);

    foreach ($archivos_mostrar as $archivo) {
        $salida .= "├── " . $archivo . PHP_EOL;
    }
}

/**
 * Función para contar archivos y líneas
 */
function contarEstadisticas($ruta, $carpetas_excluidas, $extensiones_incluidas, &$stats)
{
    if (!is_dir($ruta)) return;

    if (debeExcluir($ruta, $carpetas_excluidas)) {
        return;
    }

    $archivos = @scandir($ruta);
    if ($archivos === false) return;

    foreach ($archivos as $archivo) {
        if ($archivo === '.' || $archivo === '..') continue;

        $path = $ruta . DIRECTORY_SEPARATOR . $archivo;

        if (debeExcluir($path, $carpetas_excluidas)) {
            continue;
        }

        if (is_dir($path)) {
            contarEstadisticas($path, $carpetas_excluidas, $extensiones_incluidas, $stats);
        } elseif (debeIncluirArchivo($archivo, $extensiones_incluidas)) {
            $stats['archivos']++;

            $extension = pathinfo($archivo, PATHINFO_EXTENSION);
            if (!isset($stats['por_extension'][$extension])) {
                $stats['por_extension'][$extension] = 0;
            }
            $stats['por_extension'][$extension]++;

            // Contar líneas
            $lineas = count(file($path));
            $stats['lineas'] += $lineas;
        }
    }
}

// === GENERAR ESTRUCTURA ===
$salida = "╔" . str_repeat("═", 78) . "╗" . PHP_EOL;
$salida .= "║" . str_pad(" ESTRUCTURA DEL PROYECTO: LANDING PAGE ADMINISTRABLE CON LARAVEL", 78) . "║" . PHP_EOL;
$salida .= "╚" . str_repeat("═", 78) . "╝" . PHP_EOL . PHP_EOL;

$salida .= "📦 Proyecto: Sistema de Landing Page con Panel Admin" . PHP_EOL;
$salida .= "🛠️  Framework: Laravel 11.x + Tailwind CSS + Alpine.js" . PHP_EOL;
$salida .= "📅 Fecha: " . date('d/m/Y H:i:s') . PHP_EOL;
$salida .= str_repeat("─", 80) . PHP_EOL . PHP_EOL;

// 📁 Archivos en la raíz del proyecto
$salida .= "📂 / (Raíz del Proyecto)" . PHP_EOL;
$salida .= "│" . PHP_EOL;
listarArchivosRaiz(__DIR__, $salida, $extensiones_incluidas);
$salida .= "│" . PHP_EOL;

// 📂 Carpeta app/
$salida .= "├── 📁 app/" . PHP_EOL;
$carpetas_app = ['Console', 'Http', 'Models', 'Notifications', 'Services'];
foreach ($carpetas_app as $carpeta) {
    $ruta = __DIR__ . "/app/" . $carpeta;
    if (is_dir($ruta)) {
        $salida .= "│   ├── " . $carpeta . "/" . PHP_EOL;
        listarCarpeta($ruta, "│   │   ", $salida, $carpetas_excluidas, $extensiones_incluidas);
    }
}
$salida .= "│" . PHP_EOL;

// 📂 Carpeta database/
$salida .= "├── 📁 database/" . PHP_EOL;
$carpetas_db = ['migrations', 'seeders', 'factories'];
foreach ($carpetas_db as $carpeta) {
    $ruta = __DIR__ . "/database/" . $carpeta;
    if (is_dir($ruta)) {
        $salida .= "│   ├── " . $carpeta . "/" . PHP_EOL;
        listarCarpeta($ruta, "│   │   ", $salida, $carpetas_excluidas, $extensiones_incluidas);
    }
}
$salida .= "│" . PHP_EOL;

// 📂 Carpeta resources/
$salida .= "├── 📁 resources/" . PHP_EOL;
$salida .= "│   ├── css/" . PHP_EOL;
$ruta_css = __DIR__ . "/resources/css";
if (is_dir($ruta_css)) {
    listarCarpeta($ruta_css, "│   │   ", $salida, $carpetas_excluidas, $extensiones_incluidas);
}
$salida .= "│   ├── js/" . PHP_EOL;
$ruta_js = __DIR__ . "/resources/js";
if (is_dir($ruta_js)) {
    listarCarpeta($ruta_js, "│   │   ", $salida, $carpetas_excluidas, $extensiones_incluidas);
}
$salida .= "│   └── views/" . PHP_EOL;
$ruta_views = __DIR__ . "/resources/views";
if (is_dir($ruta_views)) {
    listarCarpeta($ruta_views, "│       ", $salida, $carpetas_excluidas, $extensiones_incluidas);
}
$salida .= "│" . PHP_EOL;

// 📂 Carpeta routes/
$salida .= "├── 📁 routes/" . PHP_EOL;
$ruta_routes = __DIR__ . "/routes";
if (is_dir($ruta_routes)) {
    listarCarpeta($ruta_routes, "│   ", $salida, $carpetas_excluidas, $extensiones_incluidas);
}
$salida .= "│" . PHP_EOL;

// 📂 Carpeta public/
$salida .= "├── 📁 public/" . PHP_EOL;
$salida .= "│   ├── images/" . PHP_EOL;
$salida .= "│   │   ├── services/" . PHP_EOL;
$salida .= "│   │   ├── projects/" . PHP_EOL;
$salida .= "│   │   ├── testimonials/" . PHP_EOL;
$salida .= "│   │   ├── gallery/" . PHP_EOL;
$salida .= "│   │   ├── settings/" . PHP_EOL;
$salida .= "│   │   └── hero/" . PHP_EOL;
$salida .= "│   ├── videos/" . PHP_EOL;
$salida .= "│   │   └── hero/" . PHP_EOL;
$salida .= "│   ├── favicon.ico" . PHP_EOL;
$salida .= "│   ├── index.php" . PHP_EOL;
$salida .= "│   └── .htaccess" . PHP_EOL;
$salida .= "│" . PHP_EOL;

// 📂 Carpeta config/
$salida .= "├── 📁 config/" . PHP_EOL;
$ruta_config = __DIR__ . "/config";
if (is_dir($ruta_config)) {
    listarCarpeta($ruta_config, "│   ", $salida, $carpetas_excluidas, $extensiones_incluidas);
}
$salida .= "│" . PHP_EOL;

// 📂 Carpeta bootstrap/
$salida .= "├── 📁 bootstrap/" . PHP_EOL;
$salida .= "│   └── app.php" . PHP_EOL;
$salida .= "│" . PHP_EOL;

// 📂 Carpeta storage/
$salida .= "└── 📁 storage/" . PHP_EOL;
$salida .= "    └── app/public/" . PHP_EOL;
$salida .= "        ├── services/" . PHP_EOL;
$salida .= "        ├── projects/" . PHP_EOL;
$salida .= "        ├── testimonials/" . PHP_EOL;
$salida .= "        ├── gallery/" . PHP_EOL;
$salida .= "        └── settings/" . PHP_EOL;

// === ESTADÍSTICAS ===
$salida .= PHP_EOL . str_repeat("═", 80) . PHP_EOL;
$salida .= "📊 ESTADÍSTICAS DEL PROYECTO" . PHP_EOL;
$salida .= str_repeat("─", 80) . PHP_EOL . PHP_EOL;

$stats = [
    'archivos' => 0,
    'lineas' => 0,
    'por_extension' => []
];

contarEstadisticas(__DIR__, $carpetas_excluidas, $extensiones_incluidas, $stats);

$salida .= "Total de archivos: " . number_format($stats['archivos']) . PHP_EOL;
$salida .= "Total de líneas de código: " . number_format($stats['lineas']) . PHP_EOL . PHP_EOL;

$salida .= "Archivos por tipo:" . PHP_EOL;
arsort($stats['por_extension']);
foreach ($stats['por_extension'] as $ext => $count) {
    $salida .= sprintf("  • .%-10s : %4d archivos", $ext, $count) . PHP_EOL;
}

// === COMPONENTES IMPLEMENTADOS ===
$salida .= PHP_EOL . str_repeat("═", 80) . PHP_EOL;
$salida .= "✅ FUNCIONALIDADES IMPLEMENTADAS" . PHP_EOL;
$salida .= str_repeat("─", 80) . PHP_EOL . PHP_EOL;

$funcionalidades = [
    "Backend (Laravel)" => [
        "✓ Sistema de autenticación (Laravel Breeze)",
        "✓ Gestión de roles (Admin/Editor)",
        "✓ CRUD completo de Servicios",
        "✓ CRUD completo de Proyectos con categorías",
        "✓ CRUD completo de Testimonios",
        "✓ CRUD completo de Galería de imágenes",
        "✓ Sistema de Leads/Contactos",
        "✓ Notificaciones por email (admin + cliente)",
        "✓ Sistema de configuración global (Settings)",
        "✓ Caché de contenido (CacheService)",
        "✓ Servicio de subida de imágenes",
        "✓ Validaciones con Form Requests",
        "✓ Seeders con datos de ejemplo",
        "✓ Middleware de roles personalizados"
    ],
    "Frontend Admin" => [
        "✓ Dashboard con estadísticas",
        "✓ Panel de configuración con tabs",
        "✓ Gestión de Hero Section (imagen/video/color)",
        "✓ Gestión de About Section",
        "✓ Gestión de secciones (on/off)",
        "✓ Gestión de colores personalizados",
        "✓ Gestión de redes sociales",
        "✓ Gestión de leads con filtros",
        "✓ Sistema de búsqueda y exportación CSV",
        "✓ Cambio de estado de leads",
        "✓ Notas internas por lead",
        "✓ Layout responsive con sidebar"
    ],
    "Frontend Landing" => [
        "✓ Hero Section dinámico (color/imagen/video)",
        "✓ Sección de Servicios con modal",
        "✓ Sección de Proyectos con filtros",
        "✓ Sección de Testimonios con ratings",
        "✓ Sección de Galería con categorías",
        "✓ Sección de Estadísticas animadas",
        "✓ Sección Features/Beneficios",
        "✓ Sección Call-to-Action (CTA)",
        "✓ Formulario de contacto funcional",
        "✓ Footer con redes sociales",
        "✓ Navbar responsive",
        "✓ Botón flotante de WhatsApp",
        "✓ Colores personalizables desde admin",
        "✓ Diseño 100% responsive",
        "✓ Animaciones con Alpine.js"
    ],
    "Características Técnicas" => [
        "✓ Laravel 11.x",
        "✓ Tailwind CSS 3.x",
        "✓ Alpine.js para interactividad",
        "✓ Sistema de caché optimizado",
        "✓ Rate limiting en formularios",
        "✓ Validación de archivos",
        "✓ Gestión de storage público",
        "✓ SEO Meta tags dinámicos",
        "✓ Google Analytics integration",
        "✓ Facebook Pixel integration",
        "✓ Email templates profesionales",
        "✓ Queue jobs para emails",
        "✓ Migraciones completas",
        "✓ Componentes Blade reutilizables"
    ]
];

foreach ($funcionalidades as $categoria => $items) {
    $salida .= "📌 " . $categoria . ":" . PHP_EOL;
    foreach ($items as $item) {
        $salida .= "   " . $item . PHP_EOL;
    }
    $salida .= PHP_EOL;
}

// === ARCHIVOS CLAVE ===
$salida .= str_repeat("═", 80) . PHP_EOL;
$salida .= "🔑 ARCHIVOS CLAVE DEL PROYECTO" . PHP_EOL;
$salida .= str_repeat("─", 80) . PHP_EOL . PHP_EOL;

$archivos_clave = [
    "Modelos" => [
        "app/Models/User.php",
        "app/Models/Setting.php",
        "app/Models/Service.php",
        "app/Models/Project.php",
        "app/Models/ProjectCategory.php",
        "app/Models/Testimonial.php",
        "app/Models/GalleryImage.php",
        "app/Models/Lead.php"
    ],
    "Controllers Admin" => [
        "app/Http/Controllers/Admin/DashboardController.php",
        "app/Http/Controllers/Admin/SettingController.php",
        "app/Http/Controllers/Admin/ServiceController.php",
        "app/Http/Controllers/Admin/ProjectController.php",
        "app/Http/Controllers/Admin/TestimonialController.php",
        "app/Http/Controllers/Admin/GalleryController.php",
        "app/Http/Controllers/Admin/LeadController.php"
    ],
    "Controllers Frontend" => [
        "app/Http/Controllers/LandingController.php",
        "app/Http/Controllers/LeadController.php"
    ],
    "Notificaciones" => [
        "app/Notifications/NewLeadNotification.php",
        "app/Notifications/LeadConfirmationNotification.php"
    ],
    "Services" => [
        "app/Services/CacheService.php",
        "app/Services/ImageUploadService.php"
    ],
    "Vistas Admin" => [
        "resources/views/admin/layout.blade.php",
        "resources/views/admin/dashboard.blade.php",
        "resources/views/admin/settings/index.blade.php",
        "resources/views/admin/leads/index.blade.php",
        "resources/views/admin/leads/show.blade.php"
    ],
    "Vistas Landing" => [
        "resources/views/landing/layout.blade.php",
        "resources/views/landing/index.blade.php",
        "resources/views/landing/sections/hero.blade.php",
        "resources/views/landing/sections/contact.blade.php"
    ],
    "Rutas" => [
        "routes/web.php",
        "routes/console.php"
    ],
    "Configuración" => [
        ".env.example",
        "composer.json",
        "package.json",
        "tailwind.config.js",
        "vite.config.js"
    ]
];

foreach ($archivos_clave as $categoria => $archivos) {
    $salida .= "📁 " . $categoria . ":" . PHP_EOL;
    foreach ($archivos as $archivo) {
        $existe = file_exists(__DIR__ . '/' . $archivo) ? "✅" : "❌";
        $salida .= "   " . $existe . " " . $archivo . PHP_EOL;
    }
    $salida .= PHP_EOL;
}

// === MENSAJE FINAL ===
$salida .= str_repeat("═", 80) . PHP_EOL;
$salida .= "🎉 FIN DEL LISTADO - Proyecto Laravel Landing Page Administrable" . PHP_EOL;
$salida .= str_repeat("═", 80) . PHP_EOL . PHP_EOL;

$salida .= "📝 Este archivo fue generado automáticamente" . PHP_EOL;
$salida .= "📅 Fecha: " . date('d/m/Y H:i:s') . PHP_EOL;
$salida .= "💾 Guardado en: " . $archivo_salida . PHP_EOL;

// === GUARDAR Y MOSTRAR ===
file_put_contents($archivo_salida, $salida);

header("Content-Type: text/plain; charset=utf-8");
echo $salida;
echo PHP_EOL . "✅ Archivo generado exitosamente en: " . $archivo_salida . PHP_EOL;
