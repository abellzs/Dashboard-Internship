<?php

namespace App\Livewire\Hc;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\MagangApplication;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MagangExport;
use App\Models\Lowongan;

class DataMagang extends Component
{
    use WithPagination;

    public $search = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $filter = 'all';
    public $toastMessage = '';
    public $showToast = false;
    public $documentUrl = null;

    public $unitFilter = 'all';
    public $durationFilter = 'all';
    public $dateFrom = null;
    public $dateTo = null;

    public $loadingApproveId = null;
    public $loadingRejectId = null;

    public $units = [];

    public $selectedPeserta = null;
    public $documentPaths = [];

    public $editDates = [];
    protected $listeners = ['updateTanggal'];

    public $confirmData = [
        'show' => false,
        'title' => '',
        'message' => '',
        'confirmText' => 'Yes',
        'action' => null,
        'id' => null,
    ];

    public function mount()
    {
        $this->units = Lowongan::select('nama_unit')
                        ->distinct()
                        ->pluck('nama_unit')
                        ->toArray();
    }

    public function updatingSearch() { $this->resetPage(); }
    public function updatingUnitFilter() { $this->resetPage(); }
    public function updatingDurationFilter() { $this->resetPage(); }
    public function updatingDateFrom() { $this->resetPage(); }
    public function updatingDateTo() { $this->resetPage(); }
    public function updatingFilter() { $this->resetPage(); }


    public function sort($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage(); // reset ke halaman 1 saat sorting berubah
    }

    public function setFilter($status)
    {
        $this->filter = $status;
        $this->resetPage();
    }

    public function showToast($msg)
    {
        $this->toastMessage = $msg;
        $this->showToast = true;

        $this->dispatch('browser-event', [
            'name' => 'toast',
            'data' => ['message' => $msg]
        ]);

        $this->dispatch('browser-event', [
            'name' => 'hide-toast',
            'data' => ['timeout' => 2000]
        ]);
    }


    public function viewDocument($id)
    {
        $magang = MagangApplication::with('user.magangDocument')->find($id);

        if (!$magang || !$magang->user) {
            session()->flash('error', 'Peserta tidak ditemukan');
            return;
        }

        $doc = $magang->user->magangDocument ?? (object)[
            'cv_path' => 'default_cv.pdf',
            'surat_permohonan_path' => 'default_surat.pdf',
            'proposal_path' => 'default_proposal.pdf',
            'foto_diri_path' => 'default_foto.jpg',
        ];

        $this->selectedPeserta = $magang;
        $this->documentPaths = [
            'cv' => $doc->cv_path ? asset('storage/' . $doc->cv_path) : null,
            'surat_permohonan' => $doc->surat_permohonan_path ? asset('storage/' . $doc->surat_permohonan_path) : null,
            'proposal' => $doc->proposal_path ? asset('storage/' . $doc->proposal_path) : null,
            'foto_diri' => $doc->foto_diri_path ? asset('storage/' . $doc->foto_diri_path) : null,
        ];

        $this->documentUrl = true;
    }

    public function closeDocument()
    {
        $this->documentUrl = null;
        $this->documentPaths = [];
        $this->selectedPeserta = null;
    }

    public function exportExcel()
    {
        return Excel::download(new MagangExport(
            $this->filter,
            $this->search,
            $this->unitFilter,
            $this->durationFilter,
            $this->dateFrom,
            $this->dateTo
        ), 'DataMagang.xlsx');
    }

    public function updateTanggal($id, $field)
    {
        $magang = MagangApplication::find($id);
        if (!$magang) return;

        $newDate = $this->editDates[$id][$field];

        try {
            $newDateCarbon = Carbon::parse($newDate);
        } catch (\Exception $e) {
            $this->showToast("Tanggal tidak valid!");
            return;
        }

        // Ambil tanggal lain untuk validasi
        $tanggalMulai = isset($this->editDates[$id]['tanggal_mulai_usulan']) 
                        ? Carbon::parse($this->editDates[$id]['tanggal_mulai_usulan']) 
                        : null;
        $tanggalSelesai = isset($this->editDates[$id]['tanggal_selesai_usulan']) 
                        ? Carbon::parse($this->editDates[$id]['tanggal_selesai_usulan']) 
                        : null;

        if ($field === 'tanggal_mulai_usulan' && $tanggalSelesai && $newDateCarbon->gt($tanggalSelesai)) {
            $this->editDates[$id][$field] = $magang->$field?->format('Y-m-d') ?? null;
            $this->showToast("Tanggal mulai tidak boleh lebih besar dari tanggal selesai!");
            return;
        }

        if ($field === 'tanggal_selesai_usulan' && $tanggalMulai && $newDateCarbon->lt($tanggalMulai)) {
            $this->editDates[$id][$field] = $magang->$field?->format('Y-m-d') ?? null;
            $this->showToast("Tanggal selesai tidak boleh lebih kecil dari tanggal mulai!");
            return;
        }

        // Simpan tanggal baru
        $magang->$field = $newDateCarbon->format('Y-m-d');
        $magang->save();

        // Tentukan status baru sesuai tanggal
        if ($magang->tanggal_mulai_usulan && $magang->tanggal_selesai_usulan) {
            $mulai = Carbon::parse($magang->tanggal_mulai_usulan);
            $selesai = Carbon::parse($magang->tanggal_selesai_usulan);

            if (now()->lt($mulai)) {
                $magang->status = 'accepted';
            } elseif (now()->between($mulai, $selesai)) {
                $magang->status = 'on_going';
            } elseif (now()->gt($selesai)) {
                $magang->status = 'done';
            }

            $magang->save();
        }

        $this->showToast("Tanggal & status berhasil diperbarui!");
    }

    public function render()
    {

        $magang = MagangApplication::with('user')
            ->whereHas('user') // Pastikan hanya yang punya user
            ->when($this->filter === 'all', fn($q) => $q->whereIn('status', ['on_going', 'done']))
            ->when($this->filter !== 'all', fn($q) => $q->where('status', $this->filter))
            ->when($this->search, fn($q) =>
                $q->whereHas('user', fn($u) =>
                    $u->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('nim_magang', 'like', '%' . $this->search . '%')
                )
            )
            ->when($this->sortBy === 'user.name', function ($query) {
                $query->join('users', 'magang_applications.user_id', '=', 'users.id')
                    ->orderBy('users.name', $this->sortDirection)
                    ->select('magang_applications.*');
            }, fn($q) => $q->orderBy($this->sortBy, $this->sortDirection))
            ->when($this->unitFilter !== 'all' && !empty($this->unitFilter), function ($q) {
                $q->where('unit_penempatan', $this->unitFilter);
            }, function ($q) {
                // Kondisi else, kalau all dipilih maka tidak ada filter unit
                return $q;
            })
            ->paginate(10);


        foreach ($magang as $row) {
            $this->editDates[$row->id] = [
                'tanggal_mulai_usulan' => $row->tanggal_mulai_usulan ? $row->tanggal_mulai_usulan->format('Y-m-d') : null,
                'tanggal_selesai_usulan' => $row->tanggal_selesai_usulan ? $row->tanggal_selesai_usulan->format('Y-m-d') : null,
            ];

        }

        return view('livewire.hc.data-magang', [
            'magang' => $magang,
        ])->layout('components.layouts.hc.app');
    }
}
