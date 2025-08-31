<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Quote;
use App\Models\Tender;
use App\Models\User;

class QuoteSeeder extends Seeder
{
    public function run()
    {
        $tenders = Tender::all();

        foreach ($tenders as $tender) {
            // Determine which users can bid on this tender based on type
            $userType = match($tender->tender_type) {
                'design' => 'consultant',
                'construction' => 'contractor',
                'supply' => 'supplier',
                default => 'consultant'
            };

            $users = User::where('type', $userType)->where('approved', true)->get();

            if ($users->count() > 0) {
                // Create 1-3 quotes for each tender
                $quoteCount = rand(1, 3);

                for ($i = 0; $i < $quoteCount; $i++) {
                    Quote::create([
                        'tender_id' => $tender->id,
                        'user_id' => $users->random()->id,
                        'amount' => rand(10000, 1000000),
                        'proposal' => 'We propose to deliver the highest quality service for your project. Our team has extensive experience in this field and we are confident we can meet your requirements.',
                        'status' => 'submitted',
                        'selected' => false,
                    ]);
                }
            }
        }

        // Mark one quote as selected for some tenders
        $someTenders = Tender::inRandomOrder()->limit(5)->get();

        foreach ($someTenders as $tender) {
            $quote = $tender->quotes->first();
            if ($quote) {
                $quote->update([
                    'status' => 'accepted',
                    'selected' => true,
                ]);
            }
        }
    }
}
