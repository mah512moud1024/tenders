<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
class QuickActions extends Widget
{



    protected  string $view = 'filament.widgets.quick-actions';

    protected static ?int $sort = 4;
    protected array|string|int $columnSpan =[
        'default' => 1,
        'lg'=>1,
        'md' => 1,      // 2 columns on medium screens
        'sm' => 1,      // 2 columns on small screens (mobile)
    ];



}
