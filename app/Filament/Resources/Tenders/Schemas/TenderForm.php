<?php

namespace App\Filament\Resources\Tenders\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class TenderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('city_id')
                    ->required()
                    ->numeric(),
                TextInput::make('area')
                    ->default(null),
                Select::make('project_type')
                    ->options(['building' => 'Building', 'roads' => 'Roads'])
                    ->required(),
                Select::make('work_type')
                    ->options([
            'maintenance' => 'Maintenance',
            'new_construction' => 'New construction',
            'completion' => 'Completion',
        ])
                    ->required(),
                Select::make('tender_type')
                    ->options(['design' => 'Design', 'construction' => 'Construction', 'supply' => 'Supply'])
                    ->required(),
                TextInput::make('category_id')
                    ->required()
                    ->numeric(),
                TextInput::make('floors')
                    ->numeric()
                    ->default(null),
                TextInput::make('building_area')
                    ->numeric()
                    ->default(null),
                TextInput::make('land_area')
                    ->numeric()
                    ->default(null),
                TextInput::make('required_service')
                    ->default(null),
                Select::make('status')
                    ->options([
            'draft' => 'Draft',
            'pending' => 'Pending',
            'published' => 'Published',
            'assigned' => 'Assigned',
            'completed' => 'Completed',
        ])
                    ->default('draft')
                    ->required(),
                DateTimePicker::make('closing_date'),
            ]);
    }
}
