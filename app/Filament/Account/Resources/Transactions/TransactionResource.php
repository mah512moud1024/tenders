<?php

namespace App\Filament\Account\Resources\Transactions;

use App\Filament\Account\Resources\Transactions\Pages\CreateTransaction;
use App\Filament\Account\Resources\Transactions\Pages\EditTransaction;
use App\Filament\Account\Resources\Transactions\Pages\ListTransactions;
use App\Filament\Account\Resources\Transactions\Pages\ViewTransaction;
use App\Filament\Account\Resources\Transactions\Schemas\TransactionForm;
use App\Filament\Account\Resources\Transactions\Schemas\TransactionInfolist;
use App\Filament\Account\Resources\Transactions\Tables\TransactionsTable;
use App\Models\Transaction;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCurrencyDollar;

    protected static ?string $recordTitleAttribute = 'Transactions';

    public static function form(Schema $schema): Schema
    {
        return TransactionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TransactionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TransactionsTable::configure($table);
    }
    public static function getEloquentQuery(): Builder
    {
        // This ensures users only see their own quotes
        return parent::getEloquentQuery()->where('user_id', Auth::id());
    }
    public static function canCreate(): bool
    {
        return false;
    }
    public function canCreateAnother(): bool
    {
        return false;
    }
    public static function canEdit($record): bool
    {
        return false;
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }



    public static function getPages(): array
    {
        return [
            'index' => ListTransactions::route('/'),

            'view' => ViewTransaction::route('/{record}'),
            'edit' => EditTransaction::route('/{record}/edit'),
        ];
    }
}
