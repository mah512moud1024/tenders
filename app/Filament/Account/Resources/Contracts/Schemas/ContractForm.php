<?php

namespace App\Filament\Account\Resources\Contracts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ContractForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('tender_id')
                    ->required()
                    ->numeric(),
                TextInput::make('quote_id')
                    ->required()
                    ->numeric(),
                TextInput::make('client_id')
                    ->required()
                    ->numeric(),
                TextInput::make('provider_id')
                    ->required()
                    ->numeric(),
                TextInput::make('contract_number')
                    ->required(),
                Textarea::make('terms')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('agreed_amount')
                    ->required()
                    ->numeric(),
                DateTimePicker::make('start_date'),
                DateTimePicker::make('end_date'),
                Select::make('status')
                    ->options([
            'draft' => 'Draft',
            'active' => 'Active',
            'completed' => 'Completed',
            'terminated' => 'Terminated',
        ])
                    ->default('draft')
                    ->required(),
                TextInput::make('signed_contract_file')
                    ->default(null),
            ]);
    }
}
