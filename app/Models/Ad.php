<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ad extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'image_url',
        'target_url',
        'position',
        'area',
        'start_date',
        'end_date',
        'is_active',
        'max_clicks',
        'click_count',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
        'click_count' => 'integer',
        'max_clicks' => 'integer',
    ];

    public function advertiser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function isExpired(): bool
    {
        return $this->end_date->isPast();
    }

    public function isActive(): bool
    {
        return $this->is_active &&
               !$this->isExpired() &&
               ($this->start_date->isPast() || $this->start_date->isToday()) &&
               ($this->max_clicks === null || $this->click_count < $this->max_clicks);
    }

    public function incrementClick(): void
    {
        $this->increment('click_count');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now());
    }

    public function scopeByPosition($query, string $position)
    {
        return $query->where('position', $position);
    }

    public function scopeByArea($query, ?string $area)
    {
        if ($area) {
            return $query->where('area', $area);
        }
        return $query;
    }

    public function scopeActiveForPosition($query, string $position)
    {
        return $query->active()->byPosition($position);
    }
}
