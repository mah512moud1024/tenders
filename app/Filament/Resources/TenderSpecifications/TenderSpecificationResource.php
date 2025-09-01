<?php

namespace App\Filament\Resources\TenderSpecifications;

use App\Filament\Resources\TenderSpecifications\Pages\CreateTenderSpecification;
use App\Filament\Resources\TenderSpecifications\Pages\EditTenderSpecification;
use App\Filament\Resources\TenderSpecifications\Pages\ListTenderSpecifications;
use App\Filament\Resources\TenderSpecifications\Pages\ViewTenderSpecification;
use App\Filament\Resources\TenderSpecifications\Schemas\TenderSpecificationForm;
use App\Filament\Resources\TenderSpecifications\Schemas\TenderSpecificationInfolist;
use App\Filament\Resources\TenderSpecifications\Tables\TenderSpecificationsTable;
use App\Models\TenderSpecification;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TenderSpecificationResource extends Resource
{
    protected static ?string $model = TenderSpecification::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'TenderSpecification';

    public static function form(Schema $schema): Schema
    {
        return TenderSpecificationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TenderSpecificationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TenderSpecificationsTable::configure($table);
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
            'index' => ListTenderSpecifications::route('/'),
            'create' => CreateTenderSpecification::route('/create'),
            'view' => ViewTenderSpecification::route('/{record}'),
            'edit' => EditTenderSpecification::route('/{record}/edit'),
        ];
    }
}
