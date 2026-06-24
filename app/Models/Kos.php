<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Kos extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    public static array $genders = ['putra', 'putri', 'campur'];

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'address',
        'latitude',
        'longitude',
        'price',
        'gender',
        'description',
        'whatsapp',
        'phone',
        'status',
        'is_premium',
        'premium_expires_at',
        'is_active',
        'total_rooms',
        'available_rooms',
        'room_size',
        'deposit',
        'long_stay_discount',
        'rules',
    ];

    protected $casts = [
        'price' => 'integer',
        'latitude' => 'float',
        'longitude' => 'float',
        'is_premium' => 'boolean',
        'is_active' => 'boolean',
        'premium_expires_at' => 'datetime',
        'total_rooms' => 'integer',
        'available_rooms' => 'integer',
        'room_size' => 'integer',
        'deposit' => 'integer',
        'long_stay_discount' => 'boolean',
        'rules' => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function (Kos $kos) {
            if (empty($kos->slug)) {
                $kos->slug = static::generateUniqueSlug($kos->name);
            }
        });
    }

    public static function generateUniqueSlug(string $name): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function facilities(): BelongsToMany
    {
        return $this->belongsToMany(Facility::class, 'kos_facilities');
    }

    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class)->orderByDesc('is_primary')->orderBy('order');
    }

    public function primaryPhoto(): HasOne
    {
        return $this->hasOne(Photo::class)->where('is_primary', true)->orderBy('order');
    }

    public function getCoverPhotoAttribute(): ?Photo
    {
        // Get primary photo (is_primary = true) based on flag, not first in order
        return $this->photos->firstWhere('is_primary', true);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function reports(): MorphMany
    {
        return $this->morphMany(Report::class, 'reportable');
    }

    // KosCheck+ Analytics Relationships
    public function propertyViews(): HasMany
    {
        return $this->hasMany(PropertyView::class);
    }

    public function propertyFavorites(): HasMany
    {
        return $this->hasMany(PropertyFavorite::class);
    }

    public function whatsappClicks(): HasMany
    {
        return $this->hasMany(WhatsappClick::class);
    }

    public function getAverageRatingAttribute(): ?float
    {
        return $this->reviews()->where('is_visible', true)->avg('rating');
    }

    public function getReviewCountAttribute(): int
    {
        return $this->reviews()->where('is_visible', true)->count();
    }

    public function getAvailableRoomsAttribute($value): int
    {
        // Use the stored value if available, otherwise return 0
        return (int) ($value ?? 0);
    }

    public function getLeadCountThisMonthAttribute(): int
    {
        return $this->leads()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
    }

    public function isPremium(): bool
    {
        return $this->is_premium && ($this->premium_expires_at === null || $this->premium_expires_at->isFuture());
    }

    public function scopeActive($query)
    {
        return $query->where('kos.is_active', true)->where('status', 'active');
    }

    public function scopePremium($query)
    {
        return $query->where('is_premium', true);
    }

    public function scopeByGender($query, string $gender)
    {
        return $query->where('gender', $gender);
    }

    public function scopeByPriceRange($query, int $min, int $max)
    {
        return $query->whereBetween('price', [$min, $max]);
    }

    public function scopePremiumFirst($query)
    {
        // First priority: owner's KosCheck+ premium status
        // Second priority: property's own premium status (legacy)
        return $query
            ->select('kos.*')
            ->join('users', 'kos.user_id', '=', 'users.id')
            ->orderByRaw("CASE WHEN users.is_premium = 1 AND (users.premium_expired_at IS NULL OR users.premium_expired_at > NOW()) THEN 0 ELSE 1 END")
            ->orderByRaw("CASE WHEN kos.is_premium = 1 THEN 0 ELSE 1 END")
            ->orderBy('kos.created_at', 'desc');
    }

    public function scopeSearch($query, ?string $search)
    {
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%");
            });
        }
    }

    /**
     * Register media collections for Kos
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photos')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
            ->maxFilesize(10 * 1024 * 1024); // 10MB max per file
    }

    /**
     * Register media conversions for image compression and responsive images
     */
    public function registerMediaConversions(Media $media = null): void
    {
        // Thumbnail for listing pages (mobile-friendly)
        $this->addMediaConversion('thumbnail')
            ->width(400)
            ->height(300)
            ->crop(Manipulations::CROP_CENTER, 400, 300)
            ->format(Manipulations::FORMAT_WEBP)
            ->quality(80)
            ->withResponsiveImages()
            ->nonQueued();

        // Medium size for cards
        $this->addMediaConversion('medium')
            ->width(800)
            ->height(600)
            ->crop(Manipulations::CROP_CENTER, 800, 600)
            ->format(Manipulations::FORMAT_WEBP)
            ->quality(80)
            ->withResponsiveImages()
            ->nonQueued();

        // Large size for detail pages
        $this->addMediaConversion('large')
            ->width(1200)
            ->height(900)
            ->format(Manipulations::FORMAT_WEBP)
            ->quality(85)
            ->withResponsiveImages()
            ->nonQueued();

        // Blurred placeholder for lazy loading
        $this->addMediaConversion('placeholder')
            ->width(20)
            ->blur(10)
            ->format(Manipulations::FORMAT_WEBP)
            ->quality(20)
            ->nonQueued();
    }

    /**
     * Get the URL for a specific conversion, falling back to original
     */
    public function getPhotoUrl(string $conversion = 'medium'): ?string
    {
        $media = $this->getFirstMedia('photos');

        if (!$media) {
            return null;
        }

        if ($media->hasGeneratedConversion($conversion)) {
            return $media->getUrl($conversion);
        }

        return $media->getUrl();
    }
}
