<?php

namespace App\Filament\Widgets;

use App\Models\DetailTransaksi;
use App\Models\Produk;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Facades\DB;

class TransksiChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';
    protected static string $color = 'info';

    protected function getData(): array
    {
        $data = DetailTransaksi::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            'produk_id',
            DB::raw('SUM(qty) as total_transactions')
        )
        ->whereYear('created_at', now()->year)
        ->groupBy('year', 'month', 'produk_id')
        ->get();

        // dd($data);
        $datasets = [];
        foreach ($data as $item) {
            $produk = Produk::find($item->produk_id); // Ambil produk berdasarkan ID
            if ($produk) {
                $label = $produk->nama; // Gunakan nama produk sebagai label
                $datasets[$label][] = [
                    'month' => date('M Y', strtotime($item->year . '-' . $item->month . '-01')),
                    'total_transactions' => $item->total_transactions,
                ];
            }
        }
        $finalData = [
            'datasets' => [],
            'labels' => [],
        ];

        foreach ($datasets as $label => $dataset) {
            $finalData['datasets'][] = [
                'label' => $label,
                'data' => collect($dataset)->pluck('total_transactions')->toArray(),
            ];
            $finalData['labels'] = collect($dataset)->pluck('month')->toArray();
        }

        return $finalData;
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
