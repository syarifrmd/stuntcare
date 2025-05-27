<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArtikelController extends Controller
{
    //Artikel User
    public function index(Request $request)
    {
        $artikels = Artikel::with('author')->latest()->paginate(10);

        // Artikel yang dipilih untuk ditampilkan lengkap
        $selectedArtikel = null;
        if ($request->has('selected_id')) {
            $selectedArtikel = Artikel::find($request->input('selected_id'));
        }

        return view('artikel.index', compact('artikels', 'selectedArtikel'));
    }

    /**
     * Menampilkan daftar artikel milik dokter yang login.
     */
    public function indexDokter(Request $request)
    {
        $dokterId = Auth::id();
        $searchTerm = $request->input('search');

        $artikelsQuery = Artikel::where('dokter_id', $dokterId);

        if ($searchTerm) {
            $artikelsQuery->where(function ($query) use ($searchTerm) {
                $query->where('title', 'like', "%$searchTerm%")
                      ->orWhere('topic', 'like', "%$searchTerm%");
            });
        }

        $artikels = $artikelsQuery->latest()->paginate(10);

        return view('dokter.artikel.index', compact('artikels', 'searchTerm'));
    }

    /**
     * Menampilkan form untuk membuat artikel baru.
     */
    public function createDokter()
    {
        return view('dokter.artikel.create');
    }

    /**
     * Menyimpan artikel baru yang dibuat oleh dokter.
     */
    public function storeDokter(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'topic' => 'required|string|max:255',
            'content' => 'required|string',
            'foto_artikel' => 'nullable|image|max:2048', // jika ada upload foto
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto_artikel')) {
            $fotoPath = $request->file('foto_artikel')->store('artikel_images', 'public');
        }

        Artikel::create([
            'title' => $request->title,
            'topic' => $request->topic,
            'content' => $request->content,
            'foto_artikel' => $fotoPath,
            'author_id' => Auth::id(),
            'dokter_id' => Auth::id(),
            'status' => $request->status, // default draft
        ]);

        return redirect()->route('dokter.artikel.index')->with('success', 'Artikel berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit artikel.
     */
    public function editDokter(Artikel $artikel)
    {
        $this->authorizeDokter($artikel);
        return view('dokter.artikel.edit', compact('artikel'));
    }

    /**
     * Memperbarui artikel.
     */
    public function updateDokter(Request $request, Artikel $artikel)
    {
        $this->authorizeDokter($artikel);
        $request->validate([
            'title' => 'required|string|max:255',
            'topic' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
            'foto_artikel' => 'nullable|image|max:2048',
        ]);

        $fotoPath = $artikel->foto_artikel;
        if ($request->hasFile('foto_artikel')) {
            $fotoPath = $request->file('foto_artikel')->store('artikel_images', 'public');
        }

        $artikel->update([
            'title' => $request->title,
            'topic' => $request->topic,
            'content' => $request->content,
            'status' => $request->status,
            'foto_artikel' => $fotoPath,
        ]);

        return redirect()->route('dokter.artikel.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    /**
     * Menghapus artikel.
     */
    public function destroyDokter(Artikel $artikel)
    {
        $artikel->delete();

        return redirect()->route('dokter.artikel.index')->with('success', 'Artikel berhasil dihapus.');
    }

    /**
     * Helper: pastikan hanya dokter pemilik yang bisa mengakses.
     */
    private function authorizeDokter(Artikel $artikel)
    {
        if ($artikel->dokter_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak mengakses artikel ini.');
        }
    }
}
