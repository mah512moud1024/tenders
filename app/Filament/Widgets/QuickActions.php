<?php

namespace App\Filament\Widgets;

use Filament\Widgets\TableWidget as BaseWidget;
class QuickActions extends BaseWidget
{

    protected int | string | array $columnSpan =[
        'default' => 2, // 4 columns on large screens
        'lg'=>1,
        'md' => 2,      // 2 columns on medium screens
        'sm' => 1,      // 2 columns on small screens (mobile)
    ];
    protected static ?int $sort = 4;

    protected  string $view = 'filament.widgets.quick-actions';






}
