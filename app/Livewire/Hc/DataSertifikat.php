<?php

namespace App\Livewire\Hc;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Certificates;
use App\Models\Lowongan;
use App\Models\MagangApplication;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Writer\Pdf;

class DataSertifikat extends Component
{
    use WithPagination;

    public $search = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $filter = 'all';
    public $perPage = 10;
    public $showEditModal = false;
    public $editMagangApplicationId = null;
    public $nomor_dinas_masuk = '';
    public $nomor_dinas_keluar = '';
    public $showSenderModal = false;
    public $selectedMagangApplicationId = null;
    public $selectedDocumentType = 'masuk';
    public $receiver = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatingFilter()
    {
        $this->resetPage();
    }

    public function sort($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function setFilter($status)
    {
        $this->filter = $status;
        $this->resetPage();
    }

    public function filterPreparedGraduation()
    {
        // $startOfNextWeek = Carbon::now()->addWeek()->startOfWeek();
        $startOfNextWeek = Carbon::now()->startOfDay(); //Pembiasaan Terlebih Dahulu 
        $endOfNextWeek = Carbon::now()->addWeek()->endOfWeek();
        $query = MagangApplication::with('user')
            ->where('status', 'on_going')
            ->whereNotNull('tanggal_selesai_usulan')
            ->whereBetween('tanggal_selesai_usulan', [$startOfNextWeek, $endOfNextWeek])
            ->orderBy('tanggal_selesai_usulan', 'desc');

        if (!empty($this->search)) {
            $query->whereHas('user', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            });
        }

        return $query->paginate($this->perPage);
    }

    public function editNomorSertifikat($magangApplicationId)
    {
        $this->editMagangApplicationId = $magangApplicationId;
        $certificate = Certificates::where('magang_application_id', $magangApplicationId)->first();
        $this->nomor_dinas_masuk = $certificate ? $certificate->nomor_dinas_masuk : '';
        $this->nomor_dinas_keluar = $certificate ? $certificate->nomor_dinas_keluar : '';
        $this->showEditModal = true;
    }

    public function saveNomorDinas()
    {
        $magang = MagangApplication::find($this->editMagangApplicationId);

        Certificates::updateOrCreate(
            [
                'magang_application_id' => $this->editMagangApplicationId,
                'user_id' => $magang->user_id,
            ],
            [
                'nomor_dinas_masuk' => $this->nomor_dinas_masuk,
                'nomor_dinas_keluar' => $this->nomor_dinas_keluar !== '' ? $this->nomor_dinas_keluar : null,
            ]
        );

        session()->flash('message', 'Nomor dinas berhasil disimpan.');
        $this->showEditModal = false;
    }

    public function deleteNomorDinasMasuk()
    {
        Certificates::where('magang_application_id', $this->editMagangApplicationId)
            ->update(['nomor_dinas_masuk' => null]);
        session()->flash('message', 'Nomor dinas masuk berhasil dihapus.');
        $this->nomor_dinas_masuk = '';
        $this->showEditModal = false;
    }

    public function deleteNomorDinasKeluar()
    {
        Certificates::where('magang_application_id', $this->editMagangApplicationId)
            ->update(['nomor_dinas_keluar' => null]);
        session()->flash('message', 'Nomor dinas keluar berhasil dihapus.');
        $this->nomor_dinas_keluar = '';
        $this->showEditModal = false;
    }

    public function getCertificateNumber($magangApplicationId)
    {
        $certificate = Certificates::where('magang_application_id', $magangApplicationId)->first();

        return [
            'nomor_dinas_masuk' => $certificate && $certificate->nomor_dinas_masuk ? $certificate->nomor_dinas_masuk : '-',
            'nomor_dinas_keluar' => $certificate && $certificate->nomor_dinas_keluar ? $certificate->nomor_dinas_keluar : '-',
        ];
    }

    public function getCertificateStatus($magangApplicationId)
    {
        $certificate = Certificates::where('magang_application_id', $magangApplicationId)->first();
        return $certificate && $certificate->nomor_dinas_keluar ? 'Sudah Terbit' : 'Belum Terbit';
    }

    public function downloadSertifikat($magangApplicationId)
    {
        $magangApplication = MagangApplication::with('user')->where('id', $magangApplicationId)->first();
        if (!$magangApplication) {
            session()->flash('error', 'Data magang tidak ditemukan.');
            return;
        }

        $certificate = Certificates::where('magang_application_id', $magangApplicationId)->first();
        if (!$certificate || !$certificate->nomor_dinas_keluar) {
            session()->flash('error', 'Nomor sertifikat belum diisi.');
            return;
        }

        $pdf = FacadePdf::loadView('certificate.certificate-template', [
            'user' => $magangApplication->user,
            'magang' => $magangApplication,
            'certificate' => $certificate,
        ])->setPaper('a4', 'landscape');

        return response()->streamDownload(
            fn() => print($pdf->output()),
            'Sertifikat_' . preg_replace('/\s+/', '_', $magangApplication->user->name) . '.pdf'
        );
    }

    public function downloadNotaDinasMasuk($magangApplicationId)
    {
        $magangApplication = MagangApplication::with('user')->where('id', $magangApplicationId)->first();
        if (!$magangApplication) {
            session()->flash('error', 'Data magang tidak ditemukan.');
            return;
        }

        $certificate = Certificates::where('magang_application_id', $magangApplicationId)->first();
        if (!$certificate || !$certificate->nomor_dinas_masuk) {
            session()->flash('error', 'Nomor Nota Dinas Masuk belum diisi.');
            return;
        }

        $unit = Lowongan::where('nama_unit', $magangApplication->unit_penempatan)->first();
        if (!$unit) {
            session()->flash('error', 'Data pembimbing tidak ditemukan untuk unit penempatan ini.');
            return;
        }

        $UserProfile = \App\Models\UserProfile::where('user_id', $magangApplication->user_id)->first();

        $pdf = FacadePdf::loadView('certificate.nota-dinas-masuk', [
            'user' => $magangApplication->user,
            'magang' => $magangApplication,
            'certificate' => $certificate,
            'userProfile' => $UserProfile,
            'receiver' => $this->receiver,
            'pembimbing' => $unit->pembimbing,
        ])->setPaper('a4', 'portrait');

        $this->showSenderModal = false;

        return response()->streamDownload(
            fn() => print($pdf->output()),
            'Nota_Dinas_Masuk_' . preg_replace('/\s+/', '_', $magangApplication->user->name) . '.pdf'
        );
    }

    public function downloadNotaDinasKeluar($magangApplicationId)
    {
        $magangApplication = MagangApplication::with('user')->where('id', $magangApplicationId)->first();
        if (!$magangApplication) {
            session()->flash('error', 'Data magang tidak ditemukan.');
            return;
        }

        $certificate = Certificates::where('magang_application_id', $magangApplicationId)->first();
        if (!$certificate || !$certificate->nomor_dinas_keluar) {
            session()->flash('error', 'Nomor Nota Dinas Keluar belum diisi.');
            return;
        }

        $unit = Lowongan::where('nama_unit', $magangApplication->unit_penempatan)->first();
        if (!$unit) {
            session()->flash('error', 'Data pembimbing tidak ditemukan untuk unit penempatan ini.');
            return;
        }

        $UserProfile = \App\Models\UserProfile::where('user_id', $magangApplication->user_id)->first();

        $pdf = FacadePdf::loadView('certificate.nota-dinas-keluar', [
            'user' => $magangApplication->user,
            'magang' => $magangApplication,
            'certificate' => $certificate,
            'userProfile' => $UserProfile,
            'receiver' => $this->receiver,
            'pembimbing' => $unit->pembimbing,
        ])->setPaper('a4', 'portrait');

        $this->showSenderModal = false;

        return response()->streamDownload(
            fn() => print($pdf->output()),
            'Nota_Dinas_Keluar_' . preg_replace('/\s+/', '_', $magangApplication->user->name) . '.pdf'
        );
    }

    public function openSenderModal($magangApplicationId, $documentType)
    {
        $this->selectedMagangApplicationId = $magangApplicationId;
        $this->receiver = null;
        $this->showSenderModal = true; 
        $this->selectedDocumentType = $documentType;
    }

    public function render()
    {
        if (
            $this->filter === 'prepared_graduation'
        ) {
            $magang = $this->filterPreparedGraduation();
        } else {
            $magang = MagangApplication::with('user')
                ->whereIn('status', ['accepted','on_going', 'done']) // hanya status on_going dan done
                ->when($this->filter !== 'all', fn($q) => $q->where('status', $this->filter))
                ->when(
                    $this->search,
                    fn($q) =>
                    $q->whereHas(
                        'user',
                        fn($u) =>
                        $u->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('nim_magang', 'like', '%' . $this->search . '%')
                    )
                )
                ->orderBy($this->sortBy, $this->sortDirection)
                ->paginate($this->perPage);
        }
        return view('livewire.hc.data-sertifikat', [
            'magang' => $magang,
        ])->layout('components.layouts.hc.app');
    }
}
