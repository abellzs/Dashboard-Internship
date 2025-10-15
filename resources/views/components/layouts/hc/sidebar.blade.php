<div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
     class="fixed z-40 inset-y-0 left-0 w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0">

    <div class="p-6 border-b border-gray-200 flex items-center justify-between">
        <h2 class="text-xl font-bold text-red-600">HC Panel</h2>
        <button @click="sidebarOpen = false" class="lg:hidden text-red-500 hover:text-red-700 transition">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <nav class="mt-4 px-3 space-y-2">
        {{-- Dashboard Overview --}}
        <a href="{{ url('hc/dashboard') }}" class="flex items-center px-4 py-2 rounded-2xl transition
            {{ Request::is('hc/dashboard') ? 'bg-red-100 text-red-700 font-semibold' : 'text-gray-700 hover:bg-red-50 hover:text-red-600' }}">
            <i class="fas fa-chart-pie w-5 text-center"></i>
            <span class="ml-3">Dashboard</span>
        </a>

        {{-- Data Peserta --}}
        <a href="{{ url('hc/data-peserta') }}" class="flex items-center px-4 py-2 rounded-2xl transition
            {{ Request::is('hc/data-peserta') ? 'bg-red-100 text-red-700 font-semibold' : 'text-gray-700 hover:bg-red-50 hover:text-red-600' }}">
            <i class="fas fa-users w-5 text-center"></i>
            <span class="ml-3">Data Pelamar</span>
        </a>

        {{-- Data Anak Magang --}}
        <a href="{{ url('hc/data-magang') }}" class="flex items-center px-4 py-2 rounded-2xl transition
            {{ Request::is('hc/data-magang') ? 'bg-red-100 text-red-700 font-semibold' : 'text-gray-700 hover:bg-red-50 hover:text-red-600' }}">
            <i class="fas fa-users w-5 text-center"></i>
            <span class="ml-3">Data Internship</span>
        </a>

        {{-- Presensi --}}
        <a href="{{ url('hc/presensi') }}" class="flex items-center px-4 py-2 rounded-2xl transition
            {{ Request::is('hc/presensi') ? 'bg-red-100 text-red-700 font-semibold' : 'text-gray-700 hover:bg-red-50 hover:text-red-600' }}">
            <i class="fas fa-calendar-check w-5 text-center"></i>
            <span class="ml-3">Presensi</span>
        </a>

        {{-- Lowongan --}}
        <a href="{{ url('hc/lowongan-availability') }}" class="flex items-center px-4 py-2 rounded-2xl transition
            {{ Request::is('hc/lowongan-availability') ? 'bg-red-100 text-red-700 font-semibold' : 'text-gray-700 hover:bg-red-50 hover:text-red-600' }}">
            <i class="fas fa-file-alt w-5 text-center"></i>
            <span class="ml-3">Ketersediaan Unit</span>
        </a>

        {{-- Sertifikat --}}
        <a href="{{ url('hc/data-sertifikat') }}" class="flex items-center px-4 py-2 rounded-2xl transition
            {{ Request::is('hc/data-sertifikat') ? 'bg-red-100 text-red-700 font-semibold' : 'text-gray-700 hover:bg-red-50 hover:text-red-600' }}">
            <i class="fas fa-certificate w-5 text-center"></i>
            <span class="ml-3">Data Sertifikat</span>
        </a>
        
        {{-- Export Laporan --}}
        <a href="{{ url('hc/export') }}" class="flex items-center px-4 py-2 rounded-2xl transition
            {{ Request::is('hc/export') ? 'bg-red-100 text-red-700 font-semibold' : 'text-gray-700 hover:bg-red-50 hover:text-red-600' }}">
            <i class="fas fa-file-export w-5 text-center"></i>
            <span class="ml-3">Export Data</span>
        </a>

        {{-- Notifikasi / Reminder --}}
        <a href="{{ url('hc/reminder') }}" class="flex items-center px-4 py-2 rounded-2xl transition
            {{ Request::is('hc/reminder') ? 'bg-red-100 text-red-700 font-semibold' : 'text-gray-700 hover:bg-red-50 hover:text-red-600' }}">
            <i class="fas fa-bell w-5 text-center"></i>
            <span class="ml-3">Reminder</span>
        </a>
    </nav>
</div>
