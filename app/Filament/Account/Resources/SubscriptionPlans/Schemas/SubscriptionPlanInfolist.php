<?php

namespace App\Filament\Account\Resources\SubscriptionPlans\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class SubscriptionPlanInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('description'),
                TextEntry::make('price')
                    ->money(),
                TextEntry::make('interval'),
                TextEntry::make('free_quotes')
                    ->numeric(),
                TextEntry::make('listing_limit')
                    ->numeric(),
                IconEntry::make('featured_listing')
                    ->boolean(),
                IconEntry::make('active')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
