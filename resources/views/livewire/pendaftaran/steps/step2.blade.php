<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    {{-- Kiri: List lowongan --}}
    <div class="bg-white border rounded-xl shadow p-4 max-h-[85vh] overflow-y-auto">
        @include('livewire.user.steps.lowongan-list')
    </div>

    {{-- Kanan: Detail lowongan --}}
    <div class="bg-white border rounded-xl shadow p-6">
        @include('livewire.user.steps.lowongan-detail')
    </div>
</div>

