<?php

namespace App\Http\Controllers;

use App\Models\KonsultasiDokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KonsultasiDokterController extends Controller
{
    // Fungsi untuk menampilkan semua jadwal konsultasi
    public function index()
    {
        // Ambil semua jadwal yang sudah dibuat oleh dokter
        // Status "Tersedia", "Memesan", "Dipesan", dan "Selesai"
        $jadwals = KonsultasiDokter::all(); // Dapatkan semua jadwal

        return view('konsultasidokter.index', compact('jadwals'));
    }

    // Menampilkan form untuk membuat jadwal konsultasi
    public function create()
    {
        return view('konsultasidokter.create');
    }

    // Menyimpan jadwal konsultasi
    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'waktu_konsultasi' => 'required|date',
            'status' => 'required|in:Tersedia,Memesan,Dipesan,Selesai',
            'no_wa_dokter' => 'required|string',
        ]);

        // Membuat jadwal baru untuk dokter yang sedang login
        KonsultasiDokter::create([
            'dokter_id' => Auth::id(),  // Ambil ID dokter dari Auth
            'user_id' => null,  // Tidak ada yang memesan di awal
            'nama_dokter' => Auth::user()->name,  // Nama dokter dari Auth
            'no_wa_dokter' => $request->no_wa_dokter,  // No WA dokter
            'waktu_konsultasi' => $request->waktu_konsultasi,  // Waktu konsultasi
            'status' => $request->status,  // Status konsultasi
        ]);

        return redirect()->route('konsultasidokter.index')->with('success', 'Jadwal berhasil ditambahkan');
    }

    // Menampilkan form untuk mengedit jadwal
    public function edit($id)
    {
        $jadwal = KonsultasiDokter::findOrFail($id);  // Menemukan jadwal berdasarkan ID

        return view('konsultasidokter.edit', compact('jadwal'));
    }

    // Mengupdate jadwal konsultasi
    public function update(Request $request, $id)
    {
        $request->validate([
            'waktu_konsultasi' => 'required|date',
            'status' => 'required|in:Tersedia,Memesan,Dipesan,Selesai',
            'no_wa_dokter' => 'required|string',
        ]);

        // Temukan jadwal berdasarkan ID dan update
        $jadwal = KonsultasiDokter::findOrFail($id);
        $jadwal->update([
            'waktu_konsultasi' => $request->waktu_konsultasi,
            'status' => $request->status,
            'no_wa_dokter' => $request->no_wa_dokter,
        ]);

        return redirect()->route('konsultasidokter.index')->with('success', 'Jadwal berhasil diperbarui');
    }

    // Menghapus jadwal konsultasi
    public function destroy($id)
    {
        $jadwal = KonsultasiDokter::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('konsultasidokter.index')->with('success', 'Jadwal berhasil dihapus');
    }

    // Memesan jadwal oleh user
    public function book(Request $request, $id)
    {
        // Menemukan jadwal yang ingin dipesan
        $jadwal = KonsultasiDokter::findOrFail($id);

        // Pastikan jadwal tersebut masih tersedia untuk pemesanan
        if ($jadwal->status == 'Tersedia') {
            $jadwal->update([
                'user_id' => Auth::id(),  // ID user yang memesan
                'status' => 'Memesan',  // Jadwal berubah menjadi "Memesan"
            ]);

            return redirect()->route('konsultasidokter.index')->with('success', 'Jadwal berhasil dipesan, menunggu konfirmasi dokter.');
        }

        return redirect()->route('konsultasidokter.index')->with('error', 'Jadwal tidak tersedia untuk pemesanan.');
    }

    // Mengkonfirmasi pemesanan jadwal
    public function confirmBooking($id)
    {
        // Temukan jadwal yang akan dikonfirmasi
        $jadwal = KonsultasiDokter::findOrFail($id);

        // Pastikan jadwal dalam status "Memesan"
        if ($jadwal->status == 'Memesan') {
            $jadwal->update([
                'status' => 'Dipesan',  // Ubah status menjadi "Dipesan"
            ]);

            return redirect()->route('konsultasidokter.index')->with('success', 'Jadwal berhasil dikonfirmasi.');
        }

        return redirect()->route('konsultasidokter.index')->with('error', 'Jadwal tidak dapat dikonfirmasi.');
    }
}
