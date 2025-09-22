@php
    $lowongan = $lowongans->firstWhere('id', $selectedId);
@endphp

@if ($lowongan)
    <div class="space-y-6">
        <!-- Header -->
        <div>
            <h2 class="text-xl font-bold text-gray-800">{{ $lowongan->nama_unit }}</h2>
            <p class="text-gray-600 text-sm">{{ $lowongan->lokasi ?? 'Lokasi tidak tersedia' }} • Onsite</p>
        </div>

        <!-- Label & Stats -->
        <div class="flex flex-wrap items-center gap-3 text-sm border-b border-gray-200 pb-4">
            <span class="bg-green-100 text-green-700 font-medium px-3 py-1 rounded-full">{{ $lowongan->ketersediaan }}</span>
            <span class="text-gray-600">{{ $lowongan->durasi }} Bulan</span>
        </div>

        <!-- Pendidikan -->
        <div class="border-b border-gray-200 pb-4">
            <h3 class="font-semibold text-gray-800 mb-1 flex items-center gap-2">
                <img src="{{ asset('images/pendidikan.svg') }}" alt="Icon" class="w-5 h-5 shrink-0 object-contain">
                Pendidikan
            </h3>
            <ul class="text-sm text-gray-700 list-none ml-4 pl-3 space-y-1">
                <li>Jenjang pendidikan: {{ $lowongan->jenjang ?? 'Sarjana, Diploma' }}</li>
                <li>Jurusan: {{ $lowongan->major ?? 'Semua Jurusan' }}</li>
            </ul>
        </div>

        <!-- Dokumen -->
        <div class="border-b border-gray-200 pb-4">
            <div class="flex items-center gap-2 mb-1">
                <img src="{{ asset('images/dokumen.svg') }}" alt="Dokumen Icon" class="w-5 h-5">
                <h3 class="font-semibold text-gray-800">Persyaratan Dokumen</h3>
            </div>

            <ul class="text-sm text-gray-700 space-y-1 list-none ml-4 pl-3">
                <li>CV</li>
                <li>Surat Permohonan Kerja</li>
                <li>Proposal Magang (Opsional)</li>
                <li>Surat Rekomendasi</li>
                <li>Foto Diri Terbaru</li>
                <li>Portofolio (Jika ada)</li>
            </ul>
        </div>

        <!-- Deskripsi -->
        <div class="border-b border-gray-200 pb-4">
            <h3 class="font-semibold text-gray-800 mb-1 flex items-center gap-2">
                <img src="{{ asset('images/deskripsi.svg') }}" alt="Dokumen Icon" class="w-5 h-5">
                Deskripsi Pekerjaan
            </h3>
            <div class="text-sm text-gray-700 whitespace-pre-line">
                {!! nl2br(e($lowongan->deskripsi)) !!}
            </div>
        </div>
    </div>
@else
    <div class="text-sm text-gray-500">
        Pilih salah satu lowongan untuk melihat detailnya.
    </div>
@endif
