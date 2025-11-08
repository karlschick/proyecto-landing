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
            // Color del título del hero
            $table->string('hero_title_color')->nullable()->default('#ffffff');

            // Fuente del título del hero
            $table->string('hero_title_font')->nullable()->default('default');

            // Mostrar logo en lugar del texto principal
            $table->boolean('hero_show_logo_instead')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'hero_title_color',
                'hero_title_font',
                'hero_show_logo_instead',
            ]);
        });
    }
};
