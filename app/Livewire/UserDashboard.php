<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\UserProfile;
use App\Models\MagangApplication;
use App\Models\MagangDocument;
use Livewire\WithFileUploads;

class UserDashboard extends Component
{
    use WithFileUploads;
    
    public $user;
    public $user_profile;
    public $magangAktif;
    public $magang;
    public $riwayats;
    public $showForm = false;
    public $showDetailModal = false;
    public $detailMagang = null;
    public $filter = 'waiting';
    public $editingDocument = null;
    public $newDocument;

    public function mount()
    {
        $this->magang = $this->magangAktif;

        $this->user = Auth::user();

        // Ambil profil user
        $this->user_profile = $this->user->userProfile;

        // Ambil semua pengajuan magang (riwayat)
        $this->riwayats = $this->user->magangApplication()->latest()->get();

        // Ambil yang terakhir sebagai aktif
        $this->magangAktif = $this->riwayats->first();

        // Cek apakah harus tampilkan form
        if (request()->has('form') && request()->get('form') === 'show') {
            $this->showForm = true;
        }
    }

    public function ajukanUlang()
    {
        return redirect()->route('pendaftaran');
    }


    public function render()
    {
        return view('livewire.user.user-dashboard', [
            'user' => $this->user,
            'user_profile' => $this->user_profile,
            'magangAktif' => $this->magangAktif,
            'riwayats' => $this->riwayats,
            'showForm' => $this->showForm,
        ]);
    }

    public function showDetail($id)
    {
        $this->detailMagang = $this->riwayats->where('id', $id)->first();
        $this->showDetailModal = true;
    }

    public function closeModal()
    {
        $this->showDetailModal = false;
        $this->detailMagang = null;
    }

    public function updateDocument()
    {
        $this->validate([
            'newDocument' => 'required|mimes:pdf,jpg,png|max:2048',
        ]);

        $path = $this->newDocument->store('documents', 'public');

        // Ambil dokumen berdasarkan application_id
        $doc = $this->detailMagang->document; 

        if (!$doc) {
            // Kalau belum ada, buat baru untuk application ini
            $doc = $this->detailMagang->document()->create([
                'application_id' => $this->detailMagang->id
            ]);
        }

        // Update path dokumen sesuai jenisnya
        if ($this->editingDocument === 'cv') {
            $doc->cv_path = $path;
        } elseif ($this->editingDocument === 'proposal') {
            $doc->proposal_path = $path;
        } elseif ($this->editingDocument === 'surat_permohonan') {
            $doc->surat_permohonan_path = $path;
        } elseif ($this->editingDocument === 'foto_diri') {
            $doc->foto_diri_path = $path;
        }

        $doc->save();

        $this->reset(['newDocument', 'editingDocument']);
        $this->detailMagang->refresh();
        session()->flash('message', 'Dokumen berhasil diperbarui.');
    }
}
