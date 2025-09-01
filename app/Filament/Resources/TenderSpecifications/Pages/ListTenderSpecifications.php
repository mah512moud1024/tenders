<?php

namespace App\Filament\Resources\TenderSpecifications\Pages;

use App\Filament\Resources\TenderSpecifications\TenderSpecificationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTenderSpecifications extends ListRecords
{
    protected static string $resource = TenderSpecificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
