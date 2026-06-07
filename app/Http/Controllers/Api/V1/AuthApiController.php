<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\ApiRes\ApiResponse;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthApiController extends Controller
{
    use ApiResponse;

    public function __construct(
        protected AuthService $authService
    ) {}

    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'device_name' => 'required|string',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return $this->error('Kredensial tidak valid', 401);
        }

        if (!$user->is_active) {
            return $this->error('Akun tidak aktif', 403);
        }

        $token = $user->createToken($validated['device_name'])->plainTextToken;

        return $this->success([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'university' => $user->university,
            ],
            'token' => $token,
            'token_type' => 'Bearer',
        ], 'Login berhasil');
    }

    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:mahasiswa,owner',
            'university' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'device_name' => 'required|string',
        ]);

        $user = $this->authService->register($validated);

        $token = $user->createToken($validated['device_name'])->plainTextToken;

        return $this->success([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'university' => $user->university,
            ],
            'token' => $token,
            'token_type' => 'Bearer',
        ], 'Registrasi berhasil', 201);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return $this->success(null, 'Logout berhasil');
    }

    public function logoutAll(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return $this->success(null, 'Semua sesi logout berhasil');
    }

    public function refreshToken(Request $request): JsonResponse
    {
        $user = $request->user();

        $token = $user->createToken('refresh-token-' . now()->timestamp)->plainTextToken;

        return $this->success([
            'token' => $token,
            'token_type' => 'Bearer',
        ], 'Token diperbarui');
    }

    public function me(Request $request): JsonResponse
    {
        $user = $request->user()->load(['notifications' => function ($q) {
            $q->latest()->limit(10);
        }]);

        return $this->success([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'university' => $user->university,
            'phone' => $user->phone,
            'avatar' => $user->avatar,
            'is_verified' => $user->isVerified(),
            'email_verified_at' => $user->email_verified_at,
            'created_at' => $user->created_at,
            'recent_notifications' => $user->notifications->take(5),
        ]);
    }

    public function updateProfile(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'university' => 'nullable|string|max:255',
        ]);

        $user = $this->authService->updateProfile($request->user(), $validated);

        return $this->success([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'university' => $user->university,
            'phone' => $user->phone,
        ], 'Profil berhasil diperbarui');
    }

    public function changePassword(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $result = $this->authService->updatePassword(
            $request->user(),
            $validated['current_password'],
            $validated['password']
        );

        if (!$result) {
            return $this->error('Password saat ini tidak valid', 422);
        }

        return $this->success(null, 'Password berhasil diubah');
    }

    public function tokens(Request $request): JsonResponse
    {
        $tokens = $request->user()->tokens()->get()->map(function ($token) {
            return [
                'id' => $token->id,
                'name' => $token->name,
                'created_at' => $token->created_at,
                'last_used_at' => $token->last_used_at,
                'expires_at' => $token->expires_at,
            ];
        });

        return $this->success($tokens);
    }

    public function revokeToken(Request $request, int $tokenId): JsonResponse
    {
        $token = $request->user()->tokens()->where('id', $tokenId)->first();

        if (!$token) {
            return $this->error('Token tidak ditemukan', 404);
        }

        $token->delete();

        return $this->success(null, 'Token berhasil dicabut');
    }
}