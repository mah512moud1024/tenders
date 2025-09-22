<?php

namespace App\Filament\Account\Resources\MyQuotes\Pages;

use App\Filament\Account\Resources\MyQuotes\MyQuoteResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMyQuote extends ViewRecord
{
    protected static string $resource = MyQuoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
