<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WhatsappClick extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'kos_id',
        'user_id',
        'ip_address',
        'phone_last_digits',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function kos(): BelongsTo
    {
        return $this->belongsTo(Kos::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
