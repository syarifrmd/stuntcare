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

        // Ambil child_id dari query parameter
        $childId = $request->input('child_id');

        if (!$childId) {
            return redirect()->route('pemantauan.index')->with('error', 'Pilih anak terlebih dahulu.');
        }

        // Pastikan anak ini memang milik user yang login
        $child = Children::where('id', $childId)
            ->where('user_id', $userId)
            ->first();

        if (!$child) {
            return redirect()->route('pemantauan.index')->with('error', 'Data anak tidak ditemukan atau tidak milik Anda.');
        }

        // Ambil parameter 'date' dari request (jika ada), default ke hari ini
        $datebydate = $request->input('date', now()->toDateString());
        $selectedDay = $request->get('day', Carbon::parse($datebydate)->format('l'));

        // Hitung tanggal spesifik dari hari yang dipilih
        $date = $this->getDateByDay($selectedDay, $datebydate);

        // Ambil histori summary
        $histori = DailyNutritionSummaries::where('child_id', $child->id)
            ->whereDate('date', $date)
            ->orderBy('date', 'desc')
            ->get();

        // Ambil data intake makanan harian
        $intakes = DailyIntake::where('child_id', $child->id)
            ->whereDate('date', $date)
            ->with('food')
            ->get();

        // Ambil summary gizi harian (satu baris saja)
        $summary = DailyNutritionSummaries::where('child_id', $child->id)
            ->whereDate('date', $date)
            ->first();

        return view('pemantauan.histori', compact(
            'histori',
            'child',
            'date',
            'selectedDay',
            'intakes',
            'summary',
            'datebydate'
        ));
    }

    private function getDateByDay($day, $date = null)
    {
        $today = $date ? Carbon::parse($date) : Carbon::now();

        switch ($day) {
            case 'Monday':
                return $today->startOfWeek()->toDateString();
            case 'Tuesday':
                return $today->startOfWeek()->addDays(1)->toDateString();
            case 'Wednesday':
                return $today->startOfWeek()->addDays(2)->toDateString();
            case 'Thursday':
                return $today->startOfWeek()->addDays(3)->toDateString();
            case 'Friday':
                return $today->startOfWeek()->addDays(4)->toDateString();
            case 'Saturday':
                return $today->startOfWeek()->addDays(5)->toDateString();
            case 'Sunday':
                return $today->startOfWeek()->addDays(6)->toDateString();
            default:
                return $today->toDateString();
        }
    }
}
