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
        Schema::create('sales_carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sales_id');
            $table->unsignedBigInteger('detail_id');
            $table->integer('qty_duz');
            $table->integer('qty_pak');
            $table->integer('qty_pcs');
            $table->timestamps();

            $table->foreign('detail_id')->references('id')->on('detail_products');
            $table->foreign('sales_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_carts');
    }
};
