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
        Schema::create('barang', function (Blueprint $table) {
        $table->id('id_barang'); // Primary Key
        $table->string('kode_barang')->unique();
        $table->string('nama_barang');
        $table->integer('stok_total');
        $table->integer('stok_tersedia');
        $table->string('lokasi');
        $table->enum('kondisi', ['Normal', 'Rusak', 'Error'])->default('Normal');
        $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
