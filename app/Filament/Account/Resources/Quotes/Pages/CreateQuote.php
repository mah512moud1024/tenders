<?php

namespace App\Filament\Account\Resources\Quotes\Pages;

use App\Filament\Account\Resources\Quotes\QuoteResource;
use Filament\Resources\Pages\CreateRecord;

class CreateQuote extends CreateRecord
{
    protected static string $resource = QuoteResource::class;
}
