@if ($step === 4)

    <div class="space-y-4">
        <h2 class="text-xl font-semibold">Syarat & Ketentuan</h2>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Apakah Anda bersedia ditempatkan di unit/divisi mana saja?
        </label>
        <div class="flex space-x-4">
            <label class="inline-flex items-center">
                <input type="radio" wire:model="bersedia" value="ya" class="form-radio">
                <span class="ml-2">Ya</span>
            </label>
            <label class="inline-flex items-center">
                <input type="radio" wire:model="bersedia" value="tidak" class="form-radio">
                <span class="ml-2">Tidak</span>
            </label>
        </div>
        @error('bersedia')
            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="space-y-4">
        <p class="text-sm text-gray-600">
            Dengan mencentang kotak ini, Anda menyatakan telah membaca dan menyetujui seluruh syarat dan ketentuan magang yang berlaku.
        </p>

        <label class="flex items-center space-x-2">
            <input type="checkbox" wire:model="agreement" class="form-checkbox text-blue-600">
            <span class="text-sm">Saya menyetujui semua syarat dan ketentuan magang.</span>
        </label>
    </div>
@endif
