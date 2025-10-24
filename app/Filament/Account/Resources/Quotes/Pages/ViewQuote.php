<?php

namespace App\Filament\Account\Resources\Quotes\Pages;

use App\Filament\Account\Resources\Quotes\QuoteResource;
use App\Models\Invoice;
use App\Models\Quote;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewQuote extends ViewRecord
{
    protected static string $resource = QuoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Accept Quote Action
            Action::make('accept')
                ->label('Accept Quote')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Accept Quote')
                ->modalDescription('Are you sure you want to accept this quote? This will reject all other quotes for this tender.')
                ->action(function () {
                    $quote = $this->record;

                    // Update the tender status
                    $tender = $quote->tender;
                    $tender->status = 'assigned';
                    $tender->save();

                    // Accept the selected quote
                    $quote->status = 'accepted';
                    $quote->selected = true;
                    $quote->save();

                    // Reject all other quotes for the same tender
                    Quote::where('tender_id', $quote->tender_id)
                        ->where('id', '!=', $quote->id)
                        ->update(['status' => 'rejected']);

                    // Generate commission invoice
                    $this->generateCommissionInvoice($quote);

                    Notification::make()
                        ->title('Quote Accepted')
                        ->body('The provider has been notified.')
                        ->success()
                        ->send();

                    // Refresh the page
                    $this->refresh();
                })
                ->visible(fn (): bool => $this->record->status === 'submitted'),

            // Reject Quote Action
            Action::make('reject')
                ->label('Reject Quote')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->requiresConfirmation()
                ->modalHeading('Reject Quote')
                ->modalDescription('Are you sure you want to reject this quote?')
                ->action(function () {
                    $quote = $this->record;
                    $quote->status = 'rejected';
                    $quote->save();

                    Notification::make()
                        ->title('Quote Rejected')
                        ->success()
                        ->send();

                    // Refresh the page
                    $this->refresh();
                })
                ->visible(fn (): bool => $this->record->status === 'submitted'),
        ];
    }

    /**
     * Generate commission invoice for accepted quote
     */
    private function generateCommissionInvoice(Quote $quote): void
    {
        $commissionRate = 2.00; // 2% commission
        $commissionAmount = $quote->amount * ($commissionRate / 100);

        // Generate unique invoice number
        $invoiceNumber = 'INV-COMM-' . date('Ymd') . '-' . strtoupper(uniqid());

        try {
            Invoice::create([
                'invoice_number' => $invoiceNumber,
                'transaction_id' => null, // No transaction until paid
                'user_id' => $quote->user_id, // The business owner who submitted the quote
                'issue_date' => now(),
                'due_date' => now()->addDays(30),
                'amount' => $commissionAmount,
                'tax_amount' => 0, // No tax on commission
                'total_amount' => $commissionAmount,
                'status' => 'sent', // Invoice is sent but not paid yet
                'notes' => 'Commission for accepted quote on tender: ' . $quote->tender->title,

                // Polymorphic relationship to quote
                'invoiceable_type' => Quote::class,
                'invoiceable_id' => $quote->id,

                // Commission-specific fields
                'commission_rate' => $commissionRate,
                'quote_total_value' => $quote->amount,

                // Additional fields
                'currency' => 'AED',
                'payment_terms' => 'Commission payable within 30 days of quote acceptance',
            ]);

        } catch (\Exception $e) {
            \Log::error('Failed to generate commission invoice for quote ID: ' . $quote->id, [
                'error' => $e->getMessage()
            ]);

            Notification::make()
                ->title('Invoice Generation Failed')
                ->body('Commission invoice could not be generated. Please check logs.')
                ->danger()
                ->send();
        }
    }

    public function getMaxContentWidth(): ?string
    {
        return 'full';
    }
}
