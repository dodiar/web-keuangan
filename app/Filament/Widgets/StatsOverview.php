<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    use InteractsWithPageFilters;

    protected function getStats(): array
    {
        $startDate = ! is_null($this->filters['startDate'] ?? null) ?
        Carbon::parse($this->filters['startDate']) :
        null;

        $endDate = ! is_null($this->filters['endDate'] ?? null) ?
        Carbon::parse($this->filters['endDate']) :
        now();

        $receive = Transaction::incomes()
                    ->whereBetween('date_tx', [$startDate, $endDate])
                    ->sum('amount');     
                       
        $payable = Transaction::expenses()
                    ->whereBetween('date_tx', [$startDate, $endDate])
                    ->sum('amount');        

        return [
            Stat::make('Total Pemasukan', 'Rp.'.' '.$receive),
            Stat::make('Total Pengeluaran', 'Rp.'.' '.$payable),
            Stat::make('Selisih', 'Rp.'.' '.$receive - $payable),            
        ];
    }
}
