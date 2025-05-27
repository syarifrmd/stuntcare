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
        Schema::create('artikels', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('foto_artikel')->nullable();
            $table->unsignedBigInteger('dokter_id');
            $table->text('content');
            $table->string('topic')->nullable();
            $table->unsignedBigInteger('author_id');
            $table->enum('status', ['Draft', 'published'])->default('draft');
            $table->timestamps();

            // Relasi ke tabel users
            $table->foreign('dokter_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artikels');
    }
};
