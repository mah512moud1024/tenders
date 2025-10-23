<?php

namespace App\Filament\Account\Resources\Tenders\Schemas;

use App\Models\City;
use App\Models\ProjectCategory;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;

class TenderForm
{
    public static function getSchema(): array
    {
        return [
            Section::make('Tender Details')
                ->description('Provide the main details of your project.')
                ->schema([
                    TextInput::make('title')
                        ->required()
                        ->maxLength(255),
                    RichEditor::make('description')
                        ->toolbarButtons([
                            'bold',
                            'bulletList',
                            'orderedList',
                            'redo',
                            'undo',
                        ])
                        ->columnSpanFull()
                        ->disableAllToolbarButtons()
                        ->enableToolbarButtons([
                            'bold',
                            'bulletList',
                            'orderedList',
                            'redo',
                            'undo',
                        ])
                        ->extraAttributes(['class' => 'custom-rich-editor']),

                    Select::make('city_id')
                        ->label('City')
                        ->options(City::where('active', true)->pluck('name', 'id'))
                        ->searchable()
                        ->required(),
                    TextInput::make('area')
                        ->label('Neighborhood / Area')
                        ->maxLength(255)
                        ->required(),
                    DatePicker::make('closing_date')
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

                    Select::make('work_type')
                        ->options([
                            'maintenance' => 'Maintenance',
                            'new_construction' => 'New Construction',
                            'completion' => 'Completion',
                        ])
                        ->required()
                        ->reactive(),

                    Select::make('tender_type')
                        ->options([
                            'design' => 'Design',
                            'construction' => 'Construction',
                            'supply' => 'Supply',
                        ])
                        ->required()
                        ->reactive(),

                    Select::make('category_id')
                        ->label('Project Category')
                        ->options(ProjectCategory::where('active', true)->pluck('name', 'id'))
                        ->searchable()
                        ->required(),

                    // ---------- Maintenance Group ----------
                    Fieldset::make('Maintenance Details')
                        ->schema([
                            TextInput::make('required_service')
                                ->label('Required Service')
                                ->maxLength(255)
                                ->required(),
                        ])
                        ->hidden(fn ($get) => $get('work_type') !== 'maintenance' || $get('tender_type') === 'supply'),

                    // ---------- Construction / Design Group ----------
                    Fieldset::make('Building Details')
                        ->schema([
                            TextInput::make('floors')
                                ->numeric()
                                ->required(),

                            TextInput::make('building_area')
                                ->label('Building Area (sqm)')
                                ->numeric()
                                ->required(),

                            TextInput::make('land_area')
                                ->label('Land Area (sqm)')
                                ->numeric()
                                ->required(),
                        ])->columnSpanFull()
                        ->columns(3)
                        ->hidden(fn ($get) =>
                            $get('tender_type') === 'supply'
                            || $get('work_type') === 'maintenance'
                        ),
                ])->columns(2),


        ];
    }
}
