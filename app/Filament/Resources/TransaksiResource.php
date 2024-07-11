<?php

namespace App\Filament\Resources;

use App\Exports\DataExport;
use App\Filament\Resources\TransaksiResource\Pages;
use App\Filament\Resources\TransaksiResource\RelationManagers;
use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransaksiResource extends Resource
{
    protected static ?string $model = DetailTransaksi::class;
    protected static ?string $pluralLabel = 'Transaksi';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('transaksi.user.name')
                    ->label('Customer')
                    ->searchable(),
                TextColumn::make('produk.nama')
                    ->label('Produk')
                    ->searchable(),
                TextColumn::make('qty')
                    ->label('Qty')
                    ->searchable(),
                TextColumn::make('total')
                    ->label('Total')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->searchable(),
            ])
            ->filters([
                SelectFilter::make('produk.nama')
                    ->label('Produk')
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                BulkAction::make('export')
                ->label('Ekport Excel')
                ->icon('heroicon-o-document-arrow-down')
                ->action(function(Collection $records){
                    return Excel::download(new DataExport($records), 'Transaksi.xlsx');
                })
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransaksis::route('/'),
            'create' => Pages\CreateTransaksi::route('/create'),
            'edit' => Pages\EditTransaksi::route('/{record}/edit'),
        ];
    }
}
