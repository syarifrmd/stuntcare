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
        Schema::create('daily_nutrition_summaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('child_id')->constrained('children')->onDelete('cascade');
            $table->date('date');

            // Total asupan gizi hari itu
            $table->float('energy_total')->default(0);
            $table->float('protein_total')->default(0);
            $table->float('fat_total')->default(0);
            $table->float('carb_total')->default(0);

            // Persentase capaian gizi harian
            $table->float('energy_percent')->default(0);
            $table->float('protein_percent')->default(0);
            $table->float('fat_percent')->default(0);
            $table->float('carb_percent')->default(0);

            // Status terpenuhi atau belum (berdasarkan % vs kebutuhan)
            $table->enum('energy_status', ['Terpenuhi', 'Belum Terpenuhi'])->default('Belum Terpenuhi');
            $table->enum('protein_status', ['Terpenuhi', 'Belum Terpenuhi'])->default('Belum Terpenuhi');
            $table->enum('fat_status', ['Terpenuhi', 'Belum Terpenuhi'])->default('Belum Terpenuhi');
            $table->enum('carb_status', ['Terpenuhi', 'Belum Terpenuhi'])->default('Belum Terpenuhi');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_nutrition_summaries');
    }
};
