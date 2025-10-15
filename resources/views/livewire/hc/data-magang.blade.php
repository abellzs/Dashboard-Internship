<div x-data="{
    documentUrl: @entangle('documentUrl'),
    showToast: @entangle('showToast'),
    toastMessage: @entangle('toastMessage'),

    closeDocument() {
        this.documentUrl = null;
    }
}" @keydown.escape.window="closeDocument()" class="relative">

    {{-- Modal Preview Dokumen --}}
    <div x-show="documentUrl" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90"
        class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50" style="display: none;">
        <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-3xl mx-4 relative max-h-[90vh] overflow-y-auto">

            {{-- Tombol Close --}}
            <button @click="closeDocument"
                class="absolute top-4 right-4 text-gray-600 hover:text-[#DA291C] text-2xl font-bold transition-transform duration-200 hover:scale-125"
                title="Tutup Modal">&times;</button>

            {{-- Header --}}
            <h2 class="text-2xl font-extrabold mb-2 text-center text-[#DA291C]">Dokumen Peserta Magang</h2>
            <p class="text-sm text-center text-gray-600 mb-8">
                Berikut adalah dokumen yang diunggah peserta magang
            </p>

            {{-- Informasi Peserta --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-800 animate-fade-in">
                <div>
                    <label class="block text-sm font-semibold mb-1">Nama</label>
                    <p class="border rounded px-3 py-2 bg-[#FFF5F3]">
                        {{ $selectedPeserta->user?->name ?? '-' }}
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">NIM</label>
                    <p class="border rounded px-3 py-2 bg-[#FFF5F3]">{{ $selectedPeserta->user->nim_magang ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Universitas</label>
                    <p class="border rounded px-3 py-2 bg-[#FFF5F3]">
                        {{ $selectedPeserta->user->profile->instansi ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Jurusan</label>
                    <p class="border rounded px-3 py-2 bg-[#FFF5F3]">
                        {{ $selectedPeserta->user->profile->jurusan ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Jenis Kelamin</label>
                    <p class="border rounded px-3 py-2 bg-[#FFF5F3]">
                        {{ $selectedPeserta->user->profile->jenis_kelamin ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Unit Penempatan</label>
                    <p class="border rounded px-3 py-2 bg-[#FFF5F3]">{{ $selectedPeserta->unit_penempatan ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Durasi Magang</label>
                    <p class="border rounded px-3 py-2 bg-[#FFF5F3]">{{ $selectedPeserta->durasi_magang ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Tanggal Mulai Usulan</label>
                    <p class="border rounded px-3 py-2 bg-[#FFF5F3]">
                        {{ $selectedPeserta?->tanggal_mulai_usulan ? \Carbon\Carbon::parse($selectedPeserta->tanggal_mulai_usulan)->format('d M Y') : '-' }}
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Tanggal Selesai Usulan</label>
                    <p class="border rounded px-3 py-2 bg-[#FFF5F3]">
                        {{ $selectedPeserta?->tanggal_selesai_usulan ? \Carbon\Carbon::parse($selectedPeserta->tanggal_selesai_usulan)->format('d M Y') : '-' }}
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Status</label>
                    <p class="border rounded px-3 py-2 bg-[#FFF5F3] capitalize">
                        {{ $selectedPeserta?->status ? ucwords(str_replace('_', ' ', $selectedPeserta->status)) : '-' }}
                    </p>
                </div>
            </div>

            {{-- Dokumen --}}
            <div class="mt-8">
                <h3 class="text-lg font-bold mb-4">Dokumen</h3>
                <ul class="space-y-4">
                    @foreach ($documentPaths as $label => $path)
                        @if ($path)
                            <li
                                class="flex flex-col md:flex-row md:items-center md:justify-between bg-white border rounded-lg px-5 py-3 shadow-sm">
                                <div class="font-semibold text-gray-700 mb-2 md:mb-0 flex items-center gap-2">
                                    @if (str_contains(strtolower($label), 'cv'))
                                        <i class="fa fa-file-pdf text-red-500"></i>
                                    @elseif(str_contains(strtolower($label), 'proposal'))
                                        <i class="fa fa-file-alt text-blue-500"></i>
                                    @elseif(str_contains(strtolower($label), 'surat'))
                                        <i class="fa fa-file-word text-green-500"></i>
                                    @else
                                        <i class="fa fa-image text-purple-500"></i>
                                    @endif
                                    {{ ucfirst(str_replace('_', ' ', $label)) }}
                                </div>
                                <div class="flex gap-2">
                                    <a href="{{ $path }}" target="_blank"
                                        class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-1 rounded transition duration-200 text-sm font-medium">
                                        Preview
                                    </a>
                                </div>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
            {{-- Tombol Tutup --}}
            <div class="mt-8 flex justify-end">
                <button wire:click="closeDocument"
                    class="bg-[#DA291C] hover:bg-red-700 text-white px-6 py-2 rounded-md font-semibold transition duration-300 ease-in-out transform hover:scale-105">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    {{-- Modal Konfirmasi --}}
    <template x-if="confirm.show">
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
                <h2 class="text-lg font-bold mb-4 text-blue-600" x-text="confirm.title"></h2>
                <p class="mb-6" x-text="confirm.message"></p>
                <div class="flex justify-end space-x-3">
                    <button @click="confirm.show = false" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400"
                        wire:loading.attr="disabled">
                        Batal
                    </button>
                    <button wire:loading.attr="disabled" wire:target="confirmExecute"
                        @click="$wire.call('confirmExecute')"
                        class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 flex items-center space-x-2">
                        <span x-text="confirm.confirmText"></span>
                        <svg wire:loading wire:target="confirmExecute" class="animate-spin h-5 w-5 text-white"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </template>

    {{-- Toast Notification --}}
    <div x-data="{
        showToast: @entangle('showToast'),
        toastMessage: @entangle('toastMessage'),
        init() {
            $watch('showToast', value => {
                if (value) setTimeout(() => this.showToast = false, 3500)
            })
        }
    }" x-init="init()" x-show="showToast"
        x-transition:enter="transform transition duration-300"
        x-transition:enter-start="translate-x-10 opacity-0 scale-90"
        x-transition:enter-end="translate-x-0 opacity-100 scale-100"
        x-transition:leave="transform transition duration-300"
        x-transition:leave-start="translate-x-0 opacity-100 scale-100"
        x-transition:leave-end="translate-x-10 opacity-0 scale-90"
        class="fixed top-5 right-5 text-white px-5 py-3 rounded-xl shadow-2xl flex items-center gap-3 z-50 text-sm font-semibold bg-gradient-to-r from-[#DA291C] to-[#FF6D00]">
        <svg class="h-5 w-5 text-white flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
        </svg>
        <span x-text="toastMessage"></span>
    </div>



    {{-- Konten utama --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden animate-fade-in duration-300 py-3 px-6">

        {{-- Filter + Search + Export --}}
        <div class="flex flex-wrap justify-between items-center gap-4 py-2">

            {{-- Status Filter --}}
            <div class="flex flex-wrap gap-3 items-center">
                @php
                    $filters = [
                        'all' => ['label' => 'All', 'color' => 'gray', 'icon' => 'fas fa-list'],
                        'on_going' => ['label' => 'On Going', 'color' => 'yellow', 'icon' => 'fas fa-play-circle'],
                        'done' => ['label' => 'Done', 'color' => 'green', 'icon' => 'fas fa-check-circle'],
                    ];
                @endphp
                @foreach ($filters as $key => $f)
                    <button wire:click="setFilter('{{ $key }}')" wire:loading.attr="disabled"
                        type="button"
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

            {{-- Search, Export, and Unit Filter --}}
            <div class="relative flex items-center gap-4 flex-wrap">

                {{-- Search Input with Icon --}}
                <div class="relative">
                    <span class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-gray-400">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" wire:model.live="search" placeholder="Cari Nama / NIM"
                        class="pl-10 pr-4 py-2 border border-gray-300 rounded-full text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition" />
                </div>

                {{-- Custom Dropdown --}}
                <div class="relative">
                    <select wire:model.live="unitFilter"
                        class="appearance-none border border-gray-300 rounded-full pl-4 pr-10 py-2 bg-white text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        <option value="">Semua Unit</option>
                        @foreach ($units as $unit)
                            <option value="{{ $unit }}">{{ $unit }}</option>
                        @endforeach
                    </select>
                    <span class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-gray-400">
                        <i class="fas fa-chevron-down"></i>
                    </span>
                </div>

                {{-- Export Button --}}
                <button wire:click="exportExcel" title="Export Data Peserta ke Excel"
                    class="text-green-600 hover:text-green-800 transition duration-200 text-2xl">
                    <i class="fas fa-download"></i>
                </button>
            </div>
        </div>

        {{-- Tabel --}}
        <div class="bg-white rounded-lg overflow-x-auto border my-5 relative">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">NIM</th>
                        <th wire:click="sort('user.name')"
                            class="cursor-pointer px-6 py-3 text-left text-sm font-semibold text-gray-700 flex items-center space-x-1 select-none">
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
                                        'on_going' => 'bg-purple-100 text-purple-800',
                                        'done' => 'bg-green-200 text-green-800',
                                    ];
                                @endphp
                                <span
                                    class="inline-flex px-2 py-1 rounded-full text-xs font-semibold {{ $statusColors[$row->status] ?? 'bg-gray-200 text-gray-700' }}">
                                    {{ ucfirst(str_replace('_', ' ', $row->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <input type="date"
                                    wire:model.lazy="editDates.{{ $row->id }}.tanggal_mulai_usulan"
                                    wire:change="updateTanggal({{ $row->id }}, 'tanggal_mulai_usulan')"
                                    class="border rounded px-2 py-1 w-full text-sm" />
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <input type="date"
                                    wire:model.lazy="editDates.{{ $row->id }}.tanggal_selesai_usulan"
                                    wire:change="updateTanggal({{ $row->id }}, 'tanggal_selesai_usulan')"
                                    class="border rounded px-2 py-1 w-full text-sm" />
                            </td>
                            <td class="px-6 py-4 flex justify-center space-x-2">
                                <button wire:click="editMagang({{ $row->id }})"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-full transition transform hover:scale-110"
                                    title="Edit Data Magang">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button wire:click="viewDocument({{ $row->id }})"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-full transition transform hover:scale-110">
                                    <i class="fas fa-file-alt"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-gray-400 py-6">Tidak ada data ditemukan</td>
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
    {{-- Modal Edit Data Magang --}}
    @if ($showEditModal)
        <div x-data="{ show: @entangle('showEditModal') }" x-show="show" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90" @keydown.escape.window="$wire.closeEditModal()"
            class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50">
            <div
                class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-2xl mx-4 relative max-h-[90vh] overflow-y-auto animate-fade-in">

                {{-- Tombol Close --}}
                <button wire:click="closeEditModal"
                    class="absolute top-4 right-4 text-gray-600 hover:text-[#DA291C] text-2xl font-bold transition-transform duration-200 hover:scale-125"
                    title="Tutup Modal">&times;</button>

                {{-- Header --}}
                <h2 class="text-2xl font-extrabold mb-2 text-center text-[#DA291C]">Edit Data Magang</h2>
                <p class="text-sm text-center text-gray-600 mb-6">
                    Perbarui data peserta magang
                </p>

                {{-- Status error --}}
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

                <form wire:submit.prevent="updateMagang">
                    <div class="grid grid-cols-1 gap-6">
                        {{-- NIM --}}
                        <div>
                            <label class="block text-sm font-semibold mb-2 text-gray-700">
                                <i class="fas fa-id-card text-[#DA291C] mr-1"></i>
                                NIM Magang
                            </label>
                            <input type="text" wire:model="editMagangData.nim_magang"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm text-sm focus:outline-none focus:ring-2 focus:ring-[#DA291C] focus:border-transparent transition bg-[#FFF5F3]"
                                placeholder="Masukkan NIM" />
                            @error('editMagangData.nim_magang')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        {{-- Nama --}}
                        <div>
                            <label class="block text-sm font-semibold mb-2 text-gray-700">
                                <i class="fas fa-user text-[#DA291C] mr-1"></i>
                                Nama Lengkap
                            </label>
                            <input type="text" wire:model="editMagangData.name"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm text-sm focus:outline-none focus:ring-2 focus:ring-[#DA291C] focus:border-transparent transition bg-[#FFF5F3]"
                                placeholder="Masukkan nama lengkap" />
                            @error('editMagangData.name')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        {{-- Unit Penempatan --}}
                        <div>
                            <label class="block text-sm font-semibold mb-2 text-gray-700">
                                <i class="fas fa-building text-[#DA291C] mr-1"></i>
                                Unit Penempatan
                            </label>
                            <select wire:model="editMagangData.unit_penempatan"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm text-sm focus:outline-none focus:ring-2 focus:ring-[#DA291C] focus:border-transparent transition bg-[#FFF5F3]">
                                <option value="">Pilih Unit</option>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit }}">{{ $unit }}</option>
                                @endforeach
                            </select>
                            @error('editMagangData.unit_penempatan')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    {{-- Action Buttons --}}
                    <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-200">
                        <button type="button" wire:click="closeEditModal"
                            class="px-6 py-2 rounded-lg bg-gray-300 hover:bg-gray-400 text-gray-700 font-semibold transition duration-300 ease-in-out transform hover:scale-105">
                            <i class="fas fa-times mr-1"></i>
                            Batal
                        </button>
                        <button type="submit"
                            class="bg-[#DA291C] hover:bg-red-700 text-white px-6 py-2 rounded-lg font-semibold transition duration-300 ease-in-out transform hover:scale-105 flex items-center gap-2">
                            <i class="fas fa-save"></i>
                            <span wire:loading.remove wire:target="updateMagang">Simpan Perubahan</span>
                            <span wire:loading wire:target="updateMagang">Menyimpan...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
