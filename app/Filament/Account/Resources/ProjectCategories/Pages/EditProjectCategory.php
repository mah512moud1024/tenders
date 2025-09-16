<?php

namespace App\Filament\Account\Resources\ProjectCategories\Pages;

use App\Filament\Account\Resources\ProjectCategories\ProjectCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditProjectCategory extends EditRecord
{
    protected static string $resource = ProjectCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
