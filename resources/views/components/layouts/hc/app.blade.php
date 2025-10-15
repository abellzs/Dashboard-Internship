<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Dashboard HC' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- Livewire Styles --}}
    @livewireStyles

    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @filamentStyles
</head>

<body class="bg-gray-100 text-gray-800" x-data="{ sidebarOpen: false }">
    
    {{-- Header --}}
    @include('components.layouts.hc.header')

    <div class="flex min-h-screen overflow-hidden">
        {{-- Sidebar --}}
        @include('components.layouts.hc.sidebar')

        {{-- Main Content --}}
        <main class="flex-1 p-4 sm:p-6 overflow-x-hidden min-w-0">
            @yield('content')
            {{ $slot ?? '' }}
        </main>
    </div>

    {{-- Livewire Scripts --}}
    @livewireScripts

    @filamentScripts

</body>
</html>
