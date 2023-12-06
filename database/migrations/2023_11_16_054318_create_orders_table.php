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
            $table->string('transaction_id', 150)->unique();
            $table->string('customer_name', 150);
            $table->string('customer_sales', 150);
            $table->text('customer_address');
            $table->integer('total');
            $table->integer('payment_status')->comment('0 => due, 1 => paid');
            $table->integer('order_status')->comment('0 => pending, 1 => completed, 2 => canceled');
            $table->timestamps();

            $table->foreign('sales_id')->references('id')->on('users');
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
