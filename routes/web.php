<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\LeadController as AdminLeadController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aquí se registran todas las rutas web de la aplicación.
|
*/

// ============================================
// RUTAS PÚBLICAS - LANDING PAGE
// ============================================

// Página principal
Route::get('/', [LandingController::class, 'index'])->name('home');

// Formulario de contacto — PÚBLICO (Sin login)
Route::post('/contacto', [LeadController::class, 'store'])->name('leads.store');


// ============================================
// RUTAS DE AUTENTICACIÓN
// ============================================

require __DIR__ . '/auth.php';

// ============================================
// REDIRECCIÓN AL DASHBOARD
// ============================================

Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ============================================
// PANEL ADMINISTRATIVO
// ============================================

Route::middleware(['auth', 'verified'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard principal
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // CONFIGURACIÓN GENERAL (solo Admin)
        Route::middleware(['admin'])->group(function () {
            Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
            Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
        });

        // SERVICIOS (Admin y Editor)
        Route::middleware(['editor'])->group(function () {
            Route::resource('services', ServiceController::class);
        });

        // PROYECTOS (Admin y Editor)
        Route::middleware(['editor'])->group(function () {
            Route::resource('projects', ProjectController::class);
        });

        // TESTIMONIOS (Admin y Editor)
        Route::middleware(['editor'])->group(function () {
            Route::resource('testimonials', TestimonialController::class);
        });

        // GALERÍA (Admin y Editor)
        Route::middleware(['editor'])->group(function () {
            Route::resource('gallery', GalleryController::class);
            Route::post('gallery/upload-multiple', [GalleryController::class, 'uploadMultiple'])
                ->name('gallery.upload-multiple');
        });

        // LEADS / CONTACTOS (Admin y Editor)
        Route::middleware(['editor'])
            ->prefix('leads')
            ->name('leads.')
            ->group(function () {
                Route::get('/', [AdminLeadController::class, 'index'])->name('index');
                Route::get('/{lead}', [AdminLeadController::class, 'show'])->name('show');
                Route::delete('/{lead}', [AdminLeadController::class, 'destroy'])
                    ->middleware('admin')->name('destroy');
                Route::put('/{lead}/status', [AdminLeadController::class, 'updateStatus'])
                    ->name('update-status');
                Route::put('/{lead}/notes', [AdminLeadController::class, 'updateNotes'])
                    ->name('update-notes');
                Route::post('/mark-read-bulk', [AdminLeadController::class, 'markAsReadBulk'])
                    ->name('mark-read-bulk');
                Route::get('/export/csv', [AdminLeadController::class, 'export'])->name('export');
            });

        // PRODUCTOS Y CATEGORÍAS (Admin y Editor)
        Route::middleware(['editor'])->group(function () {
            Route::resource('categories', App\Http\Controllers\Admin\ProductCategoryController::class);
            Route::resource('products', App\Http\Controllers\Admin\ProductController::class);
            Route::put('products/{product}/stock', [App\Http\Controllers\Admin\ProductController::class, 'updateStock'])
                ->name('products.update-stock');
        });

        // ÓRDENES (Admin y Editor)
        Route::middleware(['editor'])
            ->prefix('orders')
            ->name('orders.')
            ->group(function () {
                Route::get('/', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('index');
                Route::get('/{order}', [App\Http\Controllers\Admin\OrderController::class, 'show'])->name('show');
                Route::put('/{order}/status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])
                    ->name('update-status');
                Route::post('/{order}/cancel', [App\Http\Controllers\Admin\OrderController::class, 'cancel'])
                    ->name('cancel');
                Route::get('/export/csv', [App\Http\Controllers\Admin\OrderController::class, 'export'])
                    ->name('export');
            });
    });

// ============================================
// PERFIL DE USUARIO (FUERA DEL PREFIJO ADMIN)
// ============================================

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ============================================
// RUTAS DE E-COMMERCE - TIENDA
// ============================================

Route::prefix('tienda')->name('shop.')->group(function () {
    Route::get('/', [App\Http\Controllers\ShopController::class, 'index'])->name('index');
    Route::get('/producto/{product:slug}', [App\Http\Controllers\ShopController::class, 'show'])->name('show');
});

// Carrito de compras
Route::prefix('carrito')->name('cart.')->group(function () {
    Route::get('/', [App\Http\Controllers\CartController::class, 'index'])->name('index');
    Route::post('/agregar/{product}', [App\Http\Controllers\CartController::class, 'add'])->name('add');
    Route::put('/actualizar/{cartItem}', [App\Http\Controllers\CartController::class, 'update'])->name('update');
    Route::delete('/eliminar/{cartItem}', [App\Http\Controllers\CartController::class, 'remove'])->name('remove');
    Route::delete('/vaciar', [App\Http\Controllers\CartController::class, 'clear'])->name('clear');
    Route::get('/cantidad', [App\Http\Controllers\CartController::class, 'count'])->name('count');
});

// Checkout y órdenes
Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [App\Http\Controllers\CheckoutController::class, 'index'])->name('index');
    Route::post('/procesar', [App\Http\Controllers\CheckoutController::class, 'process'])->name('process');
});

Route::get('/orden/confirmacion/{order}', [App\Http\Controllers\CheckoutController::class, 'confirmation'])
    ->name('orders.confirmation');

// Ruta QR de pago
Route::get('/orders/{order}/qr-payment', [CheckoutController::class, 'qrPayment'])
    ->name('orders.qr-payment');

// ============================================
// PÁGINA 404 PERSONALIZADA
// ============================================

Route::fallback(function () {
    return view('errors.404');
});

// ==================== DESCARGAS PÚBLICAS ====================
use App\Http\Controllers\DownloadController;

Route::get('/descargas/{token}', [DownloadController::class, 'show'])->name('downloads.show');
Route::get('/descargar/{token}', [DownloadController::class, 'download'])->name('downloads.file');

// ==================== ADMIN - PAGOS ====================
use App\Http\Controllers\Admin\PaymentController;

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // ... tus rutas admin existentes ...

    // Pagos pendientes
    Route::get('/pagos/pendientes', [PaymentController::class, 'pending'])->name('payments.pending');
    Route::post('/pagos/{payment}/verificar', [PaymentController::class, 'verify'])->name('payments.verify');
    Route::post('/pagos/{payment}/rechazar', [PaymentController::class, 'reject'])->name('payments.reject');

    // Órdenes
    Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class);
});
