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
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
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
                            <td colspan="6" class="text-center text-gray-400 py-6">Tidak ada data presensi ditemukan
                            </td>
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
    @if ($showEditModal)
        <div class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
                <h2 class="text-lg font-semibold mb-4">Edit Presensi</h2>

                {{-- Status sukses --}}
                @if (session()->has('message'))
                    <div class="mb-4 px-4 py-2 bg-green-100 text-green-800 rounded">
                        {{ session('message') }}
                    </div>
                @endif

                {{-- Status error --}}
                @if ($errors->any())
                    <div class="mb-4 px-4 py-2 bg-red-100 text-red-800 rounded">
                        <ul class="list-disc pl-4">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form wire:submit.prevent="updateAttendance">
                    <div class="mb-5">
                        <label class="block text-sm md:text-base font-medium mb-1">Tanggal</label>
                        <input type="date" wire:model="editAttendanceData.date"
                            class="w-full px-4 py-2 md:py-3 border border-gray-300 rounded-md shadow-sm text-sm md:text-base focus:outline-none focus:ring-2 focus:ring-red-500" />
                    </div>
                    <div class="mb-5">
                        <label class="block text-sm md:text-base font-medium mb-1">Jam Masuk</label>
                        <input type="time" wire:model="editAttendanceData.check_in"
                            class="w-full px-4 py-2 md:py-3 border border-gray-300 rounded-md shadow-sm text-sm md:text-base focus:outline-none focus:ring-2 focus:ring-red-500" />
                    </div>
                    <div class="mb-5 relative">
                        <label class="block text-sm md:text-base font-medium mb-1">Status</label>
                        <select wire:model="editAttendanceData.status"
                            class="w-full px-4 py-2 md:py-3 border border-gray-300 rounded-md shadow-sm text-sm md:text-base focus:outline-none focus:ring-2 focus:ring-red-500">
                            <option value="Hadir">Hadir</option>
                            <option value="Terlambat">Terlambat</option>
                            <option value="Izin">Izin</option>
                            <option value="Tidak Hadir">Tidak Hadir</option>
                        </select>
                    </div>
                    <div class="mb-5">
                        <label class="block text-sm md:text-base font-medium mb-1">Keterangan</label>
                        <input type="text" wire:model="editAttendanceData.keterangan"
                            class="w-full px-4 py-2 md:py-3 border border-gray-300 rounded-md shadow-sm text-sm md:text-base focus:outline-none focus:ring-2 focus:ring-red-500" />
                    </div>
                    <div class="flex justify-end gap-2 mt-4">
                        <button type="button" wire:click="$set('showEditModal', false)"
                            class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
