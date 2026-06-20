<?php

namespace App\Filament\Resources\Tenders\Tables;

use App\Models\Tender;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TendersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label(__('Title'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.first_name')
                    ->label(__('Client'))
                    ->formatStateUsing(fn ($record) => $record->user ? "{$record->user->first_name} {$record->user->last_name}" : '')
                    ->sortable()
                    ->searchable(query: function ($query, string $search) {
                        $query->whereHas('user', function ($q) use ($search) {
                            $q->where('first_name', 'like', "%{$search}%")
                              ->orWhere('last_name', 'like', "%{$search}%");
                        });
                    }),
                TextColumn::make('city.name')
                    ->label(__('City'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('area')
                    ->label(__('Area'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('project_type')
                    ->label(__('Project Type'))
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => __($state))
                    ->color(fn (string $state): string => match ($state) {
                        'building' => 'primary',
                        'roads' => 'success',
                    }),
                TextColumn::make('work_type')
                    ->label(__('Work Type'))
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => __($state))
                    ->color(fn (string $state): string => match ($state) {
                        'maintenance' => 'warning',
                        'new_construction' => 'info',
                        'completion' => 'success',
                    }),
                TextColumn::make('tender_type')
                    ->label(__('Tender Type'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'design' => 'purple',
                        'construction' => 'orange',
                        'supply' => 'blue',
                    }),
                TextColumn::make('category.name')
                    ->label(__('Category'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('floors')
                    ->label(__('Floors'))
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('building_area')
                    ->label(__('Building Area'))
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('land_area')
                    ->label(__('Land Area'))
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('required_service')
                    ->label(__('Required Service'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('status')
                    ->label(__('Status'))
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => __($state))
                    ->color(fn (string $state): string => match ($state) {
                        'draft'=> 'gray',
                        'pending'=> 'warning',
                        'published' => 'info',
                        'assigned' => 'success',
                        'completed' => 'primary',
                    }),
                TextColumn::make('closing_date')
                    ->label(__('Closing Date'))
                    ->dateTime()
                    ->sortable()
                    ->color(fn ($record) => $record->closing_date?->isPast() ? 'danger' : 'success'),
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
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),

                Action::make('reject_tender')
                    ->label(__('Reject Tender'))
                    ->icon('heroicon-o-x-circle')
                    ->action(function (Tender $record) {
                        $record->update(['status' => 'draft']);
                    })
                    ->visible(fn (Tender $record) => in_array($record->status, ['pending', 'published']))
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading(__('Reject Tender'))
                    ->modalDescription(__('Are you sure you want to reject this tender? This will change the status back to draft.'))
                    ->modalSubmitActionLabel(__('Yes, reject tender')),
                Action::make('publish_tender')
                    ->label(__('Publish Tender'))
                    ->icon('heroicon-o-megaphone')
                    ->action(function (Tender $record) {
                        $record->update(['status' => 'published']);
                    })
                    ->visible(fn (Tender $record) => $record->status === 'pending')
                    ->color('info')
                    ->requiresConfirmation()
                    ->modalHeading(__('Publish Tender'))
                    ->modalDescription(__('Are you sure you want to publish this tender? It will become visible to contractors.'))
                    ->modalSubmitActionLabel(__('Yes, publish tender')),
                Action::make('mark_completed')
                    ->label(__('Mark as Completed'))
                    ->icon('heroicon-o-flag')
                    ->action(function (Tender $record) {
                        $record->update(['status' => 'completed']);
                    })
                    ->visible(fn (Tender $record) => $record->status === 'assigned')
                    ->color('primary')
                    ->requiresConfirmation()
                    ->modalHeading(__('Mark as Completed'))
                    ->modalDescription(__('Are you sure you want to mark this tender as completed?'))
                    ->modalSubmitActionLabel(__('Yes, mark as completed')),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
