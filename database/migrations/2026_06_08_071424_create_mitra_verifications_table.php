<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mitra_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mitra_id')
                  ->unique() // Satu mitra hanya punya satu data verifikasi
                  ->constrained('mitras')
                  ->onDelete('cascade');
            $table->string('foto_ktp', 255);
            $table->string('foto_sim', 255);
            $table->enum('status', ['PENDING', 'APPROVED', 'REJECTED'])->default('PENDING');
            $table->text('rejection_note')->nullable(); // Catatan admin kalau REJECTED
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mitra_verifications');
    }
};