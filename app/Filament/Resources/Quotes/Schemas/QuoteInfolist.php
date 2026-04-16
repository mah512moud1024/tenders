<?php

namespace App\Filament\Resources\Quotes\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Actions\Action;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;


class QuoteInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Quote Information')
                    ->schema([
                        TextEntry::make('tender.title')
                            ->label('Tender Title')
                            ->weight('bold')
                            ->size('lg'),
                        TextEntry::make('user.business_name')
                            ->label('Submitted By')
                            ->weight('bold')
                            ->size('lg'),
                        TextEntry::make('amount')
                            ->money('AED')
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
                    ->columns(2),

                Section::make('Quote Details')
                    ->schema([
                        TextEntry::make('proposal')
                            ->label('Proposal Details')
                            ->columnSpanFull()
                            ->markdown()
                            ->prose(),
                        TextEntry::make('created_at')
                            ->dateTime()
                            ->label('Submitted Date'),
                        TextEntry::make('updated_at')
                            ->dateTime()
                            ->label('Last Updated'),
                    ])
                    ->columns(2),

                // Documents section with dynamic title
                Section::make(function ($record) {
                    $count = $record->documents->count();
                    return "Attached Documents ({$count})";
                })
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
                                    ->dateTime('M j, Y g:i A'),
                                Actions::make([
                                    Action::make('download_document')
                                        ->label('Download')
                                        ->icon('heroicon-o-arrow-down-tray')
                                        ->color('success')
                                        ->url(function ($component) {
                                            // This is the correct way to get the current document in RepeatableEntry
                                            $document = $component->getRecord();
                                            return route('quote.document.download', ['document' => $document->id]);
                                        })
                                        ->openUrlInNewTab(),
                                ]),
                            ])
                            ->columns(4)
                            ->grid(1),
                    ])
                    ->visible(fn ($record) => $record->documents->count() > 0)
                    ->collapsible(),
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
