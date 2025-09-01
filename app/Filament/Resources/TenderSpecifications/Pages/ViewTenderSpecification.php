<?php

namespace App\Filament\Resources\TenderSpecifications\Pages;

use App\Filament\Resources\TenderSpecifications\TenderSpecificationResource;
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
