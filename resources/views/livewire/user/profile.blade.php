<div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold mb-10 text-gray-800 flex items-center gap-2">
        Informasi Profil
    </h1>

    {{-- Notifikasi sukses --}}
    @if (session()->has('success'))
        <div class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200 text-green-700 shadow-sm flex items-center gap-2">
            <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="save" class="space-y-10">

        {{-- Foto Profil --}}
        <div class="bg-gradient-to-br from-white to-gray-50 shadow-lg rounded-2xl p-6 flex flex-col items-center space-y-4 border border-gray-200 hover:shadow-xl transition">
            <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-blue-100 shadow-md">
                @if($foto_diri && !is_string($foto_diri))
                    <img src="{{ $foto_diri->temporaryUrl() }}" alt="Preview" class="w-full h-full object-cover">
                @elseif($foto_diri)
                    <img src="{{ asset('storage/'.$foto_diri) }}" alt="Foto Profil" class="w-full h-full object-cover">
                @else
                    <img src="{{ asset('images/default-profile.png') }}" alt="Default" class="w-full h-full object-cover">
                @endif
            </div>
            <label class="cursor-pointer bg-blue-600 text-white px-5 py-2 rounded-lg shadow-md hover:bg-blue-700 hover:scale-105 transition">
                Ganti Foto
                <input type="file" wire:model="foto_diri" class="hidden">
            </label>
            @error('foto_diri') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Info dasar --}}
        <div class="bg-gradient-to-br from-white to-gray-50 shadow-lg rounded-2xl p-6 space-y-6 border border-gray-200">
            <h2 class="text-lg font-semibold text-gray-700 flex items-center gap-2 border-b pb-3">
                Informasi Akun
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Nama Lengkap</label>
                    <input type="text" wire:model.defer="name" 
                           class="block w-full rounded-xl border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 sm:text-sm transition">
                    @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Email</label>
                    <input type="email" wire:model.defer="email" 
                           class="block w-full rounded-xl border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 sm:text-sm transition">
                    @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        {{-- Detail Profil --}}
        <div class="bg-gradient-to-br from-white to-gray-50 shadow-lg rounded-2xl p-6 space-y-6 border border-gray-200">
            <h2 class="text-lg font-semibold text-gray-700 flex items-center gap-2 border-b pb-3">
                Detail Profil
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                    <input type="date" wire:model.defer="tgl_lahir" 
                           class="mt-1 block w-full rounded-xl border border-gray-300 shadow-sm px-3 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm transition">
                    @error('tgl_lahir') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Dropdown Jenis Kelamin --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                    <div class="relative">
                        <select wire:model.defer="jenis_kelamin"
                            class="mt-1 block w-full rounded-xl border border-gray-300 shadow-sm px-3 py-2 pr-8 focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm transition appearance-none bg-white">
                            <option value="">-- Pilih --</option>
                            <option value="Pria">Pria</option>
                            <option value="Wanita">Wanita</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-2 flex items-center pr-2 text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                    @error('jenis_kelamin') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No. HP</label>
                    <input type="text" wire:model.defer="no_hp" 
                           class="mt-1 block w-full rounded-xl border border-gray-300 shadow-sm px-3 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm transition">
                    @error('no_hp') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Domisili</label>
                    <input type="text" wire:model.defer="domisili" 
                           class="mt-1 block w-full rounded-xl border border-gray-300 shadow-sm px-3 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm transition">
                    @error('domisili') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Dropdown Jenjang Pendidikan --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenjang Pendidikan</label>
                    <div class="relative">
                        <select wire:model.defer="jenjang_pendidikan"
                                class="mt-1 block w-full rounded-xl border border-gray-300 shadow-sm px-3 py-2 pr-8 focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm transition appearance-none">
                            <option value="">-- Pilih --</option>
                            <option value="SMK">SMK</option>
                            <option value="Diploma">Diploma</option>
                            <option value="Sarjana">Sarjana</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-2 flex items-center pr-2 text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                    @error('jenjang_pendidikan') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Instansi</label>
                    <input type="text" wire:model.defer="instansi" 
                           class="mt-1 block w-full rounded-xl border border-gray-300 shadow-sm px-3 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm transition">
                    @error('instansi') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jurusan</label>
                    <input type="text" wire:model.defer="jurusan" 
                           class="mt-1 block w-full rounded-xl border border-gray-300 shadow-sm px-3 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm transition">
                    @error('jurusan') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Masuk</label>
                    <input type="number" wire:model.defer="thn_masuk" placeholder="2020"
                           class="mt-1 block w-full rounded-xl border border-gray-300 shadow-sm px-3 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm transition">
                    @error('thn_masuk') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Semester</label>
                    <input type="text" wire:model.defer="semester" 
                           class="mt-1 block w-full rounded-xl border border-gray-300 shadow-sm px-3 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm transition">
                    @error('semester') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        {{-- Tombol Simpan --}}
        <div class="flex justify-end">
            <button type="submit" class="px-6 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl shadow-md hover:shadow-xl hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-300 transition">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
