<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;

new #[Layout('components.layouts.guest')] class extends Component {
    #[Locked]
    public string $token = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function mount(string $token): void
    {
        $this->token = $token;
        $this->email = request()->string('email');
    }

    public function resetPassword(): void
    {
        $this->validate([
            'token' => ['required'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $status = Password::reset(
            $this->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) {
                $user->forceFill([
                    'password' => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status != Password::PASSWORD_RESET) {
            $this->addError('email', __($status));
            return;
        }

        Session::flash('status', __($status));
        $this->redirectRoute('login', navigate: true);
    }
};
?>

<div class="min-h-screen flex flex-col bg-white text-gray-800">
    <div class="flex flex-col items-center justify-center flex-1 px-6 md:px-32">
        <div class="w-full max-w-md bg-white border border-gray-200 rounded-xl shadow-md p-6 md:p-10 space-y-6">
            
            <h2 class="text-2xl font-bold text-center">Reset Password</h2>
            <p class="text-sm text-center text-gray-600">
                Masukkan password baru Anda untuk mengatur ulang akun.
            </p>

            @if (session('status'))
                <div class="p-3 text-green-700 bg-green-100 border border-green-200 rounded">
                    {{ session('status') }}
                </div>
            @endif

            <form wire:submit="resetPassword" class="space-y-5">
                <div>
                    <label for="email" class="block text-sm font-medium">Email</label>
                    <input wire:model="email" type="email" id="email" required
                        class="mt-2 w-full px-4 py-2 md:py-3 border border-gray-300 rounded-md shadow-sm text-sm md:text-base focus:outline-none focus:ring-2 focus:ring-red-500"
                        placeholder="Contoh: email@witelyjs.com">
                    @error('email') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium">Password Baru</label>
                    <input wire:model="password" type="password" id="password" required
                        class="mt-2 w-full px-4 py-2 md:py-3 border border-gray-300 rounded-md shadow-sm text-sm md:text-base focus:outline-none focus:ring-2 focus:ring-red-500"
                        placeholder="Password Baru">
                    @error('password') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium">Konfirmasi Password</label>
                    <input wire:model="password_confirmation" type="password" id="password_confirmation" required
                        class="mt-2 w-full px-4 py-2 md:py-3 border border-gray-300 rounded-md shadow-sm text-sm md:text-base focus:outline-none focus:ring-2 focus:ring-red-500"
                        placeholder="Konfirmasi Password">
                    @error('password_confirmation') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <button type="submit"
                        class="w-full py-2 md:py-3 px-4 bg-gradient-to-r from-[#C1002A] to-[#0066B1] text-white rounded-md text-sm md:text-base font-semibold hover:opacity-90 transition">
                        Reset Password
                    </button>
                </div>

                <div class="text-center text-sm mt-2">
                    <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Kembali ke Login</a>
                </div>
            </form>
        </div>
    </div>
</div>
