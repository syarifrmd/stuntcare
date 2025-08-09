<?php

namespace App\Http\Controllers;

use App\Models\KonsultasiDokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\ConsultationBooked;

class KonsultasiDokterController extends Controller
{
    // Semua user bisa melihat semua jadwal dari semua dokter
    public function index()
    {
        // Ambil jadwal dokter yang statusnya tersedia untuk semua user
        $jadwals = KonsultasiDokter::where('status', 'tersedia')->get();
    
        // Tambahkan kondisi untuk menampilkan jadwal yang sudah dipesan hanya untuk user yang sedang login
        $jadwalsByAuthUser = KonsultasiDokter::where('user_id', Auth::id())
            ->whereIn('status', ['Dipesan', 'Memesan', 'Selesai', 'Dibatalkan'])
            ->get();
    
        // Gabungkan keduanya
        $jadwals = $jadwals->merge($jadwalsByAuthUser);
        return view('konsultasidokter.index', compact('jadwals'));
    }


    // User memesan jadwal dokter
    public function book(Request $request, $id)
    {
        $jadwal = KonsultasiDokter::findOrFail($id);

        if ($jadwal->status === 'Tersedia') {
            $jadwal->update([
                'user_id' => Auth::id(),
                'status' => 'Memesan',
            ]);

            // Trigger event untuk notifikasi pemesanan
            event(new ConsultationBooked($jadwal));

            return redirect()->route('konsultasidokter.index')->with('success', 'Berhasil memesan jadwal.');
        }

        return redirect()->route('konsultasidokter.index')->with('error', 'Jadwal tidak tersedia.');
    }


    // Jadwal dikonfirmasi oleh dokter (jika kamu ingin endpoint ini tetap)
    public function confirmBooking($id)
    {
        $jadwal = KonsultasiDokter::findOrFail($id);

        if ($jadwal->status === 'Memesan') {
            $jadwal->update(['status' => 'Dipesan']);
            
            // Event sudah dipanggil di DokterController, tidak perlu duplikat di sini
            
            return redirect()->route('konsultasidokter.index')->with('success', 'Jadwal dikonfirmasi');
        }

        return redirect()->route('konsultasidokter.index')->with('error', 'Tidak dapat dikonfirmasi');
    }
}