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

Route::get('/test-email', function () {
    try {
        Mail::raw('Test email from Laravel', function ($message) {
            $message->to('mah512moud1024@gmail.com')
                ->subject('Test Email');
        });
        return 'Email sent successfully!';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

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
