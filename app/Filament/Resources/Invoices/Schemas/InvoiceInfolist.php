<?php

namespace App\Filament\Resources\Invoices\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class InvoiceInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('invoice_number'),
                TextEntry::make('transaction_id')
                    ->numeric(locale: 'en'),
                TextEntry::make('user_id')
                    ->numeric(locale: 'en'),
                TextEntry::make('issue_date')
                    ->date(),
                TextEntry::make('due_date')
                    ->date(),
                TextEntry::make('amount')
                    ->numeric(locale: 'en'),
                TextEntry::make('tax_amount')
                    ->numeric(locale: 'en'),
                TextEntry::make('total_amount')
                    ->numeric(locale: 'en'),
                TextEntry::make('status'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
