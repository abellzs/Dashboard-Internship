<!-- filepath: resources/views/livewire/hc/data-sertifikat.blade.php -->
<div>
    <div class="bg-white rounded-lg shadow-md overflow-hidden animate-fade-in duration-300 py-3 px-6">

        {{-- Filter + Search --}}
        <div class="flex flex-wrap justify-between items-center gap-4 py-2">
            {{-- Status Filter --}}
            <div class="flex flex-wrap gap-3 items-center">
                @php
                    $filters = [
                        'all' => ['label' => 'All', 'color' => 'gray', 'icon' => 'fas fa-list'],
                        'accepted' => ['label' => 'Accepted', 'color' => 'blue', 'icon' => 'fas fa-check'],
                        'on_going' => ['label' => 'On Going', 'color' => 'yellow', 'icon' => 'fas fa-play-circle'],
                        'done' => ['label' => 'Done', 'color' => 'green', 'icon' => 'fas fa-check-circle'],
                        'prepared_graduation' => [
                            'label' => 'Prepared Graduation',
                            'color' => 'red',
                            'icon' => 'fas fa-graduation-cap',
                        ],
                    ];
                @endphp
                @foreach ($filters as $key => $f)
                    <button wire:click="setFilter('{{ $key }}')" wire:loading.attr="disabled" type="button"
                        class="inline-flex items-center px-4 py-2 rounded-full border transition-all duration-200
                            {{ $filter === $key
                                ? 'bg-' . $f['color'] . '-600 text-white border-' . $f['color'] . '-600 shadow-md scale-105'
                                : 'bg-white text-gray-700 border-gray-300 hover:bg-' . $f['color'] . '-50 hover:border-' . $f['color'] . '-400' }}">
                        <i class="{{ $f['icon'] }} mr-2 text-sm"></i>
                        <span class="font-medium flex items-center">
                            @if ($filter === $key)
                                <span wire:loading wire:target="setFilter" class="spinner-elegant mr-2"></span>
                            @endif
                            {{ $f['label'] }}
                        </span>
                    </button>
                @endforeach
            </div>

            {{-- Search --}}
            <div class="relative flex items-center gap-4 flex-wrap">
                <div class="relative">
                    <span class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-gray-400">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" wire:model.live="search" placeholder="Cari Nama / NIM"
                        class="pl-10 pr-4 py-2 border border-gray-300 rounded-full text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition" />
                </div>
            </div>
        </div>

        {{-- Tabel --}}
        <div class="bg-white rounded-lg overflow-x-auto border my-5 relative">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">NIM</th>
                        <th wire:click="sort('user.name')"
                            class="cursor-pointer px-6 py-6 text-left text-sm font-semibold text-gray-700 flex items-center space-x-1 select-none">
                            <span>Nama</span>
                            @if ($sortBy === 'user.name')
                                @if ($sortDirection === 'asc')
                                    <i class="fas fa-caret-up text-gray-600"></i>
                                @else
                                    <i class="fas fa-caret-down text-gray-600"></i>
                                @endif
                            @else
                                <i class="fas fa-sort text-gray-400"></i>
                            @endif
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Unit Penempatan</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                        <th wire:click="sort('tanggal_mulai_usulan')"
                            class="cursor-pointer px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wide select-none min-w-[140px]">
                            <div class="flex items-center space-x-1">
                                <span>Tgl Mulai</span>
                                @if ($sortBy === 'tanggal_mulai_usulan')
                                    @if ($sortDirection === 'asc')
                                        <i class="fas fa-caret-up text-gray-600"></i>
                                    @else
                                        <i class="fas fa-caret-down text-gray-600"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort text-gray-400"></i>
                                @endif
                            </div>
                        </th>
                        <th wire:click="sort('tanggal_selesai_usulan')"
                            class="cursor-pointer px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wide select-none min-w-[140px]">
                            <div class="flex items-center space-x-1">
                                <span>Tgl Selesai</span>
                                @if ($sortBy === 'tanggal_selesai_usulan')
                                    @if ($sortDirection === 'asc')
                                        <i class="fas fa-caret-up text-gray-600"></i>
                                    @else
                                        <i class="fas fa-caret-down text-gray-600"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort text-gray-400"></i>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Nomor Dinas Masuk</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Nomor Dinas Keluar</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($magang as $row)
                        <tr class="hover:bg-gray-100 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $row->user->nim_magang ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $row->user->name ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $row->unit_penempatan }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @php
                                    $statusColors = [
                                        'Belum Terbit' => 'bg-purple-100 text-purple-800',
                                        'Sudah Terbit' => 'bg-green-200 text-green-800',
                                    ];
                                    $status = $this->getCertificateStatus($row->id);
                                @endphp
                                <span
                                    class="inline-flex px-2 py-1 rounded-full text-xs font-semibold {{ $statusColors[$status] ?? 'bg-gray-200 text-gray-700' }}">
                                    {{ $status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $row->tanggal_mulai_usulan ? \Carbon\Carbon::parse($row->tanggal_mulai_usulan)->translatedFormat('d M Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $row->tanggal_selesai_usulan ? \Carbon\Carbon::parse($row->tanggal_selesai_usulan)->translatedFormat('d M Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $this->getCertificateNumber($row->id)['nomor_dinas_masuk'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $this->getCertificateNumber($row->id)['nomor_dinas_keluar'] }}
                            </td>
                            <td class="px-6 py-4 flex justify-center space-x-2">
                                <a wire:click="editNomorSertifikat({{ $row->id }})"
                                    class="bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-1 rounded-full transition transform hover:scale-110 cursor-pointer"
                                    title="Edit Nomor Sertifikat">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a wire:click="downloadSertifikat({{ $row->id }})"
                                    class="{{ $this->getCertificateStatus($row->id) === 'Belum Terbit' ? 'bg-gray-400 cursor-not-allowed pointer-events-none' : 'bg-green-600 hover:bg-green-700' }} text-white px-3 py-1 rounded-full transition transform hover:scale-110"
                                    title="Download Sertifikat" target="_blank">
                                    <i class="fas fa-download"></i>
                                </a>
                                <a wire:click="openSenderModal({{ $row->id }}, 'masuk')"
                                    class="{{ $this->getCertificateNumber($row->id)['nomor_dinas_masuk'] == "-" ? 'bg-gray-400 cursor-not-allowed pointer-events-none' : 'bg-blue-600 hover:bg-blue-700' }} text-white px-3 py-1 rounded-full transition transform hover:scale-110 cursor-pointer"
                                    title="Isi Nama Pengirim dan Cetak Nota Dinas Masuk">
                                    <i class="fas fa-file-import"></i>
                                </a>
                                <a wire:click="openSenderModal({{ $row->id }}, 'keluar')"
                                    class="{{ $this->getCertificateNumber($row->id)['nomor_dinas_keluar'] == "-" ? 'bg-gray-400 cursor-not-allowed pointer-events-none' : 'bg-blue-600 hover:bg-blue-700' }} text-white px-3 py-1 rounded-full transition transform hover:scale-110 cursor-pointer"
                                    title="Isi Nama Pengirim dan Cetak Nota Dinas Keluar">
                                    <i class="fas fa-file-export"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-gray-400 py-6">Tidak ada data ditemukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Loading overlay --}}
            <div wire:loading.flex wire:target="search,setFilter"
                class="absolute inset-0 bg-white bg-opacity-70 flex items-center justify-center rounded-lg"
                style="z-index:10;">
                <svg class="animate-spin h-8 w-8 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="p-3">
            {{ $magang->links() }}
        </div>
    </div>
    @if ($showEditModal)
        <div x-data="{ show: @entangle('showEditModal') }" x-show="show" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90" @keydown.escape.window="$wire.set('showEditModal', false)"
            class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50">
            <div
                class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-md mx-4 relative max-h-[90vh] overflow-y-auto animate-fade-in">

                <!-- Tombol Close -->
                <button wire:click="$set('showEditModal', false)"
                    class="absolute top-4 right-4 text-gray-600 hover:text-red-600 text-2xl font-bold transition-transform duration-200 hover:scale-125"
                    title="Tutup Modal">&times;</button>

                <!-- Header -->
                <h2 class="text-2xl font-extrabold mb-2 text-center text-red-700">Edit Nomor Dinas</h2>
                <p class="text-sm text-center text-gray-600 mb-6">
                    Buat, ubah, atau hapus nomor dinas masuk dan keluar peserta magang
                </p>

                <!-- Status sukses -->
                @if (session()->has('message'))
                    <div
                        class="mb-4 px-4 py-3 bg-green-100 border border-green-400 text-green-800 rounded-lg flex items-center gap-2">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('message') }}</span>
                    </div>
                @endif

                <!-- Status error -->
                @if ($errors->any())
                    <div class="mb-4 px-4 py-3 bg-red-100 border border-red-400 text-red-800 rounded-lg">
                        <div class="flex items-start gap-2">
                            <i class="fas fa-exclamation-circle mt-1"></i>
                            <ul class="list-disc pl-4 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form wire:submit.prevent="saveNomorDinas">
                    <!-- Nomor Dinas Masuk -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold mb-2 text-gray-700">
                            <i class="fas fa-sign-in-alt text-red-700 mr-1"></i>
                            Nomor Dinas Masuk
                        </label>
                        <div class="flex gap-2">
                            <input type="text" wire:model.defer="nomor_dinas_masuk"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm text-sm focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent transition"
                                placeholder="Masukkan nomor dinas masuk" />
                            <button type="button" wire:click="deleteNomorDinasMasuk"
                                class="px-3 py-2 rounded-lg bg-red-100 hover:bg-red-200 text-red-700 font-semibold transition duration-300 ease-in-out transform hover:scale-105 flex items-center gap-1"
                                title="Hapus Nomor Dinas Masuk">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Nomor Dinas Keluar -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold mb-2 text-gray-700">
                            <i class="fas fa-sign-out-alt text-red-700 mr-1"></i>
                            Nomor Dinas Keluar
                        </label>
                        <div class="flex gap-2">
                            <input type="text" wire:model.defer="nomor_dinas_keluar"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm text-sm focus:outline-none focus:ring-2 focus:ring-green-700 focus:border-transparent transition"
                                placeholder="Masukkan nomor dinas keluar" />
                            <button type="button" wire:click="deleteNomorDinasKeluar"
                                class="px-3 py-2 rounded-lg bg-red-100 hover:bg-red-200 text-red-700 font-semibold transition duration-300 ease-in-out transform hover:scale-105 flex items-center gap-1"
                                title="Hapus Nomor Dinas Keluar">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-200">
                        <button type="button" wire:click="$set('showEditModal', false)"
                            class="px-6 py-2 rounded-lg bg-gray-300 hover:bg-gray-400 text-gray-700 font-semibold transition duration-300 ease-in-out transform hover:scale-105">
                            <i class="fas fa-times mr-1"></i>
                            Batal
                        </button>
                        <button type="submit"
                            class="bg-green-700 hover:bg-green-800 text-white px-6 py-2 rounded-lg font-semibold transition duration-300 ease-in-out transform hover:scale-105 flex items-center gap-2">
                            <i class="fas fa-save"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
    @if ($showSenderModal)
        <div x-data="{ show: @entangle('showSenderModal') }" x-show="show" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90" @keydown.escape.window="$wire.set('showSenderModal', false)"
            class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50">
            <div
                class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-md mx-4 relative max-h-[90vh] overflow-y-auto animate-fade-in">

                <!-- Tombol Close -->
                <button wire:click="$set('showSenderModal', false)"
                    class="absolute top-4 right-4 text-gray-600 hover:text-red-600 text-2xl font-bold transition-transform duration-200 hover:scale-125"
                    title="Tutup Modal">&times;</button>

                <!-- Header -->
                <h2 class="text-2xl font-extrabold mb-2 text-center text-red-700">Isi Nama Pengirim</h2>
                <p class="text-sm text-center text-gray-600 mb-6">
                    Masukkan nama pengirim sebelum mencetak Nota Dinas Masuk
                </p>

                <!-- Input Sender -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold mb-2 text-gray-700">
                        Nama Pengirim
                    </label>
                    <input type="text" wire:model.defer="receiver"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        placeholder="Masukkan nama pengirim" />
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-200">
                    <button type="button" wire:click="$set('showSenderModal', false)"
                        class="px-6 py-2 rounded-lg bg-gray-300 hover:bg-gray-400 text-gray-700 font-semibold transition duration-300 ease-in-out transform hover:scale-105">
                        <i class="fas fa-times mr-1"></i>
                        Batal
                    </button>
                    @if ($selectedDocumentType === 'keluar')
                        <button type="button" wire:click="downloadNotaDinasKeluar({{ $selectedMagangApplicationId }}, 'keluar')"
                            class="bg-green-700 hover:bg-green-800 text-white px-6 py-2 rounded-lg font-semibold transition duration-300 ease-in-out transform hover:scale-105 flex items-center gap-2">
                            <i class="fas fa-download"></i>
                            Cetak Nota Dinas
                        </button>
                    @else
                        <button type="button" wire:click="downloadNotaDinasMasuk({{ $selectedMagangApplicationId }}, 'masuk')"
                            class="bg-green-700 hover:bg-green-800 text-white px-6 py-2 rounded-lg font-semibold transition duration-300 ease-in-out transform hover:scale-105 flex items-center gap-2">
                            <i class="fas fa-download"></i>
                            Cetak Nota Dinas
                        </button>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
