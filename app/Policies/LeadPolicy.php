<?php

namespace App\Policies;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LeadPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->isOwner() || $user->isAdmin();
    }

    public function view(User $user, Lead $lead): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isOwner() && $lead->kos->user_id === $user->id) {
            return true;
        }

        return false;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Lead $lead): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return false;
    }

    public function markConverted(User $user, Lead $lead): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isOwner() && $lead->kos->user_id === $user->id) {
            return true;
        }

        return false;
    }
}
