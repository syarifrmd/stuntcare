<?php

namespace App\Listeners;

use App\Events\ConsultationConfirmed;
use App\Events\ConsultationConfirmedNotification as BroadcastConsultationConfirmedNotification;
use App\Notifications\ConsultationConfirmedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendConsultationConfirmedNotification
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
    public function handle(ConsultationConfirmed $event): void
    {
        // Kirim notifikasi ke user yang konsultasinya dikonfirmasi (database)
        $event->consultation->user->notify(new ConsultationConfirmedNotification($event->consultation));

        // Broadcast ke web listener seperti MealReminder
        $userId = (int) $event->consultation->user_id;
        $message = 'Konsultasi dikonfirmasi oleh ' . $event->consultation->dokter->name . ' pada ' . $event->consultation->tanggal_konsultasi . (
            $event->consultation->waktu_konsultasi ? (' pukul ' . $event->consultation->waktu_konsultasi) : ''
        );
        broadcast(new BroadcastConsultationConfirmedNotification($userId, $message));
    }
}
