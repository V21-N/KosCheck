<?php

use App\Http\Controllers\Api\V1\AuthApiController;
use App\Http\Controllers\Api\V1\BookingApiController;
use App\Http\Controllers\Api\V1\KosApiController;
use App\Http\Controllers\Api\V1\LeadApiController;
use App\Http\Controllers\Api\V1\ReviewApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes (v1)
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Public Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('public')->group(function () {
        Route::get('/kos', [KosApiController::class, 'index'])->name('api.v1.kos.index');
        Route::get('/kos/search', [KosApiController::class, 'search'])->name('api.v1.kos.search');
        Route::get('/kos/featured', [KosApiController::class, 'featured'])->name('api.v1.kos.featured');
        Route::get('/kos/{slug}', [KosApiController::class, 'show'])->name('api.v1.kos.show');
        Route::get('/kos/{slug}/nearby', [KosApiController::class, 'nearby'])->name('api.v1.kos.nearby');
        Route::get('/kos/{slug}/reviews', [ReviewApiController::class, 'index'])->name('api.v1.reviews.index');

        Route::get('/stats', [KosApiController::class, 'stats'])->name('api.v1.stats');
    });

    /*
    |--------------------------------------------------------------------------
    | Authentication Routes (Public)
    |--------------------------------------------------------------------------
    */
    Route::prefix('auth')->group(function () {
        Route::post('/login', [AuthApiController::class, 'login'])->name('api.v1.auth.login');
        Route::post('/register', [AuthApiController::class, 'register'])->name('api.v1.auth.register');
    });

    /*
    |--------------------------------------------------------------------------
    | Authenticated Routes (Sanctum)
    |--------------------------------------------------------------------------
    */
    Route::middleware('auth:sanctum')->group(function () {
        // Authentication
        Route::prefix('auth')->group(function () {
            Route::post('/logout', [AuthApiController::class, 'logout'])->name('api.v1.auth.logout');
            Route::post('/logout-all', [AuthApiController::class, 'logoutAll'])->name('api.v1.auth.logout-all');
            Route::post('/refresh', [AuthApiController::class, 'refreshToken'])->name('api.v1.auth.refresh');
            Route::get('/me', [AuthApiController::class, 'me'])->name('api.v1.auth.me');
            Route::put('/profile', [AuthApiController::class, 'updateProfile'])->name('api.v1.auth.profile');
            Route::post('/password', [AuthApiController::class, 'changePassword'])->name('api.v1.auth.password');
            Route::get('/tokens', [AuthApiController::class, 'tokens'])->name('api.v1.auth.tokens');
            Route::delete('/tokens/{tokenId}', [AuthApiController::class, 'revokeToken'])->name('api.v1.auth.tokens.revoke');
        });

        // Reviews (Authenticated)
        Route::post('/kos/{slug}/reviews', [ReviewApiController::class, 'store'])->name('api.v1.reviews.store');
        Route::get('/reviews/me', [ReviewApiController::class, 'myReviews'])->name('api.v1.reviews.mine');
        Route::post('/reviews/{id}/helpful', [ReviewApiController::class, 'helpful'])->name('api.v1.reviews.helpful');

        // Lead Tracking (Authenticated)
        Route::post('/leads', [LeadApiController::class, 'store'])->name('api.v1.leads.store');
        Route::get('/leads', [LeadApiController::class, 'index'])->name('api.v1.leads.index');

        // Bookings (Mahasiswa)
        Route::post('/student/booking', [BookingApiController::class, 'store'])->name('api.v1.student.booking.store');
        Route::get('/student/bookings', [BookingApiController::class, 'myBookings'])->name('api.v1.student.bookings');

        /*
        |--------------------------------------------------------------------------
        | Owner Routes
        |--------------------------------------------------------------------------
        */
        Route::middleware('role:owner')->group(function () {
            Route::get('/owner/leads', [LeadApiController::class, 'index'])->name('api.v1.owner.leads');
            Route::get('/owner/kos/{id}/leads/stats', [LeadApiController::class, 'stats'])->name('api.v1.owner.kos.leads.stats');
            Route::post('/owner/leads/{id}/converted', [LeadApiController::class, 'markConverted'])->name('api.v1.owner.leads.converted');

            // Owner Bookings
            Route::get('/owner/bookings', [BookingApiController::class, 'ownerIndex'])->name('api.v1.owner.bookings');
            Route::put('/owner/bookings/{id}/status', [BookingApiController::class, 'updateStatus'])->name('api.v1.owner.bookings.status');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function () {
        Route::get('/leads', [LeadApiController::class, 'index'])->name('api.v1.admin.leads');
        Route::get('/leads/{id}', [LeadApiController::class, 'show'])->name('api.v1.admin.leads.show');
        Route::post('/leads/{id}/converted', [LeadApiController::class, 'markConverted'])->name('api.v1.admin.leads.converted');

        // Admin Bookings
        Route::get('/bookings', [BookingApiController::class, 'adminIndex'])->name('api.v1.admin.bookings');
        Route::get('/bookings/stats', [BookingApiController::class, 'stats'])->name('api.v1.admin.bookings.stats');
    });
});
