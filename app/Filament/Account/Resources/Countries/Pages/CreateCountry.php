<?php

namespace App\Filament\Account\Resources\Countries\Pages;

use App\Filament\Account\Resources\Countries\CountryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCountry extends CreateRecord
{
    protected static string $resource = CountryResource::class;
}
