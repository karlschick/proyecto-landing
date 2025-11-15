<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_downloads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('user_email');
            $table->string('download_token', 64)->unique();
            $table->integer('downloads_count')->default(0);
            $table->integer('max_downloads')->default(3);
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('last_downloaded_at')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamps();

            $table->index(['order_id', 'product_id']);
            $table->index('download_token');
            $table->index('expires_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_downloads');
    }
};
