<?php

namespace App\Livewire\Hc;

use Livewire\Component;

class Reminder extends Component
{
    public function render()
    {
        return view('livewire.hc.reminder')
            ->extends('components.layouts.hc.app') // <-- ini penting
            ->section('content');
    }
}
