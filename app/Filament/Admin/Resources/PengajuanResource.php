<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PengajuanResource\Pages;
use App\Filament\Admin\Resources\PengajuanResource\RelationManagers;
use App\Models\Pengajuan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use App\Models\MagangApplication;

class PengajuanResource extends Resource
{
    protected static ?string $model = MagangApplication::class;

    protected static ?string $navigationLabel = 'Pengajuan';
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Magang';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user.name')
                    ->label('Nama')
                    ->disabled(), // cuma read-only

                Forms\Components\TextInput::make('user.nim_magang')
                    ->label('NIM')
                    ->disabled(),

                Forms\Components\TextInput::make('unit_penempatan')
                    ->required(),

                Forms\Components\TextInput::make('durasi_magang')
                    ->required(),

                Forms\Components\Section::make('Dokumen')
                    ->schema([
                        Forms\Components\TextInput::make('magangDocument.cv_path')->label('CV')->disabled(),
                        Forms\Components\TextInput::make('magangDocument.surat_permohonan_path')->label('Surat Permohonan')->disabled(),
                        Forms\Components\TextInput::make('magangDocument.proposal_path')->label('Proposal')->disabled(),
                        Forms\Components\TextInput::make('magangDocument.foto_diri_path')->label('Foto Diri')->disabled(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('Nama')->searchable()->sortable(),
                TextColumn::make('user.nim_magang')->label('NIM')->searchable()->sortable(),
                TextColumn::make('unit_penempatan')->label('Unit Penempatan')->searchable()->sortable(),
                TextColumn::make('durasi_magang')->label('Durasi')->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => match($state) {
                        'waiting' => 'Waiting',
                        'accepted' => 'Accepted',
                        'rejected' => 'Rejected',
                        'on_going' => 'On Going',
                        default => $state,
                    }),
                TextColumn::make('magangDocument.cv_path')
                    ->label('CV')
                    ->getStateUsing(fn ($record) => $record->magangDocument?->cv_path ?? '-'),
                TextColumn::make('magangDocument.surat_permohonan_path')
                    ->label('Surat')
                    ->getStateUsing(fn ($record) => $record->magangDocument?->surat_permohonan_path ?? '-'),
                TextColumn::make('magangDocument.proposal_path')
                    ->label('Proposal')
                    ->getStateUsing(fn ($record) => $record->magangDocument?->proposal_path ?? '-'),
                TextColumn::make('magangDocument.foto_diri_path')
                    ->label('Foto')
                    ->getStateUsing(fn ($record) => $record->magangDocument?->foto_diri_path ?? '-'),

            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'waiting' => 'Waiting',
                        'accepted' => 'Accepted',
                        'rejected' => 'Rejected',
                        'on_going' => 'On Going',
                    ]),

                Tables\Filters\SelectFilter::make('unit_penempatan')
                    ->label('Unit Penempatan')
                    ->options(fn() => MagangApplication::query()
                        ->pluck('unit_penempatan', 'unit_penempatan')
                        ->unique()),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPengajuans::route('/'),
            'create' => Pages\CreatePengajuan::route('/create'),
            'edit' => Pages\EditPengajuan::route('/{record}/edit'),
        ];
    }
}