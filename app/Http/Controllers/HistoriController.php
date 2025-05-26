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
            $child = Children::where('user_id', $userId)->first(); // Ambil data anak berdasarkan user

            // Jika tidak ada data anak, arahkan user ke halaman untuk menambah anak
            if (!$child) {
                return redirect()->route('children.create')->with('error', 'Anda belum menambahkan data anak.');
            }

            // Ambil parameter 'date' dari request (jika ada), default ke hari ini
            $datebydate = $request->input('date', now()->toDateString());
            $selectedDay = $request->get('day', Carbon::parse($datebydate)->format('l')); // Dapatkan hari dari 'date'

            // Dapatkan tanggal berdasarkan hari yang dipilih
            $date = $this->getDateByDay($selectedDay, $datebydate);

            // Ambil histori pemantauan gizi berdasarkan tanggal yang dipilih
            $histori = DailyNutritionSummaries::where('child_id', $child->id)
                ->whereDate('date', $date)
                ->orderBy('date', 'desc')
                ->get();

            // Ambil data intake makanan harian untuk ditampilkan di bagian Statistik Harian
            $intakes = DailyIntake::where('child_id', $child->id)
                ->whereDate('date', $date)
                ->with('food')
                ->get();

            // Ambil summary gizi harian jika ada
            $summary = DailyNutritionSummaries::where('child_id', $child->id)
                ->whereDate('date', $date)
                ->first();

            return view('pemantauan.histori', compact('histori', 'child', 'date', 'selectedDay', 'intakes', 'summary', 'datebydate'));
        }

        private function getDateByDay($day, $date = null)
        {
            // Ambil tanggal berdasarkan hari yang dipilih (misal Senin, Selasa, dll)
            $today = $date ? Carbon::parse($date) : Carbon::now();

            switch ($day) {
                case 'Monday':
                    return $today->startOfWeek()->toDateString(); // Hari Senin minggu ini
                case 'Tuesday':
                    return $today->startOfWeek()->addDays(1)->toDateString(); // Hari Selasa
                case 'Wednesday':
                    return $today->startOfWeek()->addDays(2)->toDateString(); // Hari Rabu
                case 'Thursday':
                    return $today->startOfWeek()->addDays(3)->toDateString(); // Hari Kamis
                case 'Friday':
                    return $today->startOfWeek()->addDays(4)->toDateString(); // Hari Jumat
                case 'Saturday':
                    return $today->startOfWeek()->addDays(5)->toDateString(); // Hari Sabtu
                case 'Sunday':
                    return $today->startOfWeek()->addDays(6)->toDateString(); // Hari Minggu
                default:
                    return $today->toDateString(); // Jika hari tidak valid, default ke hari ini
            }
        }

}
