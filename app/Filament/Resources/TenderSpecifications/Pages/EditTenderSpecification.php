<?php

namespace App\Filament\Resources\TenderSpecifications\Pages;

use App\Filament\Resources\TenderSpecifications\TenderSpecificationResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditTenderSpecification extends EditRecord
{
    protected static string $resource = TenderSpecificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
