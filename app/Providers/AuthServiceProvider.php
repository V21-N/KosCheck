<?php

namespace App\Providers;

use App\Models\Kos;
use App\Models\Lead;
use App\Models\Review;
use App\Models\AppNotification;
use App\Policies\KosPolicy;
use App\Policies\LeadPolicy;
use App\Policies\NotificationPolicy;
use App\Policies\ReviewPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Kos::class => KosPolicy::class,
        Lead::class => LeadPolicy::class,
        Review::class => ReviewPolicy::class,
        AppNotification::class => NotificationPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
