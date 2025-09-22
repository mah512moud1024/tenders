<?php

namespace App\Filament\Account\Resources\MyQuotes\Pages;

use App\Filament\Account\Resources\MyQuotes\MyQuoteResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditMyQuote extends EditRecord
{
    protected static string $resource = MyQuoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),

        ];
    }
}
