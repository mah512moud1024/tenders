<?php

namespace App\Filament\Account\Resources\QuoteDocuments\Pages;

use App\Filament\Account\Resources\QuoteDocuments\QuoteDocumentResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewQuoteDocument extends ViewRecord
{
    protected static string $resource = QuoteDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
