<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReviewPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user, Review $review): bool
    {
        return true;
    }

    public function view(User $user, Review $review): bool
    {
        if ($review->is_visible) {
            return true;
        }

        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isOwner() && $review->kos->user_id === $user->id) {
            return true;
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->isMahasiswa() && $user->isVerified();
    }

    public function update(User $user, Review $review): bool
    {
        return $user->id === $review->user_id;
    }

    public function delete(User $user, Review $review): bool
    {
        return $user->isAdmin() || $user->id === $review->user_id;
    }

    public function report(User $user, Review $review): bool
    {
        return $user->id !== $review->user_id;
    }

    public function helpful(User $user, Review $review): bool
    {
        return $user->id !== $review->user_id;
    }

    public function approve(User $user, Review $review): bool
    {
        return $user->isAdmin();
    }

    public function hide(User $user, Review $review): bool
    {
        return $user->isAdmin();
    }

    public function unflag(User $user, Review $review): bool
    {
        return $user->isAdmin();
    }
}
