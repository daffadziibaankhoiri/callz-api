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
        Schema::create('task_ratings', function (Blueprint $table) {
            $table->id();
            
            // Relasi utama ke tabel tugas (Gunakan unique agar 1 task cuma punya 1 baris rating)
            $table->foreignId('task_id')->unique()->constrained('tasks')->onDelete('cascade');
            
            // Kolom Rating & Review dari USER (Menilai Kerja Mitra)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->tinyInteger('user_rating')->nullable()->unsigned(); // Nilai 1-5
            $table->text('user_review')->nullable();
            
            // Kolom Rating & Review dari MITRA (Menilai Bayaran/Sikap User)
            $table->foreignId('mitra_id')->constrained('mitras')->onDelete('cascade');
            $table->tinyInteger('mitra_rating')->nullable()->unsigned(); // Nilai 1-5
            $table->text('mitra_review')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_ratings');
    }
};