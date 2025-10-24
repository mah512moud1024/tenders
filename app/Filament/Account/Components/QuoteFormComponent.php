<?php

namespace App\Filament\Account\Components;

use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Grid;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;

class QuoteFormComponent extends Component
{
    public static function make(): Grid
    {
        return Grid::make(1)
            ->schema([
                TextInput::make('amount')
                    ->label('Quote Amount (AED)')
                    ->numeric()
                    ->required()
                    ->prefix('AED'),

                Textarea::make('proposal')
                    ->label('Proposal Details')
                    ->required()
                    ->minLength(50)
                    ->rows(6)
                    ->helperText('Describe your proposal in detail.'),

                FileUpload::make('documents')
                    ->label('Supporting Documents')
                    ->multiple()
                    ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.ms-excel'])
                    ->maxSize(10240) // 10MB
                    ->directory('private/quote-documents')
                    ->helperText('You can upload multiple PDF, Word, or Excel files.'),
            ]);
    }
}
