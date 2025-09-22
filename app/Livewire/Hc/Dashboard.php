<?php

namespace App\Livewire\Hc;

use Livewire\Component;
use App\Models\MagangApplication;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    public $waiting, $approved, $rejected, $total;
    public $unitLabels = [], $unitCounts = [];
    public $universityLabels = [], $universityCounts = [];
    public $bulanLabels = [], $bulanCounts = [];
    public $genderLabels = [], $genderCounts = [];

    public function mount()
    {
        // Status
        $this->waiting  = MagangApplication::where('status', 'waiting')->count();
        $this->approved = MagangApplication::where('status', 'accepted')->count();
        $this->rejected = MagangApplication::where('status', 'rejected')->count();
        $this->total    = MagangApplication::count();

        // Distribusi Unit
        $unitData = MagangApplication::select('unit_penempatan', DB::raw('COUNT(*) as total'))
            ->groupBy('unit_penempatan')
            ->orderByDesc('total')
            ->get();
        $this->unitLabels = $unitData->pluck('unit_penempatan')->toArray();
        $this->unitCounts = $unitData->pluck('total')->toArray();

        // Distribusi Universitas
        $univData = MagangApplication::with('user.profile')
            ->get()
            ->groupBy(fn($m) => $m->user->profile->asal_universitas ?? 'Unknown')
            ->map(fn($g) => $g->count());
        $this->universityLabels = $univData->keys()->toArray();
        $this->universityCounts = $univData->values()->toArray();

        // Peserta per Bulan
        $bulanData = MagangApplication::select(
                DB::raw("DATE_FORMAT(created_at, '%M %Y') as bulan"),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('bulan')
            ->orderByRaw("MIN(created_at)")
            ->get();
        $this->bulanLabels = $bulanData->pluck('bulan')->toArray();
        $this->bulanCounts = $bulanData->pluck('total')->toArray();

        $genderData = MagangApplication::with('user.profile')
            ->get()
            ->groupBy(fn($m) => $m->user->profile->jenis_kelamin ?? 'Unknown')
            ->map(fn($g) => $g->count());

        $this->genderLabels = $genderData->keys()->toArray();
        $this->genderCounts = $genderData->values()->toArray();
    }

    public function render()
    {
        return view('livewire.hc.dashboard')
            ->extends('components.layouts.hc.app')
            ->section('content');
    }
}
