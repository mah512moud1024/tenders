<?php

namespace App\Filament\Account\Resources\MyQuotes;
use App\Filament\Account\Resources\MyQuotes\Pages\ViewMyQuote;
use App\Filament\Account\Resources\MyQuotes\Schemas\EnhancedMyQuoteInfolist; // Updated this line
use App\Filament\Account\Resources\MyQuotes\Tables\MyQuotesTables;
use Filament\Schemas\Schema;
use App\Models\Quote;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use BackedEnum;
use Filament\Support\Icons\Heroicon;

class MyQuoteResource extends Resource
{
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

    public static function infolist(Schema $schema): Schema
    {
        return EnhancedMyQuoteInfolist::configure($schema); // Updated this line
    }

    public static function canCreate(): bool
    {
        return false;
    }

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
        return parent::getEloquentQuery()->where('user_id', Auth::id());
    }

    public static function table(Table $table): Table
    {
        return MyQuotesTables::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMyQuotes::route('/'),
            'view' => ViewMyQuote::route('/{record}'),
        ];
    }
}
