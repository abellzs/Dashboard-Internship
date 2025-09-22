@foreach ($lowongans as $lowongan)
    <div 
        @if($lowongan->ketersediaan !== 'Tidak Tersedia')
            wire:click="selectLowongan({{ $lowongan->id }})"
        @endif
        class="border rounded-xl p-4 mb-4 shadow-sm transition 
            {{ $lowongan->ketersediaan === 'Tidak Tersedia' 
                ? 'bg-gray-100 text-gray-400 cursor-not-allowed opacity-60' 
                : 'cursor-pointer hover:shadow-md' }}
            {{ $selectedId === $lowongan->id ? 'border-blue-500 bg-blue-50' : 'bg-white' }}">
        
        <div class="flex justify-between items-center mb-1">
            <h3 class="font-semibold text-lg">
                {{ $lowongan->nama_unit }}
            </h3>
            <span class="text-sm px-2 py-1 rounded-full border 
                {{ $lowongan->ketersediaan === 'Tidak Tersedia' 
                    ? 'bg-red-100 text-red-700 border-red-300' 
                    : 'bg-green-100 text-green-700 border-green-300' }}">
                {{ $lowongan->ketersediaan }}
            </span>
        </div>

        <div class="flex flex-wrap gap-2 text-xs mt-2">
            <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded-full border border-gray-300">
                {{ $lowongan->durasi }} bulan
            </span>
            <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded-full border border-gray-300">
                On Site
            </span>
        </div>
    </div>
@endforeach
