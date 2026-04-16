<?php

namespace App\Filament\Resources\Tenders\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TenderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Basic Information'))
                    ->icon('heroicon-o-document-text')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('title')
                            ->label(__('Title'))
                            ->columnSpan(2)
                            ->size('xl')
                            ->weight('font-semibold'),
                        TextEntry::make('status')
                            ->label(__('Status'))
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'draft' => 'gray',
                                'pending' => 'warning',
                                'published' => 'info',
                                'assigned' => 'success',
                                'completed' => 'primary',
                            }),
                        TextEntry::make('user.name')
                            ->label(__('Client'))
                            ->icon('heroicon-o-user'),
                        TextEntry::make('city.name')
                            ->label(__('City')),
                        TextEntry::make('area')
                            ->label(__('Area')),
                        TextEntry::make('closing_date')
                            ->label(__('Closing Date'))
                            ->dateTime()
                            ->color(fn ($record) => $record->closing_date?->isPast() ? 'danger' : 'success')
                            ->icon('heroicon-o-calendar'),
                    ]),

                Section::make(__('Project Details'))
                    ->icon('heroicon-o-clipboard-document-list')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('project_type')
                            ->label(__('Project Type'))
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'building' => 'primary',
                                'roads' => 'success',
                            }),
                        TextEntry::make('work_type')
                            ->label(__('Work Type'))
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'maintenance' => 'warning',
                                'new_construction' => 'info',
                                'completion' => 'success',
                            }),
                        TextEntry::make('tender_type')
                            ->label(__('Tender Type'))
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'design' => 'purple',
                                'construction' => 'orange',
                                'supply' => 'blue',
                            }),
                        TextEntry::make('category.name')
                            ->label(__('Category')),
                        TextEntry::make('floors')
                            ->label(__('Floors'))
                            ->numeric()
                            ->visible(fn ($record) => !is_null($record->floors)),
                        TextEntry::make('building_area')
                            ->label(__('Building Area'))
                            ->numeric()
                            ->suffix(' m²')
                            ->visible(fn ($record) => !is_null($record->building_area)),
                        TextEntry::make('land_area')
                            ->label(__('Land Area'))
                            ->numeric()
                            ->suffix(' m²')
                            ->visible(fn ($record) => !is_null($record->land_area)),
                        TextEntry::make('required_service')
                            ->label(__('Required Service'))
                            ->visible(fn ($record) => !is_null($record->required_service))
                            ->columnSpanFull(),
                    ]),

                Section::make(__('Description'))
                    ->icon('heroicon-o-chat-bubble-left-ellipsis')
                    ->schema([
                        TextEntry::make('description')
                            ->label('')
                            ->prose()
                            ->markdown()
                            ->html()
                            ->columnSpanFull()
                            ->visible(fn ($record) => !empty($record->description)),
                    ])
                    ->collapsible()
                    ->collapsed(fn ($record) => empty($record->description)),

                Section::make(__('Timeline'))
                    ->icon('heroicon-o-clock')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('created_at')
                            ->label(__('Created At'))
                            ->dateTime()
                            ->icon('heroicon-o-calendar-days')
                            ->since()
                            ->color('gray'),
                        TextEntry::make('updated_at')
                            ->label(__('Updated At'))
                            ->dateTime()
                            ->icon('heroicon-o-calendar-days')
                            ->since()
                            ->color('gray'),
                    ]),
            ]);
    }
}
