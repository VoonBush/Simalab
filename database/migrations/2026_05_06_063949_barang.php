<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();            // Kode unik barang, e.g. "ITM-001"
            $table->string('name');                      // Nama barang
            $table->text('description')->nullable();
            $table->string('image')->nullable();         // Path gambar
            $table->string('qr_code')->nullable();       // Path file QR Code
            $table->foreignId('location_id')->nullable()->constrained('locations')->nullOnDelete();
            $table->enum('condition', ['baik', 'rusak', 'perbaikan'])->default('baik');
            $table->integer('total_stock')->default(1);
            $table->integer('available_stock')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
