<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('order_id');
            $table->string('method')->default('daviplata');
            $table->string('reference')->unique();
            $table->decimal('amount', 10, 2);

            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->string('receipt')->nullable(); // imagen del comprobante

            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
