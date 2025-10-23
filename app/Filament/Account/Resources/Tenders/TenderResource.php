<?php

namespace App\Filament\Account\Resources\Tenders;

use App\Filament\Account\Resources\Tenders\Pages\CreateTender;
use App\Filament\Account\Resources\Tenders\Pages\EditTender;
use App\Filament\Account\Resources\Tenders\Pages\ListTenders;
use App\Filament\Account\Resources\Tenders\Pages\ViewTender;
use App\Filament\Account\Resources\Tenders\Schemas\TenderForm;
use App\Filament\Account\Resources\Tenders\Schemas\TenderInfolist;
use App\Filament\Account\Resources\Tenders\Tables\TendersTable;
use App\Models\Tender;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

use Filament\Forms\Form;
class TenderResource extends Resource
{
    protected static ?string $model = Tender::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBriefcase;
    public static function getnavigationLabel(): string
    {
        return __('My Tenders');
    }
    public static function getRecordTitleAttribute(): ?string
    {
        return __('My Tenders');
    }
    protected static ?string $navigationLabel = 'My Tenders';

    protected static ?string $slug = 'my-tenders';

    /**
     * This ensures that only clients and consultants can see this resource in the navigation.
     */
    public static function canViewAny(): bool
    {
        $userType = Auth::user()->type;
        return $userType === 'client' || $userType === 'consultant' || $userType === 'admin';
    }



    /**
     * This function scopes the query to only show tenders created by the logged-in user.
     * It also prevents an error for non-authorized users trying to access the panel.
     */
    public static function getEloquentQuery(): Builder
    {
        if (static::canViewAny()){
            return parent::getEloquentQuery()->where('user_id', Auth::id());
        }
        return parent::getEloquentQuery()->whereNull('id'); // Return no records if not authorized
    }

    public static function form(Schema $schema): Schema
    {
        // We will define the form in TenderForm.php
        return $schema->schema(TenderForm::getSchema());
    }

    public static function table(Table $table): Table
    {
        // We will define the table in TendersTable.php
        return TendersTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTenders::route('/'),
            'create' => CreateTender::route('/create'),
            'view' => ViewTender::route('/{record}'),
            'edit' => EditTender::route('/{record}/edit'),
        ];
    }
}

