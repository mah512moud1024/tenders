<?php

namespace App\Filament\Account\Resources\MyQuotes\Pages;

use App\Filament\Account\Resources\MyQuotes\MyQuoteResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMyQuotes extends ListRecords
{
    protected static string $resource = MyQuoteResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
