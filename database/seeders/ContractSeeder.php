<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contract;
use App\Models\Quote;
use App\Models\Tender;

class ContractSeeder extends Seeder
{
    public function run()
    {
        // Get quotes that have been accepted
        $acceptedQuotes = Quote::where('status', 'accepted')->where('selected', true)->get();

        foreach ($acceptedQuotes as $quote) {
            Contract::create([
                'tender_id' => $quote->tender_id,
                'quote_id' => $quote->id,
                'client_id' => $quote->tender->user_id,
                'provider_id' => $quote->user_id,
                'contract_number' => 'CON-' . strtoupper(uniqid()),
                'terms' => 'This contract is made and entered into by and between the Client and the Provider. The Provider agrees to provide services as described in the tender and quote.',
                'agreed_amount' => $quote->amount,
                'start_date' => now(),
                'end_date' => now()->addMonths(rand(6, 24)),
                'status' => 'active',
                'signed_contract_file' => 'contracts/contract-' . $quote->id . '.pdf',
            ]);

            // Update tender status to assigned
            $quote->tender->update(['status' => 'assigned']);
        }
    }
}
