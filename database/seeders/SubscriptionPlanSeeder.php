<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubscriptionPlan;

class SubscriptionPlanSeeder extends Seeder
{
    public function run()
    {
        $plans = [
            [
                'name' => 'Basic',
                'description' => 'Basic plan with limited features',
                'price' => 99,
                'interval' => 'monthly',
                'free_quotes' => 5,
                'listing_limit' => 3,
                'featured_listing' => false,
                'active' => true,
            ],
            [
                'name' => 'Professional',
                'description' => 'Professional plan with more features',
                'price' => 199,
                'interval' => 'monthly',
                'free_quotes' => 20,
                'listing_limit' => 10,
                'featured_listing' => true,
                'active' => true,
            ],
            [
                'name' => 'Enterprise',
                'description' => 'Enterprise plan with unlimited features',
                'price' => 399,
                'interval' => 'monthly',
                'free_quotes' => 100,
                'listing_limit' => 50,
                'featured_listing' => true,
                'active' => true,
            ],
            [
                'name' => 'Basic Yearly',
                'description' => 'Basic yearly plan with limited features',
                'price' => 999,
                'interval' => 'yearly',
                'free_quotes' => 60,
                'listing_limit' => 36,
                'featured_listing' => false,
                'active' => true,
            ],
            [
                'name' => 'Professional Yearly',
                'description' => 'Professional yearly plan with more features',
                'price' => 1999,
                'interval' => 'yearly',
                'free_quotes' => 240,
                'listing_limit' => 120,
                'featured_listing' => true,
                'active' => true,
            ],
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::create($plan);
        }
    }
}
