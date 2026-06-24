<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPremium
{
    /**
     * Handle an incoming request.
     *
     * Checks if the authenticated user has an active premium subscription.
     * Redirects non-premium users to the KosCheck+ upgrade page.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Unauthorized. Please login.',
                    'requires_premium' => true,
                ], 401);
            }
            return redirect()->route('login');
        }

        $user = $request->user();

        // Check premium status using the User model's method
        if (!$user->isPremiumUser()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Premium subscription required.',
                    'requires_premium' => true,
                    'upgrade_url' => route('owner.koscheck-plus.index'),
                ], 403);
            }

            // Store intended URL for redirect after upgrade
            session()->put('url.intended', $request->fullUrl());

            return redirect()
                ->route('owner.koscheck-plus.index')
                ->with('info', 'Fitur ini memerlukan langganan KosCheck+. Upgrade sekarang untuk mengakses semua fitur premium.');
        }

        return $next($request);
    }
}
