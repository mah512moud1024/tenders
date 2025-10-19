<?php

namespace App\Filament\Account\Resources\Tenders\Pages;

use App\Filament\Account\Resources\Tenders\TenderResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTender extends ViewRecord
{
    protected static string $resource = TenderResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
