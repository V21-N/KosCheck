<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        Log::info('PASSWORD_RESET_STEP_1: Request received for email: ' . $request->email);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        Log::info('PASSWORD_RESET_STEP_2: Calling Password::sendResetLink()');
        
        $status = Password::sendResetLink(
            $request->only('email')
        );

        Log::info('PASSWORD_RESET_STEP_3: sendResetLink() returned status: ' . $status);
        Log::info('PASSWORD_RESET_STEP_4: Password::RESET_LINK_SENT constant value: ' . Password::RESET_LINK_SENT);
        
        $result = $status == Password::RESET_LINK_SENT;
        Log::info('PASSWORD_RESET_STEP_5: Status matches RESET_LINK_SENT? ' . ($result ? 'YES' : 'NO'));

        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);
    }
}
