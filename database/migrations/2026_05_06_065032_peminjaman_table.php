<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();
            $table->string('borrow_code')->unique();           // Format: BRW-YYYYMMDD-XXX
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->date('borrow_date');
            $table->date('return_date');                       // Rencana kembali
            $table->date('actual_return_date')->nullable();    // Aktual kembali
            $table->text('purpose');                           // Keperluan peminjaman
            $table->enum('status', [
                'pending',
                'approved',
                'rejected',
                'borrowed',
                'returned',
                'late',
            ])->default('pending');
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};
