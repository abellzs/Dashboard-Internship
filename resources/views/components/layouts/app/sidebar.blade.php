{{-- resources/views/components/layouts/app/sidebar.blade.php --}}
<div 
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
    class="fixed z-40 inset-y-0 left-0 w-72 bg-white/80 backdrop-blur-lg shadow-2xl transform transition-transform duration-500 ease-in-out border-r border-gray-200 lg:translate-x-0 lg:static lg:inset-0"
>
    <div class="p-6 border-b border-gray-100 flex items-center justify-between lg:p-0 lg:border-b-0">
        <button @click="sidebarOpen = false" class="lg:hidden text-red-500 hover:text-red-700 transition-transform duration-200 hover:scale-110">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <nav class="mt-6 px-4 space-y-2">
        <a href="{{ url('dashboard') }}" 
           class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300
           {{ Request::is('dashboard') ? 'bg-gradient-to-r from-red-100 to-red-50 text-red-700 font-semibold shadow-md' : 'text-gray-700 hover:bg-red-50 hover:text-red-600' }}">
            <i class="fas fa-home w-5 text-center transition-transform duration-300 group-hover:scale-110 {{ Request::is('dashboard') ? 'text-red-500' : '' }}"></i>
            <span class="ml-1">Dashboard</span>
            @if(Request::is('dashboard'))
                <span class="ml-auto w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
            @endif
        </a>

        <a href="{{ url('profile') }}" 
           class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300
           {{ Request::is('profile*') ? 'bg-gradient-to-r from-red-100 to-red-50 text-red-700 font-semibold shadow-md' : 'text-gray-700 hover:bg-red-50 hover:text-red-600' }}">
            <i class="fas fa-user w-5 text-center transition-transform duration-300 group-hover:scale-110 {{ Request::is('profile*') ? 'text-red-500' : '' }}"></i>
            <span class="ml-1">Profile</span>
            @if(Request::is('profile*'))
                <span class="ml-auto w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
            @endif
        </a>
    </nav>
</div>
