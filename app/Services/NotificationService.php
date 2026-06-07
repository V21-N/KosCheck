<?php

namespace App\Services;

use App\Models\AppNotification;
use App\Models\User;
use Illuminate\Support\Collection;

class NotificationService
{
    public function getUnreadNotifications(User $user, int $limit = 20): Collection
    {
        return AppNotification::where('user_id', $user->id)
            ->unread()
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function getAllNotifications(User $user, int $limit = 50): Collection
    {
        return AppNotification::where('user_id', $user->id)
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function getUnreadCount(User $user): int
    {
        return AppNotification::where('user_id', $user->id)
            ->unread()
            ->count();
    }

    public function markAsRead(AppNotification $notification): void
    {
        $notification->markAsRead();
    }

    public function markAsUnread(AppNotification $notification): void
    {
        $notification->markAsUnread();
    }

    public function markAllAsRead(User $user): int
    {
        return AppNotification::where('user_id', $user->id)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
    }

    public function delete(AppNotification $notification): void
    {
        $notification->delete();
    }

    public function deleteOld(User $user, int $daysOld = 30): int
    {
        return AppNotification::where('user_id', $user->id)
            ->where('created_at', '<', now()->subDays($daysOld))
            ->delete();
    }

    public function createNotification(
        User $user,
        string $type,
        string $title,
        string $message,
        array $data = []
    ): AppNotification {
        return AppNotification::createForUser(
            $user->id,
            $type,
            $title,
            $message,
            $data
        );
    }

    public function getNotificationsByType(User $user, string $type, int $limit = 20): Collection
    {
        return AppNotification::where('user_id', $user->id)
            ->byType($type)
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function getRecentActivity(User $user, int $limit = 10): Collection
    {
        return AppNotification::where('user_id', $user->id)
            ->latest()
            ->limit($limit)
            ->get()
            ->groupBy(function ($notification) {
                return $notification->created_at->toDateString();
            })
            ->take($limit);
    }

    public function hasUnreadNotification(User $user, string $type): bool
    {
        return AppNotification::where('user_id', $user->id)
            ->unread()
            ->byType($type)
            ->exists();
    }

    public function getUnreadByType(User $user): array
    {
        $notifications = AppNotification::where('user_id', $user->id)
            ->unread()
            ->get()
            ->groupBy('type')
            ->map->count()
            ->toArray();

        return $notifications;
    }
}