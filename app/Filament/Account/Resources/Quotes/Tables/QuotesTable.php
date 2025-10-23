<?php

namespace App\Filament\Account\Resources\Quotes\Tables;

use App\Filament\Account\Resources\QuoteResource\Pages;
use App\Models\Quote;
use Filament\Infolists;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use App\Models\Invoice;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Illuminate\Support\Collection;
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
                    ViewAction::make(),
            ]);

    }
    /**
     * Generate commission invoice for accepted quote
     */


}
