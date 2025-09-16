<?php

namespace App\Filament\Account\Resources\QuoteDocuments\Pages;

use App\Filament\Account\Resources\QuoteDocuments\QuoteDocumentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListQuoteDocuments extends ListRecords
{
    protected static string $resource = QuoteDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
