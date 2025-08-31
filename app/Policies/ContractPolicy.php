<?php

namespace App\Policies;

use App\Models\Contract;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContractPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        // Users can view contracts they're involved in
        return true;
    }

    public function view(User $user, Contract $contract)
    {
        // The client, provider, or admin can view a contract
        return $user->id === $contract->client_id ||
            $user->id === $contract->provider_id ||
            $user->hasRole('admin');
    }

    public function create(User $user)
    {
        // Only clients can create contracts (by accepting a quote)
        return $user->hasRole('client');
    }

    public function update(User $user, Contract $contract)
    {
        // Only the client or admin can update a contract
        return $user->id === $contract->client_id || $user->hasRole('admin');
    }

    public function delete(User $user, Contract $contract)
    {
        // Only admins can delete contracts
        return $user->hasRole('admin');
    }

    public function restore(User $user, Contract $contract)
    {
        // Only admins can restore contracts
        return $user->hasRole('admin');
    }

    public function forceDelete(User $user, Contract $contract)
    {
        // Only admins can force delete contracts
        return $user->hasRole('admin');
    }

    public function sign(User $user, Contract $contract)
    {
        // The client or provider can sign the contract
        return $user->id === $contract->client_id ||
            $user->id === $contract->provider_id;
    }
}
