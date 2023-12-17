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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sales_id');
            $table->unsignedBigInteger('outlet_id');
            $table->string('transaction_id', 150)->unique();
            $table->integer('total_transactions')->default(0);
            $table->integer('total');
            $table->integer('payment_status')->comment('0 => due, 1 => paid');
            $table->integer('order_status')->comment('0 => pending, 1 => completed');
            $table->decimal('disc_bawah', 5, 2)->nullable();
            $table->timestamps();

            $table->foreign('sales_id')->references('id')->on('users');
            $table->foreign('outlet_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
