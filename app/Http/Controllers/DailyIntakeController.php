<?php

namespace App\Http\Controllers;

use App\Models\DailyIntake;
use App\Models\DailyNutritionSummaries;
use App\Models\Children;
use App\Models\NutritionNeedsByAge;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DailyIntakeController extends Controller
{
    // Menyimpan data intake makanan dan menghitung statistik harian
    public function storeFromFood(Request $request)
    {
        // Validasi input
        $request->validate([
            'food_id' => 'required|exists:foods,id',
            'child_id' => 'nullable|exists:children,id',
            'time_of_day' => 'required|in:Pagi,Siang,Malam,Cemilan',
        ]);

    DailyIntake::create([
        'id'     => Auth::id(),
        'food_id'     => $request->food_id,
        'child_id'    => $request->child_id ?? null,
        'time_of_day' => $request->time_of_day,
        'portion'     => 1,
        'date'        => now()->toDateString(),
    ]);

    return redirect()->back()->with('success', 'Makanan berhasil ditambahkan ke konsumsi harian.');
}
    public function store(Request $request)
{
    foreach ($request->intakes as $intake) {
        DailyIntake::create([
            'child_id' => $intake['child_id'],
            'food_id' => $intake['food_id'],
            'portion' => $intake['portion'],
            'time_of_day' => $request->time_of_day,
        ]);
    }

    return redirect()->back()->with('success', 'Data makanan berhasil disimpan untuk semua anak.');
}


    // Fungsi untuk menghitung dan memperbarui statistik gizi harian
    public function updateDailyNutritionSummary($childId)
    {
        // Ambil data anak
        $child = Children::findOrFail($childId);
        $birthDate = Carbon::parse($child->birth_date);
        $umur = $birthDate->diffInYears(now());

        // Ambil kebutuhan gizi berdasarkan umur
        $kebutuhan = NutritionNeedsByAge::whereRaw('? BETWEEN SUBSTRING_INDEX(age_range, "-", 1) + 0 AND SUBSTRING_INDEX(age_range, "-", -1) + 0', [$umur])->first();

        if (!$kebutuhan) {
            return response()->json(['message' => 'Kebutuhan gizi tidak ditemukan untuk umur tersebut'], 404);
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
