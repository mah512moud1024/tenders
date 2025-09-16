<?php

namespace App\Filament\Account\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('first_name')
                    ->required(),
                TextInput::make('last_name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('phone')
                    ->tel()
                    ->required(),
                DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->password()
                    ->required(),
                Select::make('type')
                    ->options([
            'admin' => 'Admin',
            'client' => 'Client',
            'consultant' => 'Consultant',
            'contractor' => 'Contractor',
            'subcontractor' => 'Subcontractor',
            'supplier' => 'Supplier',
        ])
                    ->required(),
                TextInput::make('business_name')
                    ->default(null),
                TextInput::make('business_name_en')
                    ->default(null),
                Textarea::make('office_address')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('trading_license')
                    ->default(null),
                DateTimePicker::make('license_expiry'),
                Toggle::make('approved')
                    ->required(),
            ]);
    }
}
