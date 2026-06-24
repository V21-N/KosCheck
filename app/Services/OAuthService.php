<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Contracts\User as OAuthUser;

class OAuthService
{
    /**
     * Handle Google OAuth callback and user creation/login.
     */
    public function handleGoogleCallback(OAuthUser $googleUser): array
    {
        // Check if user already exists by Google ID
        $user = User::where('google_id', $googleUser->id)->first();

        if ($user) {
            // Update user's Google tokens and avatar
            $this->updateGoogleUser($user, $googleUser);
            return [
                'user' => $user,
                'needs_role_selection' => false,
                'is_new' => false,
            ];
        }

        // Check if user exists with same email (email/password account)
        $existingUser = User::where('email', $googleUser->email)->first();

        if ($existingUser) {
            // Link Google account to existing user
            $this->linkGoogleToUser($existingUser, $googleUser);
            return [
                'user' => $existingUser,
                'needs_role_selection' => false,
                'is_new' => false,
            ];
        }

        // New user - determine if role selection is needed
        $roleStrategy = config('oauth.google.role_strategy', 'prompt');
        $role = $this->determineRole($googleUser, $roleStrategy);

        if ($role) {
            // Auto-create user with determined role
            $user = $this->createGoogleUser($googleUser, $role);
            return [
                'user' => $user,
                'needs_role_selection' => false,
                'is_new' => true,
            ];
        }

        // Needs role selection
        return [
            'user' => null,
            'needs_role_selection' => true,
            'is_new' => true,
        ];
    }

    /**
     * Complete OAuth registration with user-selected role.
     */
    public function completeOAuthRegistration(array $oauthData, string $role): array
    {
        // Double-check user doesn't exist (race condition protection)
        $existingUser = User::where('email', $oauthData['email'])->first();

        if ($existingUser) {
            // If user somehow exists, just link and return
            if (!$existingUser->google_id) {
                $this->linkGoogleToUser($existingUser, $oauthData);
            }
            return [
                'user' => $existingUser,
                'is_new' => false,
            ];
        }

        $user = $this->createGoogleUserFromSession($oauthData, $role);

        return [
            'user' => $user,
            'is_new' => true,
        ];
    }

    /**
     * Determine user role based on strategy.
     */
    protected function determineRole(OAuthUser $googleUser, string $strategy): ?string
    {
        return match ($strategy) {
            'auto_mahasiswa' => 'mahasiswa',
            'domain_based' => $this->determineRoleByDomain($googleUser->email),
            default => null, // 'prompt' - needs user selection
        };
    }

    /**
     * Determine role based on email domain.
     */
    protected function determineRoleByDomain(string $email): string
    {
        $domain = substr(strrchr($email, '@'), 1);
        $domainRoles = config('oauth.google.domain_roles', []);

        foreach ($domainRoles as $pattern => $role) {
            if ($pattern === 'default') {
                continue;
            }

            if (Str::contains($domain, str_replace('.', '', $pattern))) {
                return $role;
            }
        }

        return $domainRoles['default'] ?? 'mahasiswa';
    }

    /**
     * Detect university from email domain.
     */
    public function detectUniversity(string $email): ?string
    {
        $domain = substr(strrchr($email, '@'), 1);
        $universityDomains = config('oauth.google.university_domains', []);

        return $universityDomains[$domain] ?? null;
    }

    /**
     * Create a new user from Google OAuth data.
     */
    protected function createGoogleUser(OAuthUser $googleUser, string $role): User
    {
        $university = $this->detectUniversity($googleUser->email);

        $user = User::create([
            'name' => $googleUser->name,
            'email' => $googleUser->email,
            'password' => Hash::make(Str::random(32)), // Random password for OAuth users
            'role' => $role,
            'university' => $university,
            'google_id' => $googleUser->id,
            'google_token' => $googleUser->token,
            'google_refresh_token' => $googleUser->refreshToken,
            'google_avatar_fetched' => true,
            'avatar' => $googleUser->avatar,
            'email_verified_at' => now(), // Google verifies email
            'is_active' => true,
        ]);

        Log::info('New Google OAuth user created', [
            'user_id' => $user->id,
            'email' => $user->email,
            'role' => $user->role,
        ]);

        return $user;
    }

    /**
     * Create a new user from session OAuth data (role selection flow).
     */
    protected function createGoogleUserFromSession(array $oauthData, string $role): User
    {
        $university = $this->detectUniversity($oauthData['email']);

        $user = User::create([
            'name' => $oauthData['name'],
            'email' => $oauthData['email'],
            'password' => Hash::make(Str::random(32)),
            'role' => $role,
            'university' => $university,
            'google_id' => $oauthData['google_id'],
            'google_token' => $oauthData['token'] ?? null,
            'google_refresh_token' => $oauthData['refresh_token'] ?? null,
            'google_avatar_fetched' => $oauthData['avatar_fetched'] ?? false,
            'avatar' => $oauthData['avatar'] ?? null,
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        Log::info('New Google OAuth user created via role selection', [
            'user_id' => $user->id,
            'email' => $user->email,
            'role' => $user->role,
        ]);

        return $user;
    }

    /**
     * Update existing user with Google OAuth information.
     */
    protected function updateGoogleUser(User $user, OAuthUser $googleUser): void
    {
        $user->update([
            'google_token' => $googleUser->token,
            'google_refresh_token' => $googleUser->refreshToken,
            'google_avatar_fetched' => true,
            'avatar' => $googleUser->avatar,
            'last_login_at' => now(),
            'last_seen_at' => now(),
        ]);
    }

    /**
     * Link Google account to existing user.
     */
    protected function linkGoogleToUser(User $user, OAuthUser|array $googleUser): void
    {
        $updateData = [
            'google_id' => $googleUser['google_id'] ?? $googleUser->id,
            'google_token' => $googleUser['token'] ?? $googleUser->token,
            'google_refresh_token' => $googleUser['refresh_token'] ?? $googleUser->refreshToken,
            'google_avatar_fetched' => true,
            'avatar' => $googleUser['avatar'] ?? $googleUser->avatar,
            'last_login_at' => now(),
            'last_seen_at' => now(),
        ];

        // If user hasn't verified email yet, mark as verified (Google verified it)
        if (!$user->email_verified_at) {
            $updateData['email_verified_at'] = now();
        }

        $user->update($updateData);
    }
}
