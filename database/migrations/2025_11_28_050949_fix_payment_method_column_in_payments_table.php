<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $columns = Schema::getColumnListing('payments');

        // Si existe payment_method, eliminarla (porque ya tenemos 'method')
        if (in_array('payment_method', $columns)) {
            Schema::table('payments', function (Blueprint $table) {
                $table->dropColumn('payment_method');
            });
        }

        // Asegurarnos de que 'method' no sea nullable
        Schema::table('payments', function (Blueprint $table) {
            $table->string('method')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('payment_method')->nullable();
        });
    }
};
