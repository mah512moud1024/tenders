<?php

namespace App\Filament\Account\Resources\Users;

use App\Filament\Account\Resources\Users\Pages\CreateUser;
use App\Filament\Account\Resources\Users\Pages\EditUser;
use App\Filament\Account\Resources\Users\Pages\ListUsers;
use App\Filament\Account\Resources\Users\Pages\ViewUser;
use App\Filament\Account\Resources\Users\Schemas\UserForm;
use App\Filament\Account\Resources\Users\Schemas\UserInfolist;
use App\Filament\Account\Resources\Users\Tables\UsersTable;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'profile';

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return UserInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
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
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'view' => ViewUser::route('/{record}'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
