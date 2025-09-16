<?php

namespace App\Filament\Account\Resources\Tenders\Schemas;

use App\Models\City;
use App\Models\ProjectCategory;
use Filament\Forms;
use Filament\Schemas\Components\Section;

class TenderForm
{
    public static function getSchema(): array
    {
        return [
            Section::make('Tender Details')
                ->description('Provide the main details of your project.')
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\RichEditor::make('description')
                        ->columnSpanFull(),
                    Forms\Components\Select::make('city_id')
                        ->label('City')
                        ->options(City::where('active', true)->pluck('name', 'id'))
                        ->searchable()
                        ->required(),
                    Forms\Components\TextInput::make('area')
                        ->label('Neighborhood / Area')
                        ->maxLength(255),
                    Forms\Components\DatePicker::make('closing_date')
                        ->required()
                        ->native(false)
                        ->minDate(now()),
                ])->columns(2),

            Section::make('Project Specifications')
                ->schema([
                    Forms\Components\Select::make('project_type')
                        ->options([
                            'building' => 'Building',
                            'roads' => 'Roads',
                        ])
                        ->required(),
                    Forms\Components\Select::make('work_type')
                        ->options([
                            'maintenance' => 'Maintenance',
                            'new_construction' => 'New Construction',
                            'completion' => 'Completion',
                        ])
                        ->required(),
                    Forms\Components\Select::make('tender_type')
                        ->options([
                            'design' => 'Design',
                            'construction' => 'Construction',
                            'supply' => 'Supply',
                        ])
                        ->required(),
                    Forms\Components\Select::make('category_id')
                        ->label('Project Category')
                        ->options(ProjectCategory::where('active', true)->pluck('name', 'id'))
                        ->searchable()
                        ->required(),
                    Forms\Components\TextInput::make('floors')
                        ->numeric()
                        ->nullable(),
                    Forms\Components\TextInput::make('building_area')
                        ->label('Building Area (sqm)')
                        ->numeric()
                        ->nullable(),
                    Forms\Components\TextInput::make('land_area')
                        ->label('Land Area (sqm)')
                        ->numeric()
                        ->nullable(),
                    Forms\Components\TextInput::make('required_service')
                        ->label('Required Service (for maintenance)')
                        ->maxLength(255)
                        ->nullable(),
                ])->columns(2),
        ];
    }
}
