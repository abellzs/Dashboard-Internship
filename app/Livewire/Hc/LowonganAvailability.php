<?php

namespace App\Livewire\Hc;

use Livewire\Component;
use App\Models\Lowongan;

class LowonganAvailability extends Component
{
    public $lowongans;

    // Tambahan properti untuk count
    public $availableCount = 0;
    public $unavailableCount = 0;

    // Properti untuk toast
    public $toastMessage = '';
    public $showToast = false;

    public function mount()
    {
        if(auth()->user()->role !== 'hc') {
            abort(403, 'Unauthorized');
        }

        $this->loadData();
    }

    private function loadData()
    {
        $this->lowongans = Lowongan::all();
        $this->availableCount = $this->lowongans->where('ketersediaan', 'Tersedia')->count();
        $this->unavailableCount = $this->lowongans->where('ketersediaan', '!=', 'Tersedia')->count();
    }

    public function toggleAvailability($id)
    {
        $lowongan = Lowongan::find($id);
        if ($lowongan) {
            $lowongan->ketersediaan = $lowongan->ketersediaan === 'Tersedia' ? 'Tidak Tersedia' : 'Tersedia';
            $lowongan->save();

            $this->loadData();

            $this->showToast("Ketersediaan berhasil diubah!");
        }
    }

    public function setAvailability($id, $status)
    {
        $lowongan = Lowongan::find($id);
        if ($lowongan && in_array($status, ['Tersedia', 'Tidak Tersedia'])) {
            $lowongan->ketersediaan = $status;
            $lowongan->save();

            $this->loadData();
            $this->showToast("Tanggal berhasil diperbarui!");
        }
    }

    public function showToast($message)
    {
        $this->toastMessage = $message;
        $this->showToast = true;
    }

    public function render()
    {
        return view('livewire.hc.lowongan-availability')
            ->extends('components.layouts.hc.app')
            ->section('content');
    }
}
