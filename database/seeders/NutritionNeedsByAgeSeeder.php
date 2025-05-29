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
            'age_range' => '0-6 bulan',
            'energy' => 550, // total energi dalam kkal
            'protein' => 12, // total protein dalam gram
            'fat' => 34, // total lemak dalam gram
            'carbohydrate' => 58,
        ]);

        NutritionNeedsByAge::create([
            'age_range' => '7-11 bulan',
            'energy' => 725,
            'protein' => 18,
            'fat' => 36,
            'carbohydrate' => 82,
        ]);

        NutritionNeedsByAge::create([
            'age_range' => '1-3 tahun',
            'energy' => 1125,
            'protein' => 26,
            'fat' => 44,
            'carbohydrate' => 155,
        ]);

        NutritionNeedsByAge::create([
            'age_range' => '4-6 tahun',
            'energy' => 1600,
            'protein' => 35,
            'fat' => 62,
            'carbohydrate' => 220,
        ]);

        NutritionNeedsByAge::create([
            'age_range' => '7-9 tahun',
            'energy' => 1850,
            'protein' => 49,
            'fat' => 72,
            'carbohydrate' => 254,
        ]);

        // Kamu bisa menambahkan rentang usia lainnya sesuai kebutuhan
    }
}
