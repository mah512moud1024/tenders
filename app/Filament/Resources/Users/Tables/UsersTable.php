<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('Name'))
                    ->formatStateUsing(fn (User $record) => $record->first_name . ' ' . $record->last_name)
                    ->searchable(['first_name', 'last_name'])
                    ->sortable(),
                TextColumn::make('email')
                    ->label(__('Email'))
                    ->searchable()
                    ->icon('heroicon-o-envelope'),
                TextColumn::make('phone')
                    ->label(__('Phone'))
                    ->searchable()
                    ->icon('heroicon-o-phone'),
                TextColumn::make('type')
                    ->label(__('Type'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'admin' => 'danger',
                        'client' => 'primary',
                        'consultant' => 'info',
                        'contractor' => 'warning',
                        'subcontractor' => 'gray',
                        'supplier' => 'success',
                    })
                    ->searchable()
                    ->sortable(),
                TextColumn::make('business_name')
                    ->label(__('Business Name'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('city.name')
                    ->label(__('City'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('approved')
                    ->label(__('Approved'))
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                TextColumn::make('email_verified_at')
                    ->label(__('Email Verified'))
                    ->dateTime()
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('license_expiry')
                    ->label(__('License Expiry'))
                    ->dateTime()
                    ->color(fn ($record) => $record->license_expiry?->isPast() ? 'danger' : 'success')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(__('Updated At'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('type')
                    ->label(__('User Type'))
                    ->options([
                        'client' => __('Client'),
                        'consultant' => __('Consultant'),
                        'contractor' => __('Contractor'),
                        'subcontractor' => __('Subcontractor'),
                        'supplier' => __('Supplier'),
                    ])
                    ->placeholder(__('All Types')),

                SelectFilter::make('approved')
                    ->label(__('Approval Status'))
                    ->options([
                        '1' => __('Approved'),
                        '0' => __('Not Approved'),
                    ])
                    ->default('0')
                    ->placeholder(__('All Status')),

                Filter::make('created_at')
                    ->label(__('Created Date'))
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('created_from')
                            ->label(__('From')),
                        \Filament\Forms\Components\DatePicker::make('created_until')
                            ->label(__('To')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('approve_user')
                    ->label(__('Approve User'))
                    ->icon('heroicon-o-check-badge')
                    ->action(function (User $record) {
                        $record->update(['approved' => true]);
                    })
                    ->visible(fn (User $record) => !$record->approved)
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading(__('Approve User'))
                    ->modalDescription(__('Are you sure you want to approve this user? They will gain full access to the platform.'))
                    ->modalSubmitActionLabel(__('Yes, approve user')),

                Action::make('download_license')
                    ->label(__('Download License'))
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn (User $record) => $record->trading_license ? asset('storage/' . $record->trading_license) : '#')
                    ->openUrlInNewTab()
                    ->visible(fn (User $record) => !empty($record->trading_license))
                    ->color('info'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
