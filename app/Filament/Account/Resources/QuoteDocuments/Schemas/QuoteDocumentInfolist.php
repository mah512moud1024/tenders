<?php

namespace App\Filament\Account\Resources\QuoteDocuments\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class QuoteDocumentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('quote_id')
                    ->numeric(),
                TextEntry::make('file_path'),
                TextEntry::make('original_name'),
                TextEntry::make('file_type'),
                TextEntry::make('file_size')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
