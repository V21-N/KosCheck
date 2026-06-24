<?php

namespace App\Services;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SubscriptionService
{
    public function createSubscription(User $user, int $durationDays = 30, string $planName = 'premium'): Subscription
    {
        return DB::transaction(function () use ($user, $durationDays, $planName) {
            // Deactivate any existing active subscriptions
            $user->subscriptions()
                ->where('status', 'active')
                ->update(['status' => Subscription::STATUS_CANCELLED]);

            $startedAt = now();
            $expiredAt = now()->addDays($durationDays);
            $price = config('premium.price_monthly', 49000);

            // Create new subscription
            $subscription = $user->subscriptions()->create([
                'plan_name' => $planName,
                'plan_type' => $durationDays === 30 ? 'monthly' : 'yearly',
                'price' => $price,
                'duration_days' => $durationDays,
                'started_at' => $startedAt,
                'expired_at' => $expiredAt,
                'status' => Subscription::STATUS_ACTIVE,
            ]);

            // Update user premium status
            $user->update([
                'is_premium' => true,
                'premium_started_at' => $startedAt,
                'premium_expired_at' => $expiredAt,
            ]);

            Log::info('Subscription created', [
                'user_id' => $user->id,
                'subscription_id' => $subscription->id,
                'expires_at' => $expiredAt,
            ]);

            return $subscription;
        });
    }

    public function activateSubscription(User $user, int $durationDays = 30): Subscription
    {
        return $this->createSubscription($user, $durationDays);
    }

    public function cancelSubscription(User $user): bool
    {
        return DB::transaction(function () use ($user) {
            $user->subscriptions()
                ->where('status', 'active')
                ->update(['status' => Subscription::STATUS_CANCELLED]);

            $user->update([
                'is_premium' => false,
            ]);

            return true;
        });
    }

    public function expireSubscription(Subscription $subscription): void
    {
        DB::transaction(function () use ($subscription) {
            $subscription->update(['status' => Subscription::STATUS_EXPIRED]);

            // Check if user has another active subscription
            $hasActive = $subscription->user->subscriptions()
                ->where('status', 'active')
                ->where('expired_at', '>', now())
                ->exists();

            if (!$hasActive) {
                $subscription->user->update([
                    'is_premium' => false,
                    'premium_expired_at' => null,
                ]);
            }

            Log::info('Subscription expired', [
                'subscription_id' => $subscription->id,
                'user_id' => $subscription->user_id,
            ]);
        });
    }

    public function checkAndExpireSubscriptions(): int
    {
        $expiredCount = 0;

        Subscription::expired()
            ->chunkById(100, function ($subscriptions) use (&$expiredCount) {
                foreach ($subscriptions as $subscription) {
                    $this->expireSubscription($subscription);
                    $expiredCount++;
                }
            });

        return $expiredCount;
    }

    public function isActive(User $user): bool
    {
        return $user->isPremiumUser();
    }

    public function getRemainingDays(User $user): int
    {
        return $user->days_until_expiry ?? 0;
    }

    public function getActiveSubscription(User $user): ?Subscription
    {
        return $user->subscriptions()
            ->active()
            ->first();
    }
}
