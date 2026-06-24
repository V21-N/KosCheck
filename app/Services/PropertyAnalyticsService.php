<?php

namespace App\Services;

use App\Models\Kos;
use App\Models\PropertyFavorite;
use App\Models\PropertyView;
use App\Models\User;
use App\Models\WhatsappClick;
use Illuminate\Support\Facades\Cache;

class PropertyAnalyticsService
{
    protected int $cacheMinutes = 30;

    public function trackView(Kos $kos, ?User $user = null, ?string $ipAddress = null): PropertyView
    {
        return PropertyView::create([
            'kos_id' => $kos->id,
            'user_id' => $user?->id,
            'ip_address' => $ipAddress,
            'user_agent' => request()->userAgent(),
            'referer' => request()->referer(),
        ]);
    }

    public function trackFavorite(Kos $kos, ?User $user = null, ?string $ipAddress = null): PropertyFavorite
    {
        return PropertyFavorite::firstOrCreate([
            'kos_id' => $kos->id,
            'user_id' => $user?->id,
        ], [
            'ip_address' => $ipAddress,
        ]);
    }

    public function trackWhatsappClick(Kos $kos, ?User $user = null): WhatsappClick
    {
        return WhatsappClick::create([
            'kos_id' => $kos->id,
            'user_id' => $user?->id,
            'ip_address' => request()->ip(),
            'phone_last_digits' => substr(preg_replace('/[^0-9]/', '', $kos->whatsapp), -4),
        ]);
    }

    public function getViewStats(Kos $kos, int $days = 30): array
    {
        $cacheKey = "kos_views_stats:{$kos->id}:{$days}";

        return Cache::remember($cacheKey, now()->addMinutes($this->cacheMinutes), function () use ($kos, $days) {
            $total = PropertyView::where('kos_id', $kos->id)->count();
            $thisMonth = PropertyView::where('kos_id', $kos->id)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count();
            $today = PropertyView::where('kos_id', $kos->id)
                ->whereDate('created_at', now()->toDateString())
                ->count();

            $dailyViews = PropertyView::where('kos_id', $kos->id)
                ->where('created_at', '>=', now()->subDays($days))
                ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->groupBy('date')
                ->pluck('count', 'date')
                ->toArray();

            return [
                'total' => $total,
                'this_month' => $thisMonth,
                'today' => $today,
                'daily' => $dailyViews,
            ];
        });
    }

    public function getFavoriteStats(Kos $kos): array
    {
        $cacheKey = "kos_favorite_stats:{$kos->id}";

        return Cache::remember($cacheKey, now()->addMinutes($this->cacheMinutes), function () use ($kos) {
            return [
                'total' => PropertyFavorite::where('kos_id', $kos->id)->count(),
                'this_month' => PropertyFavorite::where('kos_id', $kos->id)
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->count(),
            ];
        });
    }

    public function getWhatsappClickStats(Kos $kos): array
    {
        $cacheKey = "kos_whatsapp_stats:{$kos->id}";

        return Cache::remember($cacheKey, now()->addMinutes($this->cacheMinutes), function () use ($kos) {
            return [
                'total' => WhatsappClick::where('kos_id', $kos->id)->count(),
                'this_month' => WhatsappClick::where('kos_id', $kos->id)
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->count(),
            ];
        });
    }

    public function getOwnerAnalytics(User $owner, int $days = 30): array
    {
        $kosIds = $owner->kos()->pluck('id');

        $views = PropertyView::whereIn('kos_id', $kosIds)
            ->where('created_at', '>=', now()->subDays($days))
            ->count();

        $favorites = PropertyFavorite::whereIn('kos_id', $kosIds)
            ->where('created_at', '>=', now()->subDays($days))
            ->count();

        $whatsappClicks = WhatsappClick::whereIn('kos_id', $kosIds)
            ->where('created_at', '>=', now()->subDays($days))
            ->count();

        return [
            'views' => $views,
            'favorites' => $favorites,
            'whatsapp_clicks' => $whatsappClicks,
        ];
    }

    public function getTopPerformingKos(User $owner, string $metric = 'views', int $limit = 5): \Illuminate\Support\Collection
    {
        $kosIds = $owner->kos()->pluck('id');
        $since = now()->subDays(30);

        return match ($metric) {
            'views' => Kos::whereIn('id', $kosIds)
                ->withCount(['propertyViews as view_count' => fn($q) => $q->where('created_at', '>=', $since)])
                ->orderByDesc('view_count')
                ->limit($limit)
                ->get(['id', 'name', 'view_count']),

            'favorites' => Kos::whereIn('id', $kosIds)
                ->withCount(['propertyFavorites as favorite_count' => fn($q) => $q->where('created_at', '>=', $since)])
                ->orderByDesc('favorite_count')
                ->limit($limit)
                ->get(['id', 'name', 'favorite_count']),

            'whatsapp' => Kos::whereIn('id', $kosIds)
                ->withCount(['whatsappClicks as whatsapp_count' => fn($q) => $q->where('created_at', '>=', $since)])
                ->orderByDesc('whatsapp_count')
                ->limit($limit)
                ->get(['id', 'name', 'whatsapp_count']),

            default => collect(),
        };
    }
}
