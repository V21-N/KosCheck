<?php

namespace App\Listeners;

use App\Events\ReviewReported;
use App\Models\AppNotification;
use App\Models\User;
use App\Notifications\ReviewReportedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendReviewReportedNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public int $tries = 3;
    public int $backoff = 60;

    public function handle(ReviewReported $event): void
    {
        $review = $event->review;
        $kos = $event->kos;

        $adminUsers = User::where('role', 'admin')->get();

        foreach ($adminUsers as $admin) {
            $admin->notify(new ReviewReportedNotification($review, $kos, $event->reason));

            AppNotification::createForUser(
                $admin->id,
                'review_reported',
                'Review Dilaporkan!',
                "Review untuk kos {$kos->name} telah dilaporkan: {$event->reason}",
                [
                    'kos_id' => $kos->id,
                    'review_id' => $review->id,
                    'reason' => $event->reason,
                ]
            );
        }

        Log::info('Review reported notification sent', [
            'review_id' => $review->id,
            'kos_id' => $kos->id,
            'admin_count' => $adminUsers->count(),
        ]);
    }

    public function failed(ReviewReported $event, \Throwable $exception): void
    {
        Log::error('Failed to send review reported notification', [
            'review_id' => $event->review->id,
            'kos_id' => $event->kos->id,
            'error' => $exception->getMessage(),
        ]);
    }
}
