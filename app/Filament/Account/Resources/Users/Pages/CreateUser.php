<?php

namespace App\Filament\Account\Resources\Users\Pages;

use App\Filament\Account\Resources\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}
