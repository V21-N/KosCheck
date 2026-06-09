<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Kos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display the mahasiswa profile page with booking history and favorites.
     */
    public function index()
    {
        $user = Auth::user();

        // Get recent booking history (latest 3)
        $recentBookings = Booking::with([
                'kos.photos' => fn ($query) => $query->orderBy('order'),
            ])
            ->where('user_id', $user->id)
            ->latest()
            ->limit(3)
            ->get();

        $recentBookingsData = $recentBookings->map(function (Booking $booking) {
            $kos = $booking->kos;
            $photo = $kos?->photos->first();

            return [
                'id' => $booking->id,
                'kos_slug' => $kos?->slug,
                'kos_name' => $kos?->name ?? 'Kos tidak ditemukan',
                'kos_address' => $kos?->address ?? '-',
                'photo' => $this->resolveImageUrl($photo?->url),
                'status' => $booking->status,
                'status_label' => $this->bookingStatusLabel($booking->status),
                'status_class' => $this->bookingStatusClass($booking->status),
                'move_in_date' => $booking->move_in_date?->format('d M Y'),
                'created_at' => $booking->created_at?->format('d M Y'),
            ];
        })->values();

        // Get favorite kos (latest 3)
        $favoriteKos = $user->favoriteKos()
            ->with(['photos' => fn ($query) => $query->orderBy('order')])
            ->latest('favorite_kos.created_at')
            ->limit(3)
            ->get();

        $favoriteKosData = $favoriteKos->map(function (Kos $kos) {
            $photo = $kos->photos->first();

            return [
                'slug' => $kos->slug,
                'name' => $kos->name,
                'address' => $kos->address,
                'price' => $kos->price,
                'photo' => $this->resolveImageUrl($photo?->url),
                'is_verified' => $kos->status === 'active' && $kos->is_active,
            ];
        })->values();

        return view('profilPengguna', [
            'recentBookings' => $recentBookings,
            'recentBookingsData' => $recentBookingsData,
            'favoriteKos' => $favoriteKos,
            'favoriteKosData' => $favoriteKosData,
            'bookingCounts' => [
                'total' => Booking::where('user_id', $user->id)->count(),
                'active' => Booking::where('user_id', $user->id)
                    ->whereIn('status', ['pending', 'approved'])
                    ->count(),
            ],
        ]);
    }

    /**
     * Add a kos to favorites.
     */
    public function addFavorite(Kos $kos, Request $request)
    {
        $user = Auth::user();

        if (!$user->favoriteKos()->where('kos_id', $kos->id)->exists()) {
            $user->favoriteKos()->attach($kos->id);
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['status' => 'success', 'message' => 'Kos ditambahkan ke favorit.']);
        }

        return back()->with('success', 'Kos ditambahkan ke favorit.');
    }

    /**
     * Remove a kos from favorites.
     */
    public function removeFavorite(Kos $kos, Request $request)
    {
        $user = Auth::user();
        $user->favoriteKos()->detach($kos->id);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['status' => 'success', 'message' => 'Kos dihapus dari favorit.']);
        }

        return back()->with('success', 'Kos dihapus dari favorit.');
    }

    protected function resolveImageUrl(?string $path): string
    {
        if (!$path) {
            return asset('images/hero-illustration.png');
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, 'data:')) {
            return $path;
        }

        if (str_starts_with($path, '/')) {
            return $path;
        }

        return asset('storage/' . ltrim($path, '/'));
    }

    protected function bookingStatusLabel(string $status): string
    {
        return match ($status) {
            'approved' => 'Aktif',
            'rejected' => 'Ditolak',
            default => 'Menunggu',
        };
    }

    protected function bookingStatusClass(string $status): string
    {
        return match ($status) {
            'approved' => 'bg-green-400 text-white',
            'rejected' => 'bg-red-400 text-white',
            default => 'bg-orange-400 text-white',
        };
    }
}