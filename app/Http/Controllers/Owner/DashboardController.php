<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreKosRequest;
use App\Http\Requests\UpdateKosRequest;
use App\Models\Booking;
use App\Models\Facility;
use App\Models\Kos;
use App\Models\Lead;
use App\Models\Review;
use App\Notifications\LeadQuotaWarningNotification;
use App\Services\NotificationService;
use App\Services\KosService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{
    protected int $freeQuotaLimit = 20;

    public function __construct(
        protected KosService $kosService
    ) {}

    public function index(Request $request)
    {
        $owner = Auth::user();
        $kosList = $owner->kos()
            ->with('photos')
            ->withCount([
                'bookings',
                'reviews',
                'leads as leads_this_month_count' => fn ($query) => $query->thisMonth(),
            ])
            ->withAvg('reviews as avg_rating', 'rating')
            ->get();

        $kosWithStats = $kosList;

        $ownerKosIds = $kosList->pluck('id')->all();

        $totalLeads = Lead::whereIn('kos_id', $ownerKosIds)
            ->thisMonth()
            ->count();

        $todayLeads = Lead::whereIn('kos_id', $ownerKosIds)
            ->today()
            ->count();

        $weekLeads = Lead::whereIn('kos_id', $ownerKosIds)
            ->thisWeek()
            ->count();

        $totalBookings = Booking::whereHas('kos', fn ($query) => $query->where('user_id', $owner->id))
            ->count();

        $totalReviews = Review::whereHas('kos', fn ($query) => $query->where('user_id', $owner->id))
            ->count();

        $activeKosCount = $kosList->where('status', 'active')->count();
        $premiumKosCount = $kosList->where('is_premium', true)->count();
        $recentBookings = Booking::with([
                'mahasiswa:id,name,university,avatar',
                'kos:id,name',
            ])
            ->whereHas('kos', fn ($query) => $query->where('user_id', $owner->id))
            ->latest()
            ->limit(4)
            ->get();

        $recentReviews = Review::with([
                'user:id,name,avatar',
                'kos:id,name',
            ])
            ->whereHas('kos', fn ($query) => $query->where('user_id', $owner->id))
            ->latest()
            ->limit(4)
            ->get();

        $recentActivities = collect()
            ->merge($recentBookings->map(function (Booking $booking) {
                return [
                    'created_at' => $booking->created_at,
                    'icon' => 'booking',
                    'title' => 'Booking baru dari ' . ($booking->mahasiswa?->name ?? 'Mahasiswa'),
                    'message' => ($booking->kos?->name ?? 'Kos') . ' • ' . ($booking->move_in_date?->format('d M Y') ?? 'Tanggal belum diisi'),
                    'time' => $booking->created_at?->diffForHumans(),
                ];
            }))
            ->merge($recentLeads = Lead::whereIn('kos_id', $ownerKosIds)
                ->with(['kos:id,name', 'user:id,name,avatar'])
                ->latest()
                ->limit(4)
                ->get()
                ->map(function (Lead $lead) {
                    return [
                        'created_at' => $lead->created_at,
                        'icon' => 'lead',
                        'title' => 'Lead baru untuk ' . ($lead->kos?->name ?? 'Kos'),
                        'message' => $lead->user?->name ?? 'Pengunjung',
                        'time' => $lead->created_at?->diffForHumans(),
                    ];
                }))
            ->merge($recentReviews->map(function (Review $review) {
                return [
                    'created_at' => $review->created_at,
                    'icon' => 'review',
                    'title' => 'Review ' . ($review->rating ?? 0) . ' bintang untuk ' . ($review->kos?->name ?? 'Kos'),
                    'message' => Str::limit($review->comment ?? 'Tidak ada komentar.', 80),
                    'time' => $review->created_at?->diffForHumans(),
                ];
            }))
            ->sortByDesc('created_at')
            ->take(6)
            ->values();

        foreach ($kosWithStats as $kos) {
            if (!$kos->is_premium && (int) ($kos->leads_this_month_count ?? 0) >= $this->freeQuotaLimit) {
                $cacheKey = "quota_warning_sent:{$kos->id}";
                if (!Cache::has($cacheKey)) {
                    $owner->notify(new LeadQuotaWarningNotification($kos, (int) ($kos->leads_this_month_count ?? 0), $this->freeQuotaLimit));
                    Cache::put($cacheKey, true, now()->addDays(7));
                }
            }
        }

        $freeQuotaLimit = $this->freeQuotaLimit;

        return view('dashboardPemilikKos', compact(
            'kosList',
            'totalLeads',
            'todayLeads',
            'weekLeads',
            'totalBookings',
            'totalReviews',
            'activeKosCount',
            'premiumKosCount',
            'recentActivities',
            'kosWithStats',
            'freeQuotaLimit'
        ));
    }

    public function kosIndex()
    {
        $request = request();
        $kosTarget = $request->input('kos');
        $search = trim((string) $request->input('search'));

        $query = Auth::user()
            ->kos()
            ->with(['photos', 'facilities'])
            ->withCount(['bookings', 'reviews'])
            ->withAvg('reviews as avg_rating', 'rating');

        if ($kosTarget) {
            $query->where(function ($kosQuery) use ($kosTarget) {
                if (is_numeric($kosTarget)) {
                    $kosQuery->whereKey((int) $kosTarget);
                } else {
                    $kosQuery->where('slug', $kosTarget);
                }
            });
        }

        if ($search !== '') {
            $query->where(function ($kosQuery) use ($search) {
                $kosQuery->where('name', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%");
            });
        }

        $kosList = $query->get();
        return view('propertiPemilikKos', compact('kosList'));
    }

    public function kosCreate()
    {
        return view('tambahPropertiKos');
    }

    public function store(Request $request)
    {
        $request->merge([
            'price' => (int) preg_replace('/\D+/', '', (string) $request->input('price')),
            'latitude' => $request->filled('latitude') ? (float) str_replace(',', '.', (string) $request->input('latitude')) : null,
            'longitude' => $request->filled('longitude') ? (float) str_replace(',', '.', (string) $request->input('longitude')) : null,
            'whatsapp' => trim((string) ($request->input('whatsapp') ?: $request->user()?->phone)),
        ]);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('kos', 'name')->where(fn ($query) => $query->where('user_id', Auth::id())),
            ],
            'address' => ['required', 'string', 'max:500'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'price' => ['required', 'integer', 'min:100000', 'max:50000000'],
            'gender' => ['required', Rule::in(Kos::$genders)],
            'description' => ['nullable', 'string', 'max:1000'],
            'whatsapp' => ['required', 'string', 'max:20'],
            'phone' => ['nullable', 'string', 'max:20'],
            'facilities' => ['nullable', 'array'],
            'facilities.*' => ['nullable', 'string', 'max:50'],
            'photos' => ['nullable', 'array', 'max:10'],
            'photos.*' => ['image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ], [
            'whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
            'photos.max' => 'Maksimal 10 foto.',
            'photos.*.image' => 'File harus berupa gambar.',
            'photos.*.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau webp.',
            'photos.*.max' => 'Ukuran foto maksimal 2MB.',
        ]);

        $facilityIds = $this->resolveFacilityIds($validated['facilities'] ?? [])
            ->filter()
            ->values()
            ->all();

        $uploadedPhotoPaths = [];
        $kos = null;

        try {
            $kos = DB::transaction(function () use ($validated, $facilityIds, $request, &$uploadedPhotoPaths) {
                $kos = Kos::create([
                    'user_id' => Auth::id(),
                    'name' => $validated['name'],
                    'address' => $validated['address'],
                    'latitude' => $validated['latitude'] ?? null,
                    'longitude' => $validated['longitude'] ?? null,
                    'price' => $validated['price'],
                    'gender' => $validated['gender'],
                    'description' => $validated['description'] ?? null,
                    'whatsapp' => $validated['whatsapp'],
                    'phone' => $validated['phone'] ?? null,
                    'status' => 'pending', // Pending verification by admin
                    'is_active' => false, // Not visible until approved
                ]);

                foreach ($request->file('photos', []) as $index => $photo) {
                    $path = $photo->store('kos-photos', 'public');
                    $uploadedPhotoPaths[] = $path;

                    $kos->photos()->create([
                        'url' => $path,
                        'order' => $index,
                        'is_primary' => $index === 0,
                    ]);
                }

                $kos->facilities()->sync($facilityIds);

                return $kos->load(['photos', 'facilities']);
            });
        } catch (\Throwable $throwable) {
            foreach ($uploadedPhotoPaths as $path) {
                Storage::disk('public')->delete($path);
            }

            throw $throwable;
        }

        Cache::flush();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Kos berhasil ditambahkan dan menunggu verifikasi dari admin!',
                'redirect' => route('dashboard.properti'),
            ]);
        }

        return redirect()
            ->route('dashboard.properti')
            ->with('success', 'Kos berhasil ditambahkan! Saat ini menunggu verifikasi dari admin sebelum bisa dilihat mahasiswa.');
    }

    protected function resolveFacilityIds(array $selectedFacilities): \Illuminate\Support\Collection
    {
        $facilityDefinitions = [
            'wifi' => ['slug' => 'wifi', 'name' => 'WiFi'],
            'ac' => ['slug' => 'ac', 'name' => 'AC'],
            'km-dalam' => ['slug' => 'bathroom_in', 'name' => 'Kamar Mandi Dalam'],
            'bathroom-in' => ['slug' => 'bathroom_in', 'name' => 'Kamar Mandi Dalam'],
            'kasur' => ['slug' => 'bed', 'name' => 'Spring Bed'],
            'lemari' => ['slug' => 'wardrobe', 'name' => 'Lemari Pakaian'],
            'parkir' => ['slug' => 'parking_motor', 'name' => 'Parkir Motor'],
            'parkir-motor' => ['slug' => 'parking_motor', 'name' => 'Parkir Motor'],
            'parkir-mobil' => ['slug' => 'parking_car', 'name' => 'Parkir Mobil'],
            'dapur' => ['slug' => 'kitchen', 'name' => 'Dapur'],
            'cctv' => ['slug' => 'cctv', 'name' => 'CCTV'],
            'laundry' => ['slug' => 'laundry', 'name' => 'Laundry'],
            'listrik' => ['slug' => 'electricity_token', 'name' => 'Listrik Token'],
            'air' => ['slug' => 'water_supply', 'name' => 'Air PAM + Galon'],
            'keamanan' => ['slug' => 'security', 'name' => 'Keamanan 24 Jam'],
            '24-jam' => ['slug' => '24_hour', 'name' => 'Akses 24 Jam'],
        ];

        $facilityIds = collect();

        $numericIds = collect($selectedFacilities)
            ->filter(fn ($value) => is_numeric($value))
            ->map(fn ($value) => (int) $value)
            ->values();

        if ($numericIds->isNotEmpty()) {
            $facilityIds = $facilityIds->merge(
                Facility::query()
                    ->whereIn('id', $numericIds->all())
                    ->pluck('id')
            );
        }

        $definitions = collect($selectedFacilities)
            ->map(function ($facility) use ($facilityDefinitions) {
                $facility = trim((string) $facility);

                if ($facility === '' || is_numeric($facility)) {
                    return null;
                }

                return $facilityDefinitions[$facility] ?? null;
            })
            ->filter(fn ($value) => is_array($value))
            ->values();

        if ($definitions->isNotEmpty()) {
            foreach ($definitions as $definition) {
                $facility = Facility::firstOrCreate(
                    ['slug' => $definition['slug']],
                    ['name' => $definition['name'], 'icon' => null]
                );

                $facilityIds->push($facility->id);
            }
        }

        return $facilityIds->unique()->values();
    }

    public function kosStore(StoreKosRequest $request)
    {
        return $this->store($request);
    }

    public function kosEdit(Kos $kos)
    {
        $this->authorize('update', $kos);

        $kos->load(['photos', 'facilities']);
        return view('tambahPropertiKos', compact('kos'));
    }

    public function kosUpdate(UpdateKosRequest $request, Kos $kos)
    {
        $this->authorize('update', $kos);

        $validated = $request->validated();

        $validated['facilities'] = $this->resolveFacilityIds($request->input('facilities') ?? [])
            ->filter()
            ->values()
            ->all();

        $this->kosService->updateKos($kos, $validated);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Perubahan berhasil disimpan!',
                'redirect' => route('dashboard.properti'),
            ]);
        }

        return redirect()
            ->back()
            ->with('success', 'Perubahan berhasil disimpan!');
    }

    public function kosDestroy(Kos $kos)
    {
        $this->authorize('delete', $kos);

        $this->kosService->deleteKos($kos);

        return redirect()
            ->route('dashboard.properti')
            ->with('success', 'Kos berhasil dihapus.');
    }

    public function kosToggleStatus(Kos $kos)
    {
        $this->authorize('update', $kos);

        $this->kosService->toggleStatus($kos);

        return redirect()
            ->back()
            ->with('success', 'Status kos berhasil diperbarui.');
    }

    public function leadStats(Request $request, Kos $kos)
    {
        $this->authorize('viewLeads', $kos);

        $days = (int) $request->input('days', 30);
        $dailyCounts = Lead::getDailyCounts($kos->id, $days);

        return response()->json([
            'kos_id' => $kos->id,
            'kos_name' => $kos->name,
            'daily_counts' => $dailyCounts,
            'total' => array_sum($dailyCounts),
            'days' => $days,
        ]);
    }

    public function bookingIndex(Request $request)
    {
        $status = $request->input('status');
        $search = trim((string) $request->input('search'));
        $bookingTarget = $request->input('booking');

        $query = Booking::with([
                'mahasiswa:id,name,email,phone,university,avatar',
                'kos.photos' => fn ($relation) => $relation->orderBy('order'),
                'kos.owner:id,name,phone',
            ])
            ->whereHas('kos', fn ($relation) => $relation->where('user_id', Auth::id()))
            ->latest();

        if ($bookingTarget) {
            $query->whereKey((int) $bookingTarget);
        }

        if ($status && in_array($status, ['pending', 'approved', 'rejected'], true)) {
            $query->where('status', $status);
        }

        if ($search !== '') {
            $query->where(function ($relation) use ($search) {
                $relation->whereHas('mahasiswa', fn ($user) => $user->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('kos', fn ($kos) => $kos->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('mahasiswa', fn ($user) => $user->where('university', 'like', "%{$search}%"));
            });
        }

        $bookings = $query->get();

        $resolveImage = function (?string $path): string {
            $path = trim((string) $path);
            if ($path === '') return asset('images/hero-illustration.png');
            if (preg_match('/^(https?:|data:)/i', $path)) return $path;
            if (str_starts_with($path, '/')) return $path;
            return asset('storage/' . ltrim($path, '/'));
        };

        $bookingData = $bookings->map(function (Booking $booking) use ($resolveImage) {
            $kos = $booking->kos;
            $photo = $kos?->photos->first();
            $mahasiswa = $booking->mahasiswa;

            return [
                'id' => $booking->id,
                'nama' => $mahasiswa?->name ?? '-',
                'universitas' => $mahasiswa?->university ?? '-',
                'avatar' => $mahasiswa?->avatar
                    ? asset('storage/' . ltrim($mahasiswa->avatar, '/'))
                    : 'https://ui-avatars.com/api/?name=' . urlencode($mahasiswa?->name ?? 'Mahasiswa') . '&background=3B82F6&color=fff&size=96',
                'kos' => $kos?->name ?? '-',
                'kos_slug' => $kos?->slug,
                'kos_photo' => $resolveImage($photo?->url ?? null),
                'tanggal' => $booking->move_in_date?->format('d M Y') ?? '-',
                'durasi' => $booking->duration_months ? $booking->duration_months . ' bulan' : '-',
                'status' => $booking->status,
                'statusLabel' => match ($booking->status) {
                    'approved' => 'Diterima',
                    'rejected' => 'Ditolak',
                    default => 'Menunggu',
                },
                'phone' => $booking->phone ?: $mahasiswa?->phone ?: '',
                'university' => $booking->university ?: $mahasiswa?->university ?: '-',
                'created_at' => $booking->created_at?->format('d M Y H:i'),
                'rejection_reason' => $booking->rejection_reason,
            ];
        })->values();

        $counts = [
            'total' => $bookings->count(),
            'pending' => $bookings->where('status', 'pending')->count(),
            'approved' => $bookings->where('status', 'approved')->count(),
            'rejected' => $bookings->where('status', 'rejected')->count(),
        ];

        return view('kelolaBooking', [
            'bookings' => $bookings,
            'bookingData' => $bookingData,
            'counts' => $counts,
            'filters' => [
                'status' => $status,
                'search' => $search,
            ],
        ]);
    }

    public function bookingUpdateStatus(Request $request, Booking $booking, NotificationService $notificationService)
    {
        abort_unless($booking->kos && $booking->kos->user_id === Auth::id(), 403);

        $validated = $request->validate([
            'status' => ['required', Rule::in(['approved', 'rejected'])],
            'rejection_reason' => ['nullable', 'string', 'max:500'],
        ]);

        if ($validated['status'] === 'rejected' && empty($validated['rejection_reason'])) {
            return back()->withErrors(['rejection_reason' => 'Alasan penolakan wajib diisi.']);
        }

        if (!in_array($booking->status, ['pending', 'approved', 'rejected'], true)) {
            return back()->with('error', 'Booking sudah diproses.');
        }

        $booking->update([
            'status' => $validated['status'],
            'rejection_reason' => $validated['status'] === 'rejected' ? $validated['rejection_reason'] : null,
        ]);

        $notificationService->createNotification(
            $booking->mahasiswa,
            'booking_status',
            'Status Booking Diperbarui',
            'Booking untuk ' . ($booking->kos?->name ?? 'kos') . ' telah ' . ($validated['status'] === 'approved' ? 'diterima' : 'ditolak'),
            [
                'booking_id' => $booking->id,
                'kos_id' => $booking->kos_id,
                'status' => $validated['status'],
                'rejection_reason' => $validated['rejection_reason'] ?? null,
            ]
        );

        return back()->with('success', 'Status booking berhasil diperbarui.');
    }

    public function heartbeat(Request $request)
    {
        $user = $request->user();

        if ($user && $user->isOwner()) {
            $presenceUpdates = [];

            if (Schema::hasColumn($user->getTable(), 'last_seen_at')) {
                $presenceUpdates['last_seen_at'] = now();
            }

            if (!empty($presenceUpdates)) {
                $user->forceFill($presenceUpdates)->save();
            }
        }

        return response()->json([
            'ok' => true,
            'last_seen_at' => $user?->last_seen_at?->toIso8601String(),
            'is_online' => (bool) $user?->is_online,
        ]);
    }
}
