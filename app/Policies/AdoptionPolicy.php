<?php

namespace App\Policies;

use App\Models\Adoption;
use App\Models\User;

class AdoptionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Adoption $adoption): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('store adoption');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Adoption $adoption): bool
    {
        return $user->hasPermissionTo('update adoption');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Adoption $adoption): bool
    {
        return $user->hasPermissionTo('delete adoption');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Adoption $adoption): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Adoption $adoption): bool
    {
        return $user->hasPermissionTo('delete adoption');
    }
}
