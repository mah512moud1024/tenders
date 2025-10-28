<?php

namespace App\Filament\Widgets;

use App\Models\Quote;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentActivity extends BaseWidget
{
    protected int | string | array $columnSpan =[
        'default' => 2, // 4 columns on large screens
        'lg'=>1,
        'md' => 2,      // 2 columns on medium screens
        'sm' => 1,      // 2 columns on small screens (mobile)
    ];
    protected static ?int $sort = 4;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Quote::query()
                    ->where('user_id', auth()->id())
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('tender.title')
                    ->label(__('Tender'))
                    ->limit(30)
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->label(__('amount'))
                    ->money('AED')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label(__('status'))
                    ->colors([
                        'warning' => 'submitted',
                        'primary' => 'under_review',
                        'success' => 'accepted',
                        'danger' => 'rejected',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('M j, Y g:i A')
                    ->label(__('Submitted')),
            ])
            ->heading(__('Recent Quote Activity'));
    }
}
