<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function register(array $data): User
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'] ?? 'mahasiswa',
            'university' => $data['university'] ?? null,
            'phone' => $data['phone'] ?? null,
        ]);

        return $user;
    }

    public function login(string $email, string $password, ?Request $request = null): ?User
    {
        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            return null;
        }

        if ($request) {
            $user->last_login_at = now();
            $user->save();
        }

        return $user;
    }

    public function updateProfile(User $user, array $data): User
    {
        $updateData = [];

        if (!empty($data['name'])) {
            $updateData['name'] = $data['name'];
        }

        if (!empty($data['phone'])) {
            $updateData['phone'] = $data['phone'];
        }

        if (!empty($data['university'])) {
            $updateData['university'] = $data['university'];
        }

        if (!empty($data['avatar'])) {
            $updateData['avatar'] = $data['avatar'];
        }

        $user->update($updateData);

        return $user->fresh();
    }

    public function updatePassword(User $user, string $currentPassword, string $newPassword): bool
    {
        if (!Hash::check($currentPassword, $user->password)) {
            return false;
        }

        $user->password = Hash::make($newPassword);
        $user->save();

        return true;
    }

    public function verifyEmail(User $user): User
    {
        $user->email_verified_at = now();
        $user->save();

        return $user;
    }

    public function resetPassword(string $email, string $token, string $password): bool
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return false;
        }

        $user->password = Hash::make($password);
        $user->save();

        return true;
    }

    public function deactivate(User $user): bool
    {
        $user->update(['is_active' => false]);

        return true;
    }

    public function activate(User $user): bool
    {
        $user->update(['is_active' => true]);

        return true;
    }

    public function updateRole(User $user, string $role): User
    {
        $allowedRoles = ['mahasiswa', 'owner', 'admin'];

        if (!in_array($role, $allowedRoles)) {
            throw new \InvalidArgumentException("Invalid role: {$role}");
        }

        $user->update(['role' => $role]);

        return $user->fresh();
    }
}