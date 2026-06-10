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
        Schema::create('package_categories', function (Blueprint $table) {
    $table->id();
    $table->string('name'); // Contoh isi: 'Ringan', 'Sedang (1–5kg)', 'Berat'
    $table->integer('price')->default(0); // Contoh isi: 0, 4500, 10000 (Murni angka untuk mempermudah perhitungan)
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_category');
    }
};
