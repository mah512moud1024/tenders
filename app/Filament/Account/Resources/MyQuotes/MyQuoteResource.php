<?php

namespace App\Filament\Account\Resources\MyQuotes;

use App\Filament\Account\Resources\MyQuoteResource\Tables\MyQuotesTables;

use App\Models\Quote; // <-- IMPORTANT: We now use the correct model
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

use BackedEnum;
use Filament\Support\Icons\Heroicon;
class MyQuoteResource extends Resource
{
    // This is the crucial change: Pointing the resource to the Quote model
    protected static ?string $model = Quote::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $navigationLabel = 'All Quotes';
    public static function getnavigationLabel(): string
    {
        return __('All Quotes');
    }
    public static function getRecordTitleAttribute(): ?string
    {
        return __('All Quotes');
    }
    protected static ?string $slug = 'all-quotes';




    public static function canCreate(): bool
    {
        return false; }
    public function canCreateAnother(): bool
    {
        return false;
    }
    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canViewAny(): bool
    {
        $userType = Auth::user()->type;
        return $userType === 'supplier' || $userType === 'subcontractor' || $userType === 'admin' || $userType === 'contractor' || $userType === 'consultant';
    }

    public static function getEloquentQuery(): Builder
    {
        // This ensures users only see their own quotes
        return parent::getEloquentQuery()->where('user_id', Auth::id());
    }

    public static function table(Table $table): Table
    {
        // We will configure the table in the next step
        return MyQuotesTables::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMyQuotes::route('/'),
        ];
    }
}

