<?php

namespace App\Http\Controllers;

use App\Models\Children;
use App\Models\DailyIntake;
use App\Models\DailyNutritionSummaries;
use App\Models\Food;
use App\Models\NutritionNeedsByAge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class PemantauanController extends Controller
{
    // Menampilkan halaman utama pemantauan gizi
    public function index()
    {
        $userId = Auth::id();
        
        // Cek apakah user memiliki data anak
        $child = Children::where('user_id', $userId)->first();
        
        // Jika tidak ada data anak, arahkan user ke halaman untuk menambah anak
        if (!$child) {
            return redirect()->route('children.create')->with('error', 'Anda belum menambahkan data anak. Silakan tambahkan data anak terlebih dahulu.');
        }

        $date = now()->toDateString(); // Ambil tanggal hari ini

        // Ambil data intake makanan harian
        $intakes = DailyIntake::where('child_id', $child->id)
            ->whereDate('date', $date)
            ->with('food') // Mengambil informasi makanan
            ->get();

        // Ambil summary gizi harian jika ada
        $summary = DailyNutritionSummaries::where('child_id', $child->id)
            ->whereDate('date', $date)
            ->first();

        // Ambil daftar makanan yang ada
        $foods = Food::all();
         // Ambil 4 makanan terbaru
        $foods = Food::orderBy('created_at', 'desc')->take(4)->get();

        return view('pemantauan.index', compact('child', 'intakes', 'summary', 'foods'));
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
