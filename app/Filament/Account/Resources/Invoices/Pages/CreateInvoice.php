<?php

namespace App\Filament\Account\Resources\Invoices\Pages;

use App\Filament\Account\Resources\Invoices\InvoiceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateInvoice extends CreateRecord
{
    protected static string $resource = InvoiceResource::class;
}
