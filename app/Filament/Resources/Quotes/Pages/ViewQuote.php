<?php

namespace App\Filament\Resources\Quotes\Pages;

use App\Filament\Resources\Quotes\QuoteResource;
use App\Models\Quote;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Actions;

class ViewQuote extends ViewRecord
{
    protected static string $resource = QuoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            Action::make('revoke_contract')
                ->label(__('Revoke Contract'))
                ->icon('heroicon-o-x-circle')
                ->action(function (Quote $record) {
                    // Notify admin about revocation
                    $record->update(['status' => 'rejected']);
                })
                ->visible(fn (Quote $record) => $record->status === 'accepted')
                ->color('danger')
                ->requiresConfirmation()
                ->modalHeading(__('Revoke Contract'))
                ->modalDescription(__('Are you sure you want to revoke this contract? This will notify the admin and change the status to rejected.'))
                ->modalSubmitActionLabel(__('Yes, revoke contract')),

            Action::make('submit_contract')
                ->label(__('submit tender'))
                ->icon('heroicon-o-eye')
                ->action(function (Quote $record) {
                    // Notify admin about revocation
                    $record->update(['status' => 'submitted']);
                })
                ->visible(fn (Quote $record) => $record->status === 'under_review')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading(__('submit tender'))
                ->modalDescription(__('Are you sure you want to revoke this contract? This will notify the admin and change the status to rejected.'))
                ->modalSubmitActionLabel(__('Yes, revoke contract')),
        ];
    }
}
