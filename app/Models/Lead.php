<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = ['kos_id', 'user_id', 'ip_address', 'user_agent', 'converted_at'];

    protected $casts = [
        'converted_at' => 'datetime',
    ];

    public function kos(): BelongsTo
    {
        return $this->belongsTo(Kos::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function markAsConverted(): void
    {
        $this->update(['converted_at' => now()]);
    }

    public function isDuplicate(?string $ipAddress = null, ?int $hours = 1): bool
    {
        $ip = $ipAddress ?? $this->ip_address;

        return static::where('kos_id', $this->kos_id)
            ->where('ip_address', $ip)
            ->where('created_at', '>=', now()->subHours($hours))
            ->exists();
    }

    public function scopeForKos($query, int $kosId)
    {
        return $query->where('kos_id', $kosId);
    }

    public function scopeInDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    public function scopeConverted($query)
    {
        return $query->whereNotNull('converted_at');
    }

    public function scopeUnconverted($query)
    {
        return $query->whereNull('converted_at');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', now()->toDateString());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
    }

    public static function getDailyCounts(int $kosId, int $days = 30): array
    {
        $cacheKey = "leads_daily_{$kosId}_{$days}";

        return Cache::remember($cacheKey, now()->addHour(), function () use ($kosId, $days) {
            $startDate = now()->subDays($days)->startOfDay();
            $endDate = now()->endOfDay();

            $leads = static::forKos($kosId)
                ->inDateRange($startDate, $endDate)
                ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->groupBy('date')
                ->pluck('count', 'date')
                ->toArray();

            $result = [];
            for ($i = 0; $i < $days; $i++) {
                $date = now()->subDays($i)->toDateString();
                $result[$date] = $leads[$date] ?? 0;
            }

            return $result;
        });
    }

    public static function getMonthlyTotal(int $kosId): int
    {
        return static::forKos($kosId)->thisMonth()->count();
    }

    public static function getQuotaUsed(int $kosId): int
    {
        return static::forKos($kosId)->thisMonth()->count();
    }
}
