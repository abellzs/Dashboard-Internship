<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\LowonganResource\Pages;
use App\Filament\Admin\Resources\LowonganResource\RelationManagers;
use App\Models\Lowongan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LowonganResource extends Resource
{
    protected static ?string $model = Lowongan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Manajemen HC';
    protected static ?string $navigationLabel = 'Unit';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_unit')
                    ->label('Nama Unit')
                    ->required(),
                Forms\Components\Textarea::make('deskripsi')
                    ->label('Deskripsi')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('major')
                    ->label('Jurusan yang Dibutuhkan')
                    ->required(),
                Forms\Components\Select::make('ketersediaan')
                    ->label('Ketersediaan')
                    ->options([
                        'Tersedia' => 'Tersedia',
                        'Tidak Tersedia' => 'Tidak Tersedia',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('lokasi')
                    ->label('Lokasi')
                    ->required(),
                Forms\Components\TextInput::make('durasi')
                    ->label('Durasi (Bulan)')
                    ->numeric()
                    ->required(),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_unit')->label('Nama Unit'),
                Tables\Columns\TextColumn::make('major')->label('Jurusan'),
                Tables\Columns\TextColumn::make('ketersediaan')->label('Ketersediaan'),
                Tables\Columns\TextColumn::make('lokasi')->label('Lokasi'),
                Tables\Columns\TextColumn::make('durasi')->label('Durasi (Bulan)'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListLowongans::route('/'),
            'create' => Pages\CreateLowongan::route('/create'),
            'edit' => Pages\EditLowongan::route('/{record}/edit'),
        ];
    }
}
