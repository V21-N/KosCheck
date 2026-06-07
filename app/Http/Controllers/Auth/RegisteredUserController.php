<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {}

    public function create(): View
    {
        return view('auth.register');
    }

    public function store(RegisterRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $user = $this->authService->register($validated);

        event(new Registered($user));

        auth()->login($user);
        $request->session()->regenerate();

        if ($user instanceof User) {
            $presenceUpdates = [];

            if (Schema::hasColumn($user->getTable(), 'last_login_at')) {
                $presenceUpdates['last_login_at'] = now();
            }

            if (Schema::hasColumn($user->getTable(), 'last_seen_at')) {
                $presenceUpdates['last_seen_at'] = now();
            }

            if (!empty($presenceUpdates)) {
                $user->forceFill($presenceUpdates)->save();
            }
        }

        $request->session()->put([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'user_role' => $user->role,
            'user_institution' => $user->university,
            'user_phone' => $user->phone,
        ]);

        $redirectRoute = match ($user->role) {
            'mahasiswa' => route('student.dashboard'),
            'owner' => route('owner.dashboard'),
            default => route('home'),
        };

        return redirect()->intended($redirectRoute);
    }
}
