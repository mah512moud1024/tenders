<?php

namespace App\Filament\Account\Resources\Invoices\Pages;

use App\Filament\Account\Resources\Invoices\InvoiceResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;

class ViewInvoice extends ViewRecord
{
    protected static string $resource = InvoiceResource::class;
    protected string $view = 'filament.invoices.view-invoice';

    protected function getHeaderActions(): array
    {
        return [

            Action::make('downloadPdf')
                ->label('Download Invoice')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('primary')
                ->url(fn ($record) => route('invoices.download-pdf', $record))
                ->openUrlInNewTab(),

        ];
    }


    public function getMaxContentWidth(): ?string
    {
        return 'full';
    }
}
