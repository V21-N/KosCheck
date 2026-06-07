<?php

namespace App\Jobs;

use App\Models\Kos;
use App\Models\Review;
use App\Notifications\NewReviewNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessReviewJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 60;

    public function __construct(
        public Review $review
    ) {}

    public function handle(): void
    {
        $kos = $this->review->kos;

        if (!$kos) {
            return;
        }

        $kos->owner->notify(new NewReviewNotification($kos, $this->review->user->name));
    }

    public function failed(\Throwable $exception): void
    {
        \Log::error('ProcessReviewJob failed', [
            'review_id' => $this->review->id,
            'error' => $exception->getMessage(),
        ]);
    }
}
