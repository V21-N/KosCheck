<?php

namespace App\Providers;

use App\Events\LeadConverted;
use App\Events\LeadCreated;
use App\Events\ReviewCreated;
use App\Events\ReviewReported;
use App\Listeners\SendNewLeadNotification;
use App\Listeners\SendNewReviewNotification;
use App\Listeners\SendReviewReportedNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        LeadCreated::class => [
            SendNewLeadNotification::class,
        ],
        LeadConverted::class => [],
        ReviewCreated::class => [
            SendNewReviewNotification::class,
        ],
        ReviewReported::class => [
            SendReviewReportedNotification::class,
        ],
    ];

    public function boot(): void
    {
        parent::boot();
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}