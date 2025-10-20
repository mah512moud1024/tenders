<?php

namespace App\Filament\Account\Resources\MyQuotes\Tables;

use App\Filament\Account\Pages\ViewTender;
use App\Models\Quote;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MyQuotesTabl
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tender.title')
                    ->label('Tender Title')
                    ->searchable()
                    ->sortable()
                    ->url(fn (Quote $record): string => ViewTender::getUrl(['record' => $record->tender_id])),

                TextColumn::make('amount')
                    ->money('SAR')
                    ->sortable(),

                BadgeColumn::make('status')
                    ->colors([
                        'primary' => 'under_review',
                        'warning' => 'submitted',
                        'success' => 'accepted',
                        'danger' => 'rejected',
                    ])
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Submitted On')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                ViewAction::make(),
                // Add PDF download action

            ])
            ->defaultSort('created_at', 'desc');
    }
}
