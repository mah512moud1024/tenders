<?php

namespace Database\Factories;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    public function definition()
    {
        $statuses = ['pending', 'completed', 'failed', 'refunded'];
        $paymentMethods = ['credit_card', 'bank_transfer', 'apple_pay', 'google_pay'];

        $user = User::where('type', '!=', 'client')->inRandomOrder()->first() ??
            User::factory()->consultant()->create();

        $subscription = Subscription::where('user_id', $user->id)->inRandomOrder()->first() ??
            SubscriptionFactory::new()->create(['user_id' => $user->id]);

        return [
            'transaction_id' => 'TXN-' . strtoupper(Str::random(10)),
            'user_id' => $user->id,
            'payable_type' => Subscription::class,
            'payable_id' => $subscription->id,
            'amount' => $subscription->plan->price,
            'platform_fee' => $subscription->plan->price * 0.1, // 10% platform fee
            'payment_method' => $this->faker->randomElement($paymentMethods),
            'status' => $this->faker->randomElement($statuses),
            'notes' => $this->faker->boolean(50) ? $this->faker->sentence : null,
        ];
    }

    public function completed()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'completed',
            ];
        });
    }
}
