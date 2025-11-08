<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Asegura que el sistema de vistas esté disponible antes de intentar compartir datos
        $this->app->booted(function () {
            $settings = null;

            try {
                if (!app()->runningInConsole() && class_exists(\App\Models\Setting::class)) {
                    $settings = \App\Models\Setting::first();
                }
            } catch (\Throwable $e) {
                $settings = null;
            }

            // Compartir configuración con todas las vistas
            View::share('settings', $settings);
        });
    }
}
