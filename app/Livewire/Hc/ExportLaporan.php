<?php

namespace App\Livewire\Hc;

use Livewire\Component;

class ExportLaporan extends Component
{
    public function render()
    {
        return view('livewire.hc.export-laporan')
            ->extends('components.layouts.hc.app') // <-- ini penting
            ->section('content');
    }
}
