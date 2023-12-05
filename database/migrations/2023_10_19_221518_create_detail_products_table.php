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
            $table->unsignedBigInteger('product_id');
            $table->bigInteger('sell_price_duz')->nullable();
            $table->bigInteger('sell_price_pak')->nullable();
            $table->bigInteger('sell_price_pcs')->nullable();
            $table->enum('tax_type', ['PPN', 'NON-PPN'])->default('PPN');
            $table->enum('periode', ['Reguler', 'Seasonal'])->default('Reguler');
            $table->decimal('discount', 5, 2)->nullable();
            $table->timestamps();

            //relationship categories
            $table->foreign('product_id')->references('id')->on('products');
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
