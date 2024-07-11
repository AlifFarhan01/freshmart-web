<?php

namespace App\Filament\Widgets;

use App\Models\DetailTransaksi;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Spatie\Permission\Traits\HasRoles;

class StatsOverview extends BaseWidget
{
    protected static ?string $model = DetailTransaksi::class;
    protected function getStats(): array
    {
        $user = User::whereHas('roles', function ($query){
            $query->where('name', 'Customer');
        })->count();
        $produk = Produk::all()->count();
        $transaksi = Transaksi::count();
        $payment = Transaksi::sum('total');
        $formattedTransaksiCount = number_format($payment, 0, ',', '.');
        return [
            Stat::make('Customers', $user),
            Stat::make('Produk', $produk),
            Stat::make('Transaksi', $transaksi),
            Stat::make('Total Payment','Rp. ' . $formattedTransaksiCount),
        ];
    }
}
