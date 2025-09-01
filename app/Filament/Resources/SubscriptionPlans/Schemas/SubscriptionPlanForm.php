<?php

namespace App\Filament\Resources\SubscriptionPlans\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SubscriptionPlanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('description')
                    ->default(null),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                Select::make('interval')
                    ->options(['monthly' => 'Monthly', 'yearly' => 'Yearly'])
                    ->required(),
                TextInput::make('free_quotes')
                    ->required()
                    ->numeric()
                    ->default(2),
                TextInput::make('listing_limit')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('featured_listing')
                    ->required(),
                Toggle::make('active')
                    ->required(),
            ]);
    }
}
