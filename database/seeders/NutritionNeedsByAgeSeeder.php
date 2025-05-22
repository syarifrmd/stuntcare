<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NutritionNeedsByAge;

class NutritionNeedsByAgeSeeder extends Seeder
{
    public function run()
    {
        // Menambahkan data kebutuhan gizi berdasarkan rentang usia
        NutritionNeedsByAge::create([
            'age_range' => '0-1 tahun',
            'energy' => 1000, // total energi dalam kkal
            'protein' => 11, // total protein dalam gram
            'fat' => 30, // total lemak dalam gram
            'carbohydrate' => 130, // total karbohidrat dalam gram
        ]);

        NutritionNeedsByAge::create([
            'age_range' => '1-3 tahun',
            'energy' => 1300,
            'protein' => 13,
            'fat' => 35,
            'carbohydrate' => 175,
        ]);

        NutritionNeedsByAge::create([
            'age_range' => '4-6 tahun',
            'energy' => 1800,
            'protein' => 16,
            'fat' => 40,
            'carbohydrate' => 210,
        ]);

        NutritionNeedsByAge::create([
            'age_range' => '7-9 tahun',
            'energy' => 2000,
            'protein' => 20,
            'fat' => 50,
            'carbohydrate' => 250,
        ]);

        NutritionNeedsByAge::create([
            'age_range' => '10-12 tahun',
            'energy' => 2200,
            'protein' => 25,
            'fat' => 60,
            'carbohydrate' => 270,
        ]);

        // Kamu bisa menambahkan rentang usia lainnya sesuai kebutuhan
    }
}
