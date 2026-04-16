<?php

namespace App\Filament\Resources\Tenders\Pages;

use App\Filament\Resources\Tenders\TenderResource;
use App\Models\Tender;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTender extends ViewRecord
{
    protected static string $resource = TenderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),

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
        ];
    }
}
