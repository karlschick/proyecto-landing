<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;

// ============================================
// RUTAS PÚBLICAS - LANDING PAGE
// ============================================

// Página principal
Route::get('/', [App\Http\Controllers\LandingController::class, 'index'])->name('home');

// Leads - Formulario de contacto (AGREGAR ESTA LÍNEA)
Route::post('/contacto', [App\Http\Controllers\LeadController::class, 'store'])->name('leads.store');

// ============================================
// RUTAS DE AUTENTICACIÓN
// ============================================

require __DIR__.'/auth.php';

// ============================================
// RUTAS DEL PANEL ADMINISTRATIVO
// ============================================

Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard principal
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Configuración general
    Route::get('settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');

    // Servicios
    Route::resource('services', \App\Http\Controllers\Admin\ServiceController::class);

    // Proyectos
    Route::resource('projects', \App\Http\Controllers\Admin\ProjectController::class);

    // Testimonios
    Route::resource('testimonials', \App\Http\Controllers\Admin\TestimonialController::class);

    // Galería
    Route::resource('gallery', \App\Http\Controllers\Admin\GalleryController::class);
    Route::post('gallery/upload-multiple', [\App\Http\Controllers\Admin\GalleryController::class, 'uploadMultiple'])->name('gallery.upload-multiple');

    // ============================================
    // LEADS (AGREGAR ESTAS RUTAS)
    // ============================================
    Route::prefix('leads')->name('leads.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\LeadController::class, 'index'])->name('index');
        Route::get('/{lead}', [\App\Http\Controllers\Admin\LeadController::class, 'show'])->name('show');
        Route::delete('/{lead}', [\App\Http\Controllers\Admin\LeadController::class, 'destroy'])->name('destroy');
        Route::put('/{lead}/status', [\App\Http\Controllers\Admin\LeadController::class, 'updateStatus'])->name('update-status');
        Route::put('/{lead}/notes', [\App\Http\Controllers\Admin\LeadController::class, 'updateNotes'])->name('update-notes');
        Route::post('/mark-read-bulk', [\App\Http\Controllers\Admin\LeadController::class, 'markAsReadBulk'])->name('mark-read-bulk');
        Route::get('/export/csv', [\App\Http\Controllers\Admin\LeadController::class, 'export'])->name('export');
    });
});
