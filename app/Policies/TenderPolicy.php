<?php

namespace App\Policies;

use App\Models\Tender;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TenderPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        // All users can view tenders
        return true;
    }

    public function view(User $user, Tender $tender)
    {
        // All users can view individual tenders
        return true;
    }

    public function create(User $user)
    {
        // Only clients can create tenders
        return $user->hasAnyRole(['client', 'admin' ,'consultant']);

    }

    public function update(User $user, Tender $tender)
    {
        // Only the owner (client) can update their tender
        return ($user->id === $tender->user_id) || ($user->hasRole('admin'));
    }

    public function delete(User $user, Tender $tender)
    {
        // Only the owner (client) can delete their tender
        return $user->id === $tender->user_id;
    }

    public function restore(User $user, Tender $tender)
    {
        // Only admins can restore tenders
        return $user->hasRole('admin');
    }

    public function forceDelete(User $user, Tender $tender)
    {
        // Only admins can force delete tenders
        return $user->hasRole('admin');
    }

    public function submitQuote(User $user, Tender $tender)
    {
        // Only consultants, contractors, and suppliers can submit quotes
        // And only if the tender is still open
        return $user->hasAnyRole(['consultant', 'contractor', 'supplier']) &&
            $tender->status === 'published' &&
            $tender->closing_date > now();
    }

    public function selectQuote(User $user, Tender $tender)
    {
        // Only the tender owner can select quotes
        return $user->id === $tender->user_id;
    }
}
