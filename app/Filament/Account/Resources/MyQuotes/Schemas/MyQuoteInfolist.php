<?php

namespace App\Filament\Account\Resources\MyQuotes\Schemas;


use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
class MyQuoteInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('tender_id'),
                TextEntry::make('tender.title'),
                TextEntry::make('user_id')
                    ->numeric(locale: 'en'),
                TextEntry::make('amount')
                    ->numeric(locale: 'en'),
                TextEntry::make('proposal'),
                TextEntry::make('status'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
