<?php

namespace App\Jobs;

use App\Models\Ad;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessAdClickJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 30;

    public function __construct(
        public Ad $ad
    ) {}

    public function handle(): void
    {
        if (!$this->ad->is_active) {
            return;
        }

        $this->ad->incrementClick();
    }

    public function failed(\Throwable $exception): void
    {
        \Log::error('ProcessAdClickJob failed', [
            'ad_id' => $this->ad->id,
            'error' => $exception->getMessage(),
        ]);
    }
}
