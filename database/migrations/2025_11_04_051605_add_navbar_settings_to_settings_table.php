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
        $table->string('navbar_bg_color')->nullable()->default('#ffffff');
        $table->string('navbar_text_color')->nullable()->default('#000000');
        $table->boolean('navbar_show_logo')->default(true);
        $table->boolean('navbar_show_title')->default(true);
        $table->boolean('navbar_show_slogan')->default(true);
        $table->json('navbar_menu_labels')->nullable(); // para guardar nombres de links
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            //
        });
    }
};
