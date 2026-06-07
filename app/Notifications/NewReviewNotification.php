<?php

namespace App\Notifications;

use App\Models\Kos;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewReviewNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Kos $kos,
        public string $reviewerName
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("⭐ Review Baru untuk {$this->kos->name}!")
            ->greeting("Halo {$notifiable->name},")
            ->line(" **{$this->reviewerName}** menulis review baru untuk kos **{$this->kos->name}**.")
            ->action('Lihat Review', route('kos.show', $this->kos->slug))
            ->line('Terima kasih atas kepercayaan Anda di KosCheck!');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'new_review',
            'kos_id' => $this->kos->id,
            'kos_name' => $this->kos->name,
            'reviewer_name' => $this->reviewerName,
            'message' => "{$this->reviewerName} menulis review baru untuk {$this->kos->name}",
        ];
    }
}
