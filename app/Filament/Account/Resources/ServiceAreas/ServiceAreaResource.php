<?php

namespace App\Filament\Account\Resources\ServiceAreas;

use App\Filament\Account\Resources\ServiceAreas\Pages\CreateServiceArea;
use App\Filament\Account\Resources\ServiceAreas\Pages\EditServiceArea;
use App\Filament\Account\Resources\ServiceAreas\Pages\ListServiceAreas;
use App\Filament\Account\Resources\ServiceAreas\Pages\ViewServiceArea;
use App\Filament\Account\Resources\ServiceAreas\Schemas\ServiceAreaForm;
use App\Filament\Account\Resources\ServiceAreas\Schemas\ServiceAreaInfolist;
use App\Filament\Account\Resources\ServiceAreas\Tables\ServiceAreasTable;
use App\Models\ServiceArea;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ServiceAreaResource extends Resource
{
    protected static ?string $model = ServiceArea::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'ServiceArea';

    public static function form(Schema $schema): Schema
    {
        return ServiceAreaForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ServiceAreaInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ServiceAreasTable::configure($table);
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
            'index' => ListServiceAreas::route('/'),
            'create' => CreateServiceArea::route('/create'),
            'view' => ViewServiceArea::route('/{record}'),
            'edit' => EditServiceArea::route('/{record}/edit'),
        ];
    }
}
