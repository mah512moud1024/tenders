<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionPlanFactory extends Factory
{
    public function definition()
    {
        $plans = [
            ['name' => 'Basic', 'price' => 99, 'free_quotes' => 5, 'listing_limit' => 3],
            ['name' => 'Professional', 'price' => 199, 'free_quotes' => 20, 'listing_limit' => 10],
            ['name' => 'Enterprise', 'price' => 399, 'free_quotes' => 100, 'listing_limit' => 50],
        ];

        $plan = $this->faker->randomElement($plans);

        return [
            'name' => $plan['name'],
            'description' => $this->faker->sentence,
            'price' => $plan['price'],
            'interval' => $this->faker->randomElement(['monthly', 'yearly']),
            'free_quotes' => $plan['free_quotes'],
            'listing_limit' => $plan['listing_limit'],
            'featured_listing' => $this->faker->boolean(30),
            'active' => true,
        ];
    }

    public function monthly()
    {
        return $this->state(function (array $attributes) {
            return [
                'interval' => 'monthly',
            ];
        });
    }

    public function yearly()
    {
        return $this->state(function (array $attributes) {
            return [
                'interval' => 'yearly',
            ];
        });
    }
}
