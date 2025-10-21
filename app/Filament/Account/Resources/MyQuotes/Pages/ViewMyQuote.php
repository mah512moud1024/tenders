<?php

namespace App\Filament\Account\Resources\MyQuotes\Pages;

use App\Filament\Account\Resources\MyQuotes\MyQuoteResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Storage;

class ViewMyQuote extends ViewRecord
{
    protected static string $resource = MyQuoteResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }



    public function getMaxContentWidth(): ?string
    {
        return 'full';
    }
}
