<?php

namespace App\Filament\Account\Resources\Contracts\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ContractInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('tender_id')
                    ->numeric(),
                TextEntry::make('quote_id')
                    ->numeric(),
                TextEntry::make('client_id')
                    ->numeric(),
                TextEntry::make('provider_id')
                    ->numeric(),
                TextEntry::make('contract_number'),
                TextEntry::make('agreed_amount')
                    ->numeric(),
                TextEntry::make('start_date')
                    ->dateTime(),
                TextEntry::make('end_date')
                    ->dateTime(),
                TextEntry::make('status'),
                TextEntry::make('signed_contract_file'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
