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
        Schema::create('detail_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sales_id');
            $table->unsignedBigInteger('product_id');
            $table->bigInteger('sell_price_duz')->nullable();
            $table->bigInteger('sell_price_pak')->nullable();
            $table->bigInteger('sell_price_pcs')->nullable();
            $table->enum('tax_type', ['PPN', 'NON-PPN'])->nullable();
            $table->enum('periode', ['Reguler', 'Seasonal'])->nullable();
            $table->decimal('discount', 5, 2)->nullable();
            $table->timestamps();

            //relationship categories
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('sales_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_products');
    }
};
