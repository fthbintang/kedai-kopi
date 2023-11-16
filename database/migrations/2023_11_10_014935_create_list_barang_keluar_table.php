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
        Schema::create('list_barang_keluars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained('barangs')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('barang_keluar_id')->constrained('list_barang_keluars')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('stok_keluar');
            $table->integer('stok_sebelum');
            $table->integer('stok_sesudah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_barang_keluars');
    }
};
