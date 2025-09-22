{{-- resources/views/components/layouts/app/header.blade.php --}}
<header class="bg-white shadow px-4 py-3 flex items-center border-b border-red-100 relative">
    <!-- Sidebar Toggle (mobile only) -->
    <button @click="sidebarOpen = true" class="lg:hidden text-red-700 hover:text-red-900">
        <i class="fas fa-bars fa-lg"></i>
    </button>

    <!-- User Dropdown -->
    <div x-data="{ open: false }" class="relative ml-auto">
        <button @click="open = !open"
            class="flex items-center space-x-2 px-3 py-2 bg-red-50 hover:bg-red-100 text-red-700 rounded-md transition duration-200 ease-in-out focus:outline-none">
            
            <!-- Profile icon -->
            <img src="{{ asset('images/profile.svg') }}" alt="Profile" class="h-6 w-6 rounded-full">

            <!-- Name (hidden on mobile) -->
            <span class="font-medium hidden lg:inline">{{ Auth::user()->name ?? 'Guest' }}</span>

            <!-- Arrow (hidden on mobile) -->
            <svg class="w-4 h-4 transform transition-transform duration-200 hidden lg:inline" 
                 :class="{ 'rotate-180': open }" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <!-- Dropdown Menu -->
        <div x-show="open" 
            x-transition:enter="transition ease-out duration-100" 
            x-transition:enter-start="transform opacity-0 scale-95" 
            x-transition:enter-end="transform opacity-100 scale-100" 
            x-transition:leave="transition ease-in duration-75" 
            x-transition:leave-start="transform opacity-100 scale-100" 
            x-transition:leave-end="transform opacity-0 scale-95"
            @click.away="open = false"
            class="absolute right-0 mt-2 w-44 bg-white border border-gray-200 rounded-md shadow-lg z-50 origin-top-right">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full text-left px-4 py-2 text-gray-700 hover:bg-red-50 hover:text-red-700 transition-colors duration-150">
                    Logout
                </button>
            </form>
        </div>
    </div>
</header>
