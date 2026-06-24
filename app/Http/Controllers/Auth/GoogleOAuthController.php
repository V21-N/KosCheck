<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\OAuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleOAuthController extends Controller
{
    public function __construct(
        protected OAuthService $oauthService
    ) {}

    /**
     * Redirect the user to Google OAuth consent screen.
     */
    public function redirect(): RedirectResponse|JsonResponse
    {
        // Store intended URL in session before redirecting to Google
        $intendedUrl = url()->previous();
        if (!Str::contains($intendedUrl, ['login', 'register', 'auth/google'])) {
            Session::put('url.intended', $intendedUrl);
        }

        // Check if this is an API request
        if (request()->expectsJson()) {
            $googleUrl = Socialite::driver('google')
                ->stateless()
                ->redirect()
                ->getTargetUrl();

            return response()->json([
                'success' => true,
                'redirect_url' => $googleUrl,
                'message' => 'Redirecting to Google OAuth...',
            ]);
        }

        return Socialite::driver('google')
            ->stateless()
            ->redirect();
    }

    /**
     * Handle the callback from Google OAuth.
     */
    public function callback(Request $request): RedirectResponse
    {
        try {
            // Get Google user information
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Process the OAuth user
            $result = $this->oauthService->handleGoogleCallback($googleUser);

            if ($result['needs_role_selection']) {
                // Store OAuth data in session for role selection
                Session::put('oauth_pending', [
                    'google_id' => $googleUser->id,
                    'email' => $googleUser->email,
                    'name' => $googleUser->name,
                    'avatar' => $googleUser->avatar,
                    'token' => $googleUser->token,
                    'refresh_token' => $googleUser->refreshToken,
                    'avatar_fetched' => true,
                ]);

                return redirect()->route('auth.google.role-select');
            }

            // User exists or was created with auto-assigned role
            $user = $result['user'];

            // Login the user
            $this->loginUser($request, $user);

            // Redirect to intended URL or role-based dashboard
            return $this->redirectToDashboard($user);

        } catch (\Exception $e) {
            \Log::error('Google OAuth Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->route('login')
                ->with('error', 'Autentikasi Google gagal. Silakan coba lagi.');
        }
    }

    /**
     * Show role selection page for OAuth users who need to choose a role.
     */
    public function showRoleSelection(): \Illuminate\View\View
    {
        $pendingOAuth = Session::get('oauth_pending');

        if (!$pendingOAuth) {
            return redirect()->route('login')
                ->with('error', 'Sesi OAuth tidak valid. Silakan coba login ulang.');
        }

        return view('auth.oauth-register');
    }

    /**
     * Process the role selection from OAuth users.
     */
    public function selectRole(Request $request): RedirectResponse
    {
        $request->validate([
            'role' => 'required|in:mahasiswa,owner',
        ], [
            'role.required' => 'Silakan pilih peran anda.',
            'role.in' => 'Peran tidak valid.',
        ]);

        $pendingOAuth = Session::get('oauth_pending');

        if (!$pendingOAuth) {
            return redirect()->route('login')
                ->with('error', 'Sesi OAuth tidak valid. Silakan coba login ulang.');
        }

        try {
            // Complete OAuth registration with role
            $result = $this->oauthService->completeOAuthRegistration(
                $pendingOAuth,
                $request->input('role')
            );

            $user = $result['user'];

            // Clear the pending OAuth session
            Session::forget('oauth_pending');

            // Login the user
            $this->loginUser($request, $user);

            // Redirect to role-based dashboard
            return $this->redirectToDashboard($user)
                ->with('success', 'Login dengan Google berhasil! Selamat datang, ' . $user->name);

        } catch (\Exception $e) {
            \Log::error('OAuth Role Selection Error: ' . $e->getMessage());

            return redirect()->route('auth.google.role-select')
                ->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }

    /**
     * Login the user and set session data.
     */
    protected function loginUser(Request $request, User $user): void
    {
        Auth::login($user);
        $request->session()->regenerate();

        // Update presence columns
        if (Schema::hasColumn($user->getTable(), 'last_login_at')) {
            $user->last_login_at = now();
        }
        if (Schema::hasColumn($user->getTable(), 'last_seen_at')) {
            $user->last_seen_at = now();
        }
        $user->save();

        // Set session data
        $request->session()->put([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'user_role' => $user->role,
            'user_institution' => $user->university,
            'user_phone' => $user->phone,
        ]);
    }

    /**
     * Redirect user to their role-based dashboard.
     */
    protected function redirectToDashboard(User $user): RedirectResponse
    {
        $intendedUrl = Session::pull('url.intended');

        if ($intendedUrl && !Str::contains($intendedUrl, ['login', 'register', 'auth/google', 'logout'])) {
            return redirect()->intended($intendedUrl);
        }

        return redirect()->intended(
            match ($user->role) {
                'admin' => route('admin'),
                'owner' => route('owner.dashboard'),
                'mahasiswa' => route('student.dashboard'),
                default => route('home'),
            }
        );
    }
}
