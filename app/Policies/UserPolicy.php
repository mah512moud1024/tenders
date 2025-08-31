<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        // Only admins can view all users
        return $user->hasRole('admin');
    }

    public function view(User $user, User $model)
    {
        // Users can view their own profile, admins can view any
        return $user->id === $model->id || $user->hasRole('admin');
    }

    public function create(User $user)
    {
        // Only admins can create users (though registration is public)
        return $user->hasRole('admin');
    }

    public function update(User $user, User $model)
    {
        // Users can update their own profile, admins can update any
        return $user->id === $model->id || $user->hasRole('admin');
    }

    public function delete(User $user, User $model)
    {
        // Only admins can delete users (and cannot delete themselves)
        return $user->hasRole('admin') && $user->id !== $model->id;
    }

    public function restore(User $user, User $model)
    {
        // Only admins can restore users
        return $user->hasRole('admin');
    }

    public function forceDelete(User $user, User $model)
    {
        // Only admins can force delete users (and cannot delete themselves)
        return $user->hasRole('admin') && $user->id !== $model->id;
    }

    public function approve(User $user, User $model)
    {
        // Only admins can approve service providers
        return $user->hasRole('admin') &&
            $model->hasAnyRole(['consultant', 'contractor', 'supplier']);
    }


}
