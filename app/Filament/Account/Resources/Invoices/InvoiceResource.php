<?php

namespace App\Filament\Account\Resources\Invoices;

use App\Filament\Account\Resources\Invoices\Pages\CreateInvoice;
use App\Filament\Account\Resources\Invoices\Pages\EditInvoice;
use App\Filament\Account\Resources\Invoices\Pages\ListInvoices;
use App\Filament\Account\Resources\Invoices\Pages\ViewInvoice;
use App\Filament\Account\Resources\Invoices\Schemas\InvoiceForm;
use App\Filament\Account\Resources\Invoices\Schemas\InvoiceInfolist;
use App\Filament\Account\Resources\Invoices\Tables\InvoicesTable;
use App\Models\Invoice;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedReceiptRefund;

    protected static ?string $recordTitleAttribute = 'Invoice';
    public static function getnavigationLabel(): string
    {
        return __('Invoice');
    }
    public static function getRecordTitleAttribute(): ?string
    {
        return __('Invoice');
    }
    public static function form(Schema $schema): Schema
    {
        return InvoiceForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return InvoiceInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InvoicesTable::configure($table);
    }


    public static function getEloquentQuery(): Builder
    {
        if (static::canViewAny()) {
            return parent::getEloquentQuery()
                ->where('status', '=', 'paid')
                ->whereHas('user', function (Builder $query) {
                    $query->where('user_id', Auth::id());
                });
        }
        return parent::getEloquentQuery()->whereNull('id'); // Return no records if not authorized
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
            'index' => ListInvoices::route('/'),
            'create' => CreateInvoice::route('/create'),
            'view' => ViewInvoice::route('/{record}'),
            'edit' => EditInvoice::route('/{record}/edit'),
        ];
    }
}
