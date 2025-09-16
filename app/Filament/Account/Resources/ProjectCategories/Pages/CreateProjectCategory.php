<?php

namespace App\Filament\Account\Resources\ProjectCategories\Pages;

use App\Filament\Account\Resources\ProjectCategories\ProjectCategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProjectCategory extends CreateRecord
{
    protected static string $resource = ProjectCategoryResource::class;
}
