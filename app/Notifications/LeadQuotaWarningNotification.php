<?php

namespace App\Notifications;

use App\Models\Kos;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LeadQuotaWarningNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Kos $kos,
        public int $currentLeads,
        public int $quotaLimit
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $remaining = $this->quotaLimit - $this->currentLeads;

        return (new MailMessage)
            ->subject("⚠️ Kuota Lead Hampir Habis - {$this->kos->name}")
            ->greeting("Halo {$notifiable->name},")
            ->line(" Kos **{$this->kos->name}** Anda hampir mencapai batas lead gratis.")
            ->line(" Lead bulan ini: **{$this->currentLeads}** / {$this->quotaLimit}")
            ->line(" Sisa: **{$remaining}** lead")
            ->line('**Upgrade ke Premium** untuk unlimited lead dan manfaat lainnya!')
            ->action('Upgrade Premium', route('dashboard.properti'))
            ->line(' atau hubungi tim KosCheck untuk informasi paket terbaik.');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'quota_warning',
            'kos_id' => $this->kos->id,
            'kos_name' => $this->kos->name,
            'current_leads' => $this->currentLeads,
            'quota_limit' => $this->quotaLimit,
            'message' => "Kuota lead untuk {$this->kos->name} hampir habis ({$this->currentLeads}/{$this->quotaLimit})",
        ];
    }
}
