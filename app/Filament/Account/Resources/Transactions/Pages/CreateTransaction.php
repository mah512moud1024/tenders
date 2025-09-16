<?php

namespace App\Filament\Account\Resources\Transactions\Pages;

use App\Filament\Account\Resources\Transactions\TransactionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTransaction extends CreateRecord
{
    protected static string $resource = TransactionResource::class;
}
