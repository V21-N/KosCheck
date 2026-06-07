<?php

namespace App\Policies;

use App\Models\AppNotification;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotificationPolicy
{
    use HandlesAuthorization;

    public function update(User $user, AppNotification $notification): bool
    {
        return $user->id === $notification->user_id;
    }

    public function delete(User $user, AppNotification $notification): bool
    {
        return $user->id === $notification->user_id;
    }
}
