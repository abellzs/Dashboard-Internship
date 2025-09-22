<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Models\UserProfile;
use App\Models\MagangDocument;

class Profile extends Component
{
    use WithFileUploads;

    public $name, $email, $tgl_lahir, $jenis_kelamin, $no_hp, $domisili, $jenjang_pendidikan, 
           $instansi, $jurusan, $thn_masuk, $semester, $foto_diri;

    public function mount()
    {
        $user = Auth::user();
        $profile = $user->profile;
        $magang = $user->magangDocument;

        $this->name = $user->name;
        $this->email = $user->email;

        $this->tgl_lahir = optional($profile)->tgl_lahir;
        $this->jenis_kelamin = optional($profile)->jenis_kelamin;
        $this->no_hp = optional($profile)->no_hp;
        $this->domisili = optional($profile)->domisili;
        $this->jenjang_pendidikan = optional($profile)->jenjang_pendidikan;
        $this->instansi = optional($profile)->instansi;
        $this->jurusan = optional($profile)->jurusan;
        $this->thn_masuk = optional($profile)->thn_masuk;
        $this->semester = optional($profile)->semester;

        // Foto diri dari magang_documents
        $this->foto_diri = optional($magang)->foto_diri_path;
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'tgl_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Pria,Wanita',
            'no_hp' => 'required|string|max:20',
            'domisili' => 'required|string|max:255',
            'jenjang_pendidikan' => 'required|in:SMK,Diploma,Sarjana',
            'instansi' => 'nullable|string|max:255',
            'jurusan' => 'nullable|string|max:255',
            'thn_masuk' => 'nullable|digits:4|integer|min:1900|max:' . date('Y'),
            'semester' => 'nullable|string|max:10',
        ];
    }

    protected function rulesFoto()
    {
        return [
            'foto_diri' => 'nullable|image|max:2048', // Hanya untuk upload baru
        ];
    }

    public function save()
    {
        $this->validate(); // validasi field biasa

        $user = Auth::user();
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        UserProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'tgl_lahir' => $this->tgl_lahir,
                'jenis_kelamin' => $this->jenis_kelamin,
                'no_hp' => $this->no_hp,
                'domisili' => $this->domisili,
                'jenjang_pendidikan' => $this->jenjang_pendidikan,
                'instansi' => $this->instansi,
                'jurusan' => $this->jurusan,
                'thn_masuk' => $this->thn_masuk,
                'semester' => $this->semester,
            ]
        );

        // Hanya validasi foto jika user upload baru
        if ($this->foto_diri && !is_string($this->foto_diri)) {
            $this->validate($this->rulesFoto());

            $path = $this->foto_diri->store('foto_diri', 'public');

            MagangDocument::updateOrCreate(
                ['user_id' => $user->id],
                ['foto_diri_path' => $path]
            );
        }

        session()->flash('success', 'Profil berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.user.profile');
    }
}
