<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('stats_bg_color')->default('#000000')->after('stats_enabled');
            $table->string('stats_number_color')->default('#f5f500')->after('stats_bg_color');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['stats_bg_color', 'stats_number_color']);
        });
    }
};
