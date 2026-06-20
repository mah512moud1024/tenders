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

                Section::make(__('Attachments'))
                    ->icon('heroicon-o-paper-clip')
                    ->schema([
                        TextEntry::make('specifications')
                            ->label('')
                            ->formatStateUsing(function ($record) {
                                if (!$record || $record->specifications->isEmpty()) {
                                    return __('No attachments uploaded.');
                                }
                                
                                $html = '<ul class="divide-y divide-gray-200 dark:divide-gray-700">';
                                foreach ($record->specifications as $spec) {
                                    $url = route('tenders.specifications.download', $spec);
                                    $size = number_format($spec->file_size / (1024 * 1024), 2) . ' MB';
                                    $html .= '<li class="py-2 flex items-center justify-between text-sm">';
                                    $html .= '<div class="w-0 flex-1 flex items-center">';
                                    $html .= '<svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" /></svg>';
                                    $html .= '<span class="ml-2 flex-1 w-0 truncate text-gray-700 dark:text-gray-300 font-medium">' . e($spec->original_name) . ' (' . $size . ')</span>';
                                    $html .= '</div>';
                                    $html .= '<div class="ml-4 flex-shrink-0">';
                                    $html .= '<a href="' . $url . '" class="font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400 dark:hover:text-primary-300">' . __('Download') . '</a>';
                                    $html .= '</div>';
                                    $html .= '</li>';
                                }
                                $html .= '</ul>';
                                
                                return $html;
                            })
                            ->html()
                            ->columnSpanFull()
                    ]),
            ]);
    }
}
