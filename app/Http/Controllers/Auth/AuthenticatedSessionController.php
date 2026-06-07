<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();
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
            'admin' => route('admin'),
            'owner' => route('owner.dashboard'),
            'mahasiswa' => route('student.dashboard'),
            default => route('home'),
        };

        return redirect()->intended($redirectRoute)->with('success', 'Login berhasil! Selamat datang, ' . $user->name);
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->forget([
            'user_id',
            'user_name',
            'user_email',
            'user_role',
            'user_institution',
            'user_phone',
        ]);

        return redirect()->route('home')->with('success', 'Berhasil logout.');
    }
}
