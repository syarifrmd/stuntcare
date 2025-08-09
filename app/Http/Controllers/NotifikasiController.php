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

    public function getUnreadNotifications()
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['notifications' => [], 'count' => 0]);
        }

        $unreadNotifications = $user->unreadNotifications()
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($notification) {
                $data = $notification->data;
                
                // Handle message yang bisa berupa array atau string
                $message = 'Anda memiliki notifikasi baru';
                if (isset($data['message'])) {
                    if (is_array($data['message'])) {
                        $message = implode(' ', $data['message']);
                    } else {
                        $message = $data['message'];
                    }
                }
                
                return [
                    'id' => $notification->id,
                    'title' => $data['title'] ?? 'Notifikasi',
                    'message' => $message,
                    'type' => $data['type'] ?? 'info',
                    'icon' => $data['icon'] ?? 'fas fa-bell',
                    'color' => $data['color'] ?? 'blue',
                    'created_at' => $notification->created_at->diffForHumans(),
                    'read_url' => route('notifikasi.read', $notification->id)
                ];
            });

        return response()->json([
            'notifications' => $unreadNotifications,
            'count' => $user->unreadNotifications()->count()
        ]);
    }

    public function cleanDuplicates()
    {
        // Hapus notifikasi duplikat berdasarkan konsultasi yang sama
        $duplicates = \DB::table('notifications')
            ->select('notifiable_id', \DB::raw('JSON_EXTRACT(data, "$.consultation_id") as consultation_id'), \DB::raw('MIN(id) as keep_id'))
            ->whereIn(\DB::raw('JSON_EXTRACT(data, "$.type")'), ['consultation_booked', 'consultation_confirmed'])
            ->groupBy('notifiable_id', \DB::raw('JSON_EXTRACT(data, "$.consultation_id")'))
            ->havingRaw('COUNT(*) > 1')
            ->get();

        $deletedCount = 0;
        foreach ($duplicates as $duplicate) {
            $deleted = \DB::table('notifications')
                ->where('notifiable_id', $duplicate->notifiable_id)
                ->where(\DB::raw('JSON_EXTRACT(data, "$.consultation_id")'), $duplicate->consultation_id)
                ->where('id', '!=', $duplicate->keep_id)
                ->delete();
            $deletedCount += $deleted;
        }

        return response()->json([
            'message' => "Berhasil menghapus {$deletedCount} notifikasi duplikat",
            'deleted_count' => $deletedCount
        ]);
    }
}
