<?php

namespace App\Filament\Resources\QuoteDocuments;

use App\Filament\Resources\QuoteDocuments\Pages\CreateQuoteDocument;
use App\Filament\Resources\QuoteDocuments\Pages\EditQuoteDocument;
use App\Filament\Resources\QuoteDocuments\Pages\ListQuoteDocuments;
use App\Filament\Resources\QuoteDocuments\Pages\ViewQuoteDocument;
use App\Filament\Resources\QuoteDocuments\Schemas\QuoteDocumentForm;
use App\Filament\Resources\QuoteDocuments\Schemas\QuoteDocumentInfolist;
use App\Filament\Resources\QuoteDocuments\Tables\QuoteDocumentsTable;
use App\Models\QuoteDocument;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class QuoteDocumentResource extends Resource
{
    protected static ?string $model = QuoteDocument::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'QuoteDocument';

    public static function form(Schema $schema): Schema
    {
        return QuoteDocumentForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return QuoteDocumentInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return QuoteDocumentsTable::configure($table);
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
            'index' => ListQuoteDocuments::route('/'),
            'create' => CreateQuoteDocument::route('/create'),
            'view' => ViewQuoteDocument::route('/{record}'),
            'edit' => EditQuoteDocument::route('/{record}/edit'),
        ];
    }
}
