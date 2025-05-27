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
        Schema::create('konsultasi_dokters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dokter_id'); // ID dokter yang membuat jadwal
            $table->unsignedBigInteger('user_id')->nullable(); // ID user yang memesan jadwal
            $table->string('nama_dokter'); // Nama dokter
            $table->string('no_wa_dokter'); // No WA dokter
            $table->string('fotodokter')->nullable(); // Foto dokter (optional)
            $table->timestamp('waktu_konsultasi'); // Waktu konsultasi
            $table->enum('status', ['Tersedia', 'Memesan', 'Dipesan', 'Selesai', 'Dibatalkan'])->default('Tersedia'); // Status jadwal
            $table->text('catatan_user')->nullable(); // Catatan dari user
            $table->text('catatan_dokter')->nullable(); // Catatan dari dokter
            $table->timestamps();
            
            // Menambahkan foreign key untuk dokter_id dan user_id
            $table->foreign('dokter_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konsultasi_dokters');
    }
};
