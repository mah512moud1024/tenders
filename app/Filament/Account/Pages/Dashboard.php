<?php

namespace App\Filament\Account\Pages;

//use Filament\Pages\Dashboards as BaseDashboard;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    // 1. Add the view property to point to your custom dashboard view
    protected  string $view = 'filament.account.pages.dashboard';

    public function getColumns(): int | array
    {
        // You can keep this, but since we are overriding the view,
        // it may not have an effect on your custom layout.
        return 1;
    }

    // You can now remove the getWidgets() method if you added it previously.
}
