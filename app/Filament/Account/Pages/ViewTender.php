<?php

namespace App\Filament\Account\Pages;

use App\Models\Tender;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Filament\Support\Icons\Heroicon;
use Filament\Panel;

class ViewTender extends Page
{
    // This tells Filament to use our custom Blade view
    protected string $view = 'filament.account.pages.view-tender';

    // This is the crucial line that hides the page from the navigation menu
    protected static bool $shouldRegisterNavigation = false;

    public Tender $tender;

    /**
     * This method receives the Tender model from the URL.
     */
    public function mount(Tender $record): void
    {
        $this->tender = $record;
    }

    /**
     * This sets the URL for the page, e.g., /account/view-tender/123
     */
    public static function getRoutePath(Panel $panel): string
    {
        return '/browse-tenders/{record}';
    }

    /**
     * Sets the browser tab title.
     */
    public function getTitle(): string
    {
        return $this->tender->title;
    }

    /**
     * Ensures only authorized users can access this page.
     */
    public static function canAccess(): bool
    {
        $user = Auth::user();
        return $user && $user->type !== 'client' && $user->approved;
    }
}
