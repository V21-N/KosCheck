<?php

namespace App\Jobs;

use App\Models\Kos;
use App\Models\Lead;
use App\Notifications\NewLeadNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class ProcessLeadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 60;

    public function __construct(
        public array $leadData
    ) {}

    public function handle(): void
    {
        $kos = Kos::find($this->leadData['kos_id']);

        if (!$kos) {
            return;
        }

        if (!$kos->is_active) {
            return;
        }

        $lead = Lead::create([
            'kos_id' => $this->leadData['kos_id'],
            'user_id' => $this->leadData['user_id'],
            'ip_address' => $this->leadData['ip_address'],
            'user_agent' => $this->leadData['user_agent'],
        ]);

        $cacheKey = "lead_count_month:{$kos->id}:" . now()->format('Y-m');
        Cache::forget($cacheKey);

        $monthlyLeadCount = Lead::where('kos_id', $kos->id)
            ->thisMonth()
            ->count();

        if ($monthlyLeadCount % 5 === 0) {
            $kos->owner->notify(new NewLeadNotification($kos, $monthlyLeadCount));
        }
    }

    public function failed(\Throwable $exception): void
    {
        \Log::error('ProcessLeadJob failed', [
            'lead_data' => $this->leadData,
            'error' => $exception->getMessage(),
        ]);
    }
}
