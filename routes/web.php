<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\TenderList;
use App\Livewire\QuoteForm;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/tenders', TenderList::class)->middleware(['auth'])->name('tenders.index');

// Tender detail page (optional)
Route::get('/tenders/{tender}', function (\App\Models\Tender $tender) {
    return view('tenders.show', compact('tender'));
})->name('tenders.show');

// Quote submission form
Route::get('/tenders/{tender}/quotes/create', QuoteForm::class)
    ->middleware(['auth', 'verified'])
    ->name('quotes.create');
require __DIR__.'/auth.php';
