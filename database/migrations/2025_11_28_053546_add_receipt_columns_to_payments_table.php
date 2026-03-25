<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $columns = Schema::getColumnListing('payments');

            if (!in_array('receipt_path', $columns)) {
                $table->string('receipt_path')->nullable()->after('status');
            }

            if (!in_array('admin_notes', $columns)) {
                $table->text('admin_notes')->nullable()->after('receipt_path');
            }

            if (!in_array('reviewed_by', $columns)) {
                $table->unsignedBigInteger('reviewed_by')->nullable()->after('admin_notes');
            }

            if (!in_array('reviewed_at', $columns)) {
                $table->timestamp('reviewed_at')->nullable()->after('reviewed_by');
            }
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['receipt_path', 'admin_notes', 'reviewed_by', 'reviewed_at']);
        });
    }
};
