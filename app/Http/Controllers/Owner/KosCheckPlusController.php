<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Services\PaymentService;
use App\Services\PropertyAnalyticsService;
use App\Services\SubscriptionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KosCheckPlusController extends Controller
{
    public function __construct(
        protected SubscriptionService $subscriptionService,
        protected PaymentService $paymentService,
        protected PropertyAnalyticsService $analyticsService
    ) {}

    /**
     * Display KosCheck+ landing page
     */
    public function index(): View
    {
        $user = auth()->user();
        $isPremium = $this->subscriptionService->isActive($user);
        $activeSubscription = $this->subscriptionService->getActiveSubscription($user);

        // Get owner analytics if premium
        $analytics = [];
        if ($isPremium) {
            $analytics = $this->analyticsService->getOwnerAnalytics($user);
        }

        return view('owner.koscheck-plus.index', [
            'isPremium' => $isPremium,
            'activeSubscription' => $activeSubscription,
            'remainingDays' => $this->subscriptionService->getRemainingDays($user),
            'analytics' => $analytics,
            'price' => config('premium.price_monthly', 49000),
        ]);
    }

    /**
     * Display checkout page
     */
    public function checkout(): View
    {
        $user = auth()->user();

        // Check if already premium
        if ($this->subscriptionService->isActive($user)) {
            return redirect()->route('owner.koscheck-plus.index')
                ->with('info', 'Anda sudah menjadi member KosCheck+');
        }

        return view('owner.koscheck-plus.checkout', [
            'price' => config('premium.price_monthly', 49000),
            'durationDays' => 30,
        ]);
    }

    /**
     * Initiate payment process
     */
    public function initiatePayment(Request $request)
    {
        $user = auth()->user();

        // Check if already premium
        if ($this->subscriptionService->isActive($user)) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah menjadi member KosCheck+',
            ], 400);
        }

        try {
            // Create pending subscription
            $subscription = Subscription::create([
                'user_id' => $user->id,
                'plan_name' => 'premium',
                'plan_type' => 'monthly',
                'price' => config('premium.price_monthly', 49000),
                'duration_days' => 30,
                'started_at' => now(),
                'expired_at' => now()->addDays(30),
                'status' => 'pending',
            ]);

            // Create transaction
            $transaction = $this->paymentService->createTransaction($user, $subscription);

            // Get Snap token
            $snapToken = $this->paymentService->getSnapToken($transaction);

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'transaction_id' => $transaction->id,
                'redirect_url' => route('owner.koscheck-plus.payment', ['transaction' => $transaction->id]),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display payment page with Midtrans Snap
     */
    public function payment(Transaction $transaction): View
    {
        abort_unless($transaction->user_id === auth()->id(), 403);

        return view('owner.koscheck-plus.payment', [
            'transaction' => $transaction,
            'clientKey' => config('midtrans.client_key'),
            'isProduction' => config('midtrans.is_production', false),
        ]);
    }

    /**
     * Display subscription history
     */
    public function history(): View
    {
        $user = auth()->user();

        $subscriptions = $user->subscriptions()
            ->with('transactions')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('owner.koscheck-plus.history', [
            'subscriptions' => $subscriptions,
        ]);
    }

    /**
     * Get dashboard widget data (for AJAX refresh)
     */
    public function widgetData(): JsonResponse
    {
        $user = auth()->user();
        $isPremium = $this->subscriptionService->isActive($user);

        return response()->json([
            'is_premium' => $isPremium,
            'remaining_days' => $isPremium ? $this->subscriptionService->getRemainingDays($user) : null,
            'analytics' => $isPremium ? $this->analyticsService->getOwnerAnalytics($user) : null,
        ]);
    }

    /**
     * Cancel subscription
     */
    public function cancel(Request $request)
    {
        $user = auth()->user();

        $this->subscriptionService->cancelSubscription($user);

        return redirect()->route('owner.koscheck-plus.index')
            ->with('success', 'Langganan KosCheck+ berhasil dibatalkan.');
    }
}
