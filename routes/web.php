<?php

use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\KosController;
use App\Http\Controllers\Web\ReviewController;
use App\Http\Controllers\Web\LeadController;
use App\Http\Controllers\Web\ReportController;
use App\Http\Controllers\Owner\DashboardController;
use App\Http\Controllers\Owner\NotificationController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Mahasiswa\KosController as MahasiswaKosController;
use App\Http\Controllers\Mahasiswa\ProfileController as MahasiswaProfileController;
use App\Http\Controllers\Admin\KosController as AdminKosController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\AdController as AdminAdController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (Guest-Only - Redirect Authenticated Users)
|--------------------------------------------------------------------------
*/
Route::middleware('guest_guard')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/kos', [KosController::class, 'index'])->name('kos.index');
    Route::get('/kos/{slug}', [KosController::class, 'show'])->name('kos.show');
    Route::get('/presence/owner/{user}', function (User $user) {
        return response()->json([
            'is_online' => (bool) $user->is_online,
            'last_seen_at' => $user->last_seen_at?->toIso8601String(),
            'name' => $user->name,
        ]);
    })->name('owner.presence.show');
});

/*
|--------------------------------------------------------------------------
| Lead Tracking Routes
|--------------------------------------------------------------------------
*/
Route::post('/lead/track', [LeadController::class, 'track'])->name('lead.track');
Route::get('/lead/{slug}', [LeadController::class, 'redirect'])->name('lead.redirect');

/*
|--------------------------------------------------------------------------
| Guest Routes (No Login Required - Redirect Authenticated Users)
|--------------------------------------------------------------------------
*/
Route::middleware('guest_guard')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password/{token}', [NewPasswordController::class, 'store'])->name('password.update');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Email Verification
    Route::get('/mahasiswa/verify-email', [EmailVerificationPromptController::class, '__invoke'])->name('verification.notice');
    Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])->name('verification.verify');
    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->name('verification.send');

    // Confirm Password
    Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
    Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store']);

    // Logout
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout.get');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | Review Routes (Authenticated Users - No Email Verification Required)
    |--------------------------------------------------------------------------
    */
    // Route review telah dipindah ke dalam grup mahasiswa
    Route::post('/reviews/{review}/helpful', [ReviewController::class, 'helpful'])->name('reviews.helpful');
    Route::post('/reviews/{review}/report', [ReviewController::class, 'report'])->name('reviews.report');

    /*
    |--------------------------------------------------------------------------
    | Mahasiswa Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:mahasiswa'])->group(function () {
        Route::get('/mahasiswa/kos/{id}/review', [ReviewController::class, 'create'])->name('student.kos.review.create');
        Route::post('/mahasiswa/kos/{id}/review', [ReviewController::class, 'store'])->name('student.kos.review.store');
        Route::get('/mahasiswa', [MahasiswaKosController::class, 'dashboard'])->name('student.dashboard');
        Route::get('/mahasiswa/booking', [MahasiswaKosController::class, 'bookings'])->name('student.booking');
        Route::get('/mahasiswa/review', [MahasiswaKosController::class, 'reviews'])->name('student.review');
        Route::get('/mahasiswa/kos', [MahasiswaKosController::class, 'index'])->name('student.kos');
        Route::get('/mahasiswa/kos/{slug}', [MahasiswaKosController::class, 'show'])->name('student.kos.show');
        Route::get('/mahasiswa/profil', [MahasiswaProfileController::class, 'index'])->name('mahasiswa.profil');
        Route::post('/mahasiswa/favorite/{kos}', [MahasiswaProfileController::class, 'addFavorite'])->name('mahasiswa.favorite.add');
        Route::delete('/mahasiswa/favorite/{kos}', [MahasiswaProfileController::class, 'removeFavorite'])->name('mahasiswa.favorite.remove');
        Route::get('/booking/{slug}', [KosController::class, 'booking'])->name('booking');
        Route::post('/booking/{slug}', [KosController::class, 'bookingStore'])->name('booking.store');
    });

    /*
    |--------------------------------------------------------------------------
    | Owner Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:owner'])->prefix('owner')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('owner.dashboard');
        Route::redirect('/dashboard', '/owner')->name('dashboard');

        Route::get('/properti', [DashboardController::class, 'kosIndex'])->name('dashboard.properti');
        Route::get('/properti/kos/{slug}', [App\Http\Controllers\Web\KosController::class, 'show'])->name('dashboard.kos.show');
        Route::get('/kos/create', [DashboardController::class, 'kosCreate'])->name('dashboard.kos.create');
        Route::post('/kos', [DashboardController::class, 'store'])->name('dashboard.kos.store');
        Route::get('/kos/{kos}/edit', [DashboardController::class, 'kosEdit'])->name('dashboard.kos.edit');
        Route::put('/kos/{kos}', [DashboardController::class, 'kosUpdate'])->name('dashboard.kos.update');
        Route::delete('/kos/{kos}', [DashboardController::class, 'kosDestroy'])->name('dashboard.kos.destroy');
        Route::post('/kos/{kos}/toggle', [DashboardController::class, 'kosToggleStatus'])->name('dashboard.kos.toggle');
        Route::get('/kos/{kos}/leads', [DashboardController::class, 'leadStats'])->name('dashboard.kos.leads');

        Route::get('/booking', [DashboardController::class, 'bookingIndex'])->name('dashboard.booking');
        Route::post('/booking/{booking}/status', [DashboardController::class, 'bookingUpdateStatus'])->name('dashboard.booking.status');
        Route::view('/pengaturan', 'pengaturanAkun')->name('dashboard.pengaturan');
        Route::get('/notifikasi', [NotificationController::class, 'index'])->name('dashboard.notifikasi');
        Route::get('/notifikasi/{notification}/open', [NotificationController::class, 'open'])->name('dashboard.notifikasi.open');
        Route::post('/notifikasi/{notification}/read', [NotificationController::class, 'markAsRead'])->name('dashboard.notifikasi.read');
        Route::post('/notifikasi/read-all', [NotificationController::class, 'markAllAsRead'])->name('dashboard.notifikasi.read-all');
        Route::delete('/notifikasi/clear-all', [NotificationController::class, 'clearAll'])->name('dashboard.notifikasi.clear-all');
        Route::delete('/notifikasi/{notification}', [NotificationController::class, 'destroy'])->name('dashboard.notifikasi.destroy');
        Route::post('/presence/heartbeat', [DashboardController::class, 'heartbeat'])->name('dashboard.presence.heartbeat');

        Route::get('/tambah-properti', fn() => redirect()->route('dashboard.kos.create'))->name('dashboard.tambah-properti');
    });

    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('admin');
        Route::redirect('/admin-panel', '/admin')->name('admin.dashboard');

        // Kos Management
        Route::get('/kos', [AdminKosController::class, 'index'])->name('admin.kos');
        Route::get('/verifikasi', [AdminKosController::class, 'index'])->name('admin.verifikasi');
        Route::post('/kos/{kos}/approve', [AdminKosController::class, 'approve'])->name('admin.kos.approve');
        Route::post('/kos/{kos}/reject', [AdminKosController::class, 'reject'])->name('admin.kos.reject');
        Route::post('/kos/{kos}/premium', [AdminKosController::class, 'togglePremium'])->name('admin.kos.premium');

        // Review Moderation
        Route::get('/moderasi', [AdminReviewController::class, 'index'])->name('admin.moderasi');
        Route::post('/reviews/{review}/approve', [AdminReviewController::class, 'approve'])->name('admin.reviews.approve');
        Route::post('/reviews/{review}/reject', [AdminReviewController::class, 'reject'])->name('admin.reviews.reject');
        Route::post('/reviews/{review}/hide', [AdminReviewController::class, 'hide'])->name('admin.reviews.hide');
        Route::post('/reviews/{review}/unflag', [AdminReviewController::class, 'unflag'])->name('admin.reviews.unflag');
        Route::delete('/reviews/{review}', [AdminReviewController::class, 'destroy'])->name('admin.reviews.destroy');

        // Ad Management
        Route::get('/iklan', [AdminAdController::class, 'index'])->name('admin.iklan');
        Route::post('/iklan/{ad}/approve', [AdminAdController::class, 'approve'])->name('admin.iklan.approve');
        Route::post('/iklan/{ad}/reject', [AdminAdController::class, 'reject'])->name('admin.iklan.reject');

        // User Management
        Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users');
        Route::post('/users/{user}/toggle', [AdminUserController::class, 'toggleActive'])->name('admin.users.toggle');
        Route::post('/users/{user}/role', [AdminUserController::class, 'updateRole'])->name('admin.users.role');

        // Reports
        Route::get('/reports', [ReportController::class, 'index'])->name('admin.reports');
        Route::post('/reports/{report}/resolve', [ReportController::class, 'resolve'])->name('admin.reports.resolve');
        Route::post('/reports/{report}/dismiss', [ReportController::class, 'dismiss'])->name('admin.reports.dismiss');
    });
});

/*
|--------------------------------------------------------------------------
| Public Routes (Guest-Only - Redirect Authenticated Users)
|--------------------------------------------------------------------------
*/
Route::middleware('guest_guard')->group(function () {
    Route::view('/bantuan', 'bantuanDanFaq')->name('bantuan');
    Route::view('/bantuan/panduan', 'guide')->name('guide');
    Route::view('/bantuan/kebijakan-privasi', 'privacy')->name('privacy');
    Route::view('/bantuan/syarat-dan-ketentuan', 'terms')->name('terms');
    Route::view('/bantuan/layanan-galon', 'layananGalon')->name('layanan-galon');
    Route::view('/partner/{slug}', 'detailPartner')->name('detail-partner');
});

/*
|--------------------------------------------------------------------------
| Report Routes (Public)
|--------------------------------------------------------------------------
*/
Route::post('/report', [ReportController::class, 'store'])->name('report.submit');

/*
|--------------------------------------------------------------------------
| Redirect Routes
|--------------------------------------------------------------------------
*/
Route::get('/cari-kos', fn() => redirect()->route('kos.index'))->name('cari-kos');
Route::get('/detail-kos/{slug}', fn(string $slug) => redirect()->route('kos.show', ['slug' => $slug]))->name('detail-kos');
Route::get('/admin/reports', fn() => redirect()->route('admin'))->name('admin.reports');
