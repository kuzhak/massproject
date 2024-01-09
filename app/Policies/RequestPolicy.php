<?php

namespace App\Policies;

use App\Models\User;

class RequestPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === User::ROLE_USER;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        return $user->role === User::ROLE_RESPONSIBLE;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function view(User $user): bool
    {
        return $user->role === User::ROLE_RESPONSIBLE;
    }
}
