<?php

namespace App\Filament\Account\Resources\Tenders\Pages;

use App\Filament\Account\Resources\Tenders\TenderResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditTender extends EditRecord
{
    protected static string $resource = TenderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
