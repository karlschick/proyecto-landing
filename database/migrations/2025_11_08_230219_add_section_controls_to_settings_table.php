<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            // Verificar si las columnas no existen antes de agregarlas
            if (!Schema::hasColumn('settings', 'cta_enabled')) {
                $table->boolean('cta_enabled')->default(true)->after('hero_enabled');
            }
            if (!Schema::hasColumn('settings', 'about_enabled')) {
                $table->boolean('about_enabled')->default(true)->after('cta_enabled');
            }
            if (!Schema::hasColumn('settings', 'features_enabled')) {
                $table->boolean('features_enabled')->default(true)->after('about_enabled');
            }
            if (!Schema::hasColumn('settings', 'stats_enabled')) {
                $table->boolean('stats_enabled')->default(true)->after('features_enabled');
            }
            if (!Schema::hasColumn('settings', 'shop_enabled')) {
                $table->boolean('shop_enabled')->default(true)->after('products_enabled');
            }

            // NUEVO: Control para mostrar enlace "Tienda" en navbar
            if (!Schema::hasColumn('settings', 'navbar_show_shop')) {
                $table->boolean('navbar_show_shop')->default(true)->after('navbar_show_slogan');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $columns = ['cta_enabled', 'about_enabled', 'features_enabled', 'stats_enabled', 'shop_enabled', 'navbar_show_shop'];

            foreach ($columns as $column) {
                if (Schema::hasColumn('settings', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
