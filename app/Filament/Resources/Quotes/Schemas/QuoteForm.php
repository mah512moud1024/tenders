<?php

namespace App\Filament\Resources\Quotes\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class QuoteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('tender_id')
                    ->required()
                    ->numeric(),
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                Textarea::make('proposal')
                    ->default(null)
                    ->columnSpanFull(),
                Select::make('status')
                    ->options([
            'submitted' => 'Submitted',
            'under_review' => 'Under review',
            'accepted' => 'Accepted',
            'rejected' => 'Rejected',
        ])
                    ->default('submitted')
                    ->required(),
                Toggle::make('selected')
                    ->required(),
            ]);
    }
}
