<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = ['kos_id', 'url', 'order', 'is_primary'];

    protected $casts = [
        'order' => 'integer',
        'is_primary' => 'boolean',
    ];

    public function kos(): BelongsTo
    {
        return $this->belongsTo(Kos::class);
    }

    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
