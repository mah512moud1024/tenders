<?php

use App\Models\User;
use App\Notifications\NewQuoteAdminNotification;
use Illuminate\Support\Facades\Route;
use App\Livewire\TenderList;
use App\Livewire\QuoteForm;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\FileDownloadController;
use App\Livewire\TenderDetail;
use app\Models\Tender;
// Language Switcher Route
Route::get('language/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'ar'])) {
        Session::put('locale', $locale);
        App::setLocale($locale);
    }

    return redirect()->back();
})->name('language.switch');

Route::get('/invoices/{invoice}/download-pdf', function ($invoice) {
    $invoice = \App\Models\Invoice::findOrFail($invoice);

    $html = view('pdf.invoice', [
        'invoice' => $invoice,
        'company' => [
            'name' => 'Your Company Name',
            'address' => '123 Business Street, City, ZIP',
            'email' => 'info@example.com',
            'phone' => '(123) 456-7890',
        ]
    ])->render();

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html)
        ->setPaper('a4', 'portrait')
        ->setOption('defaultFont', 'DejaVu Sans')
        ->setOption('isHtml5ParserEnabled', true)
        ->setOption('isRemoteEnabled', true)
        ->setOption('chroot', base_path())
        ->setOption('defaultEncoding', 'utf-8');

    return $pdf->download("invoice-{$invoice->invoice_number}.pdf");
})->name('invoices.download-pdf');

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/documents/quote/{document}/download', [FileDownloadController::class, 'downloadQuoteDocument'])
    ->middleware(['auth'])
    ->name('quote.document.download');

Route::get('/tenders', TenderList::class)->middleware(['auth'])->name('tenders.index');

//// Tender detail page (optional)
//Route::get('/tenders/{tender}', function (\App\Models\Tender $tender) {
//    return view('tenders.show', compact('tender'));
//})->name('tenders.show');
Route::get('/tenders/view/{tender}', TenderDetail::class)->middleware(['auth'])->name('tenders.view');

// Quote submission form
Route::get('/tenders/{tender}/quotes/create', QuoteForm::class)
    ->middleware(['auth', 'verified'])
    ->name('quotes.create');
require __DIR__.'/auth.php';
