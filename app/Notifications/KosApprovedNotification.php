<?php

namespace App\Notifications;

use App\Models\Kos;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class KosApprovedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Kos $kos) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("✅ Kos {$this->kos->name} Disetujui!")
            ->greeting("Halo {$notifiable->name},")
            ->line(" Kos **{$this->kos->name}** telah disetujui dan kini tampil di platform.")
            ->action('Lihat Kos', route('kos.show', $this->kos->slug))
            ->line('Selamat! Kos Anda kini bisa dilihat oleh ribuan mahasiswa.');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'kos_approved',
            'kos_id' => $this->kos->id,
            'kos_name' => $this->kos->name,
            'message' => "Kos {$this->kos->name} telah disetujui dan aktif di platform",
        ];
    }
}
