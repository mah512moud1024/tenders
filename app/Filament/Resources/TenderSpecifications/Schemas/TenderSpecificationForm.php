<?php

namespace App\Filament\Resources\TenderSpecifications\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TenderSpecificationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('tender_id')
                    ->required()
                    ->numeric(),
                TextInput::make('specifiable_type')
                    ->required(),
                TextInput::make('specifiable_id')
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
