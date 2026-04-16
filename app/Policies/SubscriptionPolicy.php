<?php

namespace App\Policies;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubscriptionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        // Users can view their own subscriptions, admins can view all
        return true;
    }

    public function view(User $user, Subscription $subscription)
    {
        // The subscription owner or admin can view a subscription
        return $user->id === $subscription->user_id || $user->hasRole('admin');
    }

    public function create(User $user)
    {
        // Only service providers can create subscriptions
        return $user->hasAnyRole(['consultant', 'contractor', 'supplier', 'admin']);
    }

    public function update(User $user, Subscription $subscription)
    {
        // Only the subscription owner or admin can update a subscription
        return $user->id === $subscription->user_id || $user->hasRole('admin');
    }

    public function delete(User $user, Subscription $subscription)
    {
        // Only admins can delete subscriptions
        return $user->hasRole('admin');
    }

    public function restore(User $user, Subscription $subscription)
    {
        // Only admins can restore subscriptions
        return $user->hasRole('admin');
    }

    public function forceDelete(User $user, Subscription $subscription)
    {
        // Only admins can force delete subscriptions
        return $user->hasRole('admin');
    }

    public function cancel(User $user, Subscription $subscription)
    {
        // The subscription owner can cancel their subscription
        return $user->id === $subscription->user_id;
    }
}
