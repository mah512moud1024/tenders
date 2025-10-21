<?php

namespace App\Filament\Account\Resources\Invoices\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InvoicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('invoice_number')
                    ->searchable(),
                TextColumn::make('issue_date')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('amount')
                    ->money('AED', locale: 'en')
                    ->sortable(),
                TextColumn::make('tax_amount')
                    ->money('AED', locale: 'en')
                    ->sortable(),
                TextColumn::make('total_amount')
                    ->money('AED', locale: 'en')
                    ->sortable(),
                TextColumn::make('status'),
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
                // Add PDF download action
                Action::make('downloadPdf')
                    ->label('Download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('primary')
                    ->button()
                    ->url(fn ($record) => route('invoices.download-pdf', $record))
                    ->openUrlInNewTab(),
            ])
            ;
    }

}
