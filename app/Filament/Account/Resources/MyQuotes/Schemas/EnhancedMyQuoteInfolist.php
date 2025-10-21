<?php

namespace App\Filament\Account\Resources\MyQuotes\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Actions\Action;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;

class EnhancedMyQuoteInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make()->schema([
                Section::make('Quote Information')
                    ->schema([
                        TextEntry::make('tender.title')
                            ->label('Tender Title')
                            ->weight('bold')
                            ->size('lg'),
                        TextEntry::make('amount')
                            ->money('AED', locale: 'en')

                            ->color('success')
                            ->weight('bold')
                            ->size('lg'),
                        TextEntry::make('status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'submitted' => 'gray',
                                'under_review' => 'warning',
                                'accepted' => 'success',
                                'rejected' => 'danger',
                                default => 'gray',
                            }),
                    ])
                    ->columns(3),

                Section::make('Quote Details')
                    ->schema([
                        TextEntry::make('proposal')
                            ->label('Proposal Details')
                            ->columnSpanFull()
                            ->markdown()
                            ->prose(),
                        TextEntry::make('created_at')
                            ->dateTime('d/m/Y')
                            ->label('Submitted Date'),

                    ])
                    ->columns(2),]),

                Section::make('Document Files')
                    ->schema([
                        \Filament\Infolists\Components\RepeatableEntry::make('documents')
                            ->schema([
                                TextEntry::make('original_name')
                                    ->label('File Name')
                                    ->weight('medium')
                                    ->columnSpan(2),
                                TextEntry::make('file_size')
                                    ->label('Size')
                                    ->formatStateUsing(fn ($state) => self::formatFileSize($state)),
                                TextEntry::make('created_at')
                                    ->label('Uploaded')
                                    ->dateTime('d/m/Y g:i A'),
                                Actions::make([
                                    Action::make('download_document')
                                        ->label('Download')
                                        ->icon('heroicon-o-arrow-down-tray')
                                        ->color('success')
                                        // CRITICAL CHANGE: Use ->url() to point to the secure route.
                                        // The $record here IS the document model (App\Models\QuoteDocument).
                                        // Filament correctly passes the item model here for URL generation.
                                        ->url(function ($component) {
                                            // This is the correct way to get the current document in RepeatableEntry
                                            $document = $component->getRecord();
                                            return route('quote.document.download', ['document' => $document->id]);
                                        })
                                        // Optionally, add target('_blank') to download in a new tab
                                        ->openUrlInNewTab()
                                    // Hide the action if the file path is missing in the database

                                ]),
                            ])
                            ->columns(4)
                            ,
                    ])
                    ->visible(fn ($record) => $record->documents->count() > 0)
                    ->collapsible(),


                // Documents list section

            ]);
    }

    private static function formatFileSize($bytes)
    {
        if ($bytes == 0) return '0 B';

        $units = ['B', 'KB', 'MB', 'GB'];
        $base = log($bytes) / log(1024);
        $unit = $units[floor($base)];

        return round(pow(1024, $base - floor($base)), 2) . ' ' . $unit;
    }
}
