<?php

namespace App\Http\Controllers;

use App\Models\KonsultasiDokter;
use App\Models\Artikel; // Pastikan model Artikel ada dan di-namespace dengan benar
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\ConsultationConfirmed;

class DokterController extends Controller
{
    // Fungsi untuk menampilkan Dashboard Dokter
    public function dashboard()
    {
        // Ambil artikel terbaru untuk ditampilkan di dashboard
        // Anda mungkin perlu menyesuaikan ini jika model Artikel tidak ada atau berbeda
        $artikels = []; // Default ke array kosong jika Artikel tidak ada
        if (class_exists(Artikel::class)) {
            $artikels = Artikel::latest()->take(3)->get(); // Menampilkan 3 artikel terbaru
        }
        return view('dokter.dashboard', compact('artikels'));  // Tampilkan halaman dashboard dokter
    }

    // --- CRUD untuk Jadwal Konsultasi Dokter (yang dibuat oleh dokter) ---
    
    // Menampilkan semua jadwal yang sudah dibuat oleh dokter
    public function indexJadwal()
    {
        // Ambil semua jadwal yang sudah dibuat oleh dokter yang sedang login
        $jadwals = KonsultasiDokter::where('dokter_id', Auth::id()) // Menggunakan Auth::id() lebih aman
                                   ->orderBy('waktu_konsultasi', 'desc') // Urutkan berdasarkan waktu
                                   ->get();
        return view('dokter.konsultasi.index', compact('jadwals')); // Pastikan view ini ada: resources/views/dokter/konsultasi/index.blade.php
    }

    // Menampilkan form untuk membuat jadwal konsultasi
    public function createJadwal()
    {
        return view('dokter.konsultasi.create'); // Pastikan view ini ada: resources/views/dokter/konsultasi/create.blade.php
    }

    // Menyimpan jadwal konsultasi baru
    public function storeJadwal(Request $request)
    {
        $request->validate([
            'no_wa_dokter' => 'required|string|regex:/^[0-9\-\+\s\(\)]*$/|min:10', // Validasi nomor WA
            'waktu_konsultasi' => 'required|date|after:now', // Jadwal harus setelah waktu sekarang
            'status' => 'required|string|in:Tersedia,Tidak Tersedia', // Dokter hanya bisa set Tersedia/Tidak Tersedia saat buat
        ]);

        KonsultasiDokter::create([
            'dokter_id' => Auth::id(),  // Dokter ID otomatis dari user yang login
            'nama_dokter' => Auth::user()->name,  // Nama dokter otomatis dari user yang login
            'no_wa_dokter' => $request->no_wa_dokter,
            'waktu_konsultasi' => $request->waktu_konsultasi,
            'status' => $request->status, // Status awal saat dokter membuat jadwal
            'user_id' => null, // Belum ada user yang memesan saat jadwal dibuat
        ]);

        return redirect()->route('dokter.konsultasi.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit jadwal konsultasi
    public function editJadwal($id)
    {
        $jadwal = KonsultasiDokter::where('id', $id)
                                  ->where('dokter_id', Auth::id()) // Pastikan dokter hanya bisa edit jadwalnya sendiri
                                  ->firstOrFail(); // Jika tidak ditemukan atau bukan milik dokter, akan error 404
        return view('dokter.konsultasi.edit', compact('jadwal')); // Pastikan view ini ada: resources/views/dokter/konsultasi/edit.blade.php
    }

    // Memperbarui jadwal konsultasi
    public function updateJadwal(Request $request, $id)
    {
        $jadwal = KonsultasiDokter::where('id', $id)
                                  ->where('dokter_id', Auth::id()) // Keamanan: dokter hanya bisa update jadwalnya sendiri
                                  ->firstOrFail();

        $request->validate([
            'no_wa_dokter' => 'required|string|regex:/^[0-9\-\+\s\(\)]*$/|min:10',
            'waktu_konsultasi' => 'required|date',
            // Dokter bisa mengubah status jadwalnya, termasuk jika sudah ada yang memesan (misal, membatalkan atau reschedule)
            // Namun, validasi status mungkin perlu lebih kompleks tergantung alur bisnis
            'status' => 'required|string|in:Tersedia,Tidak Tersedia,Dipesan,Selesai,Dibatalkan',
        ]);

        // Jika status diubah menjadi 'Tersedia' dari 'Dipesan' atau 'Memesan', user_id harus di-null-kan
        if ($request->status == 'Tersedia' && in_array($jadwal->status, ['Memesan', 'Dipesan'])) {
            $jadwal->user_id = null;
        }
        
        $jadwal->update([
            'no_wa_dokter' => $request->no_wa_dokter,
            'waktu_konsultasi' => $request->waktu_konsultasi,
            'status' => $request->status,
        ]);


        return redirect()->route('dokter.konsultasi.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    // Menghapus jadwal konsultasi
    public function destroyJadwal($id)
    {
        $jadwal = KonsultasiDokter::where('id', $id)
                                  ->where('dokter_id', Auth::id()) // Keamanan: dokter hanya bisa hapus jadwalnya sendiri
                                  ->firstOrFail();
        
        // Sebaiknya ada pengecekan jika jadwal sudah dipesan, apakah boleh dihapus atau diubah status jadi "Dibatalkan"
        // Untuk saat ini, kita asumsikan bisa langsung dihapus.
        $jadwal->delete();

        return redirect()->route('dokter.konsultasi.index')->with('success', 'Jadwal berhasil dihapus.');
    }

    /**
     * Mengkonfirmasi pemesanan jadwal oleh dokter.
     * Metode ini akan dipanggil ketika dokter mengklik tombol "Konfirmasi" pada jadwal yang statusnya "Memesan".
     */
    public function confirmPemesananJadwal(Request $request, $id)
    {
        $jadwal = KonsultasiDokter::find($id);

        if (!$jadwal) {
            return redirect()->route('dokter.konsultasi.index')->with('error', 'Jadwal tidak ditemukan.');
        }

        // Pastikan dokter yang login adalah pemilik jadwal ini
        if ($jadwal->dokter_id !== Auth::id()) {
            return redirect()->route('dokter.konsultasi.index')->with('error', 'Anda tidak berwenang untuk mengkonfirmasi jadwal ini.');
        }

        // Pastikan jadwal dalam status "Memesan"
        if ($jadwal->status == 'Memesan') {
            $jadwal->update([
                'status' => 'Dipesan', // Ubah status menjadi "Dipesan"
            ]);
            
            // Trigger event untuk notifikasi konfirmasi konsultasi
            event(new ConsultationConfirmed($jadwal));
            
            return redirect()->route('dokter.konsultasi.index')->with('success', 'Pemesanan jadwal berhasil dikonfirmasi.');
        }

        return redirect()->route('dokter.konsultasi.index')->with('error', 'Jadwal ini tidak dalam status "Memesan" atau sudah diproses.');
    }


    // --- CRUD untuk Konsultasi Dokter (Bagian ini tampaknya duplikatif atau berbeda tujuan dengan "Jadwal") ---
    // Metode di bawah ini (indexKonsultasi, showKonsultasi, dst.) tampaknya mengelola entitas "Konsultasi"
    // secara umum, bukan spesifik jadwal yang dibuat dokter.
    // Jika ini adalah fungsionalitas yang berbeda, pastikan view dan rutenya juga berbeda.
    // Jika ini adalah duplikasi dari manajemen jadwal, sebaiknya disatukan atau dihapus.
    // Untuk saat ini, saya biarkan sesuai permintaan awal, namun perlu ditinjau.

    public function indexKonsultasi()
    {
        // Jika ini untuk admin melihat semua konsultasi:
        // $konsultasi = KonsultasiDokter::all();
        // Jika ini untuk dokter melihat konsultasi yang melibatkan dirinya (baik yang dia buat atau yang dia layani):
        $konsultasi = KonsultasiDokter::where('dokter_id', Auth::id())
                                     ->orWhere('user_id', Auth::id()) // Contoh jika dokter juga bisa jadi user di kasus lain
                                     ->get();
        return view('dokter.konsultasi.index', compact('konsultasi')); // View ini mungkin sama dengan indexJadwal, perlu dipastikan
    }

    public function showKonsultasi($id)
    {
        $konsultasi = KonsultasiDokter::find($id);
        // Tambahkan pengecekan otorisasi jika perlu
        if (!$konsultasi || ($konsultasi->dokter_id !== Auth::id() && $konsultasi->user_id !== Auth::id())) {
             // return abort(404); // Atau redirect dengan error
        }
        return view('dokter.konsultasi.show', compact('konsultasi'));
    }
    
    // public function indexArtikel(Request $request)
    // {
    //     $artikels = Artikel::where('author_id', Auth::id())
    //                        ->latest() // Urutkan berdasarkan terbaru
    //                        ->paginate(10); // Paginasi jika banyak artikel

    //     return view('dokter.artikel.index', compact('artikels'));
    // }

    // /**
    //  * Menyimpan artikel baru yang dibuat oleh dokter.
    //  * Tidak memerlukan createArtikel() karena form akan ada di modal.
    //  */
    // public function storeArtikel(Request $request)
    // {
    //     $request->validate([
    //         'title' => 'required|string|max:255',
    //         'topic' => 'required|string|max:255',
    //         'content' => 'required|string',
    //     ]);

    //     Artikel::create([
    //         'title' => $request->title,
    //         'topic' => $request->topic,
    //         'content' => $request->content,
    //         'dokter_id' => Auth::id(), // Set penulis sebagai dokter yang login
    //         'author_id' => Auth::id(),
    //     ]);

    //     return redirect()->route('dokter.artikel.index')->with('success', 'Artikel berhasil ditambahkan.');
    // }

    // /**
    //  * Menampilkan data artikel untuk diedit di modal.
    //  * Metode ini bisa juga tidak diperlukan jika data diambil langsung di view via @json.
    //  * Namun, untuk konsistensi, bisa saja ada.
    //  * Untuk modal, data biasanya dikirim ke view utama (index) dan Alpine yang mengelolanya.
    //  * Jadi, editArtikel($id) yang mengembalikan view form terpisah tidak diperlukan.
    //  */

    // /**
    //  * Memperbarui artikel yang sudah ada.
    //  */
    // public function updateArtikel(Request $request, $id)
    // {
    //     $artikel = Artikel::where('id', $id)
    //                       ->where('author_id', Auth::id()) // Pastikan dokter hanya update artikelnya sendiri
    //                       ->firstOrFail();

    //     $request->validate([
    //         'title' => 'required|string|max:255',
    //         'topic' => 'required|string|max:255',
    //         'content' => 'required|string',
    //     ]);

    //     $artikel->update([
    //         'title' => $request->title,
    //         'topic' => $request->topic,
    //         'content' => $request->content,
    //     ]);

    //     return redirect()->route('dokter.artikel.index')->with('success', 'Artikel berhasil diperbarui.');
    // }

    // /**
    //  * Menghapus artikel.
    //  */
    // public function destroyArtikel($id)
    // {
    //     $artikel = Artikel::where('id', $id)
    //                       ->where('author_id', Auth::id()) // Pastikan dokter hanya hapus artikelnya sendiri
    //                       ->firstOrFail();
        
    //     $artikel->delete();

    //     return redirect()->route('dokter.artikel.index')->with('success', 'Artikel berhasil dihapus.');
    // }

    // /**
    //  * Menampilkan detail satu artikel (jika diperlukan halaman detail terpisah).
    //  * Untuk CRUD modal, ini mungkin tidak digunakan secara langsung oleh dokter.
    //  */
    // public function showArtikel($id)
    // {
    //     // Bisa jadi ini untuk public view atau jika dokter ingin melihat preview.
    //     // Untuk CRUD dokter, fokus pada index, store, update, destroy.
    //     $artikel = Artikel::with('author')->findOrFail($id);
    //     // Tambahkan pengecekan otorisasi jika hanya dokter tertentu yang boleh lihat detail artikel tertentu
    //     // if ($artikel->author_id !== Auth::id() && Auth::user()->role !== 'admin') {
    //     //     abort(403, 'Anda tidak berhak melihat artikel ini.');
    //     // }
    //     return view('dokter.artikel.show', compact('artikel')); // Anda perlu view 'dokter.artikel.show'
    // }

    // storeKonsultasi, updateKonsultasi, destroyKonsultasi mungkin tidak relevan jika dokter hanya mengelola jadwalnya sendiri
    // dan tidak membuat entitas "konsultasi" secara manual dengan cara ini.
    // Metode ini lebih mirip dengan apa yang dilakukan `storeJadwal`.
    // Saya akan mengomentarinya untuk menghindari kebingungan dengan fungsionalitas jadwal.

    /*
    public function storeKonsultasi(Request $request)
    {
        $request->validate([
            'dokter_id' => 'required|exists:users,id', // Ini seharusnya Auth::id() jika dokter yang buat
            'nama_dokter' => 'required|string', // Ini seharusnya Auth::user()->name
            'no_wa_dokter' => 'required|string',
            'waktu_konsultasi' => 'required|date',
            'status' => 'required|string',
        ]);

        KonsultasiDokter::create($request->all());

        return redirect()->route('dokter.konsultasi.index')->with('success', 'Konsultasi berhasil ditambahkan');
    }

    public function updateKonsultasi(Request $request, $id)
    {
        $konsultasi = KonsultasiDokter::find($id);
        if (!$konsultasi) {
            return redirect()->route('dokter.konsultasi.index')->with('error', 'Konsultasi tidak ditemukan');
        }
        // Tambahkan otorisasi: pastikan dokter yang login yang berhak mengupdate
        // if ($konsultasi->dokter_id !== Auth::id()) { ... }

        $konsultasi->update($request->all());
        return redirect()->route('dokter.konsultasi.index')->with('success', 'Konsultasi berhasil diperbarui');
    }

    public function destroyKonsultasi($id)
    {
        $konsultasi = KonsultasiDokter::find($id);
        if (!$konsultasi) {
            return redirect()->route('dokter.konsultasi.index')->with('error', 'Konsultasi tidak ditemukan');
        }
        // Tambahkan otorisasi
        // if ($konsultasi->dokter_id !== Auth::id()) { ... }
        
        $konsultasi->delete();
        return redirect()->route('dokter.konsultasi.index')->with('success', 'Konsultasi berhasil dihapus');
    }
    */
}