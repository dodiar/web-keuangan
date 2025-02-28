<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $receive = Transaction::incomes()->get()->sum('amount');        
        $payable = Transaction::expenses()->get()->sum('amount');        

        return [
            Stat::make('Total Pemasukan', $receive),
            Stat::make('Total Pengeluaran', $payable),
            Stat::make('Selisih', $receive - $payable),
        ];
    }
}
