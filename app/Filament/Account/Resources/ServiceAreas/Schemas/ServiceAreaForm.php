<?php

namespace App\Filament\Account\Resources\ServiceAreas\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ServiceAreaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('city_id')
                    ->required()
                    ->numeric(),
            ]);
    }
}
