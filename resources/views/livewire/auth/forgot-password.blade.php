<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.guest')] class extends Component {

    public string $email = '';

    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        Password::sendResetLink($this->only('email'));

        session()->flash('status', __('Link reset password telah dikirim ke email Anda jika terdaftar.'));
    }
};
?>

<div class="min-h-screen flex flex-col bg-white text-gray-800">
    <div class="flex flex-col items-center justify-center flex-1 px-6 md:px-32">
        <div class="w-full max-w-md bg-white border border-gray-200 rounded-xl shadow-md p-6 md:p-10 space-y-6">
            
            <h2 class="text-2xl font-bold text-center">Lupa Password</h2>
            <p class="text-sm text-center text-gray-600">
                Masukkan email Anda untuk menerima link reset password.
            </p>

            @if (session('status'))
                <div class="p-3 text-green-700 bg-green-100 border border-green-200 rounded">
                    {{ session('status') }}
                </div>
            @endif

            <form wire:submit="sendPasswordResetLink" class="space-y-5">
                <div>
                    <label for="email" class="block text-sm font-medium">Email</label>
                    <input wire:model="email" type="email" id="email" required
                        class="mt-2 w-full px-4 py-2 md:py-3 border border-gray-300 rounded-md shadow-sm text-sm md:text-base focus:outline-none focus:ring-2 focus:ring-red-500"
                        placeholder="Contoh: email@witelyjs.com">
                    @error('email') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <button type="submit"
                        class="w-full py-2 md:py-3 px-4 bg-gradient-to-r from-[#C1002A] to-[#0066B1] text-white rounded-md text-sm md:text-base font-semibold hover:opacity-90 transition">
                        Kirim Link Reset
                    </button>
                </div>

                <div class="text-center text-sm mt-2">
                    <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Kembali ke Login</a>
                </div>
            </form>
        </div>
    </div>
</div>
