<?php

namespace App\Filament\Account\Resources\MyQuotes\Pages;

use App\Filament\Account\Resources\MyQuotes\MyQuoteResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMyQuote extends CreateRecord
{
    protected static string $resource = MyQuoteResource::class;
    public static function canCreate(): bool
    {
        return false; }
    public function canCreateAnother(): bool
    {
        return false;
    }
}
