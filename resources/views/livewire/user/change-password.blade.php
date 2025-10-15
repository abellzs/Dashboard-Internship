{{-- filepath: d:\laragon\www\Dashboard-Internship\resources\views\livewire\user\change-password.blade.php --}}
<div class="px-10" x-data="{
    showCurrentPassword: false,
    showPassword: false,
    showPasswordConfirmation: false
}">
    <div class="w-full mx-auto bg-white border border-gray-200 rounded-xl shadow-md p-6 md:p-10 space-y-6 md:space-y-8">

        {{-- Header --}}
        <div class="text-center">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Ubah Password</h1>
            <p class="text-sm md:text-base text-gray-600 mt-2">Pastikan password baru Anda aman dan mudah diingat</p>
        </div>

        {{-- Success/Error Messages --}}
        @if (session('status'))
            <div class="p-4 bg-green-100 border border-green-400 text-green-700 rounded-md text-center">
                {{ session('status') }}
            </div>
        @endif

        @if (session('error'))
            <div class="p-4 bg-red-100 border border-red-400 text-red-700 rounded-md text-center">
                {{ session('error') }}
            </div>
        @endif

        <form wire:submit="updatePassword" class="space-y-5 md:space-y-6">
            {{-- Old Password --}}
            <div>
                <label for="current_password" class="block text-sm md:text-base font-medium">Password Lama</label>
                <div class="relative mt-2">
                    <input wire:model="current_password" :type="showCurrentPassword ? 'text' : 'password'"
                        id="current_password" required
                        class="w-full px-4 py-2 md:py-3 pr-12 border border-gray-300 rounded-md shadow-sm text-sm md:text-base focus:outline-none focus:ring-2 focus:ring-red-500"
                        placeholder="Masukkan password lama Anda">
                    <button type="button" @click="showCurrentPassword = !showCurrentPassword"
                        class="absolute inset-y-0 right-0 pr-5 flex items-center text-gray-400 hover:text-gray-600">
                        <svg x-show="!showCurrentPassword" class="h-5 w-5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                            </path>
                        </svg>
                        <svg x-show="showCurrentPassword" class="h-5 w-5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21">
                            </path>
                        </svg>
                    </button>
                </div>
                @error('current_password')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div x-data="{
                showCurrentPassword: false,
                showPassword: false,
                showPasswordConfirmation: false,
                newPassword: '',
                confirmPassword: '',
                errorConfirm: false
            }">
                {{-- New Password --}}
                <div>
                    <label for="new_password" class="block text-sm md:text-base font-medium">Password Baru</label>
                    <div class="relative mt-2">
                        <input wire:model="new_password" x-model="newPassword"
                            :type="showPassword ? 'text' : 'password'" id="new_password" required
                            class="w-full px-4 py-2 md:py-3 pr-12 border border-gray-300 rounded-md shadow-sm text-sm md:text-base focus:outline-none focus:ring-2 focus:ring-red-500"
                            placeholder="Masukkan password baru">
                        <button type="button" @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 pr-5 flex items-center text-gray-400 hover:text-gray-600">
                            <svg x-show="!showPassword" class="h-5 w-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                </path>
                            </svg>
                            <svg x-show="showPassword" class="h-5 w-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21">
                                </path>
                            </svg>
                        </button>
                    </div>
                    @error('new_password')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Password minimal 8 karakter</p>
                </div>

                {{-- Password Confirmation --}}
                <div>
                    <label for="new_password_confirmation" class="block text-sm md:text-base font-medium">Konfirmasi
                        Password Baru</label>
                    <div class="relative mt-2">
                        <input wire:model="new_password_confirmation" x-model="confirmPassword"
                            @input="errorConfirm = confirmPassword !== newPassword"
                            :type="showPasswordConfirmation ? 'text' : 'password'" id="new_password_confirmation"
                            required
                            class="w-full px-4 py-2 md:py-3 pr-12 border border-gray-300 rounded-md shadow-sm text-sm md:text-base focus:outline-none focus:ring-2 focus:ring-red-500"
                            placeholder="Ulangi password baru">
                        <button type="button" @click="showPasswordConfirmation = !showPasswordConfirmation"
                            class="absolute inset-y-0 right-0 pr-5 flex items-center text-gray-400 hover:text-gray-600">
                            <svg x-show="!showPasswordConfirmation" class="h-5 w-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                </path>
                            </svg>
                            <svg x-show="showPasswordConfirmation" class="h-5 w-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21">
                                </path>
                            </svg>
                        </button>
                    </div>
                    <template x-if="errorConfirm">
                        <p class="text-sm text-red-500 mt-1">Konfirmasi password tidak sama dengan password baru.</p>
                    </template>
                    @error('new_password_confirmation')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Tips Keamanan --}}
            <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                <h4 class="text-sm font-medium text-blue-800 mb-2">Tips Password Aman:</h4>
                <ul class="text-xs text-blue-700 space-y-1">
                    <li>• Gunakan kombinasi huruf besar, kecil, angka, dan simbol</li>
                    <li>• Minimal 8 karakter, semakin panjang semakin baik</li>
                    <li>• Hindari menggunakan informasi pribadi</li>
                    <li>• Jangan gunakan password yang sama di akun lain</li>
                </ul>
            </div>

            {{-- Tombol --}}
            <div class="space-y-3">
                <button type="submit"
                    class="w-full py-2 md:py-3 px-4 md:px-5 bg-red-100 text-red-700 font-semibold hover:bg-red-200 transition text-center block">
                    <span wire:loading.remove>Ubah Password</span>
                    <span wire:loading>Mengubah Password...</span>
                </button>
            </div>
        </form>
    </div>
</div>
