<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class AdvertisingSlider extends BaseWidget
{
    protected  string $view = 'filament.widgets.advertising-slider';
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 'full' ;


//    protected function getViewData(): array
//    {
//        // Add this line to "die and dump" the property
//        dd($this);
//
//
//    }

    public function getMaxHeight(): string
    {
        return '400px';
    }
}
