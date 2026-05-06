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
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id('id_peminjaman');
            $table->foreignId('id_user')->constrained('users', 'id_user')->onDelete('cascade');
            $table->dateTime('tanggal_pinjam');
            $table->dateTime('batas_peminjaman');
            $table->dateTime('tanggal_kembali')->nullable();
            $table->enum('status', ['diajukan', 'disetujui', 'ditolak', 'dikembalikan'])->default('diajukan');
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
