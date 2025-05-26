<?php

namespace App\Http\Controllers;

use App\Models\KonsultasiDokter;
use App\Models\Artikel;
use Illuminate\Http\Request;

class DokterController extends Controller
{
    // Fungsi untuk menampilkan Dashboard Dokter
    public function dashboard()
    {
        // Ambil artikel terbaru untuk ditampilkan di dashboard
        $artikels = Artikel::latest()->take(3)->get(); // Menampilkan 3 artikel terbaru
        return view('dokter.dashboard', compact('artikels'));  // Tampilkan halaman dashboard dokter
    }

    // --- CRUD untuk Konsultasi Dokter ---

    // Menampilkan semua data Konsultasi Dokter
    public function indexKonsultasi()
    {
        $konsultasi = KonsultasiDokter::all();  // Mengambil semua data konsultasi dokter
        return view('dokter.konsultasi.index', compact('konsultasi'));
    }

    // Menampilkan data Konsultasi Dokter berdasarkan ID
    public function showKonsultasi($id)
    {
        $konsultasi = KonsultasiDokter::find($id);
        return view('dokter.konsultasi.show', compact('konsultasi'));
    }

    // Menyimpan data Konsultasi Dokter baru
    public function storeKonsultasi(Request $request)
    {
        $request->validate([
            'dokter_id' => 'required|exists:users,id',
            'nama_dokter' => 'required|string',
            'no_wa_dokter' => 'required|string',
            'waktu_konsultasi' => 'required|date',
            'status' => 'required|string',
        ]);

        KonsultasiDokter::create($request->all());

        return redirect()->route('dokter.konsultasi.index')->with('success', 'Konsultasi berhasil ditambahkan');
    }

    // Memperbarui data Konsultasi Dokter
    public function updateKonsultasi(Request $request, $id)
    {
        $konsultasi = KonsultasiDokter::find($id);
        if (!$konsultasi) {
            return redirect()->route('dokter.konsultasi.index')->with('error', 'Konsultasi tidak ditemukan');
        }

        $konsultasi->update($request->all());
        return redirect()->route('dokter.konsultasi.index')->with('success', 'Konsultasi berhasil diperbarui');
    }

    // Menghapus data Konsultasi Dokter
    public function destroyKonsultasi($id)
    {
        $konsultasi = KonsultasiDokter::find($id);
        if (!$konsultasi) {
            return redirect()->route('dokter.konsultasi.index')->with('error', 'Konsultasi tidak ditemukan');
        }

        $konsultasi->delete();
        return redirect()->route('dokter.konsultasi.index')->with('success', 'Konsultasi berhasil dihapus');
    }

    // --- CRUD untuk Artikel ---

    // Menampilkan semua data Artikel
    public function indexArtikel()
    {
        $artikels = Artikel::all();  // Mengambil semua data artikel
        return view('dokter.artikel.index', compact('artikels'));
    }

    // Menampilkan data Artikel berdasarkan ID
    public function showArtikel($id)
    {
        $artikel = Artikel::find($id);
        if ($artikel) {
            return view('dokter.artikel.show', compact('artikel'));
        }
        return redirect()->route('dokter.artikel.index')->with('error', 'Artikel tidak ditemukan');
    }

    // Menyimpan data Artikel baru
    public function storeArtikel(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'dokter_id' => 'required|exists:users,id',
            'content' => 'required|string',
            'author_id' => 'required|exists:users,id',
        ]);

        Artikel::create($request->all());

        return redirect()->route('dokter.artikel.index')->with('success', 'Artikel berhasil ditambahkan');
    }

    // Memperbarui data Artikel
    public function updateArtikel(Request $request, $id)
    {
        $artikel = Artikel::find($id);
        if (!$artikel) {
            return redirect()->route('dokter.artikel.index')->with('error', 'Artikel tidak ditemukan');
        }

        $artikel->update($request->all());
        return redirect()->route('dokter.artikel.index')->with('success', 'Artikel berhasil diperbarui');
    }

    // Menghapus data Artikel
    public function destroyArtikel($id)
    {
        $artikel = Artikel::find($id);
        if (!$artikel) {
            return redirect()->route('dokter.artikel.index')->with('error', 'Artikel tidak ditemukan');
        }

        $artikel->delete();
        return redirect()->route('dokter.artikel.index')->with('success', 'Artikel berhasil dihapus');
    }
}
