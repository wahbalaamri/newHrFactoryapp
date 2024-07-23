<?php

namespace App\Policies;

use App\Models\Functions;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FunctionsPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
        return $user->isAdmin || $user->user_type == 'partner'|| $user->user_type == 'client';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Functions $functions): bool
    {
        //
        return $user->isAdmin || $user->user_type == 'partner'|| $user->user_type == 'client';
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
        return $user->isAdmin;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Functions $functions): bool
    {
        //
        return $user->isAdmin;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Functions $functions): bool
    {
        //
        return $user->isAdmin;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Functions $functions): bool
    {
        //
        return $user->isAdmin;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Functions $functions): bool
    {
        //
        return $user->isAdmin;
    }
}
