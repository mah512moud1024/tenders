<?php

namespace App\Filament\Account\Resources\Contracts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ContractsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tender_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('quote_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('client_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('provider_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('contract_number')
                    ->searchable(),
                TextColumn::make('agreed_amount')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('start_date')
                    ->datetime('d/m/Y H:i')
                    ->sortable(),
                TextColumn::make('end_date')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                TextColumn::make('status'),
                TextColumn::make('signed_contract_file')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
