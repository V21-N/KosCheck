<?php

namespace App\Notifications;

use App\Models\AppNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Channels\DatabaseChannel;
use Illuminate\Notifications\Channels\TwilioSmsChannel;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class SmsNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public string $phone,
        public string $message,
        public array $options = []
    ) {}

    public function via(object $notifiable): array
    {
        $channels = ['database'];

        if ($this->isSmsEnabled()) {
            $channels[] = 'vonage';
        }

        return $channels;
    }

    protected function isSmsEnabled(): bool
    {
        return config('services.vonage.enabled', false) ||
               config('services.twilio.enabled', false);
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('SMS Alert - KosCheck')
            ->line('SMS notifikasi:')
            ->line($this->message)
            ->line('Untuk: ' . $this->phone);
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'sms_notification',
            'phone' => $this->phone,
            'message' => $this->message,
            'sent_at' => now()->toIso8601String(),
            'status' => 'pending',
        ];
    }

    public function toVonage($notifiable): array
    {
        return [
            'content' => $this->message,
        ];
    }

    public function toTwilio($notifiable): array
    {
        return [
            'body' => $this->message,
            'from' => config('services.twilio.from'),
        ];
    }

    public function withTracking(string $userId): self
    {
        $this->options['user_id'] = $userId;
        $this->options['track_id'] = 'SMS-' . now()->timestamp;
        return $this;
    }
}