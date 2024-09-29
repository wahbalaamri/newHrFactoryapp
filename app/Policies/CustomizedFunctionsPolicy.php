<?php

namespace App\Policies;

use App\Models\CustomizedSurveyFunctions;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CustomizedFunctionsPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
        return $user->isAdmin || $user->user_type == 'partner';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CustomizedSurveyFunctions $customizedSurveyFunctions): bool
    {
        //
        return $user->isAdmin || $user->user_type == 'partner' || $user->client_id == $customizedSurveyFunctions->client;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CustomizedSurveyFunctions $customizedSurveyFunctions): bool
    {
        //
        return $user->isAdmin || $user->user_type == 'partner' || $user->client_id == $customizedSurveyFunctions->client;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CustomizedSurveyFunctions $customizedSurveyFunctions): bool
    {
        //
        return $user->isAdmin || $user->user_type == 'partner' || $user->client_id == $customizedSurveyFunctions->client;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CustomizedSurveyFunctions $customizedSurveyFunctions): bool
    {
        //
        return $user->isAdmin || $user->user_type == 'partner';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CustomizedSurveyFunctions $customizedSurveyFunctions): bool
    {
        //
        return $user->isAdmin;
    }
}
