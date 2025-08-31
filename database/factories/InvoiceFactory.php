<?php

namespace Database\Factories;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    public function definition()
    {
        $statuses = ['draft', 'sent', 'paid', 'overdue'];
        $transaction = Transaction::inRandomOrder()->first() ?? TransactionFactory::new()->completed()->create();

        return [
            'invoice_number' => 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(6)),
            'transaction_id' => $transaction->id,
            'user_id' => $transaction->user_id,
            'issue_date' => now(),
            'due_date' => now()->addDays(15),
            'amount' => $transaction->amount,
            'tax_amount' => $transaction->amount * 0.15, // 15% tax
            'total_amount' => $transaction->amount * 1.15, // amount + tax
            'status' => $this->faker->randomElement($statuses),
            'notes' => $this->faker->boolean(30) ? $this->faker->sentence : null,
        ];
    }

    public function paid()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'paid',
            ];
        });
    }
}
