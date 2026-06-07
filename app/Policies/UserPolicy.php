<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, User $target): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->id === $target->id;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, User $target): bool
    {
        return $user->id === $target->id || $user->isAdmin();
    }

    public function delete(User $user, User $target): bool
    {
        if ($user->isAdmin() && $target->id !== $user->id) {
            return true;
        }

        return false;
    }

    public function updateRole(User $user, User $target): bool
    {
        return $user->isAdmin();
    }

    public function toggleActive(User $user, User $target): bool
    {
        return $user->isAdmin() && $target->id !== $user->id;
    }
}
