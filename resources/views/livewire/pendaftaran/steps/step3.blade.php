<div>
    <div class="mb-4">
        <label for="mulai" class="block font-semibold">Usulan Mulai Magang (Hari senin awal bulan) <span class="text-red-600">*</span></label>
        <input type="date" id="mulai" name="mulai" wire:model="mulai" autocomplete="on" class="w-full px-4 py-2 border rounded">
        @error('mulai') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="mb-4">
        <label for="selesai" class="block font-semibold">Usulan Selesai Magang (Hari jumat akhir bulan) <span class="text-red-600">*</span></label>
        <input type="date" id="selesai" name="selesai" wire:model.defer="selesai" autocomplete="on" class="w-full px-4 py-2 border rounded"/>
        @error('selesai') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="mb-4">
        <label for="durasi" class="block font-semibold mb-1">Durasi Magang <span class="text-red-600">*</span></label>
        <select id="durasi" name="durasi" wire:model.defer="durasi" class="w-full px-4 py-2 border rounded">
            <option value="">Pilih Durasi Magang</option>
            <option value="2 Bulan">2 Bulan</option>
            <option value="3 Bulan">3 Bulan</option>
            <option value="4 Bulan">4 Bulan</option>
            <option value="5 Bulan">5 Bulan</option>
            <option value="6 Bulan">6 Bulan</option>
        </select>
        @error('durasi') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="mb-4">
        <label for="semester" class="block font-semibold mb-1">
            Semester Saat Ini <span class="text-red-600">*</span>
        </label>
        <select id="semester" name="semester" wire:model.defer="semester" 
            class="w-full px-4 py-2 border rounded bg-white">
            <option value="">Pilih Semester</option>
            @foreach([5,6,7,8] as $smt)
                <option value="{{ $smt }}">{{ $smt }}</option>
            @endforeach
        </select>
        @error('semester') 
            <span class="text-red-500 text-sm">{{ $message }}</span> 
        @enderror
    </div>

    <div class="mb-4">
        <label for="alasan" class="block font-semibold mb-1">Alasan Memilih Telkom Witel Yogya Jateng Selatan sebagai Tempat Magang/Kerja Praktik<span class="text-red-600">*</span></label>
        <textarea id="alasan" name="alasan" wire:model="alasan" rows="4" autocomplete="off" class="w-full px-4 py-2 border rounded" placeholder="Tulis alasanmu di sini..."></textarea>
        @error('alasan') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    {{-- === Component Upload (CV, Surat, Proposal, Foto) === --}}
    @foreach ([
        ['name' => 'cv', 'label' => 'Upload CV', 'desc' => 'Format PDF. Maks 10MB'],
        ['name' => 'surat_permohonan', 'label' => 'Upload Surat Permohonan Kerja Praktek/PKL', 'desc' => 'Format PDF. Maks 10MB'],
        ['name' => 'proposal', 'label' => 'Upload Proposal Magang (Opsional)', 'desc' => 'Format PDF. Maks 10MB'],
        ['name' => 'foto_diri', 'label' => 'Upload Foto Diri Terbaru', 'desc' => 'Format .jpg .jpeg .png. Maks 10MB']
    ] as $file)
        <div class="mb-4">
            {{-- Label di luar box --}}
            <label class="block font-semibold mb-1">
                {{ $file['label'] }}
                @if ($file['name'] !== 'proposal')
                    <span class="text-red-500">*</span>
                @endif
            </label>
            <p class="text-sm text-gray-600 mb-2">{!! $file['desc'] !!}</p>

            {{-- Box upload --}}
            <div 
                x-data="{ fileName: null, fileType: null, fileUrl: null }" 
                x-init="
                    window.addEventListener('livewire-upload-finish', () => {
                        fileName = null;
                        fileType = null;
                        fileUrl = null;
                    });
                "
                class="border rounded-lg p-4 shadow-sm bg-gray-50"
            >
                <!-- Input hidden -->
                <input type="file" wire:model="{{ $file['name'] }}" x-ref="fileInput" class="hidden"
                    @change="
                        const file = $refs.fileInput.files[0];
                        if(file){
                            fileName = file.name;
                            fileType = file.type;
                            fileUrl = URL.createObjectURL(file);
                        }
                    ">

                <!-- Preview file lama -->
                @if(!empty($this->{$file['name'].'_path'}))
                    <div class="mt-3">
                        <div class="flex items-center justify-between px-3 py-2 border rounded-lg bg-white shadow-sm">
                            <div class="flex items-center space-x-2">
                                @if(Str::endsWith($this->{$file['name'].'_path'}, '.pdf'))
                                    <span class="bg-red-500 text-white text-xs px-2 py-1 rounded">PDF</span>
                                @elseif(Str::endsWith($this->{$file['name'].'_path'}, ['.jpg', '.jpeg', '.png']))
                                    <img src="{{ asset('storage/'.$this->{$file['name'].'_path'}) }}" alt="Preview" class="h-8 w-8 object-cover rounded">
                                @else
                                    <span class="bg-gray-500 text-white text-xs px-2 py-1 rounded">FILE</span>
                                @endif

                                <a href="{{ asset('storage/'.$this->{$file['name'].'_path'}) }}" target="_blank"
                                class="text-sm font-medium text-blue-600 truncate max-w-xs">
                                {{ basename($this->{$file['name'].'_path'}) }}
                                </a>
                            </div>
                            <!-- Tombol hapus, reset file lama -->
                            <button type="button" class="text-gray-400 hover:text-red-500"
                                wire:click="$set('{{ $file['name'].'_path' }}', '')">
                                ✕
                            </button>
                        </div>
                    </div>
                @endif

                <!-- Button hanya muncul jika tidak ada file lama DAN belum upload file baru -->
                <div 
                    x-show="!fileName && '{{ $this->{$file['name'].'_path'} }}' == ''" 
                    class="flex justify-center"
                >
                    <button type="button" @click="$refs.fileInput.click()"
                        class="px-4 py-2 border rounded-lg text-blue-600 hover:bg-blue-50 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambahkan file
                    </button>
                </div>

                <!-- Preview file baru -->
                <div x-show="fileName" class="mt-3">
                    <div class="flex items-center justify-between px-3 py-2 border rounded-lg bg-white shadow-sm">
                        <div class="flex items-center space-x-2">
                            <template x-if="fileType && fileType.includes('pdf')">
                                <span class="bg-red-500 text-white text-xs px-2 py-1 rounded">PDF</span>
                            </template>
                            <template x-if="fileType && fileType.includes('image')">
                                <img :src="fileUrl" alt="Preview" class="h-8 w-8 object-cover rounded">
                            </template>
                            <a :href="fileUrl" target="_blank" class="text-sm font-medium text-blue-600 truncate max-w-xs"
                            x-text="fileName"></a>
                        </div>
                        <button type="button" @click="fileName=null; fileUrl=null; $refs.fileInput.value=''" 
                                class="text-gray-400 hover:text-red-500">✕</button>
                    </div>
                </div>
            </div>

            @error($file['name']) <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
    @endforeach
</div>
