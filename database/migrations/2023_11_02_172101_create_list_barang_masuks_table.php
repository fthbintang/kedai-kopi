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
        Schema::create('list_barang_masuks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->nullable();
            $table->foreignId('barang_masuk_id')->nullable();
            $table->integer('stok_masuk')->nullable();
            $table->integer('stok_sebelum')->nullable();
            $table->integer('stok_sesudah')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_barang_masuks');
    }
};
