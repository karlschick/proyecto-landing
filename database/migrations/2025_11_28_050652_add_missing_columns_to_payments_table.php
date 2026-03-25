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
        // Primero verificamos qué columnas ya existen
        $columns = Schema::getColumnListing('payments');

        Schema::table('payments', function (Blueprint $table) use ($columns) {
            // Agregar columna 'reference' si no existe
            if (!in_array('reference', $columns)) {
                $table->string('reference')->nullable()->after('method');
            }

            // Agregar columna 'currency' si no existe
            if (!in_array('currency', $columns)) {
                $table->string('currency', 3)->default('COP')->after('amount');
            }

            // Agregar columna 'payment_gateway' si no existe
            if (!in_array('payment_gateway', $columns)) {
                $table->string('payment_gateway')->nullable()->after('currency');
            }

            // Agregar columna 'metadata' si no existe
            if (!in_array('metadata', $columns)) {
                $table->json('metadata')->nullable()->after('payment_gateway');
            }

            // Agregar columna 'paid_at' si no existe
            if (!in_array('paid_at', $columns)) {
                $table->timestamp('paid_at')->nullable()->after('status');
            }

            // Agregar columna 'receipt_path' si no existe
            if (!in_array('receipt_path', $columns)) {
                $table->string('receipt_path')->nullable()->after('paid_at');
            }

            // Agregar columna 'admin_notes' si no existe
            if (!in_array('admin_notes', $columns)) {
                $table->text('admin_notes')->nullable()->after('receipt_path');
            }

            // Agregar columna 'reviewed_by' si no existe
            if (!in_array('reviewed_by', $columns)) {
                $table->unsignedBigInteger('reviewed_by')->nullable()->after('admin_notes');
            }

            // Agregar columna 'reviewed_at' si no existe
            if (!in_array('reviewed_at', $columns)) {
                $table->timestamp('reviewed_at')->nullable()->after('reviewed_by');
            }
        });

        // Hacer que 'reference' sea único si no lo es
        if (in_array('reference', $columns)) {
            try {
                DB::statement('ALTER TABLE payments MODIFY COLUMN reference VARCHAR(255) NOT NULL');
                DB::statement('ALTER TABLE payments ADD UNIQUE KEY payments_reference_unique (reference)');
            } catch (\Exception $e) {
                // Si ya existe el índice único, ignorar
            }
        }

        // Actualizar el ENUM de status si es necesario
        try {
            DB::statement("ALTER TABLE payments MODIFY COLUMN status ENUM('pending', 'pending_verification', 'completed', 'approved', 'failed', 'rejected', 'cancelled') DEFAULT 'pending'");
        } catch (\Exception $e) {
            // Si falla, continuar
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $columns = Schema::getColumnListing('payments');

            $columnsToRemove = [
                'reference',
                'currency',
                'payment_gateway',
                'metadata',
                'paid_at',
                'receipt_path',
                'admin_notes',
                'reviewed_by',
                'reviewed_at'
            ];

            foreach ($columnsToRemove as $column) {
                if (in_array($column, $columns)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
