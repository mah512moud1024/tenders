<?php

namespace App\Filament\Account\Resources\Contracts;

use App\Filament\Account\Resources\Contracts\Pages\CreateContract;
use App\Filament\Account\Resources\Contracts\Pages\EditContract;
use App\Filament\Account\Resources\Contracts\Pages\ListContracts;
use App\Filament\Account\Resources\Contracts\Pages\ViewContract;
use App\Filament\Account\Resources\Contracts\Schemas\ContractForm;
use App\Filament\Account\Resources\Contracts\Schemas\ContractInfolist;
use App\Filament\Account\Resources\Contracts\Tables\ContractsTable;
use App\Models\Contract;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class ContractResource extends Resource
{
    protected static ?string $model = Contract::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static ?string $recordTitleAttribute = 'Contract';
    public static function canViewAny(): bool
    {
        $userType = Auth::user()->type;
        return false;
    }
    public static function getnavigationLabel(): string
    {
        return __('Contract');
    }
    public static function getRecordTitleAttribute(): ?string
    {
        return __('Contract');
    }
    public static function form(Schema $schema): Schema
    {
        return ContractForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ContractInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ContractsTable::configure($table);
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
            'index' => ListContracts::route('/'),
            'create' => CreateContract::route('/create'),
            'view' => ViewContract::route('/{record}'),
            'edit' => EditContract::route('/{record}/edit'),
        ];
    }
}
