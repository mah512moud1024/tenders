<?php

namespace App\Filament\Account\Resources\TenderSpecifications\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TenderSpecificationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tender_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('specifiable_type')
                    ->searchable(),
                TextColumn::make('specifiable_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('file_path')
                    ->searchable(),
                TextColumn::make('original_name')
                    ->searchable(),
                TextColumn::make('file_type')
                    ->searchable(),
                TextColumn::make('file_size')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
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
