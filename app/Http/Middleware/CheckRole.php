<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request with strict role-based access control.
     *
     * - Unauthenticated users are redirected to login
     * - Users with wrong role are redirected to their own dashboard
     * - Prevents infinite redirect loops by checking current route
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!$request->user()) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthorized. Please login.'], 401);
            }
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $userRole = $request->user()->role;

        if (!in_array($userRole, $roles)) {
            // Determine user's dashboard route
            $userDashboard = match ($userRole) {
                'mahasiswa' => route('student.dashboard'),
                'owner' => route('owner.dashboard'),
                'admin' => route('admin'),
                default => route('home'),
            };

            // Get current route name to prevent redirect loops
            $currentRoute = $request->route()?->getName();

            // If already on the target dashboard, show 403 instead of redirecting
            $isAlreadyOnDashboard = match ($userRole) {
                'mahasiswa' => $currentRoute === 'student.dashboard',
                'owner' => $currentRoute === 'owner.dashboard',
                'admin' => $currentRoute === 'admin',
                default => false,
            };

            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Access denied. Insufficient permissions.',
                    'required_role' => $roles,
                    'your_role' => $userRole,
                ], 403);
            }

            // If already on own dashboard, return 403 to prevent infinite loop
            if ($isAlreadyOnDashboard) {
                abort(403, 'Anda tidak memiliki akses ke fitur ini.');
            }

            return redirect($userDashboard)->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
