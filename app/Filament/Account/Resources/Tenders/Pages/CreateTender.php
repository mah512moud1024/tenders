<?php

namespace App\Filament\Account\Resources\Tenders\Pages;

use App\Filament\Account\Resources\Tenders\TenderResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTender extends CreateRecord
{
    protected static string $resource = TenderResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }
}
