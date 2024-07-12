<?php

namespace App\Filament\Resources;

use App\Exports\DataExport;
use App\Filament\Resources\TransaksiResource\Pages;
use App\Models\DetailTransaksi;
use App\Models\Produk;
use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\QueryBuilder\Constraints\DateConstraint;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Facades\Excel;

class TransaksiResource extends Resource
{
    protected static ?string $model = DetailTransaksi::class;
    protected static ?string $pluralLabel = 'Transaksi';
    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label('Customer')
                    ->required()
                    ->preload()
                    ->options(User::whereHas('roles', function ($query) {
                        $query->where('name', 'Customer');
                    })->get()->pluck('name', 'id')),
                select::make('produk_id')
                    ->label('Nama Produk')
                    ->required()
                    ->preload()
                    ->options(Produk::get()->pluck('nama', 'id')),
                TextInput::make('qty')
                    ->label('QTY')
                    ->required()
                    ->numeric(),
                TextInput::make('total')
                    ->label('Total')
                    ->required()
                    ->numeric(),
                DateTimePicker::make('created_at')
                    ->label('Tanggal')
                    ->nullable(),
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
                QueryBuilder::make()
                ->constraints([
                    DateConstraint::make('created_at')
                    ->label('Tahun')
                ]),
                SelectFilter::make('produk')->relationship('produk', 'nama')
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
