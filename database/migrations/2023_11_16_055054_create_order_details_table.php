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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('detail_id');
            $table->integer('qty_duz');
            $table->integer('qty_pak');
            $table->integer('qty_pcs');
            $table->integer('price_duz');
            $table->integer('price_pak');
            $table->integer('price_pcs');
            $table->timestamps();

            //relationship order
            $table->foreign('order_id')->references('id')->on('orders');
            //relationship detail product
            $table->foreign('detail_id')->references('id')->on('detail_products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
