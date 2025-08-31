<?php

namespace Database\Factories;

use App\Models\Quote;
use App\Models\Tender;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContractFactory extends Factory
{
    public function definition()
    {
        $quote = Quote::inRandomOrder()->first() ?? QuoteFactory::new()->accepted()->create();
        $tender = $quote->tender;

        return [
            'tender_id' => $tender->id,
            'quote_id' => $quote->id,
            'client_id' => $tender->user_id,
            'provider_id' => $quote->user_id,
            'contract_number' => 'CON-' . strtoupper(Str::random(8)),
            'terms' => $this->faker->paragraphs(5, true),
            'agreed_amount' => $quote->amount,
            'start_date' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'end_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'status' => $this->faker->randomElement(['draft', 'active', 'completed', 'terminated']),
            'signed_contract_file' => $this->faker->boolean(70) ? 'contracts/' . Str::random(10) . '.pdf' : null,
        ];
    }

    public function active()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'active',
            ];
        });
    }
}
