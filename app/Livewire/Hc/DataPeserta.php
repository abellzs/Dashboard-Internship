<?php

namespace App\Livewire\Hc;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\MagangApplication;
use App\Exports\PesertaExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Mail;
use App\Mail\MagangAcceptedMail;
use App\Mail\MagangRejectedMail;
use Carbon\Carbon;
use App\Models\Lowongan;

class DataPeserta extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $unitFilter = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $showFlagged = false;
    public $filter = 'all';
    public $documentUrl = null;
    public $documentPaths = [];
    public $loadingApproveId = null;
    public $loadingRejectId = null;
    public $showDocument = false;
    public $showToast = false;
    public $toastMessage = '';
    public $selectedPeserta;
    public $waNumber = null;
    public $editDates = [];


    public $confirmData = [
        'show' => false,
        'title' => '',
        'message' => '',
        'confirmText' => '',
        'action' => '',
        'id' => null,
    ];

    protected $paginationTheme = 'tailwind';

    // Satukan ke satu map, pakai ini
    protected $unitCodes = [
        'Human Capital' => '01',
        'Sekretaris' => '02',
        'Asset & Facility' => '03',
        'Financial Collection' => '04',
        'Business Service' => '05',
        'Government Service' => '06',
        'Enterprise Service' => '07',
        'Performance, Risk & QOS (PRQ)' => '08',
        'BGES & MBB Service Operation' => '09',
        'HOTD (Head of Telkom Daerah Gunung Kidul)' => '10',
        'HOTD (Head of Telkom Daerah Sleman)' => '11',
        'HOTD (Head of Telkom Daerah Bantul)' => '12',
        'Telkom Infrastruktur (TIF)' => '13',
    ];

    public function updating($field)
    {
        if (in_array($field, ['search', 'statusFilter', 'unitFilter', 'showFlagged', 'filter'])) {
            $this->resetPage();
        }
    }

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

    public function setFilter($filter)
    {
        $this->filter = $filter;
        $this->resetPage();
    }

    public function getPesertaQueryProperty()
    {
        return MagangApplication::with('user')
            ->whereNotIn('status', ['on_going', 'done'])
            ->when($this->search, function ($q) {
                $q->whereHas('user', function ($u) {
                    $u->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('nim_magang', 'like', '%' . $this->search . '%');
                });
            })
            ->when(
                $this->statusFilter,
                fn($q) =>
                $q->where('status', $this->statusFilter)
            )
            ->when(
                $this->unitFilter,
                fn($q) =>
                $q->where('unit_penempatan', $this->unitFilter)
            )
            ->when(
                $this->showFlagged,
                fn($q) =>
                $q->where('is_flagged', true)
            )
            ->when(
                $this->filter === 'waiting',
                fn($q) =>
                $q->where('status', 'waiting')
            )
            ->when(
                $this->filter === 'accepted',
                fn($q) =>
                $q->where('status', 'accepted')
            )
            ->when(
                $this->filter === 'rejected',
                fn($q) =>
                $q->where('status', 'rejected')
            )
            ->when(
                $this->filter === 'flagged',
                fn($q) =>
                $q->where('is_flagged', true)
            )
            ->when($this->statusFilter === 'accepted', function ($q) {
                $q->select('magang_applications.*', 'tanggal_mulai_usulan', 'tanggal_selesai_usulan');
            })
            ->when($this->sortBy === 'user.name', function ($q) {
                $q->join('users', 'magang_applications.user_id', '=', 'users.id')
                    ->orderBy('users.name', $this->sortDirection)
                    ->select('magang_applications.*');
            }, function ($q) {
                $q->orderBy($this->sortBy, $this->sortDirection);
            });
    }

    public function triggerSearch()
    {
        $this->resetPage();
    }

    public function confirmApprove($id)
    {
        $this->confirmData = [
            'show' => true,
            'title' => 'Terima Data?',
            'message' => 'Peserta akan dipindahkan ke status Accepted.',
            'confirmText' => 'Ya, Terima',
            'action' => 'approve',
            'id' => $id,
        ];
    }

    public function confirmReject($id)
    {
        $this->confirmData = [
            'show' => true,
            'title' => 'Tolak Data?',
            'message' => 'Peserta akan dipindahkan ke status Rejected.',
            'confirmText' => 'Ya, Tolak',
            'action' => 'reject',
            'id' => $id,
        ];
    }

    public function confirmCancelStatus($id)
    {
        $this->confirmData = [
            'show' => true,
            'title' => 'Batalkan Status?',
            'message' => 'Status peserta akan dikembalikan ke Waiting.',
            'confirmText' => 'Ya, Batalkan',
            'action' => 'cancelStatus',
            'id' => $id,
        ];
    }

    public function confirmExecute()
    {
        if (!$this->confirmData['id']) {
            $this->confirmData['show'] = false;
            return;
        }

        $id = $this->confirmData['id'];
        $action = $this->confirmData['action'];

        switch ($action) {
            case 'approve':
                $this->loadingApproveId = $id;
                $this->approve($id);
                $this->loadingApproveId = null;
                break;
            case 'reject':
                $this->loadingRejectId = $id; // ini perbaikan
                $this->reject($id);
                $this->loadingRejectId = null;
                break;
            case 'cancelStatus':
                $this->cancelStatus($id);
                break;
        }

        $this->confirmData['show'] = false;
    }

    protected function approve($id)
    {
        $magang = MagangApplication::find($id);
        if ($magang) {
            $magang->status = 'accepted';
            $magang->approved_by = auth()->id();
            $magang->approved_at = now();

            $nim = $this->generateNim($magang);
            $magang->user->nim_magang = $nim;
            $magang->user->save();
            $magang->save();

            Mail::to($magang->user->email)->send(new MagangAcceptedMail($magang));

            $this->showToast('Pengajuan disetujui dan notifikasi email telah dikirim!');
        }
    }
    protected function reject($id)
    {
        $magang = MagangApplication::find($id);
        if ($magang) {
            $magang->status = 'rejected';
            $magang->approved_by = auth()->id();
            $magang->approved_at = now();
            $magang->save();

            $user = $magang->user;
            if ($user) {
                $user->save();
                Mail::to($user->email)->send(new MagangRejectedMail($magang));
            }

            $this->showToast('Pengajuan ditolak dan email notifikasi terkirim!');
        }
    }

    protected function cancelStatus($id)
    {
        $application = MagangApplication::find($id);
        if ($application) {
            $application->status = 'waiting';
            $application->save();

            $user = $application->user;
            if ($user) {
                $user->nim_magang = null;
                $user->save();
            }

            $this->showToast('Status berhasil direset ke Waiting.');
            $this->resetPage();
        }
    }


    public function toggleFlag($id)
    {
        $peserta = MagangApplication::findOrFail($id);
        $peserta->is_flagged = !$peserta->is_flagged;
        $peserta->save();

        $msg = $peserta->is_flagged
            ? 'Peserta berhasil dimasukkan ke list flagged'
            : 'Peserta dihapus dari list flagged';

        $this->showToast($msg);
    }

    public function viewDocument($id)
    {
        $magang = MagangApplication::with('user.magangDocument')->find($id);
        if (!$magang || !$magang->user) {
            session()->flash('error', 'Peserta tidak ditemukan');
            return;
        }

        $doc = $magang->user->magangDocument;

        // Kalau dokumen tidak ada, buat object dummy dengan default file
        if (!$doc) {
            $doc = (object)[
                'cv_path' => 'default_cv.pdf',
                'surat_permohonan_path' => 'default_surat_magang.pdf',
                'proposal_path' => 'default_surat_magang.pdf',
                'foto_diri_path' => 'default_foto.jpg',
            ];
        }

        $this->selectedPeserta = $magang;
        $this->documentPaths = [
            'cv' => $doc->cv_path ? asset('storage/' . $doc->cv_path) : null,
            'surat_permohonan' => $doc->surat_permohonan_path ? asset('storage/' . $doc->surat_permohonan_path) : null,
            'proposal' => $doc->proposal_path ? asset('storage/' . $doc->proposal_path) : null,
            'foto_diri' => $doc->foto_diri_path ? asset('storage/' . $doc->foto_diri_path) : null,
        ];

        // --- START NOMOR WA ---
        $noHp = $magang->user->profile->no_hp ?? null;

        if ($noHp) {
            // Kalau nomor mulai dengan 0, ubah jadi 62
            if (substr($noHp, 0, 1) === '0') {
                $noHp = '62' . substr($noHp, 1);
            }
            // Hilangkan spasi atau karakter selain angka
            $noHp = preg_replace('/\D/', '', $noHp);
        }

        $this->waNumber = $noHp;

        $this->documentUrl = true;
    }

    public function closeDocument()
    {
        $this->documentUrl = null;
        $this->documentPaths = [];
        $this->selectedPeserta = null; // <-- reset selected peserta
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


    protected function generateNim(MagangApplication $magang)
    {
        $unitCode = $this->unitCodes[$magang->unit_penempatan] ?? '00';
        $year = date('y');

        // Cari NIM terakhir untuk unit & tahun ini
        $lastNim = \DB::table('users')
            ->where('nim_magang', 'like', $unitCode . $year . '%')
            ->max('nim_magang');

        // Ambil 4 digit terakhir, convert ke integer, lalu +1
        $nextNumber = $lastNim ? (intval(substr($lastNim, -4)) + 1) : 1;

        // Format NIM: unitCode + tahun + 4 digit urut
        return sprintf("%s%s%04d", $unitCode, $year, $nextNumber);
    }

    public function generateAllNim()
    {
        try {
            // Ambil semua user yang nim_magang-nya masih null dan punya magang application
            $usersWithoutNim = \App\Models\User::whereNull('nim_magang')
                ->whereHas('magangApplication', function ($q) {
                    $q->whereIn('status', ['accepted', 'on_going', 'done']);
                })
                ->with('magangApplication')
                ->get();

            $generated = 0;

            foreach ($usersWithoutNim as $user) {
                $magang = $user->magangApplication->first();
                if ($magang) {
                    // Gunakan method generateNim yang sama seperti saat approved
                    $nim = $this->generateNim($magang);
                    $user->nim_magang = $nim;
                    $user->save();
                    $generated++;
                }
            }

            $this->showToast("Berhasil generate {$generated} NIM untuk peserta yang belum memiliki NIM!");
        } catch (\Exception $e) {
            $this->showToast("Error: " . $e->getMessage());
        }
    }

    public function showToast($message)
    {
        $this->toastMessage = $message;
        $this->showToast = true;
    }

    public function updateTanggal($id, $field)
    {
        $magang = MagangApplication::find($id);
        if (!$magang) return;

        $newDate = $this->editDates[$id][$field] ?? null;
        if (!$newDate) return;

        try {
            $newDateCarbon = Carbon::parse($newDate);
        } catch (\Exception $e) {
            $this->showToast("Tanggal tidak valid!");
            return;
        }

        $tanggalMulai = isset($this->editDates[$id]['tanggal_mulai_usulan'])
            ? Carbon::parse($this->editDates[$id]['tanggal_mulai_usulan'])
            : null;
        $tanggalSelesai = isset($this->editDates[$id]['tanggal_selesai_usulan'])
            ? Carbon::parse($this->editDates[$id]['tanggal_selesai_usulan'])
            : null;

        // Validasi logika
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

        // Simpan ke database
        $magang->$field = $newDateCarbon->format('Y-m-d');
        $magang->save();

        $this->showToast("Tanggal berhasil diperbarui!");
    }

    public function render()
    {
        foreach ($this->pesertaQuery->get() as $p) {
            if ($p->status === 'accepted') {
                $this->editDates[$p->id] = [
                    'tanggal_mulai_usulan' => $p->tanggal_mulai_usulan?->format('Y-m-d'),
                    'tanggal_selesai_usulan' => $p->tanggal_selesai_usulan?->format('Y-m-d'),
                ];
            }
        }

        // Update status otomatis
        MagangApplication::where('status', 'accepted')
            ->whereDate('tanggal_mulai_usulan', '<=', now())
            ->whereDate('tanggal_selesai_usulan', '>=', now())
            ->update(['status' => 'on_going']);

        MagangApplication::whereIn('status', ['accepted', 'on_going'])
            ->whereDate('tanggal_selesai_usulan', '<', now())
            ->update(['status' => 'done']);

        return view('livewire.hc.data-peserta', [
            'peserta' => $this->pesertaQuery->paginate(10),
            'totalPeserta' => MagangApplication::count(),
            'waitingCount' => MagangApplication::where('status', 'waiting')->count(),
            'acceptedCount' => MagangApplication::where('status', 'accepted')->count(),
            'rejectedCount' => MagangApplication::where('status', 'rejected')->count(),
            'flaggedCount' => MagangApplication::where('is_flagged', true)->count(),
            'unitList' => Lowongan::select('nama_unit')->distinct()->pluck('nama_unit')
        ])->extends('components.layouts.hc.app')
            ->section('content');
    }
}
