{{-- filepath: d:\laragon\www\Dashboard-Internship\resources\views\components\layouts\app\sidebar.blade.php --}}
<div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed z-40 inset-y-0 left-0 w-72 bg-white/80 backdrop-blur-lg shadow-2xl transform transition-transform duration-500 ease-in-out border-r border-gray-200 lg:translate-x-0 lg:static lg:inset-0">
    <div class="p-6 border-b border-gray-100 flex items-center justify-between lg:p-0 lg:border-b-0">
        <button @click="sidebarOpen = false"
            class="lg:hidden text-red-500 hover:text-red-700 transition-transform duration-200 hover:scale-110">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <nav class="mt-6 px-4 space-y-2" x-data="{
        settingsOpen: {{ Request::is('change-password*') || Request::is('settings*') ? 'true' : 'false' }}
    }">
        <a href="{{ url('dashboard') }}"
            class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300
           {{ Request::is('dashboard') ? 'bg-gradient-to-r from-red-100 to-red-50 text-red-700 font-semibold shadow-md' : 'text-gray-700 hover:bg-red-50 hover:text-red-600' }}">
            <i
                class="fas fa-home w-5 text-center transition-transform duration-300 group-hover:scale-110 {{ Request::is('dashboard') ? 'text-red-500' : '' }}"></i>
            <span class="ml-1">Dashboard</span>
            @if (Request::is('dashboard'))
                <span class="ml-auto w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
            @endif
        </a>

        @php
            $hasOnGoingMagang = false;
            if (auth()->check()) {
                $hasOnGoingMagang = auth()->user()->magangApplication()->where('status', 'on_going')->exists();
            }
        @endphp

        @if ($hasOnGoingMagang)
            <a href="{{ url('presensi') }}"
                class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300
                   {{ Request::is('presensi') ? 'bg-gradient-to-r from-red-100 to-red-50 text-red-700 font-semibold shadow-md' : 'text-gray-700 hover:bg-red-50 hover:text-red-600' }}">
                <i
                    class="fas fa-calendar-check w-5 text-center transition-transform duration-300 group-hover:scale-110 {{ Request::is('presensi') ? 'text-red-500' : '' }}"></i>
                <span class="ml-1">Presensi</span>
                @if (Request::is('presensi'))
                    <span class="ml-auto w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                @endif
            </a>
        @endif

        <a href="{{ url('profile') }}"
            class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300
           {{ Request::is('profile*') ? 'bg-gradient-to-r from-red-100 to-red-50 text-red-700 font-semibold shadow-md' : 'text-gray-700 hover:bg-red-50 hover:text-red-600' }}">
            <i
                class="fas fa-user w-5 text-center transition-transform duration-300 group-hover:scale-110 {{ Request::is('profile*') ? 'text-red-500' : '' }}"></i>
            <span class="ml-1">Profile</span>
            @if (Request::is('profile*'))
                <span class="ml-auto w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
            @endif
        </a>

        {{-- Settings Dropdown --}}
        <div class="relative">
            <button @click="settingsOpen = !settingsOpen"
                class="group w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300
                    {{ Request::is('change-password*') || Request::is('settings*') ? 'bg-gradient-to-r from-red-100 to-red-50 text-red-700 font-semibold shadow-md' : 'text-gray-700 hover:bg-red-50 hover:text-red-600' }}">
                <i class="fas fa-cog w-5 text-center transition-transform duration-300 group-hover:scale-110 {{ Request::is('change-password*') || Request::is('settings*') ? 'text-red-500' : '' }}"
                    :class="settingsOpen ? 'rotate-90' : ''"></i>
                <span class="ml-1">Settings</span>
                <i class="fas fa-chevron-down ml-auto transition-transform duration-300"
                    :class="settingsOpen ? 'rotate-180' : ''"></i>
            </button>

            {{-- Dropdown Menu --}}
            <div x-show="settingsOpen" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95" class="mt-2 ml-4 space-y-1">

                {{-- Change Password --}}
                <a href="{{ url('change-password') }}"
                    class="group flex items-center gap-3 px-4 py-2 rounded-lg transition-all duration-300
                   {{ Request::is('change-password*') ? 'bg-gradient-to-r from-red-100 to-red-50 text-red-700 font-medium shadow-sm' : 'text-gray-600 hover:bg-red-50 hover:text-red-600' }}">
                    <i
                        class="fas fa-key w-4 text-center transition-transform duration-300 group-hover:scale-110 {{ Request::is('change-password*') ? 'text-red-500' : '' }}"></i>
                    <span class="text-sm">Change Password</span>
                    {{-- PERBAIKAN: Titik merah di submenu --}}
                    @if (Request::is('change-password*'))
                        <span class="ml-auto w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                    @endif
                </a>

                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit"
                        class="group w-full flex items-center gap-3 px-4 py-2 rounded-lg transition-all duration-300 text-gray-600 hover:bg-red-50 hover:text-red-600">
                        <i
                            class="fas fa-sign-out-alt w-4 text-center transition-transform duration-300 group-hover:scale-110"></i>
                        <span class="text-sm">Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </nav>
</div>
