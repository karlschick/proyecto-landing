<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Hacer nullable los campos que ya no usaremos
            $table->foreignId('category_id')->nullable()->change();
            $table->string('short_description', 500)->nullable()->change();
            $table->string('client')->nullable()->change();
            $table->date('project_date')->nullable()->change();
            $table->string('url')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable(false)->change();
            $table->string('short_description', 500)->nullable(false)->change();
            $table->string('client')->nullable(false)->change();
            $table->date('project_date')->nullable(false)->change();
            $table->string('url')->nullable(false)->change();
        });
    }
};
