<?php

namespace App\Filament\Resources\Subscriptions\Tables;
use App\Models\Subscription;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Notifications\Notification;
use Filament\Tables\Table;
use Carbon\Carbon;

class SubscriptionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('user.first_name')
                    ->label('User')
                    ->formatStateUsing(fn ($record) => $record->user ? "{$record->user->first_name} {$record->user->last_name}" : '')
                    ->sortable()
                    ->searchable(query: function ($query, string $search) {
                        $query->whereHas('user', function ($q) use ($search) {
                            $q->where('first_name', 'like', "%{$search}%")
                              ->orWhere('last_name', 'like', "%{$search}%");
                        });
                    }),
                TextColumn::make('plan.name')
                    ->label('Plan')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('status')
                    ->colors([
                        'gray' => 'pending',
                        'warning' => 'canceled',
                        'success' => 'active',
                        'danger' => 'expired',
                    ]),

                TextColumn::make('starts_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('ends_at')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])->defaultSort('status', 'desc')
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('approve')
                    ->label('Approve')
                    ->button()
                    ->color('success')
                    ->icon('heroicon-o-check-circle')
                    ->requiresConfirmation()
                    // This action is only visible if the subscription is 'pending'
                    ->visible(fn (Subscription $record): bool => $record->status === 'pending')
                    ->action(function (Subscription $record) {
                        $ends_at = null;
                        if ($record->plan->interval === 'monthly') {
                            $ends_at = Carbon::now()->addMonth();
                        } elseif ($record->plan->interval === 'yearly') {
                            $ends_at = Carbon::now()->addYear();
                        }

                        $record->update([
                            'status' => 'active',
                            'starts_at' => Carbon::now(),
                            'ends_at' => $ends_at,
                            // Set remaining quotes to -1 for unlimited
                            'remaining_quotes' => -1,
                        ]);

                        Notification::make()
                            ->title('Subscription Approved')
                            ->body('The user is now subscribed.')
                            ->success()
                            ->send();
                    }),

                Action::make('reject')
                    ->label('Reject')
                    ->button()
                    ->color('danger')
                    ->icon('heroicon-o-x-circle')
                    ->requiresConfirmation()
                    ->modalHeading('Reject Subscription')
                    ->modalDescription('Are you sure you want to reject this request? This action cannot be undone.')
                    // This action is only visible if the subscription is 'pending'
                    ->visible(fn (Subscription $record): bool => $record->status === 'pending')
                    ->action(function (Subscription $record) {
                        // For rejection, we simply delete the pending record.
                        $record->delete();

                        Notification::make()
                            ->title('Subscription Rejected')
                            ->body('The pending request has been deleted.')
                            ->success()
                            ->send();
                    }),

            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
