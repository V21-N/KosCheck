<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class GuestGuard
{
    /**
     * Handle an incoming request.
     *
     * Ensures that only unauthenticated users can access guest-only routes.
     * Authenticated users are redirected to their role-specific dashboard.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return $next($request);
        }

        $user = Auth::user();
        $currentRoute = $request->route()?->getName();

        // Determine the appropriate dashboard based on user role
        $dashboardRoute = match ($user->role) {
            'admin' => route('admin'),
            'owner' => route('owner.dashboard'),
            'mahasiswa' => route('student.dashboard'),
            default => route('home'),
        };

        // Get the current URL to check if already on dashboard
        $currentUrl = $request->url();
        $dashboardUrl = $request->root() . ($user->role === 'admin'
            ? '/admin'
            : ($user->role === 'owner'
                ? '/owner'
                : '/mahasiswa'));

        // If already on the dashboard, stay there (prevents infinite redirect)
        if (str_starts_with($currentUrl, rtrim($dashboardUrl, '/'))) {
            return $next($request);
        }

        // Redirect authenticated users to their dashboard
        if ($request->expectsJson()) {
            return response()->json([
                'error' => 'Access denied. This page is for guests only.',
                'redirect_to' => $dashboardRoute,
            ], 403);
        }

        return redirect($dashboardRoute)
            ->with('info', 'Anda sudah login. Halaman ini hanya untuk tamu.');
    }
}
