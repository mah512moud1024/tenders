<?php

namespace App\Filament\Account\Resources\Tenders\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
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
