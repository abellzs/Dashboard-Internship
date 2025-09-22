<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MagangFullImport;

class ImportMagang extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-upload';
    protected static string $view = 'filament.pages.import-magang'; // Tidak akan dipakai di v3
    protected static ?string $navigationLabel = 'Import Magang';

    public ?string $file = null;

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                FileUpload::make('file')
                    ->label('Upload Excel')
                    ->acceptedFileTypes(['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','application/vnd.ms-excel'])
                    ->required()
            ]);
    }

    public function submit()
    {
        if ($this->file) {
            Excel::import(new MagangFullImport, storage_path('app/'.$this->file));
            $this->notify('success', 'Data berhasil diimport!');
        }
    }
}
