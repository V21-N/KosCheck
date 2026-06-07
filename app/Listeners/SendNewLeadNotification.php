<?php

namespace App\Listeners;

use App\Events\LeadCreated;
use App\Models\AppNotification;
use App\Models\Lead;
use App\Notifications\NewLeadNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendNewLeadNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public int $tries = 3;
    public int $backoff = 60;

    public function handle(LeadCreated $event): void
    {
        $kos = $event->kos;
        $lead = $event->lead;

        $monthlyLeadCount = Lead::where('kos_id', $kos->id)
            ->thisMonth()
            ->count();

        if ($kos->owner) {
            $kos->owner->notify(new NewLeadNotification($kos, $monthlyLeadCount));

            AppNotification::createForUser(
                $kos->owner->id,
                'new_lead',
                'Lead Baru!',
                "Ada lead baru yang tertarik dengan kos {$kos->name}. Total lead bulan ini: {$monthlyLeadCount}",
                [
                    'kos_id' => $kos->id,
                    'kos_name' => $kos->name,
                    'lead_id' => $lead->id,
                ]
            );
        }

        Log::info('New lead notification sent', [
            'lead_id' => $lead->id,
            'kos_id' => $kos->id,
            'owner_id' => $kos->owner?->id,
        ]);
    }

    public function failed(LeadCreated $event, \Throwable $exception): void
    {
        Log::error('Failed to send new lead notification', [
            'lead_id' => $event->lead->id,
            'kos_id' => $event->kos->id,
            'error' => $exception->getMessage(),
        ]);
    }
}
