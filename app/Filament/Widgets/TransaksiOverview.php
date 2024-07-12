<?php

namespace App\Filament\Widgets;

use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TransaksiOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $payment = Transaksi::sum('total');
        $formattedTransaksiCount = number_format($payment, 0, ',', '.');
        return [
            Stat::make('Total Payment','Rp. ' . $formattedTransaksiCount),
        ];
    }
}
