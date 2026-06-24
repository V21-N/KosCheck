<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Schema;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'university',
        'phone',
        'address',
        'avatar',
        // Google OAuth fields
        'google_id',
        'google_token',
        'google_refresh_token',
        'google_avatar_fetched',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
        'last_seen_at' => 'datetime',
        'is_premium' => 'boolean',
        'premium_started_at' => 'datetime',
        'premium_expired_at' => 'datetime',
    ];

    public function kos(): HasMany
    {
        return $this->hasMany(Kos::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(AppNotification::class);
    }

    public function localBusiness()
    {
        return $this->hasOne(LocalBusiness::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function favoriteKos(): BelongsToMany
    {
        return $this->belongsToMany(Kos::class, 'favorite_kos')->withTimestamps();
    }

    // KosCheck+ Premium Relationships
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function activeSubscription(): HasMany
    {
        return $this->hasMany(Subscription::class)
            ->where('status', 'active')
            ->where('expired_at', '>', now());
    }

    public function isPremiumUser(): bool
    {
        return $this->is_premium
            && $this->premium_expired_at !== null
            && $this->premium_expired_at->isFuture();
    }

    public function getDaysUntilExpiryAttribute(): ?int
    {
        if (!$this->premium_expired_at) {
            return null;
        }

        return max(0, now()->diffInDays($this->premium_expired_at, false));
    }

    public function scopePremium($query)
    {
        return $query->where('is_premium', true)
            ->whereNotNull('premium_expired_at')
            ->where('premium_expired_at', '>', now());
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isOwner(): bool
    {
        return $this->role === 'owner';
    }

    public function isMahasiswa(): bool
    {
        return $this->role === 'mahasiswa';
    }

    public function isVerified(): bool
    {
        return !is_null($this->email_verified_at);
    }

    public function getIsOnlineAttribute(): bool
    {
        if (Schema::hasColumn($this->getTable(), 'last_seen_at')) {
            if (!$this->last_seen_at) {
                return false;
            }

            return $this->last_seen_at->greaterThan(now()->subMinutes(2));
        }

        return auth()->check() && auth()->id() === $this->id;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByRole($query, string $role)
    {
        return $query->where('role', $role);
    }

    /*
    |--------------------------------------------------------------------------
    | Google OAuth Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Check if user is registered via Google OAuth.
     */
    public function isGoogleUser(): bool
    {
        return !empty($this->google_id);
    }

    /**
     * Link Google account to this user.
     */
    public function linkGoogleAccount(string $googleId, ?string $token = null, ?string $refreshToken = null): bool
    {
        $this->update([
            'google_id' => $googleId,
            'google_token' => $token,
            'google_refresh_token' => $refreshToken,
        ]);

        return true;
    }

    /**
     * Unlink Google account from this user.
     */
    public function unlinkGoogleAccount(): bool
    {
        // Check if user has a password (can login without Google)
        if (empty($this->password) || $this->password === '') {
            return false; // Can't unlink if no password set
        }

        $this->update([
            'google_id' => null,
            'google_token' => null,
            'google_refresh_token' => null,
            'google_avatar_fetched' => false,
        ]);

        return true;
    }

    /**
     * Check if user can login with Google.
     */
    public function canLoginWithGoogle(): bool
    {
        return $this->is_active && $this->isGoogleUser();
    }
}
