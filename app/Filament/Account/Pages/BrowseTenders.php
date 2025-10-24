<?php
// [file name]: BrowseTenders.php
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

    public static function getnavigationLabel(): string
    {
        return __('Browse Tenders');
    }

    public static function getRecordTitleAttribute(): ?string
    {
        return __('Browse Tenders');
    }

    public function getTitle(): string
    {
        return __('');
    }

    public static function canAccess(): bool
    {
        $user = Auth::user();
        return $user->type !== 'client' && $user->approved;
    }
}
