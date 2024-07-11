<?php

namespace App\Filament\Widgets;

use App\Models\DetailTransaksi;
use App\Models\Produk;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class Laporan extends BaseWidget
{
    protected int | string | array $columnSpan = "full";
    protected static ?int $sort = 2;
    public function table(Table $table): Table
    {
        return $table
            ->query(DetailTransaksi::query())
            ->columns([
                TextColumn::make('produk.nama')
                    ->label('Produk')
            ]);
    }
}
