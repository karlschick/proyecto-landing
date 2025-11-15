<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Ruta del archivo PDF
            $table->string('file_path')->nullable()->after('featured_image');

            // Tamaño del archivo en bytes
            $table->bigInteger('file_size')->nullable()->after('file_path');

            // Límite de descargas por compra
            $table->integer('download_limit')->default(3)->after('file_size');

            // Días de acceso al archivo después de la compra
            $table->integer('access_days')->default(365)->after('download_limit');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['file_path', 'file_size', 'download_limit', 'access_days']);
        });
    }
};
