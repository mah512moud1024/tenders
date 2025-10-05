<?php

namespace App\Filament\Account\Resources\Quotes\Tables;

use App\Filament\Account\Resources\QuoteResource\Pages;
use App\Models\Quote;
use Filament\Infolists;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use App\Models\Invoice;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Illuminate\Support\Collection;
class QuotesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tender.title')
                    ->label('Tender')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.business_name')
                    ->label('Submitted By')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('amount')
                    ->money('SAR') // Change currency as needed
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'submitted' => 'gray',
                        'under_review' => 'warning',
                        'accepted' => 'success',
                        'rejected' => 'danger',
                    }),
                TextColumn::make('created_at')
                    ->label('Submitted On')
                    ->dateTime()
                    ->sortable(),
            ]) ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    // Action to view/download attached documents
                    Action::make('viewDocuments')
                        ->label('View Documents')
                        ->icon('heroicon-o-paper-clip')
                        ->modalContent(fn(Quote $record) => view(
                            'filament.modals.quote-documents',
                            ['documents' => $record->documents]
                        ))
                        ->modalSubmitAction(false) // Hides the submit button
                        ->modalCancelAction(false), // Hides the cancel button

                    // Action to accept a quote
                    Action::make('accept')
                        ->label('Accept Quote')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Accept Quote')
                        ->modalDescription('Are you sure you want to accept this quote? This will reject all other quotes for this tender.')
                        ->action(function (Quote $record) {
                            // Update the tender status
                            $tender = $record->tender;
                            $tender->status = 'assigned';
                            $tender->save();

                            // Accept the selected quote
                            $record->status = 'accepted';
                            $record->selected = true;
                            $record->save();

                            // Reject all other quotes for the same tender
                            Quote::where('tender_id', $record->tender_id)
                                ->where('id', '!=', $record->id)
                                ->update(['status' => 'rejected']);

                            self::generateCommissionInvoice($record);

                            Notification::make()
                                ->title('Quote Accepted')
                                ->body('The provider has been notified.')
                                ->success()
                                ->send();
                        })
                        // Only show this button if the quote is still 'submitted'
                        ->visible(fn(Quote $record): bool => $record->status === 'submitted'),

                    // Action to reject a quote
                    Action::make('reject')
                        ->label('Reject Quote')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(function (Quote $record) {
                            $record->status = 'rejected';
                            $record->save();
                            Notification::make()
                                ->title('Quote Rejected')
                                ->success()
                                ->send();
                        })
                        // Only show this button if the quote is still 'submitted'
                        ->visible(fn(Quote $record): bool => $record->status === 'submitted'),
                ]),
            ]);

    }
    /**
     * Generate commission invoice for accepted quote
     */
    private static function generateCommissionInvoice(Quote $quote): void
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
                'currency' => 'SAR',
                'payment_terms' => 'Commission payable within 30 days of quote acceptance',
            ]);

        } catch (\Exception $e) {
            \Log::error('Failed to generate commission invoice for quote ID: ' . $quote->id, [
                'error' => $e->getMessage()
            ]);

            // You can also send a notification about the failure
            Notification::make()
                ->title('Invoice Generation Failed')
                ->body('Commission invoice could not be generated. Please check logs.')
                ->danger()
                ->send();
        }
    }

}
