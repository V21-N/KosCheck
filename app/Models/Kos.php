<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Kos extends Model
{
    use HasFactory, SoftDeletes;

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
    ];

    protected $casts = [
        'price' => 'integer',
        'latitude' => 'float',
        'longitude' => 'float',
        'is_premium' => 'boolean',
        'is_active' => 'boolean',
        'premium_expires_at' => 'datetime',
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
        return $this->hasMany(Photo::class)->orderBy('order');
    }

    public function primaryPhoto(): BelongsTo
    {
        return $this->belongsTo(Photo::class);
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

    public function getAverageRatingAttribute(): ?float
    {
        return $this->reviews()->where('is_visible', true)->avg('rating');
    }

    public function getReviewCountAttribute(): int
    {
        return $this->reviews()->where('is_visible', true)->count();
    }

    public function getAvailableRoomsAttribute(): int
    {
        // Placeholder: returns 3 for demo; replace with actual stock logic
        return 3;
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
        return $query->where('is_active', true)->where('status', 'active');
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
        return $query->orderByRaw("CASE WHEN is_premium = 1 THEN 0 ELSE 1 END")
            ->orderBy('created_at', 'desc');
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
}
