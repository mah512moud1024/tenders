<?php

namespace App\Filament\Account\Resources\Transactions\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TransactionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('transaction_id'),
                TextEntry::make('user_id')
                    ->numeric(),
                TextEntry::make('payable_type'),
                TextEntry::make('payable_id')
                    ->numeric(),
                TextEntry::make('amount')
                    ->numeric(),
                TextEntry::make('platform_fee')
                    ->numeric(),
                TextEntry::make('payment_method'),
                TextEntry::make('status'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
