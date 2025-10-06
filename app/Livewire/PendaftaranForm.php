<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Pendaftaran;
use App\Models\UserProfile;
use App\Models\MagangApplication;
use App\Models\MagangDocument;
use App\Models\Lowongan;
use Livewire\WithFileUploads;

class PendaftaranForm extends Component
{
    use WithFileUploads;

    public $step = 1;
    public $lowongans;
    public $selectedId = null;
    public $semester;
    public $alasan, $mulai, $selesai, $durasi;
    public $cv, $surat_permohonan, $proposal, $foto_diri;
    public $agreement = false;
    public $bersedia;

    public $cv_path, $surat_permohonan_path, $proposal_path, $foto_diri_path;

    protected $rules = [
        'mulai' => 'required|date',
        'selesai' => 'required|date|after:mulai',
        'durasi' => 'required|string',
        'alasan' => 'required|string',
        'cv' => 'required|file|mimes:pdf|max:2048',
        'surat_permohonan' => 'required|file|mimes:pdf|max:2048',
        'proposal' => 'nullable|file|mimes:pdf|max:2048',
        'foto_diri' => 'required|image|max:2048',
    ];

    public function mount()
    {
        $this->lowongans = Lowongan::all();

        // Ambil data dari session biar nggak hilang pas refresh
        $this->step = session('step', 1);
        $this->cv_path = session('cv_path');
        $this->surat_permohonan_path = session('surat_permohonan_path');
        $this->proposal_path = session('proposal_path');
        $this->foto_diri_path = session('foto_diri_path');
        $this->selectedId = session('selectedId');
        $this->semester = session('semester');
        $this->alasan = session('alasan');
        $this->mulai = session('mulai');
        $this->selesai = session('selesai');
        $this->durasi = session('durasi');
        $this->bersedia = session('bersedia');
        $this->agreement = session('agreement', false);
    }

    public function updated($propertyName)
    {
        // Jangan simpan file upload ke session, hanya data biasa
        if (!in_array($propertyName, ['cv', 'surat_permohonan', 'proposal', 'foto_diri'])) {
            session([$propertyName => $this->$propertyName]);
        }
    }

    public function selectLowongan($id)
    {
        $this->selectedId = $id;
        session(['selectedId' => $this->selectedId]);
    }

    public function goToStep($step)
    {
        $this->step = $step;
        session(['step' => $this->step]);
    }

    public function previousStep()
    {
        if ($this->step > 1) {
            $this->step--;
            session(['step' => $this->step]);
        }
    }

    public function nextStep()
    {

        if ($this->step === 1) {
            $this->validate([
                'agreement' => 'accepted'
            ], [
                'agreement.accepted' => 'Anda harus menyetujui ketentuan terlebih dahulu.'
            ]);
        }

        if ($this->step === 2) {
            if (!$this->selectedId) {
                $this->addError('selectedId', 'Anda harus memilih lowongan terlebih dahulu.');
                return;
            }
        }

        if ($this->step === 3) {
            $this->saveStepThree();
            
        }

        if ($this->step === 4) {
            $this->validate([
                'bersedia' => 'required|in:ya,tidak',
            ]);

            if (!$this->agreement) {
                $this->addError('agreement', 'Anda harus menyetujui syarat dan ketentuan.');
                return;
            }
        }

        if ($this->step < 5) {
            $this->step++;
            session(['step' => $this->step]);
        }
    }

    public function updatedCv()
    {
        $this->validate([
            'cv' => 'required|file|mimes:pdf|max:2048',
        ]);

        $this->cv_path = $this->cv->store('documents/tmp', 'public');
        session(['cv_path' => $this->cv_path]);
    }

    public function updatedSuratPermohonan()
    {
        $this->validate([
            'surat_permohonan' => 'required|file|mimes:pdf|max:2048',
        ]);
        $this->surat_permohonan_path = $this->surat_permohonan->store('documents/tmp', 'public');
        session(['surat_permohonan_path' => $this->surat_permohonan_path]);
    }

    public function updatedProposal()
    {
        $this->validate([
            'proposal' => 'nullable|file|mimes:pdf|max:2048',
        ]);
        $this->proposal_path = $this->proposal->store('documents/tmp', 'public');
        session(['proposal_path' => $this->proposal_path]);
    }

    public function updatedFotoDiri()
    {
        $this->validate([
            'foto_diri' => 'required|image|max:2048',
        ]);
        $this->foto_diri_path = $this->foto_diri->store('documents/tmp', 'public');
        session(['foto_diri_path' => $this->foto_diri_path]);
    }

    public function saveStepThree()
    {
        $this->validate([
            'mulai' => 'required|date',
            'selesai' => 'required|date|after:mulai',
            'durasi' => 'required|string',
            'semester' => 'required|string|max:10',
            'alasan' => 'required|string',
            // validasi file upload atau path lama
            'cv' => $this->cv || $this->cv_path ? 'sometimes|file|mimes:pdf|max:2048' : 'required',
            'surat_permohonan' => $this->surat_permohonan || $this->surat_permohonan_path ? 'sometimes|file|mimes:pdf|max:2048' : 'required',
            'proposal' => $this->proposal || $this->proposal_path ? 'nullable|file|mimes:pdf|max:2048' : 'nullable',
            'foto_diri' => $this->foto_diri || $this->foto_diri_path ? 'sometimes|image|max:2048' : 'required',
        ]);
    }

    public function submitPendaftaran()
    {
        $this->validate([
            'mulai' => 'required|date',
            'selesai' => 'required|date|after:mulai',
            'durasi' => 'required|string',
            'semester' => 'required|string|max:10',
            'alasan' => 'required|string',
            'cv' => 'required|file|mimes:pdf|max:2048',
            'surat_permohonan' => 'required|file|mimes:pdf|max:2048',
            'proposal' => 'nullable|file|mimes:pdf|max:2048',
            'foto_diri' => 'required|image|max:2048',
            'bersedia' => 'required|in:ya,tidak',
            'agreement' => 'required|accepted',
        ]);

        try {
            \DB::beginTransaction();

            $user = Auth::user();
            $lowongan = Lowongan::findOrFail($this->selectedId);

            $cvPath = $this->cv ? $this->cv->store('documents/cv', 'public') : $this->cv_path;
            $suratPath = $this->surat_permohonan ? $this->surat_permohonan->store('documents/surat_permohonan', 'public') : $this->surat_permohonan_path;
            $fotoPath = $this->foto_diri ? $this->foto_diri->store('documents/foto_diri', 'public') : $this->foto_diri_path;
            $proposalPath = $this->proposal ? $this->proposal->store('documents/proposal', 'public') : $this->proposal_path;

            if ($user->profile) {
                $user->profile->update([
                    'semester' => $this->semester,
                ]);
            }

            $application = MagangApplication::create([
                'user_id' => $user->id,
                'tanggal_mulai_usulan' => $this->mulai,
                'tanggal_selesai_usulan' => $this->selesai,
                'unit_penempatan' => $lowongan->nama_unit,
                'durasi_magang' => $this->durasi . ' bulan',
                'alasan_pilih_telkom' => $this->alasan,
                'bersedia' => $this->bersedia,
            ]);

            MagangDocument::create([
                'user_id' => $user->id,
                'application_id' => $application->id,
                'cv_path' => $cvPath,
                'surat_permohonan_path' => $suratPath,
                'proposal_path' => $proposalPath,
                'foto_diri_path' => $fotoPath,
            ]);

            \DB::commit();

            // 🔹 Hapus session biar data lama tidak terbawa
            session()->forget([
                'step',
                'selectedId',
                'semester',
                'alasan',
                'mulai',
                'selesai',
                'durasi',
                'bersedia',
                'agreement',
                'cv_path',
                'surat_permohonan_path',
                'proposal_path',
                'foto_diri_path',
            ]);

            session()->flash('success', 'Pendaftaran berhasil dikirim.');
            return redirect()->to('/dashboard');
        } catch (\Throwable $e) {
            \DB::rollBack();
            report($e);
            session()->flash('error', 'Terjadi kesalahan saat mengirim pendaftaran. Silakan coba lagi.');
        }
    }

    public function render()
    {
        return view('livewire.user.pendaftaran-form')
            ->layout('components.layouts.guest');
    }
}
