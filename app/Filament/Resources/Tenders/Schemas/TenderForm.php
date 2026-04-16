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
                    ->label(__('Title'))
                    ->required()
                    ->maxLength(255),
                Textarea::make('description')
                    ->label(__('Description'))
                    ->default(null)
                    ->columnSpanFull(),
                Select::make('user_id')
                    ->label(__('Client'))
                    ->relationship('user', 'first_name')
                    ->required()
                    ->searchable()
                    ->preload(),
                Select::make('city_id')
                    ->label(__('City'))
                    ->relationship('city', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                TextInput::make('area')
                    ->label(__('Area'))
                    ->default(null)
                    ->maxLength(255),
                Select::make('project_type')
                    ->label(__('Project Type'))
                    ->options([
                        'building' => __('Building'),
                        'roads' => __('Roads'),
                    ])
                    ->required(),
                Select::make('work_type')
                    ->label(__('Work Type'))
                    ->options([
                        'maintenance' => __('Maintenance'),
                        'new_construction' => __('New construction'),
                        'completion' => __('Completion'),
                    ])
                    ->required(),
                Select::make('tender_type')
                    ->label(__('Tender Type'))
                    ->options([
                        'design' => __('Design'),
                        'construction' => __('Construction'),
                        'supply' => __('Supply'),
                    ])
                    ->required(),
                Select::make('category_id')
                    ->label(__('Category'))
                    ->relationship('category', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                TextInput::make('floors')
                    ->label(__('Floors'))
                    ->numeric()
                    ->default(null),
                TextInput::make('building_area')
                    ->label(__('Building Area'))
                    ->numeric()
                    ->default(null)
                    ->suffix('m²'),
                TextInput::make('land_area')
                    ->label(__('Land Area'))
                    ->numeric()
                    ->default(null)
                    ->suffix('m²'),
                TextInput::make('required_service')
                    ->label(__('Required Service'))
                    ->default(null)
                    ->maxLength(255),
                Select::make('status')
                    ->label(__('Status'))
                    ->options([
                        'draft' => __('Draft'),
                        'pending' => __('Pending'),
                        'published' => __('Published'),
                        'assigned' => __('Assigned'),
                        'completed' => __('Completed'),
                    ])
                    ->default('draft')
                    ->required(),
                DateTimePicker::make('closing_date')
                    ->label(__('Closing Date')),
            ]);
    }
}
