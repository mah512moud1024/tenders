<?php

namespace App\Filament\Account\Resources\QuoteDocuments\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class QuoteDocumentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('quote_id')
                    ->required()
                    ->numeric(),
                TextInput::make('file_path')
                    ->required(),
                TextInput::make('original_name')
                    ->required(),
                TextInput::make('file_type')
                    ->required(),
                TextInput::make('file_size')
                    ->required()
                    ->numeric(),
            ]);
    }
}
