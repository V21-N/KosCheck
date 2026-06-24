<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Services\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransController extends Controller
{
    public function __construct(
        protected PaymentService $paymentService
    ) {}

    /**
     * Handle Midtrans notification callback
     */
    public function callback(Request $request): JsonResponse
    {
        $payload = $request->all();

        Log::info('Midtrans callback received', $payload);

        $success = $this->paymentService->handleNotification($payload);

        if ($success) {
            return response()->json(['status' => 'success'], 200);
        }

        return response()->json(['status' => 'failed'], 400);
    }

    /**
     * Handle Midtrans finish redirect
     */
    public function finish(Request $request): \Illuminate\Http\RedirectResponse
    {
        $orderId = $request->get('order_id');

        if (!$orderId) {
            return redirect()->route('owner.koscheck-plus.index')
                ->with('error', 'Transaksi tidak valid.');
        }

        $transaction = Transaction::where('order_id', $orderId)->first();

        if (!$transaction) {
            return redirect()->route('owner.koscheck-plus.index')
                ->with('error', 'Transaksi tidak ditemukan.');
        }

        if ($transaction->isSuccess()) {
            return redirect()->route('owner.koscheck-plus.index')
                ->with('success', 'Pembayaran berhasil! Selamat menikmati KosCheck+.');
        }

        if ($transaction->isPending()) {
            return redirect()->route('owner.koscheck-plus.payment', $transaction)
                ->with('info', 'Pembayaran sedang diproses. Silakan selesaikan pembayaran.');
        }

        return redirect()->route('owner.koscheck-plus.checkout')
            ->with('error', 'Pembayaran gagal. Silakan coba lagi.');
    }

    /**
     * Handle Midtrans error redirect
     */
    public function error(Request $request): \Illuminate\Http\RedirectResponse
    {
        $orderId = $request->get('order_id');

        Log::warning('Midtrans error redirect', [
            'order_id' => $orderId,
            'params' => $request->all(),
        ]);

        return redirect()->route('owner.koscheck-plus.checkout')
            ->with('error', 'Terjadi kesalahan saat pembayaran. Silakan coba lagi.');
    }
}
