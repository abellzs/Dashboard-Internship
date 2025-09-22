<div class="mt-10">

    {{-- Flash Message --}}
    @if (session()->has('message'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4 animate-fade-in">
            {{ session('message') }}
        </div>
    @endif

    {{-- Header --}}
    <div>
        <h2 class="text-2xl md:text-3xl font-bold pb-10 text-[#DA291C]">
            Selamat datang, <strong>{{ $user->name }}</strong>
        </h2>
    </div>

    {{-- Tombol Ajukan Ulang / Tambah --}}
    <div class="flex items-center justify-between mb-3">
        <h3 class="text-xl font-semibold text-gray-700">Riwayat Pengajuan Kerja Praktik</h3>

        @php $isRejected = $magangAktif && $magangAktif->status === 'rejected'; @endphp
        @php $isDone = $magangAktif && $magangAktif->status === 'done'; @endphp

        @if ($isRejected || $isDone)
            <button wire:click="ajukanUlang"
                    class="inline-block px-4 py-2 bg-[#DA291C] text-white text-sm font-semibold rounded hover:bg-red-700 transition duration-200 transform hover:scale-105">
                + Ajukan Ulang
            </button>

        @elseif (!$magangAktif)
            <button wire:click="tambahPengajuan"
                    class="inline-block px-4 py-2 bg-[#DA291C] text-white text-sm font-semibold rounded hover:bg-red-700 transition duration-200 transform hover:scale-105">
                + Ajukan Ulang
            </button>
        @else
            <button disabled
                    class="inline-block px-4 py-2 bg-gray-300 text-gray-600 text-sm font-semibold rounded cursor-not-allowed">
                + Tambah
            </button>
        @endif
    </div>

    {{-- TABEL DESKTOP --}}
    <div class="overflow-x-auto hidden md:block">
        <table class="min-w-full border border-gray-200 bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-[#DA291C] text-white text-base font-semibold">
                <tr>
                    <th class="px-6 py-3 text-left">No</th>
                    <th class="px-6 py-3 text-left">Tanggal Pengajuan</th>
                    <th class="px-6 py-3 text-left">Unit Penempatan</th>
                    <th class="px-6 py-3 text-left">Durasi</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-sm">
                @foreach ($riwayats as $index => $m)
                    @php
                        $statusColors = [
                            'waiting' => 'bg-yellow-100 text-yellow-800',
                            'accepted' => 'bg-green-100 text-green-800',
                            'rejected' => 'bg-red-100 text-red-800',
                            'on_going' => 'bg-purple-100 text-purple-800 animate-pulse',
                            'default' => 'bg-gray-100 text-gray-700'
                        ];
                        $badgeClass = $statusColors[$m->status] ?? $statusColors['default'];
                    @endphp
                    <tr class="border-t hover:bg-gray-50 transition duration-200">
                        <td class="px-6 py-3">{{ $index + 1 }}</td>
                        <td class="px-6 py-3 flex items-center gap-1">
                            <i class="fa fa-calendar text-gray-400"></i>
                            {{ \Carbon\Carbon::parse($m->created_at)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-3">{{ $m->unit_penempatan }}</td>
                        <td class="px-6 py-3">{{ $m->durasi_magang }}</td>
                        <td class="px-6 py-3">
                            <span title="{{ ucfirst(str_replace('_', ' ', $m->status)) }}" 
                                  class="px-2 py-1 rounded-full text-xs font-semibold {{ $badgeClass }} transition-colors duration-300">
                                {{ ucfirst(str_replace('_', ' ', $m->status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-3">
                            <button wire:click="showDetail({{ $m->id }})" class="text-blue-600 hover:underline">
                                Lihat Detail
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- MOBILE CARD VIEW --}}
    <div class="md:hidden overflow-x-auto mt-6">
        <table class="w-full table-auto border-collapse border border-gray-300 text-sm">
            <thead class="bg-gray-200 text-gray-700">
                <tr>
                    <th class="p-2 border">No</th>
                    <th class="p-2 border">Unit Penempatan</th>
                    <th class="p-2 border">Status</th>
                    <th class="p-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($riwayats as $index => $m)
                    @php
                        $badgeClass = $statusColors[$m->status] ?? $statusColors['default'];
                    @endphp
                    <tr class="bg-white border-b border-gray-300 rounded-lg shadow-sm mb-2">
                        <td class="p-2 border text-center">{{ $index + 1 }}</td>
                        <td class="p-2 border text-center">{{ $m->unit_penempatan }}</td>
                        <td class="p-2 border text-center">
                            <span title="{{ ucfirst(str_replace('_', ' ', $m->status)) }}"
                                  class="px-2 py-1 rounded-full text-xs font-semibold {{ $badgeClass }} transition-colors duration-300">
                                {{ ucfirst(str_replace('_', ' ', $m->status)) }}
                            </span>
                        </td>
                        <td class="p-2 border text-center">
                            <button wire:click="showDetail({{ $m->id }})" class="text-blue-600 hover:underline">
                                <i class="fa fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- MODAL DETAIL --}}
    @if($showDetailModal && $detailMagang)
        <div 
            x-data="{ show: true }"
            x-init="$nextTick(() => show = true)"
            x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90"
            class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50"
            style="display: none;"
        >
            <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-3xl mx-4 relative max-h-[90vh] overflow-y-auto">
                
                {{-- Tombol Close --}}
                <button wire:click="closeModal" 
                        class="absolute top-4 right-4 text-gray-600 hover:text-[#DA291C] text-2xl font-bold transition-transform duration-200 hover:scale-125">&times;</button>

                {{-- Header --}}
                <h2 class="text-2xl font-extrabold mb-2 text-center text-[#DA291C]">Detail Pengajuan Kerja Praktek</h2>
                <p class="text-sm text-center text-gray-600 mb-8">
                    Berikut ini merupakan detail dari pengajuan Kerja Praktek yang diajukan
                </p>

                {{-- Informasi Utama --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-800 animate-fade-in">
                    <div>
                        <label class="block text-sm font-semibold mb-1">Nama</label>
                        <p class="border rounded px-3 py-2 bg-[#FFF5F3]">{{ $detailMagang->user->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">NIM</label>
                        <p class="border rounded px-3 py-2 bg-[#FFF5F3]">{{ $detailMagang->user->nim_magang ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Unit Penempatan</label>
                        <p class="border rounded px-3 py-2 bg-[#FFF5F3]">{{ $detailMagang->unit_penempatan }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Durasi Magang</label>
                        <p class="border rounded px-3 py-2 bg-[#FFF5F3]">{{ $detailMagang->durasi_magang }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Tanggal Mulai</label>
                        <p class="border rounded px-3 py-2 bg-[#FFF5F3] flex items-center gap-1">
                            <i class="fa fa-calendar text-gray-400"></i>
                            {{ \Carbon\Carbon::parse($detailMagang->tanggal_mulai_usulan)->format('d M Y') }}
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Tanggal Selesai</label>
                        <p class="border rounded px-3 py-2 bg-[#FFF5F3] flex items-center gap-1">
                            <i class="fa fa-calendar text-gray-400"></i>
                            {{ \Carbon\Carbon::parse($detailMagang->tanggal_selesai_usulan)->format('d M Y') }}
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Status</label>
                        @php $badgeClassDetail = $statusColors[$detailMagang->status] ?? $statusColors['default']; @endphp
                        <p class="border rounded px-3 py-2 bg-[#FFF5F3] capitalize">
                            <span title="{{ ucfirst(str_replace('_', ' ', $detailMagang->status)) }}" 
                                  class="px-2 py-1 rounded-full text-xs font-semibold {{ $badgeClassDetail }} transition-colors duration-300">
                                {{ ucfirst(str_replace('_', ' ', $detailMagang->status)) }}
                            </span>
                        </p>
                    </div>
                </div>

                {{-- Dokumen --}}
                <div class="mt-8">
                    <h3 class="text-lg font-bold mb-4">Dokumen</h3>
                    @if($detailMagang->document)
                        @php
                            $magangDoc = $detailMagang->document;
                            $docs = [
                                'CV' => $magangDoc->cv_path,
                                'Surat Permohonan' => $magangDoc->surat_permohonan_path,
                                'Proposal' => $magangDoc->proposal_path,
                                'Foto Diri' => $magangDoc->foto_diri_path,
                            ];
                        @endphp
                        <ul class="space-y-4">
                            @foreach($docs as $label => $path)
                                @if($path)
                                    <li class="flex flex-col md:flex-row md:items-center md:justify-between bg-white border rounded-lg px-5 py-3 shadow-sm">
                                        <div class="font-semibold text-gray-700 mb-2 md:mb-0 flex items-center gap-2">
                                            @if(str_contains(strtolower($label), 'cv'))
                                                <i class="fa fa-file-pdf text-red-500"></i>
                                            @elseif(str_contains(strtolower($label), 'proposal'))
                                                <i class="fa fa-file-alt text-blue-500"></i>
                                            @elseif(str_contains(strtolower($label), 'surat'))
                                                <i class="fa fa-file-word text-green-500"></i>
                                            @else
                                                <i class="fa fa-image text-purple-500"></i>
                                            @endif
                                            {{ $label }}
                                        </div>
                                        <div class="flex gap-2">
                                            <a href="{{ asset('storage/'.$path) }}" target="_blank"
                                            class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-1 rounded transition duration-200 text-sm font-medium">
                                                Preview
                                            </a>

                                            {{-- Tombol Update --}}
                                            <button wire:click="$set('editingDocument', '{{ strtolower(str_replace(' ', '_', $label)) }}')" 
                                                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-1 rounded border transition duration-200 transform hover:scale-105 text-sm font-medium">
                                                Update
                                            </button>
                                        </div>
                                    </li>

                                    {{-- Input file muncul setelah klik Update --}}
                                    @if($editingDocument === strtolower(str_replace(' ', '_', $label)))
                                        <li class="mt-2 flex flex-col gap-2">
                                            <input type="file" wire:model="newDocument" class="border p-2 rounded">
                                            <button wire:click="updateDocument"
                                                    class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
                                                Simpan
                                            </button>
                                            <button wire:click="$set('editingDocument', null)"
                                                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                                Batal
                                            </button>
                                        </li>
                                    @endif
                                @endif
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500">Tidak ada dokumen.</p>
                    @endif
                </div>

                {{-- Tombol Tutup --}}
                <div class="mt-8 flex justify-end">
                    <button wire:click="closeModal"
                        class="bg-[#DA291C] hover:bg-red-700 text-white px-6 py-2 rounded-md font-semibold transition duration-300 ease-in-out transform hover:scale-105">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
    Livewire.on('showAlert', data => {
        Swal.fire({
            title: data.title,
            text: data.text,
            icon: data.icon,
            confirmButtonText: 'OK'
        });
    });
</script>

