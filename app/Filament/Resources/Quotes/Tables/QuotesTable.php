<?php

namespace App\Filament\Resources\Quotes\Tables;

use App\Models\Quote;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

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
                TextColumn::make(__('amount'))
                    ->money(__('AED')) // Change currency as needed
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
                    ->dateTime('d/m/Y h:i A')
                    ->sortable(),
            ])->defaultSort('created_at', 'desc')
            ->recordActions([
                Action::make('submit_contract')
                    ->label(__('submit'))
                    ->icon('heroicon-o-eye')
                    ->action(function (Quote $record) {
                        $record->update(['status' => 'submitted']);
                    })
                    ->visible(fn (Quote $record) => $record->status === 'under_review')
                    ->color('warning')
                    ->badge(),
                Action::make('revoke_contract')
                    ->label(__('Revoke Contract'))
                    ->icon('heroicon-o-x-circle')
                    ->action(function (Quote $record) {
                        // Notify admin about revocation
                        // This would typically send a notification
                        $record->update(['status' => 'rejected']);
                    })
                    ->visible(fn (Quote $record) => $record->status === 'accepted')
                    ->color('danger')
                    ->badge()
                    ->requiresConfirmation()
                    ->modalHeading(__('Revoke Contract'))
                    ->modalDescription(__('Are you sure you want to revoke this contract? This will notify the admin and change the status to rejected.'))
                    ->modalSubmitActionLabel(__('Yes, revoke contract')),
            ])
           ;
    }
}
