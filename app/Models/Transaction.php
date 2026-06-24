<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subscription_id',
        'order_id',
        'midtrans_order_id',
        'amount',
        'payment_type',
        'transaction_status',
        'snap_token',
        'snap_redirect_url',
        'midtrans_response',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'integer',
        'midtrans_response' => 'array',
        'paid_at' => 'datetime',
    ];

    public const STATUS_PENDING = 'pending';
    public const STATUS_SETTLEMENT = 'settlement';
    public const STATUS_CAPTURE = 'capture';
    public const STATUS_DENY = 'deny';
    public const STATUS_CANCEL = 'cancel';
    public const STATUS_EXPIRE = 'expire';
    public const STATUS_REFUND = 'refund';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    public function isPending(): bool
    {
        return $this->transaction_status === self::STATUS_PENDING;
    }

    public function isSuccess(): bool
    {
        return in_array($this->transaction_status, [self::STATUS_SETTLEMENT, self::STATUS_CAPTURE]);
    }

    public function isFailed(): bool
    {
        return in_array($this->transaction_status, [self::STATUS_DENY, self::STATUS_CANCEL, self::STATUS_EXPIRE]);
    }

    public function scopePending($query)
    {
        return $query->where('transaction_status', self::STATUS_PENDING);
    }

    public function scopeSuccess($query)
    {
        return $query->where('transaction_status', self::STATUS_SETTLEMENT);
    }
}
