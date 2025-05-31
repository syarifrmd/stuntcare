<?php

namespace App\Http\Controllers;

use App\Models\DailyIntake;
use App\Models\DailyNutritionSummaries;
use App\Models\Children;
use App\Models\Food;
use App\Models\NutritionNeedsByAge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DailyIntakeController extends Controller
{
    public function storeFromFood(Request $request)
    {
        // Validasi input
        $request->validate([
            'food_id' => 'required|exists:foods,id',
            'child_id' => 'required|exists:children,id',
            'time_of_day' => 'required|in:Pagi,Siang,Malam,Cemilan',
        ]);

        // Simpan intake makanan
        $intake = DailyIntake::create([
            'food_id' => $request->food_id,
            'child_id' => $request->child_id,
            'time_of_day' => $request->time_of_day,
            'portion' => 1,  // Default portion
            'date' => now()->toDateString(),
        ]);

        // Hitung gizi harian setelah data intake disimpan
        $this->updateDailyNutritionSummary($intake->child_id);

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Makanan berhasil ditambahkan ke konsumsi harian.');
    }

    public function updateDailyNutritionSummary($childId)
    {
        // Ambil data anak
        $child = Children::findOrFail($childId);
        $birthDate = Carbon::parse($child->birth_date);
        $umur = $birthDate->diffInYears(now());

        // Ambil kebutuhan gizi berdasarkan umur
        $kebutuhan = NutritionNeedsByAge::whereRaw('? BETWEEN SUBSTRING_INDEX(age_range, "-", 1) + 0 AND SUBSTRING_INDEX(age_range, "-", -1) + 0', [$umur])->first();

        if (!$kebutuhan) {
            // Jika tidak ditemukan kebutuhan gizi untuk umur tersebut
            return response()->json(['success' => false, 'message' => 'Kebutuhan gizi tidak ditemukan untuk umur tersebut'], 404);
        }

        // Ambil semua intake untuk anak dan hari ini
        $intakes = DailyIntake::where('child_id', $childId)
            ->whereDate('date', now()->toDateString())
            ->with('food')
            ->get();

        // Hitung total gizi harian
        $total = [
            'energy' => 0,
            'protein' => 0,
            'fat' => 0,
            'carbohydrate' => 0,
        ];

        foreach ($intakes as $intake) {
            $food = $intake->food;
            $total['energy'] += $food->energy * $intake->portion;
            $total['protein'] += $food->protein * $intake->portion;
            $total['fat'] += $food->fat * $intake->portion;
            $total['carbohydrate'] += $food->carbohydrate * $intake->portion;
        }

        // Hitung persentase capaian berdasarkan kebutuhan
        $persen = [
            'energy' => round(($total['energy'] / $kebutuhan->energy) * 100, 2),
            'protein' => round(($total['protein'] / $kebutuhan->protein) * 100, 2),
            'fat' => round(($total['fat'] / $kebutuhan->fat) * 100, 2),
            'carbohydrate' => round(($total['carbohydrate'] / $kebutuhan->carbohydrate) * 100, 2),
        ];

        // Simpan atau update summary harian
        DailyNutritionSummaries::updateOrCreate(
            [
                'child_id' => $childId,
                'date' => now()->toDateString(),
            ],
            [
                'energy_total' => $total['energy'],
                'protein_total' => $total['protein'],
                'fat_total' => $total['fat'],
                'carb_total' => $total['carbohydrate'],
                'energy_percent' => $persen['energy'],
                'protein_percent' => $persen['protein'],
                'fat_percent' => $persen['fat'],
                'carb_percent' => $persen['carbohydrate'],
                'energy_status' => $persen['energy'] >= 100 ? 'Terpenuhi' : 'Belum Terpenuhi',
                'protein_status' => $persen['protein'] >= 100 ? 'Terpenuhi' : 'Belum Terpenuhi',
                'fat_status' => $persen['fat'] >= 100 ? 'Terpenuhi' : 'Belum Terpenuhi',
                'carb_status' => $persen['carbohydrate'] >= 100 ? 'Terpenuhi' : 'Belum Terpenuhi',
            ]
        );
    }
}
