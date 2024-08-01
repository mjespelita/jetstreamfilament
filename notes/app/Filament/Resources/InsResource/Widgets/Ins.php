<?php

namespace App\Filament\Resources\InsResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Ins as Inss;

class Ins extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Users', Inss::count())
                ->color('success')
                ->description('Number of active users.'),
        ];
    }
}
