<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        if ($request->user()->hasVerifiedEmail()) {
            // Redirect based on user role
            return match ($request->user()->role) {
                'owner' => redirect()->intended(route('owner.dashboard')),
                'admin' => redirect()->intended(route('admin')),
                default => redirect()->intended(route('student.dashboard')),
            };
        }

        return view('auth.verify-email');
    }
}