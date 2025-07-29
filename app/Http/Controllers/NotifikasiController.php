<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;

class NotifikasiController extends Controller
{
    public function riwayat()
    {
        // Ambil user yang sedang login
        $user = Auth::user();

        // Ambil notifikasi dari tabel notifications untuk user ini, urutkan terbaru
        $notifikasis = $user->notifications()->orderBy('created_at', 'desc')->get();

        // Kirim data ke view
        return view('notifikasi.riwayat', compact('notifikasis'));
    }

    public function tandaiDibaca($id)
    {
        // Cari notifikasi berdasarkan ID hanya milik user ini
        $notification = Auth::user()->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->markAsRead();
        }

        return redirect()->back()->with('success', 'Notifikasi berhasil ditandai sebagai dibaca.');
    }

    public function tandaiSemuaDibaca()
    {
        Auth::user()->unreadNotifications->markAsRead();

        return redirect()->back()->with('success', 'Semua notifikasi berhasil ditandai sebagai dibaca.');
    }
}
