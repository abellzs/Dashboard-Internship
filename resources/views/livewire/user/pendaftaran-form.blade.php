<div class="p-4 md:p-6 bg-gray-50 rounded-lg shadow-md animate-fade-in duration-300">
    <!-- STEP INDICATOR -->
    <div class="flex justify-between items-center gap-4 mb-6">
        @for ($i = 1; $i <= 4; $i++)
            <div 
                class="flex-1 text-center py-3 rounded-lg font-semibold transition-all duration-300 ease-in-out
                {{ $step == $i 
                    ? 'bg-[#ef1c25] text-white shadow-md' 
                    : 'bg-gray-100 text-gray-600 hover:bg-gray-200'
                }}">
                Step {{ $i }}
            </div>
        @endfor
    </div>

    <!-- STEP CONTENT -->
    <form wire:submit.prevent="submitPendaftaran" enctype="multipart/form-data">
        <div class="transition-all duration-300">
            @if ($step === 1)
                <div class="bg-white rounded-xl p-6 shadow border space-y-4">
                    <h2 class="text-xl font-bold text-[#DA291C]">Ketentuan Pendaftaran Kerja Praktik</h2>
                    @include('livewire.pendaftaran.steps.step1')
                </div>

            @elseif ($step === 2)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- KIRI: List lowongan --}}
                    <div class="bg-white rounded-xl p-4 border shadow-sm overflow-y-auto max-h-[80vh]">
                        @include('livewire.pendaftaran.steps.lowongan-list')
                    </div>

                    {{-- KANAN: Detail lowongan --}}
                    <div class="bg-white rounded-xl p-4 border shadow-sm">
                        @include('livewire.pendaftaran.steps.lowongan-detail')
                    </div>
                </div>

            @elseif ($step === 3)
                <div class="bg-white rounded-xl p-6 shadow border space-y-4">
                    <h2 class="text-xl font-bold text-[#DA291C]">Lengkapi data dibawah ini</h2>
                    @include('livewire.pendaftaran.steps.step3')
                </div>
            @elseif ($step === 4)
                <div class="bg-white rounded-xl p-6 shadow border space-y-4">
                @include('livewire.pendaftaran.steps.step4')
                </div>
            @elseif ($step === 5)
                <div class="bg-white rounded-xl p-6 shadow border">
                </div>
            @endif
        </div>
    </form>

    <!-- NAVIGATION BUTTONS -->
    <div class="mt-8 flex justify-between items-center">
        {{-- Tombol Kembali --}}
        @if ($step > 1)
        <button wire:click="previousStep" class="btn-secondary">
            Kembali
        </button>
        @endif

        {{-- Tombol Selanjutnya --}}
        @if ($step < 4)
        <button 
            wire:click="nextStep" 
            class="btn-primary ml-auto"
            @disabled(
                ($step === 1 && !$agreement) || 
                ($step === 2 && !$selectedId) || 
                ($step === 3 && (!$mulai || !$selesai || !$durasi || !$semester || !$alasan || !$cv || !$surat_permohonan || !$foto_diri))
            )
        >
            Selanjutnya
        </button>
        @endif

        {{-- Tombol Kirim --}}
        @if ($step === 4)
        <button wire:click="submitPendaftaran" class="btn-success ml-auto">
            Kirim
        </button>
        @endif

        @if (session()->has('error'))
            <div class="text-red-600 mt-4">
                {{ session('error') }}
            </div>
        @endif
    </div>
</div>
