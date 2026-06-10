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
        Schema::table('users', function (Blueprint $table) {
            // Menggunakan method table() bukan create(), jadi data aman tidak terhapus.
            // Atribut ->after('password') digunakan agar posisinya rapi berada tepat di bawah password.
            $table->date('tanggal_lahir')->nullable()->after('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Logika rollback jika ingin menghapus kembali kolom ini
            $table->dropColumn('tanggal_lahir');
        });
    }
};