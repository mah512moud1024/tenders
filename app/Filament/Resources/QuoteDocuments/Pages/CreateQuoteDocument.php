<?php

namespace App\Filament\Resources\QuoteDocuments\Pages;

use App\Filament\Resources\QuoteDocuments\QuoteDocumentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateQuoteDocument extends CreateRecord
{
    protected static string $resource = QuoteDocumentResource::class;
}
