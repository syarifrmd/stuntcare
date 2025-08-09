<?php

namespace App\Listeners;

use App\Events\ConsultationBooked;
use App\Events\ConsultationBookedNotification as BroadcastConsultationBookedNotification;
use App\Notifications\ConsultationBookedNotification;
use App\Notifications\DoctorConsultationBookedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendConsultationBookedNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ConsultationBooked $event): void
    {
        // Kirim notifikasi ke user yang memesan konsultasi (database)
        $event->consultation->user->notify(new ConsultationBookedNotification($event->consultation));
        
        // Kirim notifikasi ke dokter juga (database)
        $event->consultation->dokter->notify(new DoctorConsultationBookedNotification($event->consultation));

        // Broadcast ke web listener seperti MealReminder
        $userId = (int) $event->consultation->user_id;
        $message = 'Konsultasi berhasil dipesan dengan ' . $event->consultation->dokter->name . ' pada ' . $event->consultation->tanggal_konsultasi . (
            $event->consultation->waktu_konsultasi ? (' pukul ' . $event->consultation->waktu_konsultasi) : ''
        );
        broadcast(new BroadcastConsultationBookedNotification($userId, $message));
    }
}
