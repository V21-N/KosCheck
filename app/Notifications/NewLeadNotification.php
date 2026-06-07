<?php

namespace App\Notifications;

use App\Models\Kos;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewLeadNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Kos $kos,
        public int $leadCount
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("🎉 Lead Baru untuk {$this->kos->name}!")
            ->greeting("Halo {$notifiable->name},")
            ->line(" Ada lead baru yang tertarik dengan kos **{$this->kos->name}**.")
            ->line(" Total lead bulan ini: **{$this->leadCount}**")
            ->action('Lihat Dashboard', route('owner.dashboard'))
            ->line('Terus pantau dashboard Anda untuk insight lebih lanjut!');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'new_lead',
            'kos_id' => $this->kos->id,
            'kos_name' => $this->kos->name,
            'lead_count' => $this->leadCount,
            'message' => "Ada lead baru untuk kos {$this->kos->name}",
        ];
    }
}
