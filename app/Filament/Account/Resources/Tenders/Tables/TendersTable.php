<?php

namespace App\Filament\Account\Resources\Tenders\Tables;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;


class TendersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('city.name')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'gray' => 'draft',
                        'warning' => 'pending',
                        'success' => 'published',
                        'primary' => 'assigned',
                        'danger' => 'completed',
                    ]),
                Tables\Columns\TextColumn::make('closing_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quotes_count')
                    ->label('Quotes')
                    ->counts('quotes'),
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
