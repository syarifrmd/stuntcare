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
        Schema::create('foods', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // nama makanan
            $table->enum('category', ['Makanan Pokok', 'Sayuran', 'Lauk Pauk', 'Buah']); // kategori
            $table->float('energy')->default(0);       // kalori (kkal)
            $table->float('protein')->default(0);      // protein (gram)
            $table->float('fat')->default(0);          // lemak (gram)
            $table->float('carbohydrate')->default(0); // karbohidrat (gram)
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade'); // admin/user yang menambahkan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foods');
    }
};
