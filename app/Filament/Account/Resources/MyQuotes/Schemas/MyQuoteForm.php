<?php

namespace App\Filament\Account\Resources\MyQuotes\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MyQuoteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextEntry::make('tender_id'),
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
