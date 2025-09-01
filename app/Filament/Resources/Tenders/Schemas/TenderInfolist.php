<?php

namespace App\Filament\Resources\Tenders\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TenderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title'),
                TextEntry::make('user_id')
                    ->numeric(),
                TextEntry::make('city_id')
                    ->numeric(),
                TextEntry::make('area'),
                TextEntry::make('project_type'),
                TextEntry::make('work_type'),
                TextEntry::make('tender_type'),
                TextEntry::make('category_id')
                    ->numeric(),
                TextEntry::make('floors')
                    ->numeric(),
                TextEntry::make('building_area')
                    ->numeric(),
                TextEntry::make('land_area')
                    ->numeric(),
                TextEntry::make('required_service'),
                TextEntry::make('status'),
                TextEntry::make('closing_date')
                    ->dateTime(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
