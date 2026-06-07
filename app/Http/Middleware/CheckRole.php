<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
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
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Access denied.'], 403);
            }

            $redirectRoute = match ($userRole) {
                'mahasiswa' => route('student.dashboard'),
                'owner' => route('owner.dashboard'),
                'admin' => route('admin'),
                default => route('home'),
            };

            return redirect($redirectRoute)->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
