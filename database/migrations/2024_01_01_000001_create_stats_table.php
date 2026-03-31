<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stats', function (Blueprint $table) {
            $table->id();
            $table->string('label');           // "Proyectos Completados"
            $table->string('value');           // "150+"
            $table->integer('target');         // 150  (número real para la animación)
            $table->string('suffix')->default('');  // "+" o "%"
            $table->integer('duration')->default(20); // velocidad del intervalo (ms)
            $table->integer('step')->default(5);      // cuánto incrementa por tick
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stats');
    }
};
