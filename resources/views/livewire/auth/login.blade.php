<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('components.layouts.guest')] class extends Component {

    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public string $captcha = '';

    public bool $remember = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
            'captcha' => 'required',
        ]);

        // Cek captcha manual
        if (!captcha_check($this->captcha)) {
            throw ValidationException::withMessages([
                'captcha' => 'Captcha tidak cocok. Silakan coba lagi.',
            ]);
        }

        // Lanjut login biasa
        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            throw ValidationException::withMessages([
                'email' => 'Email atau password salah.',
            ]);
        }

        session()->regenerate();

        $user = Auth::user();
        // dd($user->role);

        if ($user->role === 'hc') {
            $this->redirect('/hc/dashboard', navigate: true);
        } elseif ($user->role === 'user' && !$user->magangApplication()->exists()) {
            $this->redirect(route('pendaftaran', absolute: false), navigate: true);
        } elseif ($user->role === 'admin') {
            $this->redirect('/admin', navigate: true); // filament
        } else {
            $this->redirect(route('dashboard', absolute: false), navigate: true);
        }

    }

    public string $captchaImg = '';

    public function mount()
    {
        $this->refreshCaptcha();
    }

    public function refreshCaptcha()
    {
        $this->captchaImg = captcha_img('numeric'); // atau 'flat', dll
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }
}; ?>

<div class="min-h-screen flex flex-col bg-white text-gray-800">

    {{-- Konten Utama --}}
    <div class="flex flex-col md:flex-row items-center justify-center flex-1 px-6 md:px-32 gap-28">

        {{-- Kiri: Gambar & Teks --}}
        <div class="hidden md:flex flex-col items-start justify-center max-w-xl ml-32 pr-5">
            <img src="{{ asset('images/loginpage.png') }}" alt="Login Illustration" class="w-full max-w-lg mb-8">
            <h2 class="text-xl md:text-3xl font-semibold leading-snug text-pretty">
                Langkah Kecil, Dampak Besar untuk Masa Depan
            </h2>
        </div>

        {{-- Kanan: Form Login --}}
        <div class="w-full max-w-xl ml-auto mr-32 bg-white border border-gray-200 rounded-xl shadow-md p-6 md:p-10 space-y-6 md:space-y-8">

            <x-auth-session-status class="text-center" :status="session('status')" />

            <form wire:submit="login" class="space-y-5 md:space-y-6">
                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm md:text-base font-medium">Email</label>
                    <input wire:model="email" type="email" id="email" required
                        class="mt-2 w-full px-4 py-2 md:py-3 border border-gray-300 rounded-md shadow-sm text-sm md:text-base focus:outline-none focus:ring-2 focus:ring-red-500"
                        placeholder="Contoh: email@witelyjs.com">
                    @error('email') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm md:text-base font-medium">Password</label>
                    <input wire:model="password" type="password" id="password" required
                        class="mt-2 w-full px-4 py-2 md:py-3 border border-gray-300 rounded-md shadow-sm text-sm md:text-base focus:outline-none focus:ring-2 focus:ring-red-500"
                        placeholder="Masukkan password">
                    @error('password') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Captcha --}}
                <div class="flex items-start gap-4 mt-2">
                    <div class="flex flex-col items-center">
                        <div id="captcha-img" class="p-2 border border-gray-300 rounded-md shadow-sm">
                            {!! captcha_img('numeric') !!}
                        </div>
                        <button type="button" id="reload" class="mt-2 text-blue-500 text-xs hover:underline">
                            Reload Captcha
                        </button>
                    </div>
                    <div class="flex-1">
                        <input
                            wire:model.defer="captcha"
                            name="captcha"
                            class="w-full px-4 py-2 md:py-3 border border-gray-300 rounded-md text-sm md:text-base"
                            type="text"
                            placeholder="Insert Captcha">
                        @error('captcha')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <script>
                    document.getElementById('reload').addEventListener('click', function () {
                        fetch('/reload-captcha')
                            .then(res => res.json())
                            .then(data => {
                                document.getElementById('captcha-img').innerHTML = data.captcha;
                            });
                    });
                </script>

                {{-- Remember --}}
                <div class="flex items-center">
                    <input wire:model="remember" type="checkbox" id="remember_me"
                        class="h-4 w-4 md:h-5 md:w-5 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                    <label for="remember_me" class="ml-2 md:ml-3 text-sm md:text-base text-gray-900">Remember me</label>
                </div>

                {{-- Tombol --}}
                <div>
                    <button type="submit"
                        class="w-full py-2 md:py-3 px-4 md:px-5 bg-gradient-to-r from-[#C1002A] to-[#0066B1] text-white rounded-md text-sm md:text-base font-semibold hover:opacity-90 transition">
                        Masuk
                    </button>
                </div>

                {{-- Link tambahan --}}
                <div class="flex justify-between text-xs md:text-sm mt-2">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-gray-600 hover:underline">Lupa password?</a>
                    @endif
                    @if (Route::has('register'))
                        <span class="text-gray-600">
                            <a href="{{ route('register') }}" class="text-blue-600 font-medium hover:underline">Daftar di sini</a>
                        </span>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
