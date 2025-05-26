<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DailyNutritionSummaries;

class DailyNutritionSummariesSeeder extends Seeder
{
    public function run()
    {
        DailyNutritionSummaries::create([
            'child_id' => 1, // ID Anak
            'date' => now()->toDateString(),
            'energy_total' => 150,
            'protein_total' => 4.0,
            'fat_total' => 2.0,
            'carb_total' => 40.0,
            'energy_percent' => 75, // Persentase sesuai dengan kebutuhan
            'protein_percent' => 50,
            'fat_percent' => 80,
            'carb_percent' => 90,
            'energy_status' => 'Terpenuhi',
            'protein_status' => 'Belum Terpenuhi',
            'fat_status' => 'Terpenuhi',
            'carb_status' => 'Terpenuhi',
        ]);
    }
}
