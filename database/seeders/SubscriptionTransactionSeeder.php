<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\Transaction;
use App\Models\Invoice;
use App\Models\User;

class SubscriptionTransactionSeeder extends Seeder
{
    public function run()
    {
        $serviceProviders = User::where('type', '!=', 'client')->where('approved', true)->get();
        $plans = SubscriptionPlan::all();

        foreach ($serviceProviders as $provider) {
            $plan = $plans->random();

            // Create subscription
            $subscription = Subscription::create([
                'user_id' => $provider->id,
                'plan_id' => $plan->id,
                'starts_at' => now(),
                'ends_at' => $plan->interval === 'monthly' ? now()->addMonth() : now()->addYear(),
                'trial_ends_at' => null,
                'remaining_quotes' => $plan->free_quotes,
                'status' => 'active',
            ]);

            // Create transaction
            $transaction = Transaction::create([
                'transaction_id' => 'TXN-' . strtoupper(uniqid()),
                'user_id' => $provider->id,
                'payable_type' => Subscription::class,
                'payable_id' => $subscription->id,
                'amount' => $plan->price,
                'platform_fee' => $plan->price * 0.1, // 10% platform fee
                'payment_method' => 'credit_card',
                'status' => 'completed',
                'notes' => 'Subscription payment for ' . $plan->name . ' plan',
            ]);

            // Create invoice
            Invoice::create([
                'invoice_number' => 'INV-' . date('Ymd') . '-' . strtoupper(uniqid()),
                'transaction_id' => $transaction->id,
                'user_id' => $provider->id,
                'issue_date' => now(),
                'due_date' => now()->addDays(15),
                'amount' => $plan->price,
                'tax_amount' => $plan->price * 0.15, // 15% tax
                'total_amount' => $plan->price * 1.15, // amount + tax
                'status' => 'paid',
                'notes' => 'Invoice for subscription to ' . $plan->name . ' plan',
            ]);
        }
    }
}
