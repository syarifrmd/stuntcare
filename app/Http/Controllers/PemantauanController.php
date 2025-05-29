<?php

namespace App\Http\Controllers;

use App\Models\Children;
use App\Models\DailyIntake;
use App\Models\DailyNutritionSummaries;
use App\Models\Food;
use App\Models\NutritionNeedsByAge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PemantauanController extends Controller
{
    // Menampilkan halaman utama pemantauan gizi
public function index(Request $request)
{
    $userId = Auth::id();
    $childId = $request->query('child_id');

    if (!$childId) {
        return redirect()->back()->with('error', 'Tidak ada anak yang dipilih.');
    }

    $child = Children::where('user_id', $userId)->where('id', $childId)->firstOrFail();

    $date = now()->toDateString();

    $intakes = DailyIntake::where('child_id', $child->id)
        ->whereDate('date', $date)
        ->with('food')
        ->get();

    $summary = DailyNutritionSummaries::where('child_id', $child->id)
        ->whereDate('date', $date)
        ->first();

    // Ambil daftar makanan yang ada
    $foods = Food::all();
    // Ambil 4 makanan terbaru
    $foods = Food::orderBy('created_at', 'desc')->take(4)->get();

    $birthDate = Carbon::parse($child->birth_date);
    $ageInMonths = round($birthDate->diffInMonths(Carbon::now()));

    $nutritionNeeds = NutritionNeedsByAge::where('age_range', $this->getAgeRange($ageInMonths))->first();

    return view('pemantauan.index', compact('child','foods' ,'intakes', 'summary', 'nutritionNeeds', 'ageInMonths'));
}

    // Get the age range based on the child's age in months
    private function getAgeRange($ageInMonths)
    {
        if ($ageInMonths <= 6) {
            return '0-6 bulan';
        } elseif ($ageInMonths <= 11) {
            return '7-11 bulan';
        } elseif ($ageInMonths <= 36) {
            return '1-3 tahun';
        } elseif ($ageInMonths <= 72) {
            return '4-6 tahun';
        } elseif ($ageInMonths <= 108) {
            return '7-9 tahun';
        }
        // You can expand age ranges if necessary
        return '10 tahun ke atas'; 
    }

    // Menghitung gizi harian dan menyimpannya
    public function hitungGiziHarian($childId, $date = null)
    {
        $date = $date ?? now()->toDateString(); // Jika tidak ada tanggal yang diberikan, gunakan tanggal hari ini

        // Ambil data anak
        $child = Children::findOrFail($childId);
        $birthDate = Carbon::parse($child->birth_date); // Ambil tanggal lahir anak
        $umur = $birthDate->diffInYears(now()); // Hitung umur anak

        // Ambil data kebutuhan gizi per umur
        $kebutuhan = NutritionNeedsByAge::all()->first(function ($item) use ($umur) {
            [$min, $max] = array_map('trim', explode('-', str_replace(['tahun', ' '], '', $item->age_range)));
            return $umur >= (int)$min && $umur <= (int)$max;
        });

        if (!$kebutuhan) {
            return response()->json(['message' => 'Kebutuhan gizi tidak ditemukan untuk umur tersebut'], 404);
        }

        // Ambil data intake makanan harian
        $intakes = DailyIntake::where('child_id', $childId)
            ->whereDate('date', $date)
            ->with('food')
            ->get();

        // Hitung total asupan gizi
        $total = [
            'energy' => 0,
            'protein' => 0,
            'fat' => 0,
            'carbohydrate' => 0,
        ];

        foreach ($intakes as $intake) {
            $porsi = $intake->portion;
            $food = $intake->food;

            $total['energy'] += $food->energy * $porsi;
            $total['protein'] += $food->protein * $porsi;
            $total['fat'] += $food->fat * $porsi;
            $total['carbohydrate'] += $food->carbohydrate * $porsi;
        }

        // Hitung persentase capaian gizi
        $persen = [
            'energy' => round(($total['energy'] / $kebutuhan->energy) * 100, 2),
            'protein' => round(($total['protein'] / $kebutuhan->protein) * 100, 2),
            'fat' => round(($total['fat'] / $kebutuhan->fat) * 100, 2),
            'carbohydrate' => round(($total['carbohydrate'] / $kebutuhan->carbohydrate) * 100, 2),
        ];

        // Simpan atau update data ke DailyNutritionSummaries
        DailyNutritionSummaries::updateOrCreate(
            [
                'child_id' => $childId,
                'date' => $date,
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

        return redirect()->route('pemantauan.index')->with('success', 'Data gizi harian berhasil dihitung dan disimpan.');
    }
}
