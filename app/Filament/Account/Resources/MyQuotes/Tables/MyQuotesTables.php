<?php

namespace App\Filament\Account\Resources\MyQuotes\Tables;
use App\Filament\Account\Pages\ViewTender;
use App\Models\Quote;

use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;


class MyQuotesTables
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
                TextColumn::make('issue_date')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('amount')
                    ->money('AED', locale: 'en')
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'submitted' => 'gray',
                        'under_review' => 'warning',
                        'accepted' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('documents_count')
                    ->label('Documents')
                    ->counts('documents')
                    ->badge()
                    ->color(fn ($state) => $state > 0 ? 'primary' : 'gray'),

            ])->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
            ]);
    }
}
