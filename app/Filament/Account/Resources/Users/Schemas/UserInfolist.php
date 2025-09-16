<?php

namespace App\Filament\Account\Resources\Users\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('first_name'),
                TextEntry::make('last_name'),
                TextEntry::make('email')
                    ->label('Email address'),
                TextEntry::make('phone'),
                TextEntry::make('email_verified_at')
                    ->dateTime(),
                TextEntry::make('type'),
                TextEntry::make('business_name'),
                TextEntry::make('business_name_en'),
                TextEntry::make('trading_license'),
                TextEntry::make('license_expiry')
                    ->dateTime(),
                IconEntry::make('approved')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
