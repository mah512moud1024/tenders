<?php

namespace App\Services;

use Barryvdh\DomPDF\PDF;
use App\Models\Invoice;

class InvoicePdfService
{
    public function generatePdf(Invoice $invoice): PDF
    {
        $html = view('pdf.invoice', [
            'invoice' => $invoice,
            'company' => [
                'name' => 'Your Company Name',
                'address' => '123 Business Street, City, ZIP',
                'email' => 'info@example.com',
                'phone' => '(123) 456-7890',
            ]
        ])->render();

        return app('dompdf')
            ->loadHTML($html)
            ->setPaper('a4', 'portrait')
            ->setOption('defaultFont', 'Arial')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', true);
    }
}
