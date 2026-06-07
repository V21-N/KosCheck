<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReviewReportedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public int $reviewId,
        public string $reviewerName,
        public string $kosName,
        public string $reason
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("🚩 Review Dilaporkan - {$this->kosName}")
            ->line(" Review dari **{$this->reviewerName}** di kos {$this->kosName} telah dilaporkan.")
            ->line("**Alasan:** {$this->reason}")
            ->action('Tinjau Report', route('admin.reviews'));
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'review_reported',
            'review_id' => $this->reviewId,
            'reviewer_name' => $this->reviewerName,
            'kos_name' => $this->kosName,
            'reason' => $this->reason,
            'message' => "Review dari {$this->reviewerName} di {$this->kosName} dilaporkan",
        ];
    }
}
