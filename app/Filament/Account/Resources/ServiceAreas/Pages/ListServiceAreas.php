<?php

namespace App\Filament\Account\Resources\ServiceAreas\Pages;

use App\Filament\Account\Resources\ServiceAreas\ServiceAreaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListServiceAreas extends ListRecords
{
    protected static string $resource = ServiceAreaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
