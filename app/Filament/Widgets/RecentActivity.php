<?php

namespace App\Filament\Widgets;

use App\Models\Quote;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentActivity extends BaseWidget
{
    protected int | string | array $columnSpan = 'half';
    protected static ?int $sort = 3;

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
                    ->label('Tender')
                    ->limit(30)
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->money('AED')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'submitted',
                        'primary' => 'under_review',
                        'success' => 'accepted',
                        'danger' => 'rejected',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('M j, Y g:i A')
                    ->label('Submitted'),
            ])
            ->heading('Recent Quote Activity')
            ->description('Your latest quote submissions');
    }
}
