<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\AppNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $typeLabels = [
            'booking' => 'Booking Baru',
            'new_lead' => 'Lead Baru',
            'new_review' => 'Review Baru',
            'booking_status' => 'Status Booking',
            'review_reported' => 'Review Dilaporkan',
            'system' => 'Sistem',
        ];

        $filter = (string) $request->input('type', 'all');
        $allowedFilters = array_merge(['all', 'unread'], array_keys($typeLabels));

        if (!in_array($filter, $allowedFilters, true)) {
            $filter = 'all';
        }

        $baseQuery = $user->notifications();

        $notifications = (clone $baseQuery)
            ->when($filter === 'unread', fn ($query) => $query->unread())
            ->when($filter !== 'all' && $filter !== 'unread', fn ($query) => $query->byType($filter))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $typeCounts = (clone $baseQuery)
            ->selectRaw('type, COUNT(*) as total')
            ->groupBy('type')
            ->pluck('total', 'type');

        $totalCount = (clone $baseQuery)->count();
        $unreadCount = (clone $baseQuery)->unread()->count();

        return view('notifikasiOwner', compact(
            'notifications',
            'filter',
            'typeLabels',
            'typeCounts',
            'totalCount',
            'unreadCount'
        ));
    }

    public function open(AppNotification $notification)
    {
        abort_unless($notification->user_id === Auth::id(), 403);

        $notification->markAsRead();

        return redirect()
            ->to($this->targetUrl($notification))
            ->with('success', 'Notifikasi dibuka dan ditandai sudah dibaca.');
    }

    public function markAsRead(AppNotification $notification)
    {
        abort_unless($notification->user_id === Auth::id(), 403);

        $notification->markAsRead();

        return back()->with('success', 'Notifikasi ditandai sudah dibaca.');
    }

    public function markAllAsRead()
    {
        Auth::user()->notifications()->unread()->update([
            'is_read' => true,
            'read_at' => now(),
        ]);

        return redirect()
            ->back()
            ->with('success', 'Semua notifikasi berhasil ditandai dibaca.');
    }

    public function clearAll()
    {
        Auth::user()->notifications()->delete();

        return redirect()
            ->back()
            ->with('success', 'Semua notifikasi berhasil dihapus.');
    }

    public function destroy(AppNotification $notification)
    {
        abort_unless($notification->user_id === Auth::id(), 403);

        $notification->delete();

        return redirect()->back()->with('success', 'Notifikasi berhasil dihapus.');
    }

    private function targetUrl(AppNotification $notification): string
    {
        return match ($notification->type) {
            'booking' => route('dashboard.booking', array_filter([
                'booking' => data_get($notification->data, 'booking_id'),
                'status' => data_get($notification->data, 'status'),
            ])),
            'booking_status' => route('dashboard.booking', array_filter([
                'booking' => data_get($notification->data, 'booking_id'),
                'status' => data_get($notification->data, 'status'),
            ])),
            'new_lead', 'new_review', 'review_reported' => route('dashboard.properti', array_filter([
                'kos' => data_get($notification->data, 'kos_id'),
            ])),
            default => route('dashboard.notifikasi', array_filter([
                'type' => $notification->type,
            ])),
        };
    }
}
