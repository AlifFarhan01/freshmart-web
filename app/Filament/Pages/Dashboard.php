<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BasePage;

class Dashboard extends \Filament\Pages\Dashboard
{
    protected static ?string $title = 'Dashboard';
    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 3,
    ];
    
}
