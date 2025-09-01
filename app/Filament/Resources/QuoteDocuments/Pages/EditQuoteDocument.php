<?php

namespace App\Filament\Resources\QuoteDocuments\Pages;

use App\Filament\Resources\QuoteDocuments\QuoteDocumentResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditQuoteDocument extends EditRecord
{
    protected static string $resource = QuoteDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
