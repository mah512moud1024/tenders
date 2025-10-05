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

            // Create invoice with new structure
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

                // New fields for polymorphic relationship
                'invoiceable_type' => Subscription::class,
                'invoiceable_id' => $subscription->id,

                // Commission fields (null for subscription invoices)
                'commission_rate' => null,
                'quote_total_value' => null,

                // Additional fields
                'currency' => 'USD',
                'payment_terms' => 'Payment due within 15 days',
            ]);
        }

        // Optional: Create some commission invoices without transactions (for testing)
        $this->createCommissionInvoices();
    }

    private function createCommissionInvoices()
    {
        // Get some service providers to create commission invoices for
        $providers = User::where('type', '!=', 'client')
            ->where('approved', true)
            ->take(3)
            ->get();

        foreach ($providers as $provider) {
            // Create a commission invoice without transaction (unpaid)
            Invoice::create([
                'invoice_number' => 'INV-COMM-' . date('Ymd') . '-' . strtoupper(uniqid()),
                'transaction_id' => null, // No transaction yet - invoice is unpaid
                'user_id' => $provider->id,
                'issue_date' => now(),
                'due_date' => now()->addDays(30),
                'amount' => 500.00, // Example commission amount
                'tax_amount' => 75.00, // 15% tax
                'total_amount' => 575.00,
                'status' => 'sent', // Not paid yet
                'notes' => 'Commission for accepted quote on tender #TDR-001',

                // Link to quote (assuming you have a Quote model)
                'invoiceable_type' => 'App\\Models\\Quote', // Update with your actual Quote model
                'invoiceable_id' => 1, // Example quote ID

                // Commission-specific fields
                'commission_rate' => 5.00, // 5% commission
                'quote_total_value' => 10000.00, // Total value of the accepted quote

                // Additional fields
                'currency' => 'USD',
                'payment_terms' => 'Commission payable within 30 days of quote acceptance',
            ]);
        }
    }
}
