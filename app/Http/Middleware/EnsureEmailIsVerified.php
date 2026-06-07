<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailIsVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if (is_null(Auth::user()->email_verified_at)) {
            return redirect()->route('verification.notice')->with('warning', 'Anda perlu memverifikasi email terlebih dahulu.');
        }

        return $next($request);
    }
}