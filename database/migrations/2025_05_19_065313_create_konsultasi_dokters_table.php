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

            $table->string('nama_pasien');
            $table->string('nama_dokter');
            $table->string('no_wa_dokter');
            $table->text('whatsapp_log')->nullable();
            $table->dateTime('waktu_konsultasi')->nullable();
            $table->enum('status', ['terbuka', 'selesai', 'ditutup'])->default('terbuka');
            $table->text('catatan_user')->nullable();
            $table->text('catatan_dokter')->nullable();

            $table->timestamps();
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