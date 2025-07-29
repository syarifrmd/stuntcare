<?php

namespace App\Http\Controllers;

use App\Models\Children;
use App\Models\DailyNutritionSummaries;
use App\Models\DailyIntake;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HistoriController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();
        $childId = $request->input('child_id');

        // Validasi child_id
        if (!$childId) {
            return redirect()->route('pemantauan.index')->with('error', 'Pilih anak terlebih dahulu.');
        }

        $child = Children::where('id', $childId)
            ->where('user_id', $userId)
            ->first();

        if (!$child) {
            return redirect()->route('pemantauan.index')->with('error', 'Data anak tidak ditemukan atau tidak milik Anda.');
        }

        // Ambil parameter filter
        $selectedDate = $request->input('date');
        $selectedDay = $request->input('day');

        if ($selectedDay) {
            // Jika day dipilih, gunakan date yang sudah ada atau today sebagai anchor
            $anchorDate = $selectedDate ?: now()->toDateString();
            $date = $this->getDateByDay($selectedDay, $anchorDate);
        } elseif ($selectedDate) {
            $date = Carbon::parse($selectedDate)->toDateString();
        } else {
            $date = now()->toDateString();
        }
        // Query histori dan intake berdasarkan tanggal final
        $histori = DailyNutritionSummaries::where('child_id', $child->id)
            ->whereDate('date', $date)
            ->orderBy('date', 'desc')
            ->get();

        $intakes = DailyIntake::where('child_id', $child->id)
            ->whereDate('date', $date)
            ->with('food')
            ->get();

        $summary = DailyNutritionSummaries::where('child_id', $child->id)
            ->whereDate('date', $date)
            ->first();

        return view('pemantauan.histori', [
            'histori'      => $histori,
            'child'        => $child,
            'date'         => $date,
            'selectedDay'  => $selectedDay,
            'intakes'      => $intakes,
            'summary'      => $summary
        ]);
    }

    /**
     * Ambil tanggal spesifik sesuai nama hari di minggu berjalan
     */
    private function getDateByDay($day, $baseDate = null)
    {
        $anchor = $baseDate ? Carbon::parse($baseDate) : Carbon::now();
    
        // Pastikan selalu hitung dari minggu yang mengandung anchor
        $startOfWeek = $anchor->copy()->startOfWeek(Carbon::MONDAY);
    
        $daysMap = [
            'Monday'    => 0,
            'Tuesday'   => 1,
            'Wednesday' => 2,
            'Thursday'  => 3,
            'Friday'    => 4,
            'Saturday'  => 5,
            'Sunday'    => 6,
        ];
    
        return isset($daysMap[$day])
            ? $startOfWeek->addDays($daysMap[$day])->toDateString()
            : $anchor->toDateString();
    }
    
}
