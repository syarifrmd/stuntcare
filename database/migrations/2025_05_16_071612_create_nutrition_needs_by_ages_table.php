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
        Schema::create('nutrition_needs_by_ages', function (Blueprint $table) {
            $table->id();
            $table->string('age_range'); // e.g. '1-3 tahun'
            $table->float('energy');
            $table->float('protein');
            $table->float('fat');
            $table->float('carbohydrate');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nutrition_needs_by_ages');
    }
};
