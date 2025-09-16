<?php

namespace App\Filament\Account\Resources\Quotes;

use App\Filament\Account\Resources\Quotes\Pages\CreateQuote;
use App\Filament\Account\Resources\Quotes\Pages\EditQuote;
use App\Filament\Account\Resources\Quotes\Pages\ListQuotes;
use App\Filament\Account\Resources\Quotes\Pages\ViewQuote;
use App\Filament\Account\Resources\Quotes\Schemas\QuoteForm;
use App\Filament\Account\Resources\Quotes\Schemas\QuoteInfolist;
use App\Filament\Account\Resources\Quotes\Tables\QuotesTable;
use App\Models\Quote;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class QuoteResource extends Resource
{
    protected static ?string $model = Quote::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static ?string $navigationLabel = 'Received Quotes';

    protected static ?string $slug = 'received-quotes';

    protected static ?string $recordTitleAttribute = 'Quote';
    public static function canCreate(): bool
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
        return $userType === 'client' || $userType === 'consultant' || $userType === 'admin';
    }

    public static function getEloquentQuery(): Builder
    {
        if (static::canViewAny()) {
            return parent::getEloquentQuery()
                ->where('status', '!=', 'under_review')
                ->whereHas('tender', function (Builder $query) {
                $query->where('user_id', Auth::id());
            });
        }
        return parent::getEloquentQuery()->whereNull('id'); // Return no records if not authorized
    }

    public static function form(Schema $schema): Schema
    {
        return QuoteForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return QuoteInfolist::configure($schema);
    }



    public static function table(Table $table): Table
    {
        return QuotesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListQuotes::route('/'),
            'create' => CreateQuote::route('/create'),
            'view' => ViewQuote::route('/{record}'),
            'edit' => EditQuote::route('/{record}/edit'),
        ];
    }
}
