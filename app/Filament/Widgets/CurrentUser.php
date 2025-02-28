<?php

namespace App\Filament\Widgets;

use Filament\Widgets\AccountWidget;

class CurrentUser extends AccountWidget
{
    public function getColumnSpan(): int|string|array
    {
        return 2;
    }
}
