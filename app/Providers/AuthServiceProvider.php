<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\{
    Tender, Quote, Contract, User, Subscription
};
use App\Policies\{
    TenderPolicy, QuotePolicy, ContractPolicy, UserPolicy,
    SubscriptionPolicy
};

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Tender::class => TenderPolicy::class,
        Quote::class => QuotePolicy::class,
        Contract::class => ContractPolicy::class,
        User::class => UserPolicy::class,
        Subscription::class => SubscriptionPolicy::class,

    ];

    public function boot()
    {
        $this->registerPolicies();

        // Define additional gates based on user types
        Gate::define('create-tender', function ($user) {
            return $user->hasRole('client');
        });

        Gate::define('create-quote', function ($user) {
            return $user->hasAnyRole(['consultant', 'contractor', 'supplier']);
        });

        Gate::define('manage-platform', function ($user) {
            return $user->hasRole('admin');
        });
    }
}
