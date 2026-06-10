<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            
            // Relasi Aktor
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('mitra_id')->nullable()->constrained('mitras')->onDelete('set null');
            
            // Relasi Dual Kategori (Paket & Pekerjaan)
            $table->foreignId('package_category_id')->constrained('package_categories')->onDelete('restrict');
            $table->foreignId('job_category_id')->constrained('job_categories')->onDelete('restrict'); // BARU

            // Langkah 1: Lokasi & Rute
            $table->text('pickup_address');
            $table->decimal('pickup_latitude', 10, 8)->nullable();
            $table->decimal('pickup_longitude', 11, 8)->nullable();
            
            $table->text('destination_address');
            $table->decimal('destination_latitude', 10, 8)->nullable();
            $table->decimal('destination_longitude', 11, 8)->nullable();
            $table->text('location_notes')->nullable(); 

            // Langkah 2 & 3: Detail Tugas, Penerima, & Instruksi
            $table->string('title'); 
            $table->text('instruction_detail')->nullable(); // BARU (Menampung teks "wdwew")
            $table->string('receiver_name')->nullable();
            $table->string('receiver_phone');

            // Ringkasan Biaya Lengkap Sesuai UI Kanan
            $table->integer('base_fee')->default(0);          // Biaya Layanan Dasar (Rp 20.000)
            $table->integer('job_category_fee')->default(0);   // BARU: Kategori Kerja (Rp 25.000 / Rp 5.000)
            $table->decimal('distance_km', 5, 2)->default(0);  // BARU: Menyimpan angka jarak (14 km) untuk algoritma
            $table->integer('distance_fee')->default(0);      // BARU: Ongkir Jarak (+Rp 70.000)
            $table->integer('tips_fee')->default(0);          // BARU: Biaya Tambahan / Tips dari Langkah 3
            $table->integer('discount')->default(0);          // Potongan Harga
            $table->integer('total_estimated_fee');           // Total Akhir Kombinasi Semua Biaya

            // Bukti Kerja Akhir
            $table->string('proof_of_work')->nullable(); // BARU: Menyimpan path gambar hasil kerja mitra

            // Status Pelacakan Tugas
            $table->enum('status', ['PENDING', 'SEARCHING', 'ACCEPTED', 'PICKED_UP','PROOF_SUBMITTED', 'COMPLETED', 'CANCELLED'])->default('PENDING');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};