<?php

namespace App\Policies;

use App\Models\Quote;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuotePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        // Users can view their own quotes, admins can view all
        return true;
    }

    public function view(User $user, Quote $quote)
    {
        // The quote owner, tender owner, or admin can view a quote
        return $user->id === $quote->user_id ||
            $user->id === $quote->tender->user_id ||
            $user->hasRole('admin');
    }

    public function create(User $user)
    {
        // Only consultants, contractors, and suppliers can create quotes
        return $user->hasAnyRole(['consultant', 'contractor', 'supplier']);
    }

    public function update(User $user, Quote $quote)
    {
        // Only the quote owner can update their quote (if not yet accepted)
        return $user->id === $quote->user_id &&
            $quote->status !== 'accepted';
    }

    public function delete(User $user, Quote $quote)
    {
        // Only the quote owner or admin can delete a quote
        return $user->id === $quote->user_id || $user->hasRole('admin');
    }

    public function restore(User $user, Quote $quote)
    {
        // Only admins can restore quotes
        return $user->hasRole('admin');
    }

    public function forceDelete(User $user, Quote $quote)
    {
        // Only admins can force delete quotes
        return $user->hasRole('admin');
    }

    public function accept(User $user, Quote $quote)
    {
        // Only the tender owner can accept a quote
        return $user->id === $quote->tender->user_id;
    }
}
