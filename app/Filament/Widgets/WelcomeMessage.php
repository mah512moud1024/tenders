<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class WelcomeMessage extends Widget
{
    protected  string $view = 'filament.widgets.welcome-message';

    // Set this to 'full' to take the entire width
    protected int | string | array $columnSpan = 'full';
}
