<?php

namespace Database\Factories;

use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionFactory extends Factory
{
    public function definition()
    {
        $statuses = ['active', 'pending', 'canceled', 'expired'];
        $plan = SubscriptionPlan::inRandomOrder()->first() ?? SubscriptionPlanFactory::new()->create();

        return [
            'user_id' => User::where('type', '!=', 'client')->inRandomOrder()->first()->id ??
                User::factory()->consultant()->create()->id,
            'plan_id' => $plan->id,
            'starts_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'ends_at' => $this->faker->dateTimeBetween('now', '+1 year'),
            'trial_ends_at' => $this->faker->boolean(30) ? $this->faker->dateTimeBetween('now', '+15 days') : null,
            'remaining_quotes' => $plan->free_quotes,
            'status' => $this->faker->randomElement($statuses),
        ];
    }

    public function active()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'active',
                'starts_at' => now(),
                'ends_at' => now()->addMonth(),
            ];
        });
    }
}
