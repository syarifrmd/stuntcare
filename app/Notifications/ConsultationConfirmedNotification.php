<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\KonsultasiDokter;

class ConsultationConfirmedNotification extends Notification
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
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'Konsultasi Dikonfirmasi',
            'message' => 'Konsultasi Anda dengan ' . $this->consultation->dokter->name . ' pada tanggal ' . 
                        $this->consultation->tanggal_konsultasi . ' pukul ' . $this->consultation->waktu_konsultasi . 
                        ' telah dikonfirmasi. Silakan hadir tepat waktu.',
            'type' => 'consultation_confirmed',
            'consultation_id' => $this->consultation->id,
            'doctor_name' => $this->consultation->dokter->name,
            'consultation_date' => $this->consultation->tanggal_konsultasi,
            'consultation_time' => $this->consultation->waktu_konsultasi,
            'icon' => 'fas fa-check-circle',
            'color' => 'green'
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
