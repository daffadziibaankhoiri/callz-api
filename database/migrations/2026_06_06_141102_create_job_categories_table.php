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
       Schema::create('job_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Contoh: 'Khusus', 'Sedang', 'Ringan'
            $table->integer('price')->default(0); // Contoh: 25000, 5000
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_categories');
    }
};
