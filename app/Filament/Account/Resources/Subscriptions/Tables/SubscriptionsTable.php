<?php

namespace App\Filament\Account\Resources\Subscriptions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SubscriptionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('plan.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('starts_at')
                    ->dateTime('d/m/Y H:i')

                    ->sortable(),
                TextColumn::make('ends_at')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'canceled' => 'gray',
                        'pending' => 'warning',
                        'active' => 'success',
                        'expired' => 'danger',
                    }),

            ])->defaultSort('starts_at', 'desc')
            ->filters([
                //
            ]);
    }
}
