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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sales_id');
            $table->unsignedBigInteger('outlet_id');
            $table->string('nomor', 50)->nullable();
            $table->enum('klasifikasi', ['Toko', 'Perorangan', 'MT', 'PS. Basah', 'Grosir', 'Retail', 'Perusahaan', 'Ps/Grosir', 'MT/Grosir', 'Mini Market', 'Kantor', 'EMT', 'Retail/Grosir', 'Motoris/Kemangi', 'MT/Ps']);
            $table->string('no_telp', 14)->nullable();
            $table->string('hrg_jual', 50)->nullable();
            $table->text('address')->nullable();
            //relationship sales
            $table->foreign('sales_id')->references('id')->on('users');
            $table->foreign('outlet_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
