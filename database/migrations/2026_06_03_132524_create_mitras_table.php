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
    Schema::create('mitras', function (Blueprint $table) {
        $table->id();
        $table->string('first_name', 100);
        $table->string('last_name', 100);
        $table->string('email', 255)->unique();
        $table->string('phone', 20);
        $table->string('password');
        $table->string('avatar', 255)->nullable();
        $table->text('bio')->nullable();
        $table->string('domisili', 255)->nullable();
        $table->boolean('is_available')->default(true);
        $table->decimal('rating', 3, 2)->nullable();
        $table->decimal('latitude', 10, 8)->nullable();
        $table->decimal('longitude', 11, 8)->nullable();
        $table->timestamp('email_verified_at')->nullable();
        $table->rememberToken();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mitras');
    }
};
