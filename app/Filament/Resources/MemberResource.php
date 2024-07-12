<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MemberResource\Pages;
use App\Models\member;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MemberResource extends Resource
{
    protected static ?string $model = member::class;
    protected static ?string $pluralLabel = 'Member';
    protected static ?string $navigationGroup = 'Data Master';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama')
                    ->label('Kelas Member')
                    ->required()
                    ->string()
                    ->maxLength(255),
                TextInput::make('diskon')
                    ->label('Discount Percent')
                    ->helperText('Diskon Berdasarkan Persentase Harga')
                    ->default(0)
                    ->placeholder('0%')
                    ->mask('99%'),
                Toggle::make('status')
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->label('Kelas Member')
                    ->searchable(),
                TextColumn::make('diskon')
                    ->label('Discount Percent')
                    ->formatStateUsing(function ($state) {
                        return $state . '%';
                    })
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        '1' => 'success',
                        '0' => 'danger',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        '1' => 'Aktif',
                        '0' => 'Tidak Aktif'
                    })
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('deactivate')->label('matikan')->icon('heroicon-o-x-circle')->color('danger')->action(function ($data, $record): void {
                    self::deactivate($record, $data);
                })->requiresConfirmation()->visible(function ($record) {
                    return $record->status == 1;
                })->hidden(function ($record) {
                    if ($record->nama == 'non member') {
                        return true;
                    }
                    return false;
                }),
                

                Action::make('activate')->label('Aktifkan')->icon('heroicon-o-check')->color('success')->action(function ($data, $record): void {
                    self::activate($record, $data);
                })->requiresConfirmation()->visible(function ($record) {
                    return $record->status == 0;
                })
                ->hidden(function ($record) {
                    if ($record->nama == 'non member') {
                        return true;
                    }
                    return false;
                }),

                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function deactivate($record, $data)
    {
        $record->status = 0;
        $record->save();
    }

    public static function activate($record, $data)
    {
        $record->status = 1;
        $record->save();
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
            'index' => Pages\ListMembers::route('/'),
            'create' => Pages\CreateMember::route('/create'),
            // 'edit' => Pages\EditMember::route('/{record}/edit'),
        ];
    }
}
