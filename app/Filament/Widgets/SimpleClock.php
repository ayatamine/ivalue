<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class SimpleClock extends Widget
{
    protected static string $view = 'filament.widgets.simple-clock';
    protected int | string | array $columnSpan = 'full';
}
