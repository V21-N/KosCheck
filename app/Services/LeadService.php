<?php

namespace App\Services;

use App\Models\Kos;
use App\Models\Lead;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;

class LeadService
{
    protected int $freeQuotaLimit = 20;
    protected int $rateLimitAttempts = 10;
    protected int $dedupeWindowMinutes = 60;

    public function trackLead(int $kosId, ?int $userId = null, ?string $ipAddress = null, ?string $userAgent = null): ?Lead
    {
        $kos = Kos::findOrFail($kosId);

        if (!$this->checkRateLimit($ipAddress, $kosId)) {
            return null;
        }

        if ($this->isDuplicateLead($ipAddress, $kosId)) {
            return null;
        }

        if (!$this->withinQuota($kos)) {
            Log::info('Lead quota exceeded', ['kos_id' => $kosId]);
            return null;
        }

        return $this->createLead($kos, $userId, $ipAddress, $userAgent);
    }

    public function checkRateLimit(?string $ipAddress, int $kosId): bool
    {
        if (!$ipAddress) {
            return true;
        }

        $key = "lead_track:{$ipAddress}:{$kosId}";

        if (RateLimiter::tooManyAttempts($key, $this->rateLimitAttempts)) {
            return false;
        }

        RateLimiter::hit($key, 3600);

        return true;
    }

    public function isDuplicateLead(?string $ipAddress, int $kosId): bool
    {
        if (!$ipAddress) {
            return false;
        }

        $dedupeKey = "lead_dedupe:{$ipAddress}:{$kosId}:" . now()->startOfHour()->timestamp;

        if (Cache::has($dedupeKey)) {
            return true;
        }

        Cache::put($dedupeKey, true, now()->addMinutes($this->dedupeWindowMinutes));

        return false;
    }

    public function withinQuota(Kos $kos): bool
    {
        if ($kos->isPremium()) {
            return true;
        }

        $quotaUsed = $this->getQuotaUsed($kos->id);

        return $quotaUsed < $this->freeQuotaLimit;
    }

    public function getQuotaUsed(int $kosId): int
    {
        return Lead::forKos($kosId)->thisMonth()->count();
    }

    public function getQuotaRemaining(int $kosId): int
    {
        return max(0, $this->freeQuotaLimit - $this->getQuotaUsed($kosId));
    }

    public function isQuotaExceeded(int $kosId): bool
    {
        $kos = Kos::find($kosId);

        if (!$kos || $kos->isPremium()) {
            return false;
        }

        return $this->getQuotaUsed($kosId) >= $this->freeQuotaLimit;
    }

    protected function createLead(Kos $kos, ?int $userId, ?string $ipAddress, ?string $userAgent): Lead
    {
        $lead = Lead::create([
            'kos_id' => $kos->id,
            'user_id' => $userId,
            'ip_address' => $ipAddress ?? '127.0.0.1',
            'user_agent' => $userAgent,
        ]);

        $this->clearQuotaCache($kos->id);

        Log::info('Lead created', [
            'lead_id' => $lead->id,
            'kos_id' => $kos->id,
            'ip_address' => $ipAddress,
        ]);

        return $lead;
    }

    protected function clearQuotaCache(int $kosId): void
    {
        $cacheKey = "lead_count_month:{$kosId}:" . now()->format('Y-m');
        Cache::forget($cacheKey);
    }

    public function getWhatsAppUrl(Kos $kos): string
    {
        $phone = preg_replace('/[^0-9]/', '', $kos->whatsapp);

        if (!str_starts_with($phone, '62')) {
            $phone = '62' . ltrim($phone, '0');
        }

        $message = $this->getWhatsAppMessage($kos);

        return "https://wa.me/{$phone}?text=" . urlencode($message);
    }

    protected function getWhatsAppMessage(Kos $kos): string
    {
        return "Halo, saya tertarik dengan kos {$kos->name} yang terdaftar di KosCheck. Apakah kamar masih tersedia?";
    }

    public function markAsConverted(Lead $lead): void
    {
        $lead->markAsConverted();
    }

    public function getLeadStats(int $kosId): array
    {
        $leads = Lead::forKos($kosId);

        return [
            'total' => $leads->count(),
            'today' => $leads->today()->count(),
            'this_week' => $leads->thisWeek()->count(),
            'this_month' => $leads->thisMonth()->count(),
            'converted' => $leads->converted()->count(),
            'unconverted' => $leads->unconverted()->count(),
        ];
    }

    public function getDailyLeadCounts(int $kosId, int $days = 30): array
    {
        return Lead::getDailyCounts($kosId, $days);
    }
}