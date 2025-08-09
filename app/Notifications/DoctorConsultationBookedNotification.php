<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\KonsultasiDokter;

class DoctorConsultationBookedNotification extends Notification
{
    use Queueable;

    public $consultation;

    /**
     * Create a new notification instance.
     */
    public function __construct(KonsultasiDokter $consultation)
    {
        $this->consultation = $consultation;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'Pemesanan Konsultasi Baru',
            'message' => 'Ada pemesanan konsultasi baru dari ' . $this->consultation->user->name . ' pada tanggal ' . 
                        $this->consultation->tanggal_konsultasi . ' pukul ' . $this->consultation->waktu_konsultasi . 
                        '. Silakan konfirmasi pemesanan ini.',
            'type' => 'doctor_consultation_booked',
            'consultation_id' => $this->consultation->id,
            'patient_name' => $this->consultation->user->name,
            'consultation_date' => $this->consultation->tanggal_konsultasi,
            'consultation_time' => $this->consultation->waktu_konsultasi,
            'icon' => 'fas fa-calendar-check',
            'color' => 'orange'
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
