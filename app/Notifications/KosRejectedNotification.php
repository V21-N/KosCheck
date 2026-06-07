<?php

namespace App\Notifications;

use App\Models\Kos;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class KosRejectedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Kos $kos,
        public string $reason = ''
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject("❌ Kos {$this->kos->name} Perlu Perbaikan")
            ->greeting("Halo {$notifiable->name},")
            ->line(" Maaf, kos **{$this->kos->name}** belum bisa kami setujui.")
            ->line("Silakan perbaiki data kos Anda dan ajukan kembali.");

        if ($this->reason) {
            $mail->line("**Alasan:** {$this->reason}");
        }

        return $mail
            ->action('Edit Kos', route('dashboard.kos.edit', $this->kos->id))
            ->line('Tim KosCheck siap membantu jika ada pertanyaan.');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'kos_rejected',
            'kos_id' => $this->kos->id,
            'kos_name' => $this->kos->name,
            'reason' => $this->reason,
            'message' => "Kos {$this->kos->name} ditolak. Silakan perbaiki dan ajukan kembali.",
        ];
    }
}
