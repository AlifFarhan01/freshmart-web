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
        Schema::create('keranjang', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('id_user'); 
        $table->unsignedBigInteger('id_produk'); 
        $table->integer('qty'); 
        $table->timestamps();

      
        $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('id_produk')->references('id')->on('produk')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keranjang');
    }
};
