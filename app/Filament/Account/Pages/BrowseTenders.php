<?php

namespace App\Filament\Account\Pages;

use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;

class BrowseTenders extends Page
{
    protected string $view = 'filament.account.pages.browse-tenders';
    protected static ?string $navigationLabel = 'Browse Tenders';

    protected static string|null|\BackedEnum $navigationIcon = Heroicon::OutlinedBuildingOffice;
    protected static ?int $navigationSort = 1;


    public function getTitle(): string
    {
        return __('Browse Available Tenders');
    }
    public static function canAccess(): bool
    {
        $user = Auth::user();

        // Check if the user is not a client and their account is approved.
        return $user->type !== 'client' && $user->approved;
    }

}


