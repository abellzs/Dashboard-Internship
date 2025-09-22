<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Lowongan;


class LowonganDetail extends Component
{
    public $lowongan;

    protected $listeners = ['lowonganSelected' => 'loadLowongan'];

    public function loadLowongan($id)
    {
        $this->lowongan = Lowongan::find($id);
    }

    public function render()
    {
        return view('livewire.lowongan-detail');
    }
}
