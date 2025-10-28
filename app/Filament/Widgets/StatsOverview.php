<?php

namespace App\Filament\Widgets;

use App\Models\Quote;
use App\Models\Tender;
use App\Models\Invoice;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 3;
    protected array|int|null $columns = [
        'default' => 2, // 4 columns on large screens
        'lg'=>4,
        'md' => 2,      // 2 columns on medium screens
        'sm' => 2,      // 2 columns on small screens (mobile)
    ];
    protected function getStats(): array
    {
        $user = auth()->user();

        return [
            Stat::make(__('Total Tenders'), Tender::count())
                ->description(__('All active tenders'))
                ->descriptionIcon('heroicon-o-clipboard-document-list')
                ->color('primary')
                ->chart([7, 2, 10, 3, 15, 4, 17]),

            Stat::make(__('Your Quotes'), Quote::where('user_id', $user->id)->count())
                ->description(__('Quotes you submitted'))
                ->descriptionIcon('heroicon-o-document-text')
                ->color('success')
                ->chart([2, 5, 3, 8, 4, 6, 9]),

            Stat::make(__('Pending Invoices'), Invoice::where('user_id', $user->id)->where('status', 'sent')->count())
                ->description(__('Awaiting payment'))
                ->descriptionIcon('heroicon-o-credit-card')
                ->color('warning')
                ->chart([1, 2, 3, 2, 1, 4, 3]),

            Stat::make(__('Active Projects'), Tender::where('user_id', $user->id)->where('status', 'assigned')->count())
                ->description(__('Your ongoing projects'))
                ->descriptionIcon('heroicon-o-cog-6-tooth')
                ->color('info')
                ->chart([3, 5, 2, 4, 6, 8, 7]),
        ];
    }
}
