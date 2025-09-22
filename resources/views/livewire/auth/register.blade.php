<?php

use App\Models\Instansi;
use App\Models\Jurusan;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;

return new #[Layout('components.layouts.guest')] class extends Component
{
    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|email|unique:users,email')]
    public string $email = '';

    #[Validate('required|min:6')]
    public string $password = '';

    #[Validate('required|same:password')]
    public string $passwordConfirmation = '';

    #[Validate('required|string|max:255')]
    public $instansi;

    #[Validate('required|string|max:255')]
    public $jurusan;

    #[Validate('required|date')]
    public string $tgl_lahir = '';

    #[Validate('required|string|max:20')]
    public string $no_hp = '';

    #[Validate('required|string|max:100')]
    public string $domisili = '';

    #[Validate('required|in:SMK,Diploma,Sarjana')]
    public ?string $jenjang_pendidikan = null;

    #[Validate('nullable|integer|min:1900|max:2100')]
    public ?int $thn_masuk = null;

    public $instansis = [];

    public $jurusans = [];

    public function mount()
    {
        $this->instansis = Instansi::all();
        $this->jurusans = Jurusan::all();
    }

    #[Action]
    public function register()
    {

        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        UserProfile::create([
            'user_id' => $user->id,
            'tgl_lahir' => $this->tgl_lahir,
            'no_hp' => $this->no_hp,
            'domisili' => $this->domisili,
            'jenjang_pendidikan' => $this->jenjang_pendidikan,
            'thn_masuk' => $this->thn_masuk,
            'instansi' => $this->instansi, // langsung simpan sebagai string
            'jurusan' => $this->jurusan,   // langsung simpan sebagai string
        ]);

        return redirect()->intended('/login');

    }

};
?>

@if (session()->has('success'))
    <div class="fixed top-5 left-1/2 transform -translate-x-1/2 z-50">
        <div class="bg-green-500 text-white px-6 py-3 rounded shadow">
            {{ session('success') }}
        </div>
    </div>
@endif

<div class="min-h-screen flex flex-col md:flex-row bg-white text-gray-800">

    {{-- Konten Utama --}}
    <div class="flex flex-1 md:flex-row items-center justify-center px-6 md:px-32 gap-28 my-10">

        {{-- Kiri: Gambar & Teks --}}
        <div class="hidden md:flex flex-col items-start justify-center flex-1 px-12">
            <img src="{{ asset('images/loginpage.png') }}" alt="Login Illustration" class="w-full max-w-lg mb-8">
            <h2 class="text-xl md:text-3xl font-semibold leading-snug text-pretty">
                Langkah Kecil, Dampak Besar untuk Masa Depan
            </h2>
        </div>

        <div class="flex-1 flex items-center justify-center px-6 py-10">
             <div class="w-full max-w-xl bg-white border border-gray-200 rounded-xl shadow-md p-6 md:p-10 space-y-6 md:space-y-8">
                <form wire:submit.prevent="register" class="space-y-5 md:space-y-6">

                    {{-- Nama --}}
                    <div>
                        <label class="block text-sm md:text-base font-medium">Nama Lengkap</label>
                        <input type="text" wire:model.defer="name"
                            class="mt-2 w-full px-4 py-2 md:py-3 border border-gray-300 rounded-md shadow-sm text-sm md:text-base"
                            placeholder="Nama sesuai KTP">
                        @error('name') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- No HP --}}
                    <div>
                        <label class="block text-sm md:text-base font-medium">No HP</label>
                        <div class="flex mt-2">
                            <span class="inline-flex items-center px-3 border border-gray-300 bg-gray-50 text-gray-600 text-sm md:text-base rounded-l-md">
                                +62
                            </span>
                            <input type="text" wire:model.defer="no_hp"
                                class="w-full px-4 py-2 border border-gray-300 rounded-r-md shadow-sm text-sm md:text-base focus:ring focus:ring-blue-200 focus:border-blue-400"
                                placeholder="Contoh: 81234567890">
                        </div>
                        @error('no_hp') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Tanggal Lahir --}}
                    <div>
                        <label class="block text-sm md:text-base font-medium">Tanggal Lahir</label>
                        <input type="date" wire:model.defer="tgl_lahir"
                            class="mt-2 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm md:text-base">
                        @error('tgl_lahir') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Domisili --}}
                    <div>
                        <label class="block text-sm md:text-base font-medium">Domisili</label>
                        <input type="text" wire:model.defer="domisili"
                            class="mt-2 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm md:text-base"
                            placeholder="Contoh: Bandung">
                        @error('domisili') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Jenjang Pendidikan --}}
                    <div>
                        <label class="block text-sm md:text-base font-medium">Jenjang Pendidikan</label>
                        <select wire:model="jenjang_pendidikan" id="jenjang_pendidikan"
                        class="mt-2 w-full px-4 py-2 md:py-3 border border-gray-300 rounded-md shadow-sm text-sm md:text-base">
                            <option value="">-- Pilih Jenjang --</option>
                            <option value="SMK">SMK</option>
                            <option value="Diploma">Diploma</option>
                            <option value="Sarjana">Sarjana</option>
                        </select>
                        @error('jenjang_pendidikan') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    {{-- Instansi --}}
                    <div>
                        <label class="block text-sm md:text-base font-medium">Instansi</label>
                        <input type="text" wire:model.defer="instansi"
                            class="mt-2 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm md:text-base"
                            placeholder="Contoh: Universitas Gadjah Mada">
                        @error('instansi') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Jurusan --}}
                    <div>
                        <label class="block text-sm md:text-base font-medium">Jurusan</label>
                        <input type="text" wire:model.defer="jurusan"
                            class="mt-2 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm md:text-base"
                            placeholder="Contoh: Informatika">
                        @error('jurusan') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Tahun Masuk --}}
                    <div>
                        <label class="block text-sm md:text-base font-medium">Tahun Masuk</label>
                        <input type="number" wire:model.defer="thn_masuk"
                            class="mt-2 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm md:text-base"
                            placeholder="Contoh: 2022 ">
                        @error('thn_masuk') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-sm md:text-base font-medium">Email</label>
                        <input type="email" wire:model.defer="email"
                            class="mt-2 w-full px-4 py-2 md:py-3 border border-gray-300 rounded-md shadow-sm text-sm md:text-base"
                            placeholder="email@example.com">
                        @error('email') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label class="block text-sm md:text-base font-medium">Password</label>
                        <input type="password" wire:model.defer="password"
                            class="mt-2 w-full px-4 py-2 md:py-3 border border-gray-300 rounded-md shadow-sm text-sm md:text-base"
                            placeholder="Min. 8 karakter">
                        @error('password') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Konfirmasi --}}
                    <div>
                        <label class="block text-sm md:text-base font-medium">Konfirmasi Password</label>
                        <input type="password" wire:model.defer="passwordConfirmation"
                            class="mt-2 w-full px-4 py-2 md:py-3 border border-gray-300 rounded-md shadow-sm text-sm md:text-base"
                            placeholder="Ulangi password">
                        @error('passwordConfirmation') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Checkbox --}}
                    <div class="flex items-start gap-2 mt-4">
                        <input type="checkbox" class="mt-1" required>
                        <label class="text-sm text-gray-600">Saya menyatakan bahwa data yang saya berikan benar.</label>
                    </div>

                    {{-- Tombol --}}
                    <button type="submit"
                        class="w-full py-2 md:py-3 px-4 md:px-5 bg-gradient-to-r from-[#C1002A] to-[#0066B1] text-white rounded-md text-sm md:text-base font-semibold hover:opacity-90 transition">
                        Daftar Sekarang
                    </button>

                    {{-- Link login --}}
                    <div class="text-center text-xs md:text-sm mt-2">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="text-blue-600 font-medium hover:underline">Masuk di sini</a>
                    </div>
                </form>
            </div>
        </div>
        
</div>