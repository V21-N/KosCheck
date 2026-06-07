<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'kos_id',
        'user_id',
        'rating',
        'rating_cleanliness',
        'rating_security',
        'rating_facilities',
        'comment',
        'helpful_count',
        'is_flagged',
        'is_visible',
        'status',
        'rejection_reason',
        'moderated_by',
        'moderated_at',
    ];

    protected $attributes = [
        'is_visible' => false,
        'status' => self::STATUS_PENDING,
        'is_flagged' => false,
        'helpful_count' => 0,
    ];

    protected $casts = [
        'rating' => 'integer',
        'rating_cleanliness' => 'integer',
        'rating_security' => 'integer',
        'rating_facilities' => 'integer',
        'helpful_count' => 'integer',
        'is_flagged' => 'boolean',
        'is_visible' => 'boolean',
        'moderated_at' => 'datetime',
    ];

    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';

    public function scopeVisible($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeRejected($query)
    {
        return $query->where('status', self::STATUS_REJECTED);
    }

    public function scopeNeedsModeration($query)
    {
        return $query->where(function ($q) {
            $q->where('is_flagged', true)
              ->orWhere('status', self::STATUS_PENDING);
        });
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isApproved(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }

    public function isRejected(): bool
    {
        return $this->status === self::STATUS_REJECTED;
    }

    public function needsModeration(): bool
    {
        return $this->isPending() || $this->is_flagged;
    }

    public function approve(int $adminId): void
    {
        $this->update([
            'status' => self::STATUS_APPROVED,
            'is_visible' => true,
            'is_flagged' => false,
            'rejection_reason' => null,
            'moderated_by' => $adminId,
            'moderated_at' => now(),
        ]);
    }

    public function reject(int $adminId, ?string $reason = null): void
    {
        $this->update([
            'status' => self::STATUS_REJECTED,
            'is_visible' => false,
            'is_flagged' => false,
            'rejection_reason' => $reason,
            'moderated_by' => $adminId,
            'moderated_at' => now(),
        ]);
    }

    public function moderator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'moderated_by');
    }

    public function kos(): BelongsTo
    {
        return $this->belongsTo(Kos::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reports(): MorphMany
    {
        return $this->morphMany(Report::class, 'reportable');
    }

    public function incrementHelpful(): void
    {
        $this->increment('helpful_count');
    }

    public function flag(): void
    {
        $this->update(['is_flagged' => true]);
    }

    public function unflag(): void
    {
        $this->update(['is_flagged' => false]);
    }

    public function hide(): void
    {
        $this->update(['is_visible' => false]);
    }

    public function show(): void
    {
        $this->update(['is_visible' => true]);
    }

    public function scopeFlagged($query)
    {
        return $query->where('is_flagged', true);
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeHighestRated($query)
    {
        return $query->orderBy('rating', 'desc');
    }

    public function scopeMostHelpful($query)
    {
        return $query->orderBy('helpful_count', 'desc');
    }
}
