<?php

namespace App\Filament\Resources\Tenders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TendersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('city_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('area')
                    ->searchable(),
                TextColumn::make('project_type'),
                TextColumn::make('work_type'),
                TextColumn::make('tender_type'),
                TextColumn::make('category_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('floors')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('building_area')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('land_area')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('required_service')
                    ->searchable(),
                TextColumn::make('status'),
                TextColumn::make('closing_date')
                    ->dateTime()
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
