<?php

namespace App\Services;

use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Midtrans\Snap;

class PaymentService
{
    protected string $baseUrl;

    public function __construct()
    {
        // Base URL for Midtrans
        $this->baseUrl = config('midtrans.is_production', false)
            ? 'https://app.midtrans.com'
            : 'https://app.sandbox.midtrans.com';
    }

    public function createTransaction(User $user, Subscription $subscription): Transaction
    {
        $orderId = 'KCP-' . time() . '-' . Str::random(8);

        $transaction = $subscription->transactions()->create([
            'user_id' => $user->id,
            'order_id' => $orderId,
            'amount' => $subscription->price,
            'transaction_status' => Transaction::STATUS_PENDING,
        ]);

        return $transaction;
    }

    public function getSnapToken(Transaction $transaction): string
    {
        $user = $transaction->user;
        $subscription = $transaction->subscription;

        $itemDetails = [
            [
                'id' => $subscription->id,
                'price' => $subscription->price,
                'quantity' => 1,
                'name' => 'KosCheck+ Premium - ' . ucfirst($subscription->plan_type),
            ],
        ];

        $customerDetails = [
            'first_name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone ?? '',
        ];

        $transactionDetails = [
            'order_id' => $transaction->order_id,
            'gross_amount' => $transaction->amount,
        ];

        $callbacks = [
            'finish' => route('payment.midtrans.finish'),
        ];

        try {
            $snapToken = Snap::getSnapToken([
                'transaction_details' => $transactionDetails,
                'item_details' => $itemDetails,
                'customer_details' => $customerDetails,
                'callbacks' => $callbacks,
            ]);

            $transaction->update([
                'snap_token' => $snapToken,
            ]);

            return $snapToken;
        } catch (\Exception $e) {
            Log::error('Midtrans Snap Token Error', [
                'order_id' => $transaction->order_id,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    public function handleNotification(array $payload): bool
    {
        $orderId = $payload['order_id'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;

        if (!$orderId) {
            return false;
        }

        $transaction = Transaction::where('order_id', $orderId)->first();

        if (!$transaction) {
            Log::warning('Transaction not found for order', ['order_id' => $orderId]);
            return false;
        }

        // Validate signature key if provided
        if (isset($payload['signature_key'])) {
            $expectedSignature = $this->generateSignatureKey(
                $orderId,
                $payload['gross_amount'] ?? $transaction->amount,
                config('midtrans.server_key')
            );

            if ($payload['signature_key'] !== $expectedSignature) {
                Log::warning('Invalid Midtrans signature', [
                    'order_id' => $orderId,
                    'expected' => $expectedSignature,
                    'received' => $payload['signature_key'],
                ]);
                return false;
            }
        }

        return DB::transaction(function () use ($transaction, $payload, $transactionStatus) {
            $transaction->update([
                'transaction_status' => $transactionStatus,
                'payment_type' => $payload['payment_type'] ?? null,
                'midtrans_response' => $payload,
                'paid_at' => in_array($transactionStatus, [Transaction::STATUS_SETTLEMENT, Transaction::STATUS_CAPTURE])
                    ? now()
                    : null,
            ]);

            if (in_array($transactionStatus, [Transaction::STATUS_SETTLEMENT, Transaction::STATUS_CAPTURE])) {
                $this->activateSubscription($transaction);
            }

            Log::info('Midtrans notification processed', [
                'order_id' => $orderId,
                'status' => $transactionStatus,
            ]);

            return true;
        });
    }

    protected function activateSubscription(Transaction $transaction): void
    {
        $user = $transaction->user;
        $subscription = $transaction->subscription;

        $subscriptionService = app(SubscriptionService::class);
        $subscriptionService->activateSubscription($user, $subscription->duration_days);
    }

    public function generateSignatureKey(string $orderId, int $amount, string $serverKey): string
    {
        return hash('sha512', $orderId . $amount . $serverKey);
    }

    public function getTransactionStatus(Transaction $transaction): array
    {
        return [
            'order_id' => $transaction->order_id,
            'status' => $transaction->transaction_status,
            'amount' => $transaction->amount,
            'paid_at' => $transaction->paid_at?->toIso8601String(),
        ];
    }
}
