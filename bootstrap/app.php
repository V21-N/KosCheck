<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Setting APP_ENV and APP_DEBUG here causes Laravel to read .env.local instead of .env
// Please set APP_DEBUG=true and APP_ENV=local in your Vercel Dashboard Environment Variables instead.

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Memastikan Vercel (Reverse Proxy) tidak memutus koneksi SSL/HTTPS
        $middleware->trustProxies(at: '*');

        $middleware->alias([
            'auth' => \App\Http\Middleware\Authenticate::class,
            'role' => \App\Http\Middleware\CheckRole::class,
            'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
            'guest_guard' => \App\Http\Middleware\GuestGuard::class,
            'premium' => \App\Http\Middleware\CheckPremium::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();