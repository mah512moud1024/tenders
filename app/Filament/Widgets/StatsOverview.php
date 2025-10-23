<?php

namespace App\Filament\Widgets;

use App\Models\Quote;
use App\Models\Tender;
use App\Models\Invoice;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        $user = auth()->user();

        return [
            Stat::make('Total Tenders', Tender::count())
                ->description('All active tenders')
                ->descriptionIcon('heroicon-o-clipboard-document-list')
                ->color('primary')
                ->chart([7, 2, 10, 3, 15, 4, 17]),

            Stat::make('Your Quotes', Quote::where('user_id', $user->id)->count())
                ->description('Quotes you submitted')
                ->descriptionIcon('heroicon-o-document-text')
                ->color('success')
                ->chart([2, 5, 3, 8, 4, 6, 9]),

            Stat::make('Pending Invoices', Invoice::where('user_id', $user->id)->where('status', 'sent')->count())
                ->description('Awaiting payment')
                ->descriptionIcon('heroicon-o-credit-card')
                ->color('warning')
                ->chart([1, 2, 3, 2, 1, 4, 3]),

            Stat::make('Active Projects', Tender::where('user_id', $user->id)->where('status', 'assigned')->count())
                ->description('Your ongoing projects')
                ->descriptionIcon('heroicon-o-cog-6-tooth')
                ->color('info')
                ->chart([3, 5, 2, 4, 6, 8, 7]),
        ];
    }
}
