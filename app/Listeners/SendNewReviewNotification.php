<?php

namespace App\Listeners;

use App\Events\ReviewCreated;
use App\Models\AppNotification;
use App\Models\Review;
use App\Notifications\NewReviewNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendNewReviewNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public int $tries = 3;
    public int $backoff = 60;

    public function handle(ReviewCreated $event): void
    {
        $kos = $event->kos;
        $review = $event->review;

        if ($kos->owner) {
            $kos->owner->notify(new NewReviewNotification($review, $kos));

            AppNotification::createForUser(
                $kos->owner->id,
                'new_review',
                'Review Baru!',
                "Kos {$kos->name} mendapat review baru dengan rating {$review->rating} bintang",
                [
                    'kos_id' => $kos->id,
                    'kos_name' => $kos->name,
                    'review_id' => $review->id,
                    'rating' => $review->rating,
                ]
            );
        }

        Log::info('New review notification sent', [
            'review_id' => $review->id,
            'kos_id' => $kos->id,
            'owner_id' => $kos->owner?->id,
        ]);
    }

    public function failed(ReviewCreated $event, \Throwable $exception): void
    {
        Log::error('Failed to send new review notification', [
            'review_id' => $event->review->id,
            'kos_id' => $event->kos->id,
            'error' => $exception->getMessage(),
        ]);
    }
}
