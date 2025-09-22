<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Lowongan;

class LowonganList extends Component
{
    public $selectedId = null;

    public function select($id)
    {
        $this->selectedId = $id;
        $this->dispatch('lowonganSelected', id: $id);
    }

    public function render()
    {
        return view('livewire.pendaftaran.steps.lowongan-list', [
            'lowongans' => Lowongan::all()
        ]);
    }
}
