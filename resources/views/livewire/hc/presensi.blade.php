<div>
    <div class="bg-white rounded-lg shadow-md overflow-hidden animate-fade-in duration-300 py-3 px-6">

        {{-- Filter + Search + Export --}}
        <div class="flex flex-wrap justify-between items-center gap-4 py-2">

            {{-- Status Filter --}}
            <div class="flex flex-wrap gap-3 items-center">
                @php
                    $filters = [
                        'all' => ['label' => 'Semua', 'color' => 'gray', 'icon' => 'fas fa-list'],
                        'Hadir' => ['label' => 'Hadir', 'color' => 'green', 'icon' => 'fas fa-check-circle'],
                        'Terlambat' => ['label' => 'Terlambat', 'color' => 'yellow', 'icon' => 'fas fa-clock'],
                        'Izin' => ['label' => 'Izin', 'color' => 'blue', 'icon' => 'fas fa-calendar-check'],
                        'Tidak Hadir' => ['label' => 'Tidak Hadir', 'color' => 'red', 'icon' => 'fas fa-times-circle'],
                        'Belum Hadir' => ['label' => 'Belum Hadir', 'color' => 'gray', 'icon' => 'fas fa-user-clock'],
                    ];
                @endphp
                @foreach ($filters as $key => $f)
                    <button wire:click="setFilter('{{ $key }}')" wire:loading.attr="disabled" type="button"
                        class="inline-flex items-center px-4 py-2 rounded-full border transition-all duration-200
                        {{ ($filter ?? 'all') === $key
                            ? 'bg-' . $f['color'] . '-600 text-white border-' . $f['color'] . '-600 shadow-md scale-105'
                            : 'bg-white text-gray-700 border-gray-300 hover:bg-' . $f['color'] . '-50 hover:border-' . $f['color'] . '-400' }}">
                        <i class="{{ $f['icon'] }} mr-2 text-sm"></i>
                        <span class="font-medium flex items-center">
                            {{ $f['label'] }}
                        </span>
                    </button>
                @endforeach
            </div>

            {{-- Search and Export --}}
            <div class="relative flex items-center gap-4 flex-wrap">
                {{-- Search Input --}}
                <div class="relative">
                    <span class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-gray-400">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" wire:model.live="search" placeholder="Cari Nama User"
                        class="pl-10 pr-4 py-2 border border-gray-300 rounded-full text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition" />
                </div>

                {{-- Export Button --}}
                <button wire:click="exportExcel" title="Export Data Presensi ke Excel"
                    class="text-green-600 hover:text-green-800 transition duration-200 text-2xl">
                    <i class="fas fa-download"></i>
                </button>
            </div>
        </div>

        {{-- Tabel Presensi --}}
        <div class="bg-white rounded-lg overflow-x-auto border my-5 relative">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Nama</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Unit Penempatan</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Tanggal</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Jam Masuk</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Keterangan</th>
                        <th class="{{ $filter === 'Belum Hadir' ? 'hidden' : '' }} px-6 py-3 text-center text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @if ($filter === 'Belum Hadir')
                        @forelse($attendances as $user)
                            <tr class="hover:bg-gray-100 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $user->name ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $this->getUnitById($user->id) ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ \Carbon\Carbon::now()->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    -
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span
                                        class="inline-flex px-2 py-1 rounded-full text-xs font-semibold bg-gray-200 text-gray-700">
                                        Belum Hadir
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    -
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-gray-400 py-6">Semua peserta sudah presensi
                                    hari ini</td>
                            </tr>
                        @endforelse
                    @else
                        @forelse($attendances as $attendance)
                            <tr class="hover:bg-gray-100 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $attendance->user->name ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $this->getUnitById($attendance->user_id) ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ \Carbon\Carbon::parse($attendance->date)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('H:i') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @php
                                        $statusColors = [
                                            'Hadir' => 'bg-green-100 text-green-800',
                                            'Terlambat' => 'bg-yellow-100 text-yellow-800',
                                            'Izin' => 'bg-blue-100 text-blue-800',
                                            'Tidak Hadir' => 'bg-red-100 text-red-800',
                                        ];
                                    @endphp
                                    <span
                                        class="inline-flex px-2 py-1 rounded-full text-xs font-semibold {{ $statusColors[$attendance->status] ?? 'bg-gray-200 text-gray-700' }}">
                                        {{ $attendance->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ $attendance->keterangan ?? '-' }}
                                </td>
                                <td class="px-6 py-4 flex justify-center space-x-2">
                                    <button wire:click="editAttendance({{ $attendance->id }})"
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-full transition transform hover:scale-110"
                                        title="Edit Presensi">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button wire:click="deleteAttendance({{ $attendance->id }})"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-full transition transform hover:scale-110"
                                        title="Hapus Presensi"
                                        onclick="return confirm('Yakin ingin menghapus data presensi ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-gray-400 py-6">Tidak ada data presensi
                                    ditemukan
                                </td>
                            </tr>
                        @endforelse
                    @endif
                </tbody>
            </table>

            {{-- Loading overlay --}}
            <div wire:loading.flex wire:target="search,setFilter"
                class="absolute inset-0 bg-white bg-opacity-70 flex items-center justify-center rounded-lg"
                style="z-index:10;">
                <svg class="animate-spin h-8 w-8 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4">
                    </circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
            </div>
        </div>
        {{-- Pagination --}}
        <div class="p-3">
            {{ $attendances->links() }}
        </div>
    </div>

    {{-- Modal Edit Presensi --}}
    {{-- Modal Edit Presensi --}}
    @if ($showEditModal)
        <div x-data="{ show: @entangle('showEditModal') }" x-show="show" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90" @keydown.escape.window="$wire.set('showEditModal', false)"
            class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50">
            <div
                class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-2xl mx-4 relative max-h-[90vh] overflow-y-auto animate-fade-in">

                {{-- Tombol Close --}}
                <button wire:click="$set('showEditModal', false)"
                    class="absolute top-4 right-4 text-gray-600 hover:text-[#DA291C] text-2xl font-bold transition-transform duration-200 hover:scale-125"
                    title="Tutup Modal">&times;</button>

                {{-- Header --}}
                <h2 class="text-2xl font-extrabold mb-2 text-center text-[#DA291C]">Edit Presensi</h2>
                <p class="text-sm text-center text-gray-600 mb-6">
                    Perbarui data presensi peserta magang
                </p>

                {{-- Status sukses --}}
                @if (session()->has('message'))
                    <div
                        class="mb-4 px-4 py-3 bg-green-100 border border-green-400 text-green-800 rounded-lg flex items-center gap-2">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('message') }}</span>
                    </div>
                @endif

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

                <form wire:submit.prevent="updateAttendance">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Tanggal --}}
                        <div>
                            <label class="block text-sm font-semibold mb-2 text-gray-700">
                                <i class="fas fa-calendar-alt text-[#DA291C] mr-1"></i>
                                Tanggal
                            </label>
                            <input type="date" wire:model="editAttendanceData.date"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm text-sm focus:outline-none focus:ring-2 focus:ring-[#DA291C] focus:border-transparent transition bg-[#FFF5F3]" />
                        </div>

                        {{-- Jam Masuk --}}
                        <div>
                            <label class="block text-sm font-semibold mb-2 text-gray-700">
                                <i class="fas fa-clock text-[#DA291C] mr-1"></i>
                                Jam Masuk
                            </label>
                            <input type="time" wire:model="editAttendanceData.check_in"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm text-sm focus:outline-none focus:ring-2 focus:ring-[#DA291C] focus:border-transparent transition bg-[#FFF5F3]" />
                        </div>

                        {{-- Status --}}
                        <div>
                            <label class="block text-sm font-semibold mb-2 text-gray-700">
                                <i class="fas fa-info-circle text-[#DA291C] mr-1"></i>
                                Status
                            </label>
                            <select wire:model="editAttendanceData.status"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm text-sm focus:outline-none focus:ring-2 focus:ring-[#DA291C] focus:border-transparent transition bg-[#FFF5F3]">
                                <option value="Hadir">Hadir</option>
                                <option value="Terlambat">Terlambat</option>
                                <option value="Izin">Izin</option>
                                <option value="Tidak Hadir">Tidak Hadir</option>
                            </select>
                        </div>

                        {{-- Keterangan --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold mb-2 text-gray-700">
                                <i class="fas fa-comment text-[#DA291C] mr-1"></i>
                                Keterangan
                            </label>
                            <textarea wire:model="editAttendanceData.keterangan" rows="3" placeholder="Masukkan keterangan (opsional)"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm text-sm focus:outline-none focus:ring-2 focus:ring-[#DA291C] focus:border-transparent transition bg-[#FFF5F3]"></textarea>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-200">
                        <button type="button" wire:click="$set('showEditModal', false)"
                            class="px-6 py-2 rounded-lg bg-gray-300 hover:bg-gray-400 text-gray-700 font-semibold transition duration-300 ease-in-out transform hover:scale-105">
                            <i class="fas fa-times mr-1"></i>
                            Batal
                        </button>
                        <button type="submit"
                            class="bg-[#DA291C] hover:bg-red-700 text-white px-6 py-2 rounded-lg font-semibold transition duration-300 ease-in-out transform hover:scale-105 flex items-center gap-2">
                            <i class="fas fa-save"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
