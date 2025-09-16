<?php

namespace App\Filament\Account\Resources\TenderSpecifications\Pages;

use App\Filament\Account\Resources\TenderSpecifications\TenderSpecificationResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTenderSpecification extends ViewRecord
{
    protected static string $resource = TenderSpecificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
