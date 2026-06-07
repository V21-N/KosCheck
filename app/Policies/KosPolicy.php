<?php

namespace App\Policies;

use App\Models\Kos;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class KosPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Kos $kos): bool
    {
        if ($kos->is_active) {
            return true;
        }

        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isOwner() && $kos->user_id === $user->id) {
            return true;
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->isOwner() || $user->isAdmin();
    }

    public function update(User $user, Kos $kos): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isOwner() && $kos->user_id === $user->id) {
            return true;
        }

        return false;
    }

    public function delete(User $user, Kos $kos): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isOwner() && $kos->user_id === $user->id) {
            return true;
        }

        return false;
    }

    public function manage(User $user, Kos $kos): bool
    {
        return $this->update($user, $kos);
    }

    public function approve(User $user, Kos $kos): bool
    {
        return $user->isAdmin();
    }

    public function reject(User $user, Kos $kos): bool
    {
        return $user->isAdmin();
    }

    public function togglePremium(User $user, Kos $kos): bool
    {
        return $user->isAdmin();
    }

    public function viewLeads(User $user, Kos $kos): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isOwner() && $kos->user_id === $user->id) {
            return true;
        }

        return false;
    }
}
