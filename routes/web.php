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
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DownloadController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

/* =============================
   RUTAS PÚBLICAS - LANDING
============================= */

Route::get('/', [LandingController::class, 'index'])->name('home');
Route::post('/contacto', [LeadController::class, 'store'])->name('leads.store');

/* =============================
   AUTENTICACIÓN
============================= */

require __DIR__ . '/auth.php';

/* =============================
   REDIRECCIÓN DASHBOARD
============================= */

Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/* =============================
   PANEL ADMIN
============================= */

Route::middleware(['auth', 'verified'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        /* SETTINGS */
        Route::middleware(['admin'])->group(function () {
            Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
            Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
        });

        /* HERO */
        Route::middleware(['editor'])->group(function () {
            Route::get('/hero', [App\Http\Controllers\Admin\HeroController::class, 'index'])->name('hero.index');
            Route::put('/hero', [App\Http\Controllers\Admin\HeroController::class, 'update'])->name('hero.update');
        });

        /* ABOUT */
        Route::middleware(['editor'])->group(function () {
            Route::get('/about', [App\Http\Controllers\Admin\AboutController::class, 'index'])->name('about.index');
            Route::put('/about', [App\Http\Controllers\Admin\AboutController::class, 'update'])->name('about.update');
        });

        /* SERVICIOS, PROYECTOS, ETC */
        Route::middleware(['editor'])->group(function () {
            Route::resource('services', ServiceController::class);
            Route::resource('projects', ProjectController::class);
            Route::resource('testimonials', TestimonialController::class);
            Route::resource('gallery', GalleryController::class);

            Route::post('gallery/upload-multiple', [GalleryController::class, 'uploadMultiple'])
                ->name('gallery.upload-multiple');
        });

        /* LEADS */
        Route::middleware(['editor'])
            ->prefix('leads')
            ->name('leads.')
            ->group(function () {
                Route::get('/', [AdminLeadController::class, 'index'])->name('index');
                Route::get('/{lead}', [AdminLeadController::class, 'show'])->name('show');
                Route::delete('/{lead}', [AdminLeadController::class, 'destroy'])->middleware('admin')->name('destroy');
                Route::put('/{lead}/status', [AdminLeadController::class, 'updateStatus'])->name('update-status');
                Route::put('/{lead}/notes', [AdminLeadController::class, 'updateNotes'])->name('update-notes');
                Route::post('/mark-read-bulk', [AdminLeadController::class, 'markAsReadBulk'])->name('mark-read-bulk');
                Route::get('/export/csv', [AdminLeadController::class, 'export'])->name('export');
            });

        /* PRODUCTS */
        Route::middleware(['editor'])->group(function () {
            Route::resource('categories', App\Http\Controllers\Admin\ProductCategoryController::class);
            Route::resource('products', App\Http\Controllers\Admin\ProductController::class);
            Route::put('products/{product}/stock', [App\Http\Controllers\Admin\ProductController::class, 'updateStock'])
                ->name('products.update-stock');
        });

        /* ADMIN ORDERS */
        Route::middleware(['editor'])
            ->prefix('orders')
            ->name('orders.')
            ->group(function () {
                Route::get('/', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('index');
                Route::get('/{order}', [App\Http\Controllers\Admin\OrderController::class, 'show'])->name('show');
                Route::put('/{order}/status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('update-status');
                Route::post('/{order}/cancel', [App\Http\Controllers\Admin\OrderController::class, 'cancel'])->name('cancel');
                Route::get('/export/csv', [App\Http\Controllers\Admin\OrderController::class, 'export'])->name('export');
            });

        /* ADMIN PAGOS - GESTIÓN DE COMPROBANTES */
        Route::middleware(['editor'])
            ->prefix('payments')
            ->name('payments.')
            ->group(function () {
                Route::get('/', [PaymentController::class, 'adminIndex'])->name('index');
                Route::get('/pending', [PaymentController::class, 'pending'])->name('pending');
                Route::post('/{payment}/verify', [PaymentController::class, 'verify'])->name('verify');
                Route::post('/{payment}/reject', [PaymentController::class, 'reject'])->name('reject');
                Route::post('/{id}/aprobar', [PaymentController::class, 'aprobar'])->name('aprobar');
                Route::post('/{id}/rechazar', [PaymentController::class, 'rechazar'])->name('rechazar');
            });

            // ── STATS ────────────────────────────────────────────────────
            Route::prefix('stats')->name('stats.')->group(function () {
                Route::get('/', [App\Http\Controllers\Admin\StatController::class, 'index'])
                    ->name('index');
                Route::post('/', [App\Http\Controllers\Admin\StatController::class, 'store'])
                    ->name('store');
                Route::post('/reorder', [App\Http\Controllers\Admin\StatController::class, 'reorder'])
                    ->name('reorder');

                // ⚠️ Rutas sin parámetro SIEMPRE antes de /{stat}
                Route::put('/colors', [App\Http\Controllers\Admin\StatController::class, 'updateColors'])
                    ->name('update-colors');

                // Rutas con parámetro al final
                Route::put('/{stat}', [App\Http\Controllers\Admin\StatController::class, 'update'])
                    ->name('update');
                Route::delete('/{stat}', [App\Http\Controllers\Admin\StatController::class, 'destroy'])
                    ->name('destroy');
                Route::patch('/{stat}/toggle', [App\Http\Controllers\Admin\StatController::class, 'toggleActive'])
                    ->name('toggle');
            });
    });

/* =============================
   PERFIL USUARIO
============================= */

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/* =============================
   TIENDA
============================= */

Route::prefix('tienda')->name('shop.')->group(function () {
    Route::get('/', [App\Http\Controllers\ShopController::class, 'index'])->name('index');
    Route::get('/producto/{product:slug}', [App\Http\Controllers\ShopController::class, 'show'])->name('show');
});

/* =============================
   CARRITO
============================= */

Route::prefix('carrito')->name('cart.')->group(function () {
    Route::get('/', [App\Http\Controllers\CartController::class, 'index'])->name('index');
    Route::post('/agregar/{product}', [App\Http\Controllers\CartController::class, 'add'])->name('add');
    Route::put('/actualizar/{cartItem}', [App\Http\Controllers\CartController::class, 'update'])->name('update');
    Route::delete('/eliminar/{cartItem}', [App\Http\Controllers\CartController::class, 'remove'])->name('remove');
    Route::delete('/vaciar', [App\Http\Controllers\CartController::class, 'clear'])->name('clear');
    Route::get('/cantidad', [App\Http\Controllers\CartController::class, 'count'])->name('count');
});

/* =============================
   CHECKOUT - FLUJO PRINCIPAL
============================= */

Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/procesar', [CheckoutController::class, 'process'])->name('process');
});

/* =============================
   CONFIRMACIÓN Y PAGOS
============================= */

Route::get('/orden/confirmacion/{order}', [CheckoutController::class, 'confirmation'])
    ->name('orders.confirmation');

/* =============================
   INSTRUCCIONES DE PAGO SEGÚN MÉTODO
============================= */

Route::get('/orden/{order}/pago/breb', [PaymentController::class, 'showInstructionsBreb'])
    ->name('payment.instructions.breb');

Route::get('/orden/{order}/pago/transferencia', [PaymentController::class, 'showInstructionsTransfer'])
    ->name('payment.instructions.transfer');

Route::get('/orden/{order}/pago/qr', [PaymentController::class, 'showInstructionsQr'])
    ->name('payment.instructions.qr');

Route::get('/orden/{order}/pago/tarjeta', [PaymentController::class, 'showInstructionsCard'])
    ->name('payment.instructions.card');

/* =============================
   SUBIR COMPROBANTE DE PAGO
============================= */

Route::get('/orden/{order}/subir-comprobante', [PaymentController::class, 'showUploadForm'])
    ->name('payment.upload-form');

Route::post('/orden/{order}/comprobante', [PaymentController::class, 'subirComprobante'])
    ->name('payment.upload');

Route::get('/orden/{order}/confirmacion', [PaymentController::class, 'confirmation'])
    ->name('payment.confirmation');

/* =============================
   DESCARGAS
============================= */

Route::get('/descargas/{token}', [DownloadController::class, 'show'])->name('downloads.show');
Route::get('/descargar/{token}', [DownloadController::class, 'download'])->name('downloads.file');

/* =============================
   PÁGINAS LEGALES
============================= */

Route::get('/terminos-y-condiciones', [App\Http\Controllers\LegalController::class, 'terms'])->name('legal.terms');
Route::get('/politica-de-privacidad', [App\Http\Controllers\LegalController::class, 'privacy'])->name('legal.privacy');

/* =============================
   ARCHIVOS PÚBLICOS
============================= */

Route::get('/images/{any}', function ($any) {
    $path = public_path('images/' . $any);

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->file($path);
})->where('any', '.*');

/* =============================
   RUTAS FUTURAS POR ROL
   (descomentar cuando se implementen)
============================= */

// ── INVESTIGADORES ──────────────────────────────────────────
// Route::middleware(['auth', 'researcher'])->prefix('investigaciones')->name('research.')->group(function () {
//     Route::get('/', ...)->name('index');
//     Route::get('/crear', ...)->name('create');
//     Route::post('/', ...)->name('store');
//     Route::get('/{id}/editar', ...)->name('edit');
//     Route::put('/{id}', ...)->name('update');
//     Route::delete('/{id}', ...)->name('destroy');
// });

// ── COLUMNISTAS ──────────────────────────────────────────────
// Route::middleware(['auth', 'columnist'])->prefix('columnas')->name('columns.')->group(function () {
//     Route::get('/', ...)->name('index');
//     Route::get('/crear', ...)->name('create');
//     Route::post('/', ...)->name('store');
//     Route::get('/{id}/editar', ...)->name('edit');
//     Route::put('/{id}', ...)->name('update');
//     Route::delete('/{id}', ...)->name('destroy');
// });

// ── VENDEDORES (MARKETPLACE) ─────────────────────────────────
// Route::middleware(['auth', 'seller'])->prefix('mis-productos')->name('seller.')->group(function () {
//     Route::get('/', ...)->name('index');
//     Route::get('/crear', ...)->name('create');
//     Route::post('/', ...)->name('store');
//     Route::get('/{id}/editar', ...)->name('edit');
//     Route::put('/{id}', ...)->name('update');
//     Route::delete('/{id}', ...)->name('destroy');
// });

// ── CLIENTES / COMPRADORES ───────────────────────────────────
// Route::middleware(['auth', 'customer'])->prefix('mis-pedidos')->name('customer.')->group(function () {
//     Route::get('/', ...)->name('index');
//     Route::get('/{id}', ...)->name('show');
// });

// ── USUARIOS REGISTRADOS ─────────────────────────────────────
// Route::middleware(['auth', 'user'])->prefix('mi-cuenta')->name('account.')->group(function () {
//     Route::get('/', ...)->name('index');
// });

/* =============================
   ⚠️ FALLBACK (DEBE IR AL FINAL)
============================= */

Route::fallback(function () {
    return view('errors.404');
});
