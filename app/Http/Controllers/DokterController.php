<?php

namespace App\Http\Controllers;

use App\Models\JadwalKonsultasi;
use App\Models\Artikel;
use App\Models\KonsultasiDokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DokterController extends Controller
{
    public function index()
    {
        return view('dokter.dashboard');
    }

    // Show all consultation schedules
    public function indexJadwal()
    {
        $dokter = Auth::user();
        $jadwals = JadwalKonsultasi::where('dokter_id', $dokter->id)->get();
        return view('dokter.jadwal.index', compact('jadwals'));
    }

    // Show the form for creating a new consultation schedule
    public function createJadwal()
    {
        return view('dokter.jadwal.create');
    }

    // Store a newly created consultation schedule
    public function storeJadwal(Request $request)
    {
        $validated = $request->validate([
            'waktu_konsultasi' => 'required|date',
            'status' => 'required|string',
        ]);

        $dokter = Auth::user();

        JadwalKonsultasi::create([
            'dokter_id' => $dokter->id,
            'waktu_konsultasi' => $validated['waktu_konsultasi'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('dokter.jadwal.index')->with('success', 'Jadwal konsultasi berhasil ditambahkan');
    }

    // Show the form for editing the specified consultation schedule
    public function editJadwal(JadwalKonsultasi $jadwal)
    {
        $this->authorize('update', $jadwal); // Make sure the doctor is allowed to edit this schedule
        return view('dokter.jadwal.edit', compact('jadwal'));
    }

    // Update the specified consultation schedule
    public function updateJadwal(Request $request, JadwalKonsultasi $jadwal)
    {
        $this->authorize('update', $jadwal); // Make sure the doctor is allowed to edit this schedule

        $validated = $request->validate([
            'waktu_konsultasi' => 'required|date',
            'status' => 'required|string',
        ]);

        $jadwal->update($validated);

        return redirect()->route('dokter.jadwal.index')->with('success', 'Jadwal konsultasi berhasil diperbarui');
    }

    // Remove the specified consultation schedule
    public function destroyJadwal(JadwalKonsultasi $jadwal)
    {
        $this->authorize('delete', $jadwal); // Make sure the doctor is allowed to delete this schedule

        $jadwal->delete();

        return redirect()->route('dokter.jadwal.index')->with('success', 'Jadwal konsultasi berhasil dihapus');
    }

    // Show all articles
    public function indexArtikel()
    {
        $dokter = Auth::user();
        $artikels = Artikel::where('dokter_id', $dokter->id)->get();
        return view('dokter.artikel.index', compact('artikels'));
    }

    // Show the form for creating a new article
    public function createArtikel()
    {
        return view('dokter.artikel.create');
    }

    // Store a newly created article
    public function storeArtikel(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
        ]);

        $dokter = Auth::user();

        Artikel::create([
            'dokter_id' => $dokter->id,
            'judul' => $validated['judul'],
            'konten' => $validated['konten'],
        ]);

        return redirect()->route('dokter.artikel.index')->with('success', 'Artikel berhasil ditambahkan');
    }

    // Show the form for editing the specified article
    public function editArtikel(Artikel $artikel)
    {
        $this->authorize('update', $artikel); // Make sure the doctor is allowed to edit this article
        return view('dokter.artikel.edit', compact('artikel'));
    }

    // Update the specified article
    public function updateArtikel(Request $request, Artikel $artikel)
    {
        $this->authorize('update', $artikel); // Make sure the doctor is allowed to edit this article

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
        ]);

        $artikel->update($validated);

        return redirect()->route('dokter.artikel.index')->with('success', 'Artikel berhasil diperbarui');
    }

    // Remove the specified article
    public function destroyArtikel(Artikel $artikel)
    {
        $this->authorize('delete', $artikel); // Make sure the doctor is allowed to delete this article

        $artikel->delete();

        return redirect()->route('dokter.artikel.index')->with('success', 'Artikel berhasil dihapus');
    }

    // Confirm consultation (accept or reject)
    public function konfirmasiKonsultasi(KonsultasiDokter $konsultasi)
    {
        $this->authorize('update', $konsultasi); // Make sure the doctor is allowed to confirm the consultation

        // Toggle the status of the consultation
        $konsultasi->status = $konsultasi->status === 'terima' ? 'tolak' : 'terima';
        $konsultasi->save();

        return redirect()->route('dokter.konsultasi.konfirmasi', $konsultasi->id)->with('success', 'Konsultasi berhasil diperbarui');
    }
}
