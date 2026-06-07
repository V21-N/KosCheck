<?php

namespace App\Jobs;

use App\Models\Kos;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckPremiumExpirationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $expiredKos = Kos::where('is_premium', true)
            ->whereNotNull('premium_expires_at')
            ->where('premium_expires_at', '<=', now())
            ->get();

        foreach ($expiredKos as $kos) {
            $kos->update([
                'is_premium' => false,
                'premium_expires_at' => null,
            ]);
        }
    }
}
