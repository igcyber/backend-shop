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
        Schema::create('products', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('vendor_id');
            $table->string('serial_number')->unique();
            $table->string('image')->nullable();
            $table->string('title');
            $table->text('short_description')->nullable();
            $table->$table->integer('total_stock');
            $table->integer('stock_duz')->nullable();
            $table->integer('stock_pak')->nullable();
            $table->integer('stock_pcs')->nullable();
            $table->date('exp_date')->nullable();
            $table->timestamps();

            //relationship categories
            $table->foreign('category_id')->references('id')->on('categories');
            //relationship vendors
            $table->foreign('vendor_id')->references('id')->on('vendors');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
