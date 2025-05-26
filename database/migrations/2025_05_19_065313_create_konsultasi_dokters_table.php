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
            $table->unsignedBigInteger('dokter_id'); // This is the column we need
            $table->string('nama_dokter');
            $table->string('no_wa_dokter');
            $table->string('fotodokter');
            $table->timestamp('waktu_konsultasi');
            $table->string('status');
            $table->text('catatan_user')->nullable();
            $table->text('catatan_dokter')->nullable();
            $table->timestamps();
            
            $table->foreign('dokter_id')->references('id')->on('users'); // Assuming "users" table for doctors
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