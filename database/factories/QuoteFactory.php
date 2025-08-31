<?php

namespace Database\Factories;

use App\Models\Tender;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuoteFactory extends Factory
{
    public function definition()
    {
        $statuses = ['submitted', 'under_review', 'accepted', 'rejected'];

        return [
            'tender_id' => Tender::inRandomOrder()->first()->id ?? TenderFactory::new()->create()->id,
            'user_id' => User::where('type', '!=', 'client')->inRandomOrder()->first()->id ??
                User::factory()->consultant()->create()->id,
            'amount' => $this->faker->randomFloat(2, 1000, 1000000),
            'proposal' => $this->faker->paragraphs(3, true),
            'status' => $this->faker->randomElement($statuses),
            'selected' => $this->faker->boolean(20), // 20% chance of being selected
        ];
    }

    public function accepted()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'accepted',
                'selected' => true,
            ];
        });
    }
}
